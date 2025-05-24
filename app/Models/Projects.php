<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity as act;
use App\Traits\WithActivityLogging;
use App\Models\Client;
use App\Models\User;
use App\Models\Tasks;


class Projects extends Model
{
    use HasFactory, SoftDeletes, HasUuids,LogsActivity, WithActivityLogging;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'uuid', 'name', 'description', 'client_id', 'manager_id',
        'status', 'started_at', 'deadline', 'is_active', 'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'started_at' => 'datetime',
        'deadline' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected array $logAttributes = [ 'name', 'description', 'client_id', 'manager_id','status', 'started_at', 'deadline', 'is_active', 'attachments'];
    protected string $logName = 'Project';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function tasks()
    {
        return $this->hasMany(Tasks::class,'project_id');
    }
}
