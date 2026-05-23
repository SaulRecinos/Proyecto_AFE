<?php

namespace Tests\Unit;

use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_returns_true(): void
    {
        $perm = Permissions::create([
            'name' => 'Test Module', 'code' => 'TEST_MOD', 'isActive' => true, 'createdBy' => 1,
        ]);
        $role = Roles::create([
            'name' => 'Test Role', 'code' => 'TESTROLE', 'isActive' => true, 'createdBy' => 1,
        ]);
        $role->permissions()->attach($perm->id);
        $user = User::factory()->create(['roleId' => $role->id]);

        $this->assertTrue($user->hasPermission('TEST_MOD'));
    }

    public function test_user_without_permission_returns_false(): void
    {
        $role = Roles::create([
            'name' => 'Empty Role', 'code' => 'EMPTYROLE', 'isActive' => true, 'createdBy' => 1,
        ]);
        $user = User::factory()->create(['roleId' => $role->id]);

        $this->assertFalse($user->hasPermission('ADMIN_MOD'));
    }

    public function test_permission_check_is_exact_code_match(): void
    {
        $perm = Permissions::create([
            'name' => 'CRM Module', 'code' => 'CRM_MOD', 'isActive' => true, 'createdBy' => 1,
        ]);
        $role = Roles::create([
            'name' => 'CRM Role', 'code' => 'CRMROLE', 'isActive' => true, 'createdBy' => 1,
        ]);
        $role->permissions()->attach($perm->id);
        $user = User::factory()->create(['roleId' => $role->id]);

        $this->assertTrue($user->hasPermission('CRM_MOD'));
        $this->assertFalse($user->hasPermission('CRM'));
        $this->assertFalse($user->hasPermission('ADMIN_MOD'));
    }

    public function test_user_with_multiple_permissions_can_check_each(): void
    {
        $this->seedPermissions();
        $role = $this->createRoleWithPermissions(['INV_MOD', 'BILL_MOD']);
        $user = User::factory()->create(['roleId' => $role->id]);

        $this->assertTrue($user->hasPermission('INV_MOD'));
        $this->assertTrue($user->hasPermission('BILL_MOD'));
        $this->assertFalse($user->hasPermission('ADMIN_MOD'));
        $this->assertFalse($user->hasPermission('CRM_MOD'));
        $this->assertFalse($user->hasPermission('REP_MOD'));
    }
}
