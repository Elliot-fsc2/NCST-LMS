<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_attempt_id' => QuizAttempt::factory(),
            'question_id' => Question::factory(),
            'option_id' => Option::factory(),
            'answer_text' => fake()->text(),
            'is_correct' => fake()->boolean(),
        ];
    }
}
