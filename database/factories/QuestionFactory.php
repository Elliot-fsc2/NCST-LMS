<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question_text' => fake()->text(),
            'question_type' => fake()->word(),
            'correct_answer' => fake()->text(),
            'points' => fake()->randomFloat(2, 0, 999.99),
        ];
    }
}
