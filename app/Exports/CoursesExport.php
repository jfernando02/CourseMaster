<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CoursesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $courses = Course::all();
        $entries = collect();
        
        foreach ($courses as $course) {
            $entry = [
                'id' => $course->id,
                'code' => $course->code,
                'name' => $course->name,
                'prereq' => $course->prereq,
                'offered' => $course->offerings->pluck('trimester')->unique()->map(function ($trimester) {
                    return 'Tri ' . $trimester;
                })->implode(', '),
                'transition' => $course->transition,
                'supersededby' => $course->supersededBy,
                'coursedelivery' => $course->offerings->pluck('campus')->unique()->implode(', '),
                'tmethod' => $course->tmethod,
                'note' => $course->note,
                'courselevel' => $course->course_level,
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ];
            $entries->push($entry);
        }
        return $entries;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Name',
            'Pre Requisites',
            'Offered in Terms',
            'Transition',
            'Superseded By',
            'Course Delivery',
            'Tmethod',
            'Note',
            'Course Level',
            'Created At',
            'Updated At',
        ];
    }
}
