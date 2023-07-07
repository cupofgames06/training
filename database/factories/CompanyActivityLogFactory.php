<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Tags\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyActivityLog>
 */
class CompanyActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'properties' => json_encode(array(
                "email" => fake()->email,
                "start_date" => fake()->date,
                "end_date" => fake()->date,
                'job_title'  => Tag::where('type','function')->get()->pluck('id')->random(),
                'service' => Tag::where('type','service')->get()->pluck('id')->random()
            ))
        ];
    }
}
