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
            'area' => $row['area'],
            'note' => $row['note'],
            'home_campus' => $row['home_campus'],
            'email' => $row['email'],
            'yearly_teaching_load' => $row['yearly_teaching_load'],
        ]);
    }

    public function rules(): array
    {
        request()->merge([
            'yearly_teaching_load' => request()->input('yearly_teaching_load', 0),
            'teaching_load' => request()->input('teaching_load', 0),
        ]);

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'teaching_load' => 'nullable|numeric',
            'area' => 'nullable|string',
            'note' => 'nullable|string',
            'home_campus' => 'nullable|string',
            'email' => 'nullable|string',
            'yearly_teaching_load' => 'nullable|numeric',
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
