<?php

namespace App\Imports;

use App\Models\Academic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;

class AcademicsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $processed = [];
    protected $duplicates = [];

    public function model(array $row)
    {
        \Log::info('Row data: ', $row);
        $key = $row['first_name'] . $row['last_name'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$row['first_name']} {$row['last_name']}");
        }

        $this->processed[$key] = true;

        return Academic::updateOrCreate([
            'firstname' => $row['first_name'],
            'lastname' => $row['last_name'],
        ], [
            'teaching_load' => $row['teaching_load'],
            'yearly_teaching_load' => $row['yearly_teaching_load'],
            'area' => $row['area'],
            'note' => $row['note'],
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'teaching_load' => 'numeric',
            'yearly_teaching_load' => 'numeric',
            'area' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
