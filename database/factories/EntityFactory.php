<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Entity;
use App\Models\Group;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelable = $this->modelable();
        return [
            'modelable_id' => $modelable::factory(),
            'modelable_type' => $modelable,
            'type' => fake()->randomElement(['EI','EURL','SASU','SNC','SCS','SCA','SARL','SA','SAS']),
            'reg_number' => fake('en_ZA')->companyNumber,
            'vat_number' => fake('fr_FR')->vat,
            'name' => fake()->company
        ];
    }

    public function modelable()
    {
        return fake()->randomElement([
            Company::class,
            Trainer::class,
            Group::class
        ]);
    }
}
