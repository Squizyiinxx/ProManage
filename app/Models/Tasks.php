<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\WithActivityLogging;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use App\Models\Projects;
class Tasks extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity, WithActivityLogging;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'project_id',
        'assigned_to',
        'status',
        'priority',
        'due_date',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected array $logAttributes = [
        'title',
        'description',
        'created_by',
        'project_id',
        'assigned_to',
        'status',
        'priority',
        'due_date',
        'attachments',
    ];
    protected string $logName = 'Task';

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeFilter($query, array $filters): void
    {
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('status', 'like', $search)
                  ->orWhere('priority', 'like', $search)
                  ->orWhereHas('project', fn($q) => $q->where('name', 'like', $search))
                  // Relasi: Creator name
                  ->orWhereHas('creator', fn($q) => $q->where('name', 'like', $search))
                  // Relasi: Assigned user name
                  ->orWhereHas('assigned', fn($q) => $q->where('name', 'like', $search));
            });
        }

        foreach (['status', 'priority', 'assigned_to', 'project_id'] as $field) {
            if (!empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (!empty($filters['trashed']) && $filters['trashed']) {
            $query->onlyTrashed();
        }
        if (!empty($filters['sortBy'])) {
            $sortable = ['title', 'created_at', 'due_date'];
            $sortColumn = in_array($filters['sortBy'], $sortable) ? $filters['sortBy'] : 'created_at';
            $sortOrder = in_array(strtolower($filters['sortOrder'] ?? ''), ['asc', 'desc']) ? $filters['sortOrder'] : 'desc';

            $query->orderBy($sortColumn, $sortOrder);
        }
    }


}
