<?php

namespace Tests;

use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function seedPermissions(): void
    {
        foreach ([
            ['name' => 'Admin Module',     'code' => 'ADMIN_MOD'],
            ['name' => 'CRM Module',       'code' => 'CRM_MOD'],
            ['name' => 'Inventory Module', 'code' => 'INV_MOD'],
            ['name' => 'Billing Module',   'code' => 'BILL_MOD'],
            ['name' => 'Reports Module',   'code' => 'REP_MOD'],
        ] as $p) {
            Permissions::firstOrCreate(
                ['code' => $p['code']],
                ['name' => $p['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }
    }

    protected function createRoleWithPermissions(array $codes = []): Roles
    {
        $code = strtoupper('T'.substr(uniqid(), -8));
        $role = Roles::create([
            'name' => 'Role '.$code,
            'code' => $code,
            'isActive' => true,
            'createdBy' => 1,
        ]);

        if ($codes) {
            $this->seedPermissions();
            $ids = Permissions::whereIn('code', $codes)->pluck('id');
            $role->permissions()->sync($ids);
        }

        return $role;
    }

    protected function userWithPermissions(array $codes): User
    {
        $role = $this->createRoleWithPermissions($codes);

        return User::factory()->create(['roleId' => $role->id]);
    }

    protected function adminUser(): User
    {
        return $this->userWithPermissions([
            'ADMIN_MOD', 'CRM_MOD', 'INV_MOD', 'BILL_MOD', 'REP_MOD',
        ]);
    }
}
