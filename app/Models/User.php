<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\WithActivityLogging;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Projects;
use App\Models\Tasks;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids,HasRoles, LogsActivity,WithActivityLogging;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $logAttributes =  [
        'name',
        'email',
        'password',
        'is_active',
        'preferences'
    ];
    protected string $logName = 'User';


    public function projects()
    {
        return $this->hasMany(Projects::class,'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'assigned_to');
    }

}
