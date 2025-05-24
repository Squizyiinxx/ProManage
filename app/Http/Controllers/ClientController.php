<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ExportJob;
use App\Jobs\ImportJob;
use App\Models\ExportHistory;
use Illuminate\Support\Str;
use App\Imports\DynamicImport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{

    /**
     * Display a listing of clients with filters and sorting.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $query = Client::query()
            ->with(['projects' => function ($query) {
                $query->withTrashed()
                    ->select(['id', 'name','client_id','manager_id','status', 'deleted_at']);
            }])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%' . $request->input('search') . '%';
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                      ->orWhere('company', 'like', $search)
                      ->orWhere('email', 'like', $search)
                      ->orWhere('phone', 'like', $search);
                });
            })
            ->when($request->boolean('trashed'), function ($query) {
                return $query->onlyTrashed();
            })
            ->when($request->filled('datePreset'), function ($query) use ($request) {
                switch ($request->input('datePreset')) {
                    case 'today':
                        $query->whereDate('created_at', now()->toDateString());
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                        break;
                    case 'year':
                        $query->whereYear('created_at', now()->year);
                        break;
                }
            });
            $allowedSortFields = ['name', 'created_at'];
        $sortBy = in_array($request->input('sortBy'), $allowedSortFields)
            ? $request->input('sortBy')
            : 'name';

        $sortOrder = in_array(strtolower($request->input('sortOrder')), ['asc', 'desc'])
            ? strtolower($request->input('sortOrder'))
            : 'asc';

        $clients = $query->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->withQueryString();

            $export = ExportHistory::where('user_id', auth()->id())->select(['id'])->latest()->first(); 

        return inertia('Clients', [
            'clients' => $clients,
            'file' => $export,
            'filters' => $request->only(['search', 'sortBy', 'sortOrder', 'trashed']),
        ]);
    }

    /**
     * Store a newly created client.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => [
                'required',
                'email:rfc',
                'unique:clients,email',
                'max:255',
                'string'
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9\-]+$/',
                'min:10'
            ],
            'company' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:500',
                'min:10'
            ],
        ], [
            'name.regex' => 'The name field should only contain letters and spaces.',
            'phone.regex' => 'The phone number format is invalid.',
            'phone.min' => 'The phone number must be at least 10 digits.',
            'email.email' => 'Please provide a valid email address.',
            'company.unique' => 'This company is already registered in our system.',
            'address.min' => 'The address must be at least 10 characters long.'
        ]);

        try {
            $validated['phone'] = $this->formatPhoneNumber($validated['phone']);

            Client::create($validated);
            return redirect()
                ->route('clients')
                ->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create client. Please try again.');
        }
    }

    public function auditTrail(Request $request): Response
    {
        $activities = Activity::with(['causer', 'subject'])
        ->where('subject_type', Client::class)
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

        return Inertia::render('Client/History', [
            'auditTrail' => $activities,
        ]);
    }

    public function show($id): Response
    {
        $client = Client::with(['projects'])->findOrFail($id);

        $activities = Activity::forSubject($client)
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

        return Inertia::render('Client/Show', [
            'client' => $client,
            'auditTrail' => $activities,
        ]);
    }

    /**
     * Update the specified client.
     *
     * @param Request $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(Request $request,$id): RedirectResponse
    {
        $client = Client::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email,' . $client->id],
            'phone' => ['required', 'string', 'max:15'],
            'company' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
        ]);
        try {
            $validated['phone'] = $this->formatPhoneNumber($validated['phone']);
            $client->update($validated);
            return redirect()
                ->route('clients')
                ->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update client. Please try again.');
        }
    }

    /**
     * Soft delete the specified client.
     *
     * @param Client $client
     * @return RedirectResponse
     */
    public function destroy($id) : RedirectResponse
    {
        $client = Client::withTrashed()->findOrFail($id);

        if ($client->trashed()) {
            return redirect()->route('clients')->with('error', 'Project already deleted.');
        }
        $client->delete();
        return redirect()->route('clients')->with('success', 'Project deleted successfully.');

    }

    /**
     * Restore a soft-deleted client.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
    {
        try {
            $client = Client::withTrashed()->findOrFail($id);
            $client->restore();

            return redirect()
                ->route('clients')
                ->with('success', 'Client restored successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to restore client. Please try again.');
        }
    }

    /**
     * Force delete the client permanently.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function forceDelete(int $id): RedirectResponse
    {
        try {
            $client = Client::withTrashed()->findOrFail($id);
            if ($client->projects()->withTrashed()->exists()) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot permanently delete client with project history.');
            }

            $client->forceDelete();

            return redirect()
                ->route('clients.index')
                ->with('success', 'Client permanently deleted.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to permanently delete client. Please try again.');
        }
    }

    /**
     * Format phone number to standard format.
     *
     * @param string $phone
     * @return string
     */
    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = ltrim($phone, '0');
        $phone = preg_replace('/^62/', '', $phone);
        if (strlen($phone) > 3) {
            $phone = substr($phone, 0, 3) . '-' . substr($phone, 3);
            if (strlen($phone) > 7) {
                $phone = substr($phone, 0, 7) . '-' . substr($phone, 7);
            }
        }

        return '+62 ' . $phone;
    }


    public function export(Request $request)
    {
        $fields = $request->input('fields', ['name', 'email', 'phone', 'company', 'address', 'is_active', 'created_at', 'updated_at']);
        $filename = 'clients' . now()->format('Ymd_His') . '_' . Str::random(5) . '.xlsx';
        $file_path = "exports/{$filename}";

        ExportJob::dispatch(Client::class, $fields, $file_path);
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
        $fields   = ['name', 'email', 'phone', 'company', 'address', 'is_active', 'created_at', 'updated_at'];
        $rows = Excel::toCollection(new DynamicImport(Client::class, $fields), $request->file('file'));
        foreach ($rows as $row) {
            foreach ($fields as $field) {
                if (empty($row[$field])) {
                    return to_route('clients')->with('error', "Missing data in column {$field}");
                }
            }
        }
        $filePath = $request->file('file')->store('imports', 'public');
        ImportJob::dispatch(Client::class, $fields, $filePath);
    
        return to_route('clients')->with('success', 'Task Import process');
    }
}
