<?php

namespace App\Exports;

use App\Models\Academic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AcademicsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Academic::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'first_name',
            'last_name',
            'teaching_load',
            'area',
            'note',
            'created_at',
            'updated_at',
            'home_campus',
            'email',
            'yearly_teaching_load'
        ];
    }
}
