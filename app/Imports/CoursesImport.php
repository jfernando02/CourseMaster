<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;

class CoursesImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $processed = [];
    protected $duplicates = [];

    public function model(array $row)
    {
        $key = $row['code'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$row['code']}");
        }

        $this->processed[$key] = true;

        return Course::updateOrCreate([
            'code' => $row['code'],
        ], [
            'name' => $row['name'],
            'prereq' => $row['prereq'],
            'transition' => $row['transition'],
            'note' => $row['note'],
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'prereq' => 'nullable|string',
            'transition' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
