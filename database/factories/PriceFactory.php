<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\PriceLevel;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ht = fake()->numberBetween(15, 1000);
        return [
            'price_level_id' => PriceLevel::all()->pluck('id')->random(),
            'price_ht' =>  $ht,
            'price_ttc' => $ht * 1.2,
            'vat_amount' =>  $ht * 1.2 - $ht,
            'charge' => fake()->numberBetween(15, 100),
            'type' => fake()->randomElement(['default','forfeit']),
        ];
    }
}
