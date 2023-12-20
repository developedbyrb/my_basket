<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('access-management', RolePermissionController::class)->only(['index', 'store'])->middleware([
        'index' => 'check_permission:get-access',
        'store' => 'check_permission:save-access'
    ]);

    Route::resource('roles', RoleController::class)->except(['create'])->middleware([
        'index' => 'check_permission:get-roles',
        'store' => 'check_permission:save-roles',
        'edit' => 'check_permission:edit-roles',
        'update' => 'check_permission:update-roles',
        'destroy' => 'check_permission:delete-roles',
    ]);

    Route::resource('permissions', PermissionController::class)->except(['create'])->middleware([
        'index' => 'check_permission:get-permissions',
        'store' => 'check_permission:save-permissions',
        'edit' => 'check_permission:edit-permissions',
        'update' => 'check_permission:update-permissions',
        'destroy' => 'check_permission:delete-permissions',
    ]);

    Route::resource('categories', CategoryController::class)->except(['create'])->middleware([
        'index' => 'check_permission:get-categories',
        'store' => 'check_permission:save-categories',
        'edit' => 'check_permission:edit-categories',
        'update' => 'check_permission:update-categories',
        'destroy' => 'check_permission:delete-categories',
    ]);

    Route::resource('users', UserController::class)->middleware([
        'index' => 'check_permission:get-users',
        'create' => 'check_permission:create-users',
        'store' => 'check_permission:save-users',
        'edit' => 'check_permission:edit-users',
        'update' => 'check_permission:update-users',
        'destroy' => 'check_permission:delete-users',
    ]);

    Route::resource('products', ProductController::class)->middleware([
        'index' => 'check_permission:get-categories',
        'create' => 'check_permission:create-categories',
        'store' => 'check_permission:save-categories',
        'edit' => 'check_permission:edit-categories',
        'update' => 'check_permission:update-categories',
        'destroy' => 'check_permission:delete-categories',
    ]);

    Route::resource('shops', ShopController::class)->middleware([
        'index' => 'check_permission:get-shops',
        'create' => 'check_permission:create-shops',
        'store' => 'check_permission:save-shops',
        'edit' => 'check_permission:edit-shops',
        'update' => 'check_permission:update-shops',
        'destroy' => 'check_permission:delete-shops',
    ]);

    Route::get('/get-options', [ShopController::class, 'getOptions'])
        ->middleware(['check_permission:create-shops', 'check_permission:edit-shops'])->name('products.option');
});


require __DIR__ . '/auth.php';
