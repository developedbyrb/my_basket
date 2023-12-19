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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resources([
        'users' => UserController::class,
        'permissions' => PermissionController::class,
        'products' => ProductController::class,
        'shops' => ShopController::class
    ]);

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

    Route::resource('categories', CategoryController::class)->except(['create'])->middleware([
        'index' => 'check_permission:get-categories',
        'store' => 'check_permission:save-categories',
        'edit' => 'check_permission:edit-categories',
        'update' => 'check_permission:update-categories',
        'destroy' => 'check_permission:delete-categories',
    ]);
});


require __DIR__ . '/auth.php';
