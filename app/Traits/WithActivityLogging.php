<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

trait WithActivityLogging
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->logAttributes ?? ['*'])
            ->useLogName($this->logName ?? class_basename($this))
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        if (auth()->check()) {
            $activity->causer_id = auth()->id();
            $activity->causer_type = get_class(auth()->user());
        }

        $modelName = $this->logName ?? class_basename($this);
        $actor = auth()->check() ? auth()->user()->name : 'System';

        $activity->description = "{$actor} {$eventName} {$modelName}";
    }
}
