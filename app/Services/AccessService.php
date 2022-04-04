<?php

namespace App\Services;

use App\Models\User;

class AccessService
{
    public function check(User $user, $permission): bool
    {
        $hasPermission = false;

        foreach ($user->roles as $userRole) {
            foreach ($userRole->permissions as $userPermission) {
                $hasPermission = ($hasPermission or ($userPermission->title == $permission));
            }
        }
        return $hasPermission;
    }
}
