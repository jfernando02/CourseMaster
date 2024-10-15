<?php

namespace App\Exports;

use App\Models\ClassSchedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrimestersExport implements FromCollection, WithHeadings
{
    protected $trimester;
    protected $year;

    public function __construct(int $trimester, int $year)
    {
        $this->trimester = $trimester;
        $this->year = $year;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return ClassSchedule::with('offering', 'academic')
            ->whereHas('offering', function($query) {
                $query->where('trimester', $this->trimester)
                    ->where('year', $this->year);
            })
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'offering_course_code' => $schedule->offering->course->code,
                    'offering_trimester' => $schedule->offering->trimester,
                    'offering_year' => $schedule->offering->year,
                    'offering_campus' => $schedule->offering->campus,
                    'academic' => $schedule->academic->first() ? $schedule->academic->first()->firstname . ' ' . $schedule->academic->first()->lastname : 'N/A',
                    'teaching_load' => $schedule->academic->first() ? $schedule->academic->first()->teachingHours($schedule->offering->year, $schedule->offering->trimester) : 'N/A',
                    'yearly_teaching_load' => $schedule->academic->first() ? $schedule->academic->first()->teachingHours($schedule->offering->year, 0) : 'N/A',
                    'class_type' => $schedule->class_type,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'class_day' => $schedule->class_day,
                    'created_at' => $schedule->created_at,
                    'updated_at' => $schedule->updated_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'offering_course_code',
            'offering_trimester',
            'offering_year',
            'offering_campus',
            'academic',
            'teaching_load',
            'yearly_teaching_load',
            'class_type',
            'start_time',
            'end_time',
            'class_day',
            'created_at',
            'updated_at',
        ];
    }
}
