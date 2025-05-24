<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Client;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ExportJob;
use App\Jobs\ImportJob;
use App\Models\ExportHistory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use App\Imports\DynamicImport;
use Illuminate\Http\RedirectResponse;

class ProjectsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Projects::query()
            ->with(['client', 'manager', 'tasks'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%' . $request->input('search') . '%';
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                      ->orWhere('description', 'like', $search);
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
            ->when($request->boolean('trashed'), function ($query) {
                return $query->onlyTrashed();
            });

        $allowedSortFields = ['name', 'status'];
        $sortBy = in_array($request->input('sortBy'), $allowedSortFields)
            ? $request->input('sortBy')
            : 'name';

        $sortOrder = in_array(strtolower($request->input('sortOrder')), ['asc', 'desc'])
            ? strtolower($request->input('sortOrder'))
            : 'asc';

        $projects = $query->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->withQueryString();

        $clients = Client::all();
        $managers = User::select(['id', 'name'])
            ->role('manager')
            ->get();
         $export = ExportHistory::where('user_id', auth()->id())->select(['id'])->latest()->first();
        return Inertia::render('Projects', [
            'projects' => $projects,
            'clients' => $clients,
            'managers' => $managers,
            'file' => $export,
            'filters' => $request->only(['search', 'status', 'sortBy', 'sortOrder', 'trashed']),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_id' => ['required', 'exists:clients,id'],
            'manager_id' => ['required', 'exists:users,id'],
            'started_at' => ['required', 'date'],
            'deadline' => ['nullable', 'date', 'after_or_equal:started_at'],
        ]);

        $project = Projects::firstOrCreate([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'client_id' => $validated['client_id'],
            'manager_id' => $validated['manager_id'],
            'started_at' => $validated['started_at'],
            'deadline' => $validated['deadline'],
        ]);
        return redirect()->route('projects')->with('success', 'Project created successfully.');
    }
    public function uploadAttachments(Request $request, string $projectId): RedirectResponse
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf|between:100,500',
        ]);

        $project = Projects::findOrFail($projectId);
        $file = $request->file('attachment');
        $path = $file->store('project/attachments', 'public');
        $currentAttachments = $project->attachment;

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

        $project->update([
            'attachments' => $currentAttachments,
        ]);
        return redirect()->route('projects.show', $project->id)->with('success', 'Attachment uploaded successfully');
    }
    public function show($id): Response
    {
        $project = Projects::with([
            'client',
            'manager',
            'tasks' => function($query) {
                $query->latest()->limit(3);
            }
        ])->findOrFail($id);

        $createdActivity = Activity::forSubject($project)
            ->where('event', 'created')
            ->with('causer')
            ->oldest()
            ->first();

        $updatedActivity = Activity::forSubject($project)
            ->where('event', 'updated')
            ->with('causer')
            ->latest()
            ->first();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'auditTrail' => [
                'createdBy' => $createdActivity?->causer?->name,
                'createdAt' => $createdActivity?->created_at?->toDateTimeString(),
                'updatedBy' => $updatedActivity?->causer?->name,
                'updatedAt' => $updatedActivity?->created_at?->toDateTimeString(),
            ],
        ]);
    }

    public function auditTrail(Request $request): Response
    {
        $activities = Activity::with(['causer', 'subject'])
        ->where('subject_type', Projects::class)
        ->latest()
        ->paginate(10)
        ->through(function ($activity) {
            return [
                'event' => ucfirst($activity->description),
                'user' => optional($activity->causer)->name ?? 'System',
                'description' => $activity->properties['note']
                 ?? optional($activity->subject)->name ?? '-',
                'date' => $activity->created_at->format('Y-m-d H:i:s'),
            ];
        })
        ->withQueryString();

        return Inertia::render('Projects/History', [
            'auditTrail' => $activities,
        ]);
    }

    public function update(Request $request,$id): RedirectResponse
    {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'client_id' => ['required', 'exists:clients,id'],
        'manager_id' => ['required', 'exists:users,id'],
        'started_at' => ['required', 'date'],
        'deadline' => ['nullable', 'date', 'after_or_equal:started_at'],
    ]);
    $project = Projects::findOrFail($id);
    $project->update([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'client_id' => $validated['client_id'],
        'manager_id' => $validated['manager_id'],
        'started_at' => $validated['started_at'],
        'deadline' => $validated['deadline'],
    ]);

    return redirect()->route('projects')->with('success', 'Project updated successfully.');
    }

    public function destroy($id) : RedirectResponse
    {
        $project = Projects::withTrashed()->findOrFail($id);

        if ($project->trashed()) {
            return redirect()->route('projects')->with('error', 'Project already deleted.');
        }
        $project->delete();
        return redirect()->route('projects')->with('success', 'Project deleted successfully.');

    }

    public function export(Request $request)
    {
        $fields = $request->input('fields', ['name', 'deadline', 'client_id','manager_id','started_at','description', 'status','created_at', 'updated_at']);
        $filename = 'projects_' . now()->format('Ymd_His') . '_' . Str::random(5) . '.xlsx';
        $file_path = "exports/{$filename}";

        ExportJob::dispatch(Projects::class, $fields, $file_path);
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
        $requiredFields = ['name', 'client_id', 'manager_id','status'];
        $optionalFields = ['started_at', 'deadline','description','created_at', 'updated_at'];
        $fields = array_merge($requiredFields, $optionalFields);

        $rows = Excel::toCollection(new DynamicImport(Projects::class, $fields), $request->file('file'));
        $sheet = $rows->first();
        if ($sheet->isEmpty()) {
            return to_route('projects')->with('error', 'File kosong atau tidak ada data selain header.');
        }
        foreach ($sheet as $index => $row) {
            foreach ($requiredFields as $field) {
                if (! $row->has($field) || is_null($row[$field]) || $row[$field] === '') {
                    return to_route('projects')->with(
                        'error',
                        "Missing required column '{$field}' at Excel row ".($index + 2)
                    );
                }
            }
        }

        $filePath = $request->file('file')->store('imports', 'public');
        ImportJob::dispatchSync(Projects::class, $fields, $filePath);

        return to_route('projects')->with('success', 'Project Import process');
    }
}

