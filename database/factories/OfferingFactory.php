<?php

namespace Database\Factories;
use App\Models\Course;
use App\Models\Academic;
use App\Models\Offering;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offering>
 */
class OfferingFactory extends Factory
{
    /**
     * The name of the model that the factory belongs to.
     *
     * @var string
     */
    protected $model = Offering::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'course_id' => Course::inRandomOrder()->first()->id,  // Fetching random course ID
            'year' => $this->faker->numberBetween(2022, 2024),    // Random year between 2020 and 2024
            'trimester' => $this->faker->numberBetween(1, 3),     // Random trimester between 1 and 3
            'campus' => $this->faker->randomElement(['GC', 'NA', 'OL']), // Random campus
            'academic_id' => Academic::inRandomOrder()->first()->id, // Fetching random academic ID
            'note' => null  // Default note as null
        ];
   }
}

php artisan db:seed --class=SeederClassName
