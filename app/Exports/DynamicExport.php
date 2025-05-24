<?php

namespace App\Exports;

use App\Models\Projects;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, Exportable};

class DynamicExport implements FromCollection, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    protected $modelClass;
    protected $fields;

    public function __construct(string $modelClass, array $fields)
    {
        $this->modelClass = $modelClass;
        $this->fields = $fields;
    }

    public function collection()
    {
        return $this->modelClass::select($this->fields)->get();
    }

    public function headings(): array
    {
        return $this->fields;
    }

    public function map($project): array
    {
        return collect($this->fields)->map(fn($field) => $project->{$field})->toArray();
    }
}
