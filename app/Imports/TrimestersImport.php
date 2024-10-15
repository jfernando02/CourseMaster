<?php

namespace App\Imports;

use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\Academic;
use App\Models\Offering;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;

class TrimestersImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $processed = [];
    protected $duplicates = [];

    public function prepareForValidation($row)
    {
        //Excel stores times as fractions, turn from fraction to time (e.g 12PM is stored as 0.5, turn this to 12:00)
        if(!str_contains($row['start_time'], ':')) {
            $row['start_time'] = sprintf('%02d:%02d', floor($row['start_time'] * 24), round(60 * ($row['start_time'] * 24 - floor($row['start_time'] * 24))));
        }
        if(!str_contains($row['end_time'], ':')) {
            $row['end_time'] = sprintf('%02d:%02d', floor($row['end_time'] * 24), round(60 * ($row['end_time'] * 24 - floor($row['end_time'] * 24))));
        }
        return $row;
    }

    public function model(array $row)
    {

        $course = Course::where('code', $row['offering_course_code'])->first();
        if (!$course) {
            throw new Exception("Course not found: {$row['offering_course_code']}");
        }

        $offering = Offering::where('course_id', $course->id)
            ->where('trimester', $row['offering_trimester'])
            ->where('year', $row['offering_year'])
            ->where('campus', $row['offering_campus'])
            ->first();

        if (!$offering) {
            throw new Exception("Offering not found: {$course->code} {$row['offering_trimester']} {$row['offering_year']} {$row['offering_campus']}");
        }

        $key = $offering->id . $row['class_type'] . $row['start_time'] . $row['end_time'] . $row['class_day'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$offering->id} {$row['class_type']} {$row['start_time']} {$row['end_time']} {$row['class_day']}");
        }

        $this->processed[$key] = true;

        return ClassSchedule::updateOrCreate([
            'offering_id' => $offering->id,
            'class_type' => $row['class_type'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'class_day' => $row['class_day']
        ]);
    }

    public function rules(): array
    {
        return [
            'offering_course_code' => 'required|string',
            'offering_trimester' => 'required|integer',
            'offering_year' => 'required|integer',
            'offering_campus' => 'required|string',
            'class_type' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'class_day' => 'nullable|string'
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
