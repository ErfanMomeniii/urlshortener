<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessService;
use Database\Factories\PermissionFactory;
use Database\Factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws BindingResolutionException
     */
    public function test_check_user_access_with_permission_should_work()
    {
        /**
         * @var User $user
         * @var Permission $permission
         * @var Role $role
         */
        $user = app()->make(UserFactory::class)->create();
        $permission = app()->make(PermissionFactory::class)->create();
        $role = app()->make(RoleFactory::class)->create();

        $role->permissions()->attach($permission->id);
        $user->roles()->attach($role->id);

        $this->assertTrue(app()->make(AccessService::class)->check($user, $permission->title));
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_check_user_access_without_have_right_permission_should_fail()
    {
        /**
         * @var User $user
         * @var Permission $permission
         * @var Role $role
         */
        $user = app()->make(UserFactory::class)->create();
        $permission = app()->make(PermissionFactory::class)->create();

        $this->assertFalse(app()->make(AccessService::class)->check($user, $permission->title));
    }
}
