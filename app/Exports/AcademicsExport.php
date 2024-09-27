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
            'First Name',
            'Last Name',
            'Teaching Load',
            'Area',
            'Note',
            'Created At',
            'Updated At',
            'Home Campus',
            'Email',
            'Yearly Teaching Load'
        ];
    }
}
