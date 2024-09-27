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
        $key = $row['firstname'] . $row['lastname'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$row['firstname']} {$row['lastname']}");
        }

        $this->processed[$key] = true;

        return Academic::updateOrCreate([
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'teaching_load' => 'numeric',
            'yearly_teaching_load' => 'numeric',
            'area' => 'required|string',
            'note' => 'nullable|string',
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
