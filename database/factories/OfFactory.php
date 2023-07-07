<?php

namespace Database\Factories;

use App\Models\Of;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Of>
 */
class OfFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agreement_number' => fake()->uuid,
            'licence_percent' => fake()->numberBetween(0, 100),
            'charge_percent' => fake()->numberBetween(0, 100)
        ];
    }
}
