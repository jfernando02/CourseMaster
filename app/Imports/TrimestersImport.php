<?php

namespace App\Imports;

use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\Academic;
use App\Models\Offering;
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
        $row['start_time'] = sprintf('%02d:%02d', floor($row['start_time'] * 24), round(60*($row['start_time'] * 24 - floor($row['start_time'] * 24))));
        $row['end_time'] = sprintf('%02d:%02d', floor($row['end_time'] * 24), round(60*($row['end_time'] * 24 - floor($row['end_time'] * 24))));
        return $row;
    }

    public function model(array $row)
    {

        $course = Course::where('code', $row['course_code'])->first();
        if (!$course) {
            throw new Exception("Course not found: {$row['course_code']}");
        }

        $academic = Academic::where('firstname', $row['academic_firstname'])
            ->where('lastname', $row['academic_lastname'])
            ->first();

        if (!$academic) {
            throw new Exception("Academic not found: {$row['academic_firstname']} {$row['academic_lastname']}");
        }

        $offering = Offering::where('course_id', $course->id)
            ->where('trimester', $row['trimester'])
            ->where('year', $row['year'])
            ->where('campus', $row['campus'])
            ->first();

        if (!$offering) {
            throw new Exception("Offering not found: {$course->id} {$row['trimester']} {$row['year']} {$academic->id}");
            // throw new Exception("Offering not found: {$row['course_code']} {$row['trimester']} {$row['year']} {$row['academic_firstname']} {$row['academic_lastname']}");
        }

        $key = $offering->id . $academic->id . $row['class_type'] . $row['start_time'] . $row['end_time'] . $row['class_day'] . $row['numberofstudents'] . $row['campus'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$offering->id} {$academic->id} {$row['class_type']} {$row['start_time']} {$row['end_time']} {$row['class_day']} {$row['numberofstudents']} {$row['campus']}");
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
            'course_code' => 'required|string',
            'trimester' => 'required|integer',
            'year' => 'required|integer',
            'campus' => 'required|string',
            'class_type' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'class_day' => 'required|string'
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
