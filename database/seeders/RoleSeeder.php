<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = config('services.roles');

        foreach ($data as $value) {
            Role::create([
                'name' => $value,
                'guard_name' => config('auth.defaults.guard')
            ]);
        }
    }
}
