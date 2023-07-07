<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SessionDay>
 */
class SessionDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => fake()->dateTimeBetween('now','+30 days'),
            'am_start' => fake()->time,
            'am_end' => fake()->time,
        ];
    }
}
