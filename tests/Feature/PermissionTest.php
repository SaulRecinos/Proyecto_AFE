<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    // ── Users without permissions get 403 ────────────────────────────────────

    #[DataProvider('moduleRoutes')]
    public function test_user_with_no_permissions_gets_403(string $url): void
    {
        $user = $this->userWithPermissions([]);
        $this->actingAs($user)->get($url)->assertStatus(403);
    }

    // ── Users with the right permission get 200 ──────────────────────────────

    public function test_user_with_admin_permission_can_access_admin_module(): void
    {
        $user = $this->userWithPermissions(['ADMIN_MOD']);
        $this->actingAs($user)->get('/admin/users')->assertStatus(200);
        $this->actingAs($user)->get('/admin/roles')->assertStatus(200);
    }

    public function test_user_with_crm_permission_can_access_crm_module(): void
    {
        $user = $this->userWithPermissions(['CRM_MOD']);
        $this->actingAs($user)->get('/crm/customers')->assertStatus(200);
        $this->actingAs($user)->get('/crm/suppliers')->assertStatus(200);
    }

    public function test_user_with_inventory_permission_can_access_inventory_module(): void
    {
        $user = $this->userWithPermissions(['INV_MOD']);
        $this->actingAs($user)->get('/inventory/products')->assertStatus(200);
        $this->actingAs($user)->get('/inventory/categories')->assertStatus(200);
        $this->actingAs($user)->get('/inventory/movements')->assertStatus(200);
    }

    public function test_user_with_billing_permission_can_access_billing_module(): void
    {
        $user = $this->userWithPermissions(['BILL_MOD']);
        $this->actingAs($user)->get('/billing/invoices')->assertStatus(200);
    }

    public function test_user_with_reports_permission_can_access_reports(): void
    {
        $user = $this->userWithPermissions(['REP_MOD']);
        $this->actingAs($user)->get('/reports')->assertStatus(200);
        $this->actingAs($user)->get('/reports/sales')->assertStatus(200);
        $this->actingAs($user)->get('/reports/low-stock')->assertStatus(200);
        $this->actingAs($user)->get('/reports/pending')->assertStatus(200);
    }

    // ── Cross-module isolation ────────────────────────────────────────────────

    public function test_crm_user_cannot_access_admin_module(): void
    {
        $user = $this->userWithPermissions(['CRM_MOD']);
        $this->actingAs($user)->get('/admin/users')->assertStatus(403);
    }

    public function test_inventory_user_cannot_access_billing_module(): void
    {
        $user = $this->userWithPermissions(['INV_MOD']);
        $this->actingAs($user)->get('/billing/invoices')->assertStatus(403);
    }

    public function test_admin_user_can_access_all_modules(): void
    {
        $user = $this->adminUser();
        foreach (array_column(self::moduleRoutes(), 0) as $url) {
            $this->actingAs($user)->get($url)->assertStatus(200);
        }
    }

    // ── Data provider ─────────────────────────────────────────────────────────

    public static function moduleRoutes(): array
    {
        return [
            'admin users' => ['/admin/users'],
            'admin roles' => ['/admin/roles'],
            'crm customers' => ['/crm/customers'],
            'crm suppliers' => ['/crm/suppliers'],
            'inventory products' => ['/inventory/products'],
            'inventory categories' => ['/inventory/categories'],
            'inventory movements' => ['/inventory/movements'],
            'billing invoices' => ['/billing/invoices'],
            'reports index' => ['/reports'],
            'reports sales' => ['/reports/sales'],
            'reports low-stock' => ['/reports/low-stock'],
            'reports pending' => ['/reports/pending'],
        ];
    }
}
