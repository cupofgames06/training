<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $data = $this->data();

        foreach ($data as $value) {
            Permission::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data(): array
    {
        $data = [];
        // list of model permission

        $model = ['of', 'trainer', 'learner', 'company', 'agent'];

        foreach ($model as $value) {
            foreach ($this->crudActions($value) as $action) {
                $data[] = ['name' => $action];
            }
        }

        return $data;
    }

    public function crudActions($name): array
    {
        $actions = [];
        // list of permission actions
        $crud = ['view', 'edit', 'delete'];

        foreach ($crud as $value) {
            $actions[] = $value . '-' . $name;
        }

        return $actions;
    }
}
