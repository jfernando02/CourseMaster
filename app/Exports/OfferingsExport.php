<?php

namespace App\Exports;

use App\Models\Offering;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Exception;

class OfferingsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Offering::with(['course'])->get()->map(function ($offering) {
            if (!$offering->course) {
                throw new Exception('Null value found in offering with id: ' . $offering->id);
            }
            return [
                'id' => $offering->id,
                'course_id' => $offering->course->code,
                'year' => $offering->year,
                'trimester' => $offering->trimester,
                'campus' => $offering->campus,
                'academics' => $offering->academics()->get()->map(function ($academic) {
                    return $academic->firstname . ' ' . $academic->lastname;
                })->toArray(),
                'note' => $offering->note,
                'created_at' => $offering->created_at,
                'updated_at' => $offering->updated_at
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'course_id',
            'year',
            'trimester',
            'campus',
            'academics',
            'note',
            'created_at',
            'updated_at'
        ];
    }
}
