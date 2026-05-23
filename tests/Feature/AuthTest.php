<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    #[DataProvider('protectedRoutes')]
    public function test_unauthenticated_user_is_redirected_to_login(string $url): void
    {
        $this->get($url)->assertRedirect('/login');
    }

    public static function protectedRoutes(): array
    {
        return [
            'home' => ['/'],
            'admin users' => ['/admin/users'],
            'admin roles' => ['/admin/roles'],
            'crm customers' => ['/crm/customers'],
            'crm suppliers' => ['/crm/suppliers'],
            'inventory categories' => ['/inventory/categories'],
            'inventory products' => ['/inventory/products'],
            'inventory movements' => ['/inventory/movements'],
            'billing invoices' => ['/billing/invoices'],
            'reports index' => ['/reports'],
            'reports sales' => ['/reports/sales'],
            'reports low-stock' => ['/reports/low-stock'],
            'reports pending' => ['/reports/pending'],
        ];
    }
}
