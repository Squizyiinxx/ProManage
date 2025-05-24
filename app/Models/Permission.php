<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\WithActivityLogging;

class Permission extends SpatiePermission
{
    use HasFactory,HasUuids,LogsActivity,WithActivityLogging;
    protected $table = 'permissions';
    protected $primaryKey = 'uuid';

    protected array $logAttributes = ['name'];
    protected string $logName = 'Permission';

    
}
