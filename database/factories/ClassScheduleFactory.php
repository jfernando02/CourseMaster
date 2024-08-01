<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClassSchedule;
use App\Models\Academic;
use App\Models\Offering;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassSchedule>
 */
class ClassScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassSchedule::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // An array of hourly start times from 8 am to 7 pm
        $startTimes = [];
        $currentTime = '08:00';
        while ($currentTime <= '19:00') {
            $startTimes[] = $currentTime;
            $currentTime = \Carbon\Carbon::createFromTimeString($currentTime)->addHour()->format('H:i');
        }
        
        // Count the number of classes associated with the offering
        // $offeringId = Offering::inRandomOrder()->value('id');
        $offeringId = Offering::where('year', 2024)->where('trimester', 1)->inRandomOrder()->value('id');

        $classCount = ClassSchedule::where('offering_id', $offeringId)->count();

        // Check if the offering already has 5 classes, return null to skip creating a new class.
        // This is to avoid creating more than 5 classes for an offering for the same year and trimester
        if ($classCount >= 5) {
            return null;
        }

        return [
            'offering_id' => $offeringId, 
            'academic_id' => Academic::inRandomOrder()->first()->id, // assign random lecturers from academic table
            'class_type' => $this->faker->randomElement(['Lecture', 'Workshop']), // randomly assign class type
            'start_time' => $this->faker->randomElement($startTimes), // randomly assign start time
            'end_time' => function (array $attributes) {
                // Calculate end time 1hr 50mins after start time
                $startTime = \Carbon\Carbon::createFromTimeString($attributes['start_time']);
                return $startTime->addHours(1)->addMinutes(50)->format('H:i');
            },
            'class_day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']), // randomly assign class day
            'numberOfStudents' => $this->faker->numberBetween(10, 40), // randomly assign number of students
        ];
    }

}
