<?php

namespace Database\Seeders;

use App\Models\PriceLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $locales = config('custom.kwu.supported_locales');
        $groups = config('custom.kwu.price-levels');
        foreach ($groups as $k => $group) {
            $entry = new PriceLevel();
            for ($i = 1; $i < count($locales); $i++) {
                $entry->setTranslation('name', $locales[$i], $group[$locales[$i]]);
            }
            $entry->save();
        }

    }
}
