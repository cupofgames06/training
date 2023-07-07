<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $projects = [[
            'name' => 'Maupiti',
            'id' => 1
        ]];

        foreach ($projects as $m) {
            $item = Project::create($m);
            $item->save();
        }
    }

}
