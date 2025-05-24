<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Jobs\ExportJob;
use App\Jobs\ImportJob;
use App\Models\ExportHistory;
use Illuminate\Support\Str;
use App\Imports\DynamicImport;
use Maatwebsite\Excel\Facades\Excel;

class TasksController extends Controller
{

    public function index(Request $request): Response
    {
        $filters = $request->all();
        $filters['trashed'] = filter_var($filters['trashed'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $tasks = Tasks::query()
            ->with([
                'project' => fn($q) => $q->withTrashed()->select('id', 'client_id', 'manager_id', 'name', 'status', 'deleted_at'),
                'creator:id,name',
                'assigned:id,name'
            ])
            ->filter($filters)
            ->paginate(10)
            ->withQueryString();
        $export = ExportHistory::where('user_id', auth()->id())->select(['id'])->latest()->first();   
        $tim = User::where('is_active', true)->select(['id', 'name'])->role('tim')->get();
        $projects = Projects::select(['id', 'name'])->get();

        return inertia('Tasks', [
            'tasks' => $tasks,
            'filters' => $filters,
            'file' => $export,
            'tim' => $tim,
            'projects' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['required', 'date'],
        ]);

        Tasks::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'created_by' => auth()->user()->id,
            'assigned_to' => $validated['assigned_to'],
            'project_id' => $validated['project_id'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('tasks')->with('success', 'Tasks created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        $task = Tasks::with(['assigned', 'project', 'creator'])->findOrFail($id);

        $activities = Activity::forSubject($task)
            ->with('causer')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($activity) {
                $props = $activity->properties->toArray();

                return [
                    'event' => ucfirst($activity->event),
                    'user' => $activity->causer?->name ?? 'System',
                    'date' => $activity->created_at->toDayDateTimeString(),
                    'description' => $activity->description,
                    'changes' => [
                        'old' => $props['old'] ?? null,
                        'attributes' => $props['attributes'] ?? null,
                    ],
                ];
            });

        return Inertia::render('Task/Show', [
            'task' => $task,
            'auditTrail' => $activities,
        ]);
    }

    public function auditTrail(Request $request): Response
    {
        $activities = Activity::with(['causer', 'subject'])
        ->where('subject_type', Tasks::class)
        ->latest()
        ->paginate(10)
        ->through(function ($activity) {
            return [
                'event' => ucfirst($activity->description),
                'user' => optional($activity->causer)->name ?? 'System',
                'description' => $activity->properties['note']
                    ?? optional($activity->subject)->name
                    ?? '-',
                'date' => $activity->created_at->format('Y-m-d H:i:s'),
            ];
        })
        ->withQueryString();

        return Inertia::render('Task/History', [
            'auditTrail' => $activities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function uploadAttachment(Request $request, String $taskId)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf|between:100,500',
        ]);

        $task = Tasks::findOrFail($taskId);
        $file = $request->file('attachment');
        $path = $file->store('task/attachments', 'public');
        $currentAttachments = $task->attachment;

        if (!is_array($currentAttachments)) {
            $currentAttachments = is_string($currentAttachments)
                ? json_decode($currentAttachments, true) ?? []
                : [];
        }

        $currentAttachments[] = [
            'path' => $path,
            'url' => Storage::url($path),
            'uploaded_at' => now()->toDateTimeString(),
            'original_name' => $file->getClientOriginalName(),
        ];

        $task->update([
            'attachments' => $currentAttachments,
        ]);
        return redirect()->route('tasks.show', $task->id)->with('success', 'Attachment uploaded successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['required', 'date'],
        ]);
        $task = Tasks::findOrFail($id);
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'project_id' => $validated['project_id'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('tasks')->with('success', 'Tasks updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id) : RedirectResponse
    {
        $task = Tasks::withTrashed()->findOrFail($id);

        if ($task->trashed()) {
            return redirect()->route('tasks')->with('error', 'task already deleted.');
        }
        $task->delete();
        return redirect()->route('tasks')->with('success', 'task deleted successfully.');

    }

    public function export(Request $request)
    {
        $fields = $request->input('fields', ['title', 'description', 'created_by', 'project_id', 'assigned_to', 'status', 'priority', 'due_date', 'created_at', 'updated_at']);
        $filename = 'tasks' . now()->format('Ymd_His') . '_' . Str::random(5) . '.xlsx';
        $file_path = "exports/{$filename}";

        ExportJob::dispatch(Tasks::class, $fields, $file_path);
        ExportHistory::create([
            'user_id' => auth()->id(),
            'file_path' => $file_path,
        ]);
    
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'fields' => $fields,
                'file_path' => $file_path,
            ])
            ->log('Did Export Project');
    
        return back()->with('success', 'Project exporting process');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);
        $fields   = ['title', 'description', 'created_by', 'project_id', 'assigned_to', 'status', 'priority', 'due_date', 'created_at', 'updated_at'];
        $rows = Excel::toCollection(new DynamicImport(Tasks::class, $fields), $request->file('file'));
        foreach ($rows as $row) {
            foreach ($fields as $field) {
                if (empty($row[$field])) {
                    return to_route('tasks')->with('error', "Missing data in column {$field}");
                }
            }
        }
        $filePath = $request->file('file')->store('imports', 'public');
        ImportJob::dispatch(Tasks::class, $fields, $filePath);
    
        return to_route('tasks')->with('success', 'Task Import process');
    }

}
