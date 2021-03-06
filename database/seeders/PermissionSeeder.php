<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['title' => 'see_all_users_information'],
            ['title' => 'delete_users']
        ];

        foreach ($permissions as $permission) {
            $permission1 = new Permission();
            $permission1->title = $permission['title'];
            $permission1->save();
        }
    }
}
