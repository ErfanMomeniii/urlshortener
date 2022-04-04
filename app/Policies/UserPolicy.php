<?php

namespace App\Policies;

use App\Models\User;
use App\Services\AccessService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @throws BindingResolutionException
     */
    public function viewAny(User $user): bool
    {
        return app()->make(AccessService::class)->check($user, 'see_all_users_information');
    }

    /**
     * @throws BindingResolutionException
     */
    public function delete(User $user, User $model): bool
    {
        return app()->make(AccessService::class)->check($user, 'delete_users');
    }

}
