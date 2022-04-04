<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['title' => 'admin'],
            ['title' => 'user']
        ];

        foreach ($roles as $role) {
            $role1 = new Role();
            $role1->title = $role['title'];
            $role1->save();
        }
    }
}
