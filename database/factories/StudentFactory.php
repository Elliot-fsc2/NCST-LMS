<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->word(),
            'last_name' => fake()->lastName(),
            'student_number' => fake()->word(),
            'course_id' => Course::factory(),
        ];
    }
}
