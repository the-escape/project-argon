<?php

namespace Escape\Argon\Test\Cases;

use Escape\Argon\Authentication\Permission;
use Escape\Argon\Authentication\PermissionGrant;
use Escape\Argon\Authentication\Role;
use Escape\Argon\Authentication\User;
use Exception;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testDefaultPermissions()
    {
        $this->assertEquals(1, User::all()->count());

        $root = User::find(1);
        $this->assertTrue($root->hasRole('Admin'));
        $this->assertFalse($root->hasRole('MadeUp'));
    }

    public function testCreateRole()
    {
        $role = new Role();
        $role->name = 'MadeUp';
        $role->save();

        $this->assertEquals(2, Role::all()->count());

        $root = User::find(1);
        $root->roles()->attach($role);
        $this->assertTrue(User::find(1)->hasRole('MadeUp'));
    }

    public function testCreateUser()
    {

        $user = factory(User::class)->make();
        $user->save();

        $this->assertEquals(2, User::all()->count());

        $retrieved = User::find($user->id);

        $this->assertEquals($user->id, $retrieved->id);
        $this->assertEquals($user->name, $retrieved->name);
    }

    public function testGrantingPermission()
    {
        $role = new Role();
        $role->name = 'MadeUp';
        $role->save();

        $user = factory(User::class)->make();
        $user->save();

        $grant = new PermissionGrant();
        $grant->role_id = $role->id;
        $grant->permission = 'cms:login';
        $grant->save();

        $this->assertInstanceOf(Permission::class, $grant->permission);

        $user->roles()->attach($role);

        $user = User::find($user->id);
        $this->assertTrue($user->hasPermission('cms:login'));

        $this->assertEquals('MadeUp', $grant->role->name);

        $grant->delete();

        $user = User::find($user->id);
        $this->assertFalse($user->hasPermission('cms:login'));

        $user = factory(User::class)->make();
        $user->save();
        $this->assertFalse($user->hasPermission('cms:login'));

        $role = new Role();
        $role->name = 'Test';
        $role->save();

        $perm = Permission::find('cms:login');

        $grant = new PermissionGrant();
        $grant->role = $role;
        $grant->permission = $perm;
        $grant->save();

        $role = new Role();
        $role->name = 'Test2';
        $role->save();
        $role->grant($perm);
    }

    public function testUsersInRole()
    {
        $role = Role::find(1);

        $this->assertEquals(1, $role->users->count());

        $this->assertEquals('Root', $role->users->first()->name);
    }

    public function testPermission()
    {
        $perm = Permission::find('cms:login');

        $this->assertEquals('cms:login', $perm->name);
        $this->assertEquals(1, $perm->roles->count());

        $this->assertEquals('Admin', $perm->roles->first()->name);

        $exceptionThrown = false;
        try {
            $foo = $perm->madeUp;
        } catch (Exception $exp) {
            $exceptionThrown = true;
        }

        $this->assertTrue($exceptionThrown);

        $exceptionThrown = false;
        try {
            $foo = Permission::find('doesnt:exist');
        } catch (Exception $exp) {
            $exceptionThrown = true;
        }

        $this->assertTrue($exceptionThrown);

        $role = Role::find(1);

        $this->assertEquals(3, $role->permissions->count());
    }

    public function testPermissionManager()
    {
        $manager = app('permissions');

        $this->assertContains('cms:login', $manager->getDefinedPermissions());
        $this->assertContains('cms:user:manage', $manager->getDefinedPermissions());
        $this->assertContains('cms:role:manage', $manager->getDefinedPermissions());

    }
}
