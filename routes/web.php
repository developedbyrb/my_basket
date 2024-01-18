<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
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
    Route::prefix('admin')->group(function () {
        // users route
        Route::prefix('users')->name('users.')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('', 'index')->middleware('check_permission:get-users')->name('index');
                Route::get('create', 'create')->middleware('check_permission:create-users')->name('create');
                Route::post('', 'store')->middleware('check_permission:create-users')->name('store');
                Route::get('{user}', 'show')->middleware('check_permission:view-user')->name('show');
                Route::get('{user}/edit', 'edit')->middleware('check_permission:edit-users')->name('edit');
                Route::put('{user}', 'update')->middleware('check_permission:update-users')->name('update');
                Route::delete('{user}', 'destroy')->middleware('check_permission:delete-users')->name('destroy');
            });
        // users route - END

        // roles routes
        Route::prefix('roles')->name('roles.')
            ->controller(RoleController::class)
            ->group(function () {
                Route::get('', 'index')->middleware('check_permission:get-roles')->name('index');
                Route::post('', 'store')->middleware('check_permission:create-roles')->name('store');
                Route::get('{role}', 'show')->middleware('check_permission:view-role')->name('show');
                Route::get('{role}/edit', 'edit')->middleware('check_permission:edit-roles')->name('edit');
                Route::put('{role}', 'update')->middleware('check_permission:update-roles')->name('update');
                Route::delete('{role}', 'destroy')->middleware('check_permission:delete-roles')->name('destroy');
            });
        // roles routes - END

        // permissions routes
        Route::prefix('permissions')->name('permissions.')
            ->controller(PermissionController::class)
            ->group(function () {
                Route::get('', 'index')->middleware('check_permission:get-permissions')->name('index');
                Route::post('', 'store')->middleware('check_permission:create-permissions')->name('store');
                Route::get('{permission}', 'show')->middleware('check_permission:view-permission')->name('show');
                Route::get('{permission}/edit', 'edit')->middleware('check_permission:edit-permissions')->name('edit');
                Route::put('{permission}', 'update')->middleware('check_permission:update-permissions')->name('update');
                Route::delete('{permission}', 'destroy')->middleware('check_permission:delete-permissions')->name('destroy');
            });
        // permissions routes - END

        // Role access permissions routes
        Route::prefix('access-management')->name('access-management.')
            ->controller(RolePermissionController::class)->group(function () {
                Route::get('', 'index')->name('index')->middleware('check_permission:get-access');

                Route::post('', 'store')->name('store')->middleware('check_permission:save-access');
            });
        // Role access permissions routes - END
    });

    // categories route
    Route::prefix('categories')->name('categories.')
        ->controller(CategoryController::class)
        ->group(function () {
            Route::get('', 'index')->middleware('check_permission:get-categories')->name('index');
            Route::post('', 'store')->middleware('check_permission:create-categories')->name('store');
            Route::get('{category}', 'show')->middleware('check_permission:view-category')->name('show');
            Route::get('{category}/edit', 'edit')->middleware('check_permission:edit-categories')->name('edit');
            Route::put('{category}', 'update')->middleware('check_permission:update-categories')->name('update');
            Route::delete('{category}', 'destroy')->middleware('check_permission:delete-categories')->name('destroy');
        });
    // categories route - END

    // products route
    Route::prefix('products')->name('products.')
        ->controller(ProductController::class)
        ->group(function () {
            Route::get('', 'index')->middleware('check_permission:get-products')->name('index');
            Route::get('create', 'create')->middleware('check_permission:create-products')->name('create');
            Route::post('', 'store')->middleware('check_permission:create-products')->name('store');
            Route::get('{product}', 'show')->middleware('check_permission:view-product')->name('show');
            Route::get('{product}/edit', 'edit')->middleware('check_permission:edit-products')->name('edit');
            Route::put('{product}', 'update')->middleware('check_permission:update-products')->name('update');
            Route::delete('{product}', 'destroy')->middleware('check_permission:delete-products')->name('destroy');
        });
    // products route - END

    // shops route
    Route::prefix('shops')->name('shops.')
        ->controller(ShopController::class)
        ->group(function () {
            Route::get('', 'index')->middleware('check_permission:get-shops')->name('index');
            Route::get('create', 'create')->middleware('check_permission:create-shops')->name('create');
            Route::post('', 'store')->middleware('check_permission:create-shops')->name('store');
            Route::get('{shop}', 'show')->middleware('check_permission:view-shop')->name('show');
            Route::get('{shop}/edit', 'edit')->middleware('check_permission:edit-shops')->name('edit');
            Route::put('{shop}', 'update')->middleware('check_permission:update-shops')->name('update');
            Route::delete('{shop}', 'destroy')->middleware('check_permission:delete-shops')->name('destroy');
        });
    // shops route - END

    // CRUD Operation routes for attributes
    Route::prefix('attributes')->name('attributes.')->controller(AttributeController::class)->group(function () {
        Route::get('', 'index')->name('index')->middleware('check_permission:get-attributes');
        Route::get('create', 'create')->name('create')->middleware('check_permission:create-attributes');
        Route::post('', 'store')->name('store')->middleware('check_permission:create-attributes');
        Route::get('{attribute}', 'show')->name('show');
        Route::get('{attribute}/edit', 'edit')->name('edit')->middleware('check_permission:edit-attributes');
        Route::put('{attribute}', 'update')->name('update')->middleware('check_permission:edit-attributes');
        Route::delete('{attribute}', 'destroy')->name('destroy')->middleware('check_permission:delete-attributes');
    });
    // END of attributes routes

    // warehouse routes
    Route::prefix('warehouses')->name('warehouses.')->controller(WarehouseController::class)->group(function () {
        Route::get('', 'index')->name('index')->middleware('check_permission:get-warehouses');
        Route::get('/create', 'create')->name('create')->middleware('check_permission:create-warehouses');
        Route::post('', 'store')->name('store')->middleware('check_permission:create-warehouses');
        Route::get('/{warehouse}', 'show')->name('show');
        Route::get('/{warehouse}', 'edit')->name('edit')->middleware('check_permission:edit-warehouses');
        Route::put('/{warehouse}', 'update')->name('update')->middleware('check_permission:edit-warehouses');
        Route::delete('/{warehouse}', 'destroy')->name('destroy')->middleware('check_permission:delete-warehouses');
    });
    // warehouse routes - END

    // cart routes
    Route::prefix('cart-items')->name('cartItems.')->controller(CartController::class)->group(function () {
        Route::get('', 'index')->name('index')->middleware('check_permission:get-cart-items');
        Route::post('', 'store')->name('store')->middleware('check_permission:create-cart-items');
        Route::put('', 'update')->name('update')->middleware('check_permission:edit-cart-items');
        Route::delete('/{cart}', 'destroy')->name('destroy')->middleware('check_permission:delete-cart-items');
    });
    // cart routes - END

    // order routes
    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('', 'index')->name('index')->middleware('check_permission:get-orders');
        Route::get('/create', 'create')->name('create')->middleware('check_permission:create-orders');
        Route::post('', 'store')->name('store')->middleware('check_permission:create-orders');
        Route::delete('/{order}', 'destroy')->name('destroy')->middleware('check_permission:delete-orders');
    });
    // order routes - END

    Route::post('variants/attributes', [ProductController::class, 'getProductAttributes'])
        ->middleware('check_permission:create-products')
        ->name('variants.attributes');

    Route::get('addressFields', [CommonController::class, 'getAddressFields'])
        ->name('addressFields.get');
});

Route::get('/get-search-shop', [ShopController::class, 'searchShops'])->name('shops.search');

// Show a single shop
Route::get('shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::fallback(function () {
    return view('errors.404');
});

require __DIR__ . '/auth.php';
