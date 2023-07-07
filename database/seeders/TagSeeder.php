<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //tag pour classification apprenant
        $locales = config('custom.kwu.supported_locales');
        $tag_groups = config('custom.kwu.tags');
        foreach ($tag_groups as $tag_group) {
            foreach ($tag_group as $k => $v) {
                foreach ($v as $tag) {
                    $entry = Tag::findOrCreate($tag[$locales[0]], $k);
                    for ($i = 1; $i < count($locales); $i++) {
                        $entry->setTranslation('name', $locales[$i], $tag[$locales[$i]]);
                    }
                    $entry->save();
                }
            }
        }
    }

}
