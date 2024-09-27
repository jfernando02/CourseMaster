<?php

namespace App\Imports;

use App\Models\Offering;
use App\Models\Course;
use App\Models\Academic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;

class OfferingsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $processed = [];
    protected $duplicates = [];

    public function model(array $row)
    {
        $course = Course::where('code', $row['course_code'])->first();
        if (!$course) {
            throw new Exception("Course not found: {$row['course_code']}");
        }

        $academic = Academic::where('firstname', $row['instructor_firstname'])
            ->where('lastname', $row['instructor_lastname'])
            ->first();

        if (!$academic) {
            throw new Exception("Academic not found: {$row['instructor_firstname']} {$row['instructor_lastname']}");
        }

        $key = $course->id . $row['trimester'] . $row['year'] . $academic->id;

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$row['course_code']} {$row['trimester_id']} {$row['year']} {$row['academic_id']}");
        }

        $this->processed[$key] = true;

        return Offering::updateOrCreate([
            'course_id' => $course->id,
            'trimester' => $row['trimester'],
            'year' => $row['year'],
            'campus' => $row['campus']
        ], [
            'note' => $row['note']
        ]);
    }

    public function rules(): array
    {
        return [
            'course_code' => 'required|string',
            'trimester' => 'required|numeric',
            'year' => 'required|numeric',
            'campus' => 'required|string',
            'note' => 'nullable|string'
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
