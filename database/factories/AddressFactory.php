<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $addressable = $this->addressable();
        return [
            'addressable_id' => $addressable::factory(),
            'addressable_type' => $addressable,
            'street_number' => fake()->buildingNumber,
            'street_name'=> fake()->streetName ,
            'complement'=> fake()->streetAddress,
            'postal_code'=> fake()->postcode,
            'latitude'=> fake()->latitude(),
            'longitude'=> fake()->longitude(),
            'city'=> fake()->city,
            'country_id' => Country::all()->pluck('id')->random()
        ];
    }

    public function addressable()
    {
        return fake()->randomElement([
           Company::class
        ]);
    }
}
