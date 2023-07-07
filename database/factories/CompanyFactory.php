<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\PriceLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_level_id' => PriceLevel::all()->pluck('id')->random(),
            'group_id' => /*fake()->boolean()?Group::all()->pluck('id')->random():*/null
        ];
    }
}
