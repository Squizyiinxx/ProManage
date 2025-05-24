<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ExportJob;
use App\Jobs\ImportJob;
use App\Models\ExportHistory;
use Illuminate\Support\Str;
use App\Imports\DynamicImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
     /**
     * Display a listing of clients with filters and sorting.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $query = User::query()
            ->with(['roles' => function ($query) {
                $query->select('uuid', 'name');
            }])
            ->with(['projects' => function ($query) {
                $query->withTrashed()
                    ->select(['id', 'client_id', 'manager_id', 'name', 'status', 'deleted_at']);
            }])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%' . $request->input('search') . '%';
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search);
                });
            })
            ->when($request->boolean('trashed'), function ($query) {
                return $query->onlyTrashed();
            });

        $allowedSortFields = ['name', 'created_at'];
        $sortBy = in_array($request->input('sortBy'), $allowedSortFields)
            ? $request->input('sortBy')
            : 'name';

        $sortOrder = in_array(strtolower($request->input('sortOrder')), ['asc', 'desc'])
            ? strtolower($request->input('sortOrder'))
            : 'asc';

        $users = $query->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->through(function ($user) {
                $user->role = $user->roles->first() ?? null;
                unset($user->roles);
                return $user;
            })
            ->withQueryString();

        $role = Role::select('uuid', 'name')->get();
        $export = ExportHistory::where('user_id', auth()->id())->select(['id'])->latest()->first();   
        return inertia('Users', [
            'users' => $users,
            'file' => $export,
            'role' => $role,
            'filters' => $request->only(['search', 'sortBy', 'sortOrder', 'trashed']),
        ]);
    }


    public function update(Request $request,$id):RedirectResponse
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'is_active' => 'boolean',
        ]);
        $role = Role::where('uuid', $request->role)->first();
        $user->syncRoles($role);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
        ]);
        return redirect()->route('users')->with('success', 'User updated successfully.');
    }
    public function show(string $id): Response
    {
        $user = User::with(['projects', 'tasks', 'roles:uuid,name'])->findOrFail($id);

        $activities = Activity::forSubject($user)
            ->with('causer')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($activity) {
                $props = $activity->properties->toArray();

                $changes = collect($props['attributes'] ?? [])
                    ->map(function ($new, $key) use ($props) {
                        $old = $props['old'][$key] ?? null;
                        return [
                            'field' => ucfirst(str_replace('_', ' ', $key)),
                            'from' => $old,
                            'to' => $new,
                        ];
                    })
                    ->filter()
                    ->values();

                return [
                    'event' => ucfirst($activity->event),
                    'description' => $activity->description ?? '-',
                    'user' => $activity->causer?->name ?? 'System',
                    'date' => $activity->created_at->toDayDateTimeString(),
                    'changes' => $changes,
                ];
            });

        $projects = $user->hasRole('manager') ? $user->projects : collect();
        $tasks = $user->hasRole('tim') ? $user->tasks : collect();

        return Inertia::render('User/Show', [
            'user' => $user,
            'projects' => $projects,
            'tasks' => $tasks,
            'auditTrail' => $activities,
        ]);
    }

    public function auditTrail(Request $request): Response
    {
        $activities = Activity::with(['causer', 'subject'])
        ->where('subject_type', User::class)
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

        return Inertia::render('User/History', [
            'auditTrail' => $activities,
        ]);
    }

    public function destroy(Request $request,$id) : RedirectResponse
    {
        $user = User::withTrashed()->with('roles:uuid')->findOrFail($id);
        $user->roles()->detach();

        if ($user->trashed()) {
            return redirect()->route('users')->with('error', 'User already deleted.');
        }
        $user->delete();
        return redirect()->route('users')->with('success', 'User deleted successfully.');

    }


    public function export(Request $request)
    {
        $fields = $request->input('fields', ['name', 'email', 'password', 'is_active','created_at', 'updated_at']);
        $filename = 'users' . now()->format('Ymd_His') . '_' . Str::random(5) . '.xlsx';
        $file_path = "exports/{$filename}";

        ExportJob::dispatch(User::class, $fields, $file_path);
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
        $fields   = ['name', 'email', 'password', 'is_active','created_at', 'updated_at'];
        $rows = Excel::toCollection(new DynamicImport(User::class, $fields), $request->file('file'));
        foreach ($rows as $row) {
            foreach ($fields as $field) {
                if (empty($row[$field])) {
                    return to_route('users')->with('error', "Missing data in column {$field}");
                }
            }
        }
        $filePath = $request->file('file')->store('imports', 'public');
        ImportJob::dispatch(User::class, $fields, $filePath);
    
        return to_route('users')->with('success', 'User Import process');
    }
}
