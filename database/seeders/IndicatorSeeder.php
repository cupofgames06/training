<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Course;
use App\Models\Indicator;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

/**
 * Class CategorySeeder
 * @package Database\Seeders
 */
class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $indicators = config('custom.kwu.indicators');
        foreach ($indicators as $indicator) {
            $entry = new Indicator();
            $entry->name = $indicator['name'];
            $entry->unit = $indicator['unit'];
            $entry->objective = 100;
            $entry->save();
        }

    }

}
