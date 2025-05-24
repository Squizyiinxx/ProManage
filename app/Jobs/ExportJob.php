<?php
namespace App\Jobs;

use App\Exports\DynamicExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public string $modelClass,
        public array $fields,
        public string $path
    ) {}

    public function handle(): void
    {
        Excel::store(
            new DynamicExport($this->modelClass, $this->fields),
            $this->path,
            'public'
        );
    }
}
