<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class GroupSeeder extends UserSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // création Group
       /* $group = Group::factory()->create([
            'email'             => 'group@group.com',
            'password'          => Hash::make('group@group.com'),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
        $this->addProfileInfos($group);
        $group->assignRole('group');
        Entity::factory()->for(
            $group, 'modelable'
        )->create();*/
    }
}
