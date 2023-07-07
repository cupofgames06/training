<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Classroom;
use App\Models\OfferDescription;
use App\Models\Session;
use App\Models\SessionDay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::factory()->count(10)->create()->each(function($item){

            OfferDescription::factory()->for(
                $item,'describable'
            )->create();

            SessionDay::factory()->for($item)->create();
        });
    }
}
