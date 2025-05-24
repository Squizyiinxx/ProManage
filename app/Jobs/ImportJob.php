<?php

namespace App\Jobs;

use App\Imports\DynamicImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public string $modelClass,
        public array $fields,
        public string $path
    ) {}

    public function handle(): void
    {
        try {
            Excel::import(
                new DynamicImport($this->modelClass, $this->fields),
                $this->path,
                'public'
            );
        } catch (\Exception $e) {
            \Log::error("ImportJob gagal: {$e->getMessage()}", [
                'model' => $this->modelClass,
                'path' => $this->path,
            ]);
            throw $e;
        }
    }
    
}
