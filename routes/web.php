<?php

use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RolesController::class)->except(['show']);
    Route::resource('permissions', PermissionsController::class)->except(['show']);
    Route::resource('users', UsersController::class)->except(['show']);
});
