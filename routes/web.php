<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
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
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::resources([
        'roles' => RoleController::class,
        'permissions' => PermissionController::class
    ]);

    Route::get('/access-management', [RolePermissionController::class, 'showMatrix'])->name('matrix.show');
    Route::post('/roles/upsert', [RoleController::class, 'upSert'])->name('roles.upsert');
});

Route::get('/categories', [CategoryController::class, 'index'])->middleware('check_permission:create-category');
// Route::middleware(['auth', 'check_permission:create-category'])->group(function () {
//     Route::prefix('categories')->group(function () {
//         Route::get('', [CategoryController::class, 'index'])->name('category.index');
//     });
// });

require __DIR__ . '/auth.php';
