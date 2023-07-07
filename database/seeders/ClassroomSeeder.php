<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Classroom;

class ClassroomSeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Classroom::factory()->count(30)->create()->each(function($item) {

            Address::factory()->for(
                $item, 'addressable'
            )->create();

        });
    }
}
