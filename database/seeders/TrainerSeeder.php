<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\Entity;
use App\Models\Profile;
use App\Models\Trainer;
use App\Models\TrainerDescription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TrainerSeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Trainer::factory()->count(1)
            ->create([
                'email'             => 'trainer@trainer.com',
                'password'          => Hash::make('trainer@trainer.com'),
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ])->each(function($item){
                parent::addProfileInfos($item);
                $item->assignRole('trainer');
                Address::factory()->for(
                    $item, 'addressable'
                )->create();
                Entity::factory()->for(
                    $item, 'modelable'
                )->create();

                $description = new TrainerDescription();
                $description->trainer()->associate($item);
                $description->save();

            });

        Trainer::factory()->count(4)->create()->each(function($item){
            parent::addProfileInfos($item);
            self::addTrainerInfos($item);
            $item->assignRole('trainer');
            Address::factory()->for(
                $item, 'addressable'
            )->create();
            Entity::factory()->for(
                $item, 'modelable'
            )->create();

            $description = new TrainerDescription();
            $description->trainer()->associate($item);
            $description->save();
        });
    }

    protected function addTrainerInfos(User $user)
    {
        $dummyInfo = [
            'is_person' => 1
        ];

        $info = new TrainerDescription();
        foreach ($dummyInfo as $key => $value) {
            $info->$key = $value;
        }
        $info->trainer()->associate($user);
        $info->save();
    }
}
