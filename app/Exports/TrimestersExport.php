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
                    'offering' => $schedule->offering->course ? $schedule->offering->course->code . ' ' . $schedule->offering->course->name : "N/A",
                    'academic' => $schedule->academic->first() ? $schedule->academic->first()->firstname . ' ' . $schedule->academic->first()->lastname : 'N/A',
                    'teaching_load' => $schedule->academic->first() ? $schedule->academic->first()->teaching_load : 'N/A',
                    'class_type' => $schedule->class_type,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'class_day' => $schedule->class_day,
                    'trimester' => $schedule->offering->trimester,
                    'year' => $schedule->offering->year,
                    'campus' => $schedule->offering->campus,
                    'created_at' => $schedule->created_at,
                    'updated_at' => $schedule->updated_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Offering',
            'Academic',
            'Teaching Load',
            'Class Type',
            'Start Time',
            'End Time',
            'Class Day',
            'Trimester',
            'Year',
            'Campus',
            'Created At',
            'Updated At',
        ];
    }
}
