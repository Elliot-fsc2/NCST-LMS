<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeacherFactory extends Factory
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
            'department_id' => Department::inRandomOrder()->first()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function ($teacher) {
            User::create([
                'name' => $teacher->first_name . ' ' . $teacher->last_name,
                'email' => Str::lower($teacher->first_name . '.' . $teacher->last_name . '@teacher.edu'),
                'password' => 'password',
                'role' => 'teacher',
                'userable_type' => get_class($teacher),
                'userable_id' => $teacher->id,
            ]);
        });
    }
}
