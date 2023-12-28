<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
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
    // List roles and permissions (index action)
    Route::get('access-management', [RolePermissionController::class, 'index'])
        ->middleware('check_permission:get-access')
        ->name('access-management.index');

    // Store roles and permissions (store action)
    Route::post('access-management', [RolePermissionController::class, 'store'])
        ->middleware('check_permission:save-access')
        ->name('access-management.store');


    // List roles (index action)
    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('check_permission:get-roles')
        ->name('roles.index');

    // Store a new role (store action)
    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('check_permission:save-roles')
        ->name('roles.store');

    // Show a single role (show action)
    Route::get('roles/{role}', [RoleController::class, 'show'])
        ->name('roles.show');

    // Show the form to edit a role (edit action)
    Route::get('roles/{role}', [RoleController::class, 'edit'])
        ->name('roles.edit')->middleware('check_permission:edit-roles');

    // Update a role (update action)
    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->middleware('check_permission:update-roles')
        ->name('roles.update');

    // Delete a role (destroy action)
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('check_permission:delete-roles')
        ->name('roles.destroy');


    // List permissions (index action)
    Route::get('permissions', [PermissionController::class, 'index'])
        ->middleware('check_permission:get-permissions')
        ->name('permissions.index');

    // Store a new permission (store action)
    Route::post('permissions', [PermissionController::class, 'store'])
        ->middleware('check_permission:save-permissions')
        ->name('permissions.store');

    // Show a single permission (show action)
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])
        ->name('permissions.show');

    // Show the form to edit a permission (edit action)
    Route::get('permissions/{permission}', [PermissionController::class, 'edit'])
        ->name('permissions.edit')->middleware('check_permission:edit-permissions');

    // Update a permission (update action)
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])
        ->middleware('check_permission:update-permissions')
        ->name('permissions.update');

    // Delete a permission (destroy action)
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('check_permission:delete-permissions')
        ->name('permissions.destroy');

    // List categories (index action)
    Route::get('categories', [CategoryController::class, 'index'])
        ->middleware('check_permission:get-categories')
        ->name('categories.index');

    // Store a new category (store action)
    Route::post('categories', [CategoryController::class, 'store'])
        ->middleware('check_permission:save-categories')
        ->name('categories.store');

    // Show a single category (show action)
    Route::get('categories/{category}', [CategoryController::class, 'show'])
        ->name('categories.show');

    // Show the form to edit a category (edit action)
    Route::get('categories/{category}', [CategoryController::class, 'edit'])
        ->name('categories.edit')->middleware('check_permission:edit-categories');

    // Update a category (update action)
    Route::put('categories/{category}', [CategoryController::class, 'update'])
        ->middleware('check_permission:update-categories')
        ->name('categories.update');

    // Delete a category (destroy action)
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->middleware('check_permission:delete-categories')
        ->name('categories.destroy');

    // List users (index action)
    Route::get('users', [UserController::class, 'index'])
        ->middleware('check_permission:get-users')
        ->name('users.index');

    // Show the form to create a user (create action)
    Route::get('users/create', [UserController::class, 'create'])
        ->middleware('check_permission:create-users')
        ->name('users.create');

    // Store a new user (store action)
    Route::post('users', [UserController::class, 'store'])
        ->middleware('check_permission:save-users')
        ->name('users.store');

    // Show a single user (show action)
    Route::get('users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    // Show the form to edit a user (edit action)
    Route::get('users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('check_permission:edit-users')
        ->name('users.edit');

    // Update a user (update action)
    Route::put('users/{user}', [UserController::class, 'update'])
        ->middleware('check_permission:update-users')
        ->name('users.update');

    // Delete a user (destroy action)
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->middleware('check_permission:delete-users')
        ->name('users.destroy');

    // List all products
    Route::get('products', [ProductController::class, 'index'])
        ->middleware('check_permission:get-products')
        ->name('products.index');

    // Show the product creation form
    Route::get('products/create', [ProductController::class, 'create'])
        ->middleware('check_permission:create-products')
        ->name('products.create');

    // Store a new product
    Route::post('products', [ProductController::class, 'store'])
        ->middleware('check_permission:save-products')
        ->name('products.store');

    // Show a single product
    Route::post('products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    // Show the form to edit a product
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])
        ->middleware('check_permission:edit-products')
        ->name('products.edit');

    // Update a product
    Route::put('products/{product}', [ProductController::class, 'update'])
        ->middleware('check_permission:update-products')
        ->name('products.update');

    // Delete a product
    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->middleware('check_permission:delete-products')
        ->name('products.destroy');

    // List all shops
    Route::get('shops', [ShopController::class, 'index'])
        ->middleware('check_permission:get-shops')
        ->name('shops.index');

    // Show the shop creation form
    Route::get('shops/create', [ShopController::class, 'create'])
        ->middleware('check_permission:create-shops')
        ->name('shops.create');

    // Store a new shop
    Route::post('shops', [ShopController::class, 'store'])
        ->middleware('check_permission:save-shops')
        ->name('shops.store');

    // Show the form to edit a shop
    Route::get('shops/{shop}/edit', [ShopController::class, 'edit'])
        ->middleware('check_permission:edit-shops')
        ->name('shops.edit');

    // Update a shop
    Route::put('shops/{shop}', [ShopController::class, 'update'])
        ->middleware('check_permission:update-shops')
        ->name('shops.update');

    // Delete a shop
    Route::delete('shops/{shop}', [ShopController::class, 'destroy'])
        ->middleware('check_permission:delete-shops')
        ->name('shops.destroy');

    // Add Products to Cart
    Route::get('cart', [OrderController::class, 'getCartDetails'])->name('products.viewCart');

    Route::post('products/cart/{product}', [OrderController::class, 'addToCart'])
        ->name('products.addToCart');

    // List all orders
    Route::get('orders', [OrderController::class, 'index'])
        ->middleware('check_permission:get-orders,false')
        ->name('orders.index');

    // Show the shop creation form
    Route::post('orders', [OrderController::class, 'store'])
        ->middleware('check_permission:store-orders')
        ->name('orders.store');

    Route::get('orders/checkout', [OrderController::class, 'create'])
        ->middleware('check_permission:store-orders')
        ->name('orders.create');
});

Route::get('/get-search-shop', [ShopController::class, 'searchShops'])->name('shops.search');

// Show a single shop
Route::get('shops/{shop}', [ShopController::class, 'show'])
    ->name('shops.show');

require __DIR__ . '/auth.php';
