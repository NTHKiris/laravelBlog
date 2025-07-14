<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator with full access to all features',

            ],
            [
                'name' => 'Writer',
                'slug' => 'writer',
                'description' => 'Can create and manage their own content',

            ],
            [
                'name' => 'Reader',
                'slug' => 'reader',
                'description' => 'Can read content and comment',

            ],
            [
                'name' => 'Banned',
                'slug' => 'banned',
                'description' => 'Restricted from accessing most features',

            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
