<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role  = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);

        $permissions = [
            'user'      => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'role'      => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'project'   => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'block'     => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'section'   => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'floor'     => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'flat'      => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'client'    => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'agreement' => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'payment'   => [
                'create',
                'update',
                'view',
                'delete',
            ],
            'report'    => [
                'view',
            ]
        ];

        foreach ($permissions as $key => $value) {
            foreach ($value as $item) {
                Permission::create(['name' => $key . '-' . $item]);
            }
        }
    }
}
