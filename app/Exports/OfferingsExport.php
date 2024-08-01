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
        return Offering::with(['course', 'academic'])->get()->map(function ($offering) {
            if (!$offering->course || !$offering->academic) {
                throw new Exception('Null value found in offering with id: ' . $offering->id);
            }
            return [
                'id' => $offering->id,
                'course_name' => $offering->course->code . ' ' .$offering->course->name,
                'year' => $offering->year,
                'trimester' => $offering->trimester,
                'campus' => $offering->campus,
                'convenor' => $offering->academic->firstname . ' ' . $offering->academic->lastname,
                'staff_allocated' => $offering->classSchedules->contains(function ($classSchedule) {
                    return $classSchedule->academic_id === null;
                }) ? 'No' : 'Yes',
                'note' => $offering->note,
                'reserved' => $offering->reserved,
                'created_at' => $offering->created_at,
                'updated_at' => $offering->updated_at,
                'notes' => $offering->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Course Name',
            'Year',
            'Trimester',
            'Campus',
            'Convenor',
            'Staff Allocated',
            'Note',
            'Reserved',
            'Created At',
            'Updated At',
            'Notes',
        ];
    }
}
