<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\WithActivityLogging;

class Role extends SpatieRole
{
    use HasFactory,HasUuids,LogsActivity, WithActivityLogging;
    protected $table = 'roles';
    protected $primaryKey = 'uuid';
    protected array $logAttributes = ['name'];
    protected string $logName = 'Role';

    
}
