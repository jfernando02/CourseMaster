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
                'transition' => $course->transition,
                'supersededby' => $course->supersededBy,
                'courselevel' => $course->course_level,
                'note' => $course->note,
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
            'code',
            'name',
            'prereq',
            'transition',
            'supersededBy',
            'course_level',
            'note',
            'created_at',
            'updated_at',
        ];
    }
}
