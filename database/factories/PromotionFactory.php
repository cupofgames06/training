<?php

namespace Database\Factories;

use App\Models\Of;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'of_id' => Of::all()->pluck('id')->random(),
            'code' => fake()->word,
            'percent' => fake()->boolean(),
            'date_start' => fake()->date,
            'date_end' => fake()->date,
            'amount' => fake()->randomFloat(2,0,100),
            'name' => fake_translation(),
            'status' => fake()->randomElement(Promotion::STATUS)
        ];
    }
}
