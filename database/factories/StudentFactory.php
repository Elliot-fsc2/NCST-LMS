<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'student_number' => fake()->unique()->numerify(date('Y') . '-#####'),
            'course_id' => Course::inRandomOrder()->first()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function ($student) {
            User::create([
                'name' => $student->first_name . ' ' . $student->last_name,
                'email' => Str::lower($student->first_name . '.' . $student->last_name . '@student.edu'),
                'password' => 'password',
                'role' => 'student',
                'userable_type' => get_class($student),
                'userable_id' => $student->id,
            ]);
        });
    }
}
