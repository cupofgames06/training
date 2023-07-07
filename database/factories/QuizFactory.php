<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => Quiz::QUIZ_TYPE[rand(0,count(Quiz::QUIZ_TYPE)-1)],
            //'name' => fake_translation('word'),
            //'description' => fake_translation('text')
        ];
    }
}
