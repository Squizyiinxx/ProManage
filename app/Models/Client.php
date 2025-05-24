<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;
use App\Traits\WithActivityLogging;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
class Client extends Model
{
    use HasFactory, SoftDeletes, HasUuids, LogsActivity, WithActivityLogging;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = ['is_active' => 'boolean'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['id', 'name', 'email', 'phone', 'company', 'address', 'is_active'];
    protected array $logAttributes = [
        'name', 'email', 'phone', 'company', 'address', 'is_active'
    ];
    protected string $logName = 'clients';

    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
}
