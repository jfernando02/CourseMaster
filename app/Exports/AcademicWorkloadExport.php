<?php

namespace App\Exports;

use App\Models\Academic;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AcademicWorkloadExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $academics = Academic::all();
        $entries = collect();

        foreach ($academics as $academic) {
            $classSchedules = $academic->classSchedules()
                ->join('offerings', 'classschedule.offering_id', '=', 'offerings.id')
                ->select('offerings.year', 'offerings.trimester')
                ->distinct()
                ->orderBy('offerings.year', 'desc')
                ->orderBy('offerings.trimester', 'desc')
                ->take(3)
                ->get();

            foreach ($classSchedules as $classSchedule) {
                $courseNames = $academic->classSchedules()
                ->join('offerings', 'classschedule.offering_id', '=', 'offerings.id')
                ->join('courses', 'offerings.course_id', '=', 'courses.id')
                ->select(DB::raw("courses.code || ' - ' || courses.name AS course"))
                ->where('offerings.year', $classSchedule->year)
                ->where('offerings.trimester', $classSchedule->trimester)
                ->distinct()
                ->pluck('course')
                ->toArray();
                $entry = [
                    'trimester' => 'Trimester '.$classSchedule->trimester.' '.$classSchedule->year,
                    'id' => $academic->id,
                    'fullname' => $academic->firstname.' '.$academic->lastname,
                    'teaching_load' => $academic->teachingHours($academic->id, $classSchedule->year, $classSchedule->trimester),
                    'yearly_teaching_load' => $academic->teachingHours($academic->id, $classSchedule->year),
                    'area' => $academic->area,
                    'courses' => implode(", ", $courseNames),
                    'home_campus' => $academic->home_campus,
                    'note' => $academic->note,
                    'created_at' => $academic->created_at,
                    'updated_at' => $academic->updated_at,
                ];
                // $entry = clone $academic; // clone the academic to create a new entry
                // $entry->trimester = 'Trimester '.$classSchedule->trimester.' '.$classSchedule->year;
                // $entry->teaching_load = $academic->teachingHoursperSem($academic->id, $classSchedule->year, $classSchedule->trimester);
                // $entry->courses = implode(", ", $courseNames);
                $entries->push($entry);
            }
        }
        return $entries;
    }

    public function headings(): array
    {
        return [
            'Teaching Term',
            'ID',
            'Full Name',
            'Total Teaching Load',
            'Total Teaching Load (Year)',
            'Area',
            'Allocated Courses',
            'Home Campus',
            'Note',
            'Created At',
            'Updated At',
        ];
    }
}
