<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $maupiti = [[
            'name' => 'anita',
            'project_id' => 1
        ]];

        // création acteurs
        foreach ($maupiti as $m) {
            $user = Actor::create($m);
            $user->save();
        }

    }

}
