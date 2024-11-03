<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductAttributeSetController;
use App\Http\Controllers\Admin\ProductAttributeValueController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSkusController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');

    /////////////////////////// PROFILE
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /////////////////////////// ORDER
    Route::middleware('auth')->group(function () {
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    ////////////////////////// PRODUCT ATTRIBUTE
    Route::middleware('auth')->group(function () {
        Route::post('/product_attributes', [ProductAttributeController::class, 'store'])->name('product_attributes.store');
        Route::get('/product_attributes', [ProductAttributeController::class, 'index'])->name('product_attributes.index');
        Route::get('/product_attributes/{id}', [ProductAttributeController::class, 'show'])->name('product_attributes.show');
        Route::get('/product_attributes/{id}/edit', [ProductAttributeController::class, 'edit'])->name('product_attributes.edit');
        Route::put('/product_attributes/{id}', [ProductAttributeController::class, 'update'])->name('product_attributes.update');
        Route::delete('/product_attributes/{id}', [ProductAttributeController::class, 'destroy'])->name('product_attributes.destroy');
    });

    ////////////////////////// PRODUCT ATTRIBUTE VALUE
    Route::middleware('auth')->group(function () {
        Route::post('/product_attributes/{id_attribute}/product_attribute_value',
            [ProductAttributeValueController::class, 'store']);
        Route::delete('/product_attributes/{id_attribute}/product_attribute_value/{id}',
            [ProductAttributeValueController::class, 'destroy']);
    });

    ////////////////////////// PRODUCT ATTRIBUTE SET
    Route::middleware('auth')->group(function () {
        Route::post('/product_attribute_sets', [ProductAttributeSetController::class, 'store']);
        Route::get('/product_attribute_sets', [ProductAttributeSetController::class, 'index']);
        Route::get('/product_attribute_sets/{id}/edit', [ProductAttributeSetController::class, 'edit']);
        Route::post('/product_attribute_sets/{id}', [ProductAttributeSetController::class, 'update']);
        Route::delete('/product_attribute_sets/{id}', [ProductAttributeSetController::class, 'destroy']);
    });

    ////////////////////////// PRODUCT SKUS
    Route::middleware('auth')->group(function () {
        Route::post('/products/{product_id}/product_skus', [ProductSkusController::class, 'store']);
        Route::get('/products/{product_id}/product_skus/create', [ProductSkusController::class, 'create']);
        Route::get('/products/{product_id}/product_skus/{product_sku_id}/edit', [ProductSkusController::class, 'edit']);
        Route::post('/products/{product_id}/product_skus/{id}', [ProductSkusController::class, 'update']);
        Route::delete('/products/{product_id}/product_skus/{id}', [ProductSkusController::class, 'destroy']);
    });

    /////////////////////////// POST
    Route::middleware('auth')->group(function () {
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    /////////////////////////// ROLE
    Route::middleware('auth')->group(function () {
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        // add permission to role
        Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
    });

    /////////////////////////// PERMISSION
    Route::middleware('auth')->group(function () {
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    /////////////////////////// USER
    Route::middleware('auth')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    /////////////////////////// CATEGORY
    Route::middleware('auth')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    /////////////////////////// PRODUCT
    Route::middleware('auth')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    /////////////////////////// SETTING
    Route::middleware('auth')->group(function () {
        Route::post('/settings/updateLogo', [SettingController::class, 'updateLogo']);
        Route::resource('settings', SettingController::class);
    });

});
// file manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
