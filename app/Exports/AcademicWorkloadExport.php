<?php

namespace App\Exports;

use App\Models\Academic;
use App\Models\Setting;
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
        $setting = Setting::latest('created_at')->first();

        foreach ($academics as $academic) {
            $offerings = $academic->offerings()
                ->where('year', $setting->current_year)
                ->where('trimester', $setting->current_trimester)
                ->get();
            $courseCodes = [];

            foreach ($offerings as $offering) {
                $courseCodes[] = $offering->course->code;
            }
            $entry = [
                'trimester' => 'Trimester '.$setting->current_trimester.' '.$setting->current_year,
                'id' => $academic->id,
                'fullname' => $academic->firstname.' '.$academic->lastname,
                'teaching_load' => $academic->teachingHours($setting->current_year, $setting->current_trimester),
                'yearly_teaching_load' => $academic->teachingHours($setting->current_year),
                'area' => $academic->area,
                'courses' => $courseCodes,
                'home_campus' => $academic->home_campus,
                'note' => $academic->note,
                'created_at' => $academic->created_at,
                'updated_at' => $academic->updated_at,
            ];
            $entries->push($entry);
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
            'Assigned Courses for Trimester',
            'Home Campus',
            'Note',
            'Created At',
            'Updated At',
        ];
    }
}
