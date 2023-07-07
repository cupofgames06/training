<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\OfferDescription;
use App\Models\Price;
use App\Models\PriceLevel;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()->count(30)->create()->each(function($item) {
            OfferDescription::factory()->for(
                $item,'describable'
            )->create();
            foreach (PriceLevel::all() as $lvl)
            {
                Price::factory()->for(
                    $item, 'priceable'
                )->create([
                    'price_level_id' => $lvl->id
                ]);
            }
        });

    }
}
