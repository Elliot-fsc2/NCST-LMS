<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'student_id' => Student::factory(),
            'score' => fake()->randomFloat(2, 0, 999.99),
            'started_at' => fake()->dateTime(),
            'completed_at' => fake()->dateTime(),
        ];
    }
}
