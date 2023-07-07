<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // création super admin
        $user = User::factory()->create([
            'email'             => 'info@milleniumprod.com',
            'password'          => Hash::make('millsebjb'),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
        $user->assignRole('super-admin');

    }
    protected function addProfileInfos(User $user)
    {
        $dummyInfo = [
            'title' => fake()->randomElement(['male', 'female','neutral']),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_1'    => fake()->phoneNumber,
            'phone_2'    => fake()->phoneNumber,
            'birth_date'  => fake()->dateTimeBetween('1960-01-01', '2012-12-31'),
            'birth_zipcode'=> fake()->postcode,
            'birth_country_id' => Country::all()->pluck('id')->random(),
        ];

        $info = new Profile();
        foreach ($dummyInfo as $key => $value) {
            $info->$key = $value;
        }
        $info->user()->associate($user);
        $info->save();
    }
}
