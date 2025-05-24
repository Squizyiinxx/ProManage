<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class DynamicImport implements ToCollection, WithHeadingRow
{
    protected $modelClass;
    protected $fields;

    public function __construct(string $modelClass, array $fields)
    {
        $this->modelClass = $modelClass;
        $this->fields = $fields;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = [];
            foreach ($this->fields as $field) {
                $data[$field] = $row[$field] ?? null;
            }
            $this->modelClass::create($data);
        }
    }
}
