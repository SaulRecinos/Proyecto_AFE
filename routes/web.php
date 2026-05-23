<?php

use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Billing\InvoicesController;
use App\Http\Controllers\Crm\CustomersController;
use App\Http\Controllers\Crm\SuppliersController;
use App\Http\Controllers\Inventory\CategoriesController;
use App\Http\Controllers\Inventory\InventoryMovementsController;
use App\Http\Controllers\Inventory\ProductsController;
use App\Http\Controllers\Reports\ReportsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => view('home'))->name('home');

    Route::prefix('admin')->name('admin.')->middleware('permission:ADMIN_MOD')->group(function () {
        Route::resource('roles', RolesController::class)->except(['show']);
        Route::resource('users', UsersController::class)->except(['show']);
    });

    Route::prefix('crm')->name('crm.')->middleware('permission:CRM_MOD')->group(function () {
        Route::resource('customers', CustomersController::class)->except(['show']);
        Route::resource('suppliers', SuppliersController::class)->except(['show']);
    });

    Route::prefix('inventory')->name('inventory.')->middleware('permission:INV_MOD')->group(function () {
        Route::resource('categories', CategoriesController::class)->except(['show']);
        Route::resource('products', ProductsController::class)->except(['show']);
        Route::resource('movements', InventoryMovementsController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    Route::prefix('billing')->name('billing.')->middleware('permission:BILL_MOD')->group(function () {
        Route::resource('invoices', InvoicesController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    Route::prefix('reports')->name('reports.')->middleware('permission:REP_MOD')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/low-stock', [ReportsController::class, 'lowStock'])->name('low-stock');
        Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
        Route::get('/pending', [ReportsController::class, 'pending'])->name('pending');
    });
});
