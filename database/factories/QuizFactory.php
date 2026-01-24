<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'section_id' => Section::factory(),
            'time_limit' => fake()->numberBetween(-10000, 10000),
            'max_attempts' => fake()->numberBetween(-10000, 10000),
            'is_published' => fake()->boolean(),
            'available_from' => fake()->dateTime(),
            'available_until' => fake()->dateTime(),
        ];
    }
}
