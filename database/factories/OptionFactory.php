<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'option_text' => fake()->word(),
            'is_correct' => fake()->boolean(),
        ];
    }
}
