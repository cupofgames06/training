<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Entity;
use App\Models\Of;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class OfSeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Of::factory()->count(1)->create()->each(function($item) {
            // création of
            $manager = User::factory()->create([
                'email'             => 'of@of.com',
                'password'          => Hash::make('of@of.com'),
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ]);
            $manager->assignRole('of');
            parent::addProfileInfos($manager);


            Address::factory()->for(
                $item, 'addressable'
            )->create();

            Entity::factory()->for(
                $item, 'modelable'
            )->create();

            Contact::factory()->count(fake()->numberBetween(1,3))->for(
                $item, 'contactable'
            )->create();

            $item->addUser($manager->id);
        });

    }
}
