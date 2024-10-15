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
        $course = Course::where('code', $row['course_id'])->first();
        if (!$course) {
            throw new Exception("Course not found: {$row['course_id']}");
        }

        $key = $course->id . $row['trimester'] . $row['year'] . $row['campus'];

        if (isset($this->processed[$key])) {
            throw new Exception("Duplicate entry found: {$row['course_id']} {$row['trimester_id']} {$row['year']} {$row['campus']}");
        }

        $this->processed[$key] = true;

        $offering = Offering::updateOrCreate([
            'course_id' => $course->id,
            'trimester' => $row['trimester'],
            'year' => $row['year'],
            'campus' => $row['campus']
        ], [
            'note' => $row['note']
        ]);

        $academics = $row['academics'];
        $academics = json_decode($academics, true);

        if($academics!==null) {
            foreach ($academics as $academic) {
                $nameParts = explode(" ", $academic); // Split the string into an array: ['First', 'Last']
                $firstName = $nameParts[0];
                $lastName = $nameParts[1];
                $academic = Academic::where('firstname', $firstName)
                    ->where('lastname', $lastName)
                    ->first();

                if (!$academic) {
                    throw new Exception("Academic not found: {$firstName} {$lastName}");
                }
                $offering->academics()->sync($academic->id);
            }
        }

        return $offering;
    }

    public function rules(): array
    {

        return [
            'course_id' => 'required|string',
            'trimester' => 'required|numeric',
            'year' => 'required|numeric',
            'campus' => 'required|string',
            'academics' => 'nullable|json',
            'academics.*' => 'string',
            'note' => 'nullable|string',
        ];
    }

    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
