<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AccessSeeder extends Seeder
{
    public function run()
    {
        $permissionIds = Permission::all()->pluck('id');
        $adminRole = Role::where('title', '=', 'admin')->first();
        $adminRole->permissions()->sync($permissionIds);
    }
}
