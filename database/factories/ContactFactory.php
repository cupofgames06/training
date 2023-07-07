<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contactable = $this->contactable();
        return [
            'contactable_id' => $contactable::factory(),
            'contactable_type' => $contactable,
            'title' => fake()->randomElement(['male', 'female','neutral']),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            //'function'    => fake()->phoneNumber,
            'function'    => fake()->jobTitle(),
        ];
    }
    public function contactable()
    {
        return fake()->randomElement([
            Company::class
            //Of::class
        ]);
    }
}
