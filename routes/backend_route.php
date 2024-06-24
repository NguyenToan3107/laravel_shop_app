<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

const POST_ROUTE = '/posts/{post}';
const ROLE_ROUTE = '/roles/{role}';
const PERMISSION_ROUTE = '/permissions/{permission}';
const USER_ROUTE = '/users/{user}';
const PRODUCT_ROUTE = '/products/{product}';
const CATEGORY_ROUTE = '/categories/{category}';
const ORDER_ROUTE = '/orders/{order}';


require __DIR__ . '/auth.php';

Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])->name('dashboard');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /////////////////////////// ORDER

    Route::middleware('auth')->group(function () {
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/search-order', [SearchController::class, 'searchOrder']);

        Route::get(ORDER_ROUTE . '/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

        // hard delete
        Route::delete(ORDER_ROUTE, [OrderController::class, 'destroy'])->name('orders.destroy');
        // soft delete
//        Route::post('/posts/soft_delete', [PostController::class, 'softDelete']);
    });

    ///////////////////////////

    /////////////////////////// POST

    Route::middleware('auth')->group(function () {
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::post('/search-post', [SearchController::class, 'searchPost']);

        Route::get(POST_ROUTE . '/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put(POST_ROUTE, [PostController::class, 'update'])->name('posts.update');

        // hard delete
        Route::delete(POST_ROUTE, [PostController::class, 'destroy'])->name('posts.destroy');
        // soft delete
        Route::post('/posts/soft_delete', [PostController::class, 'softDelete']);
    });

    ///////////////////////////


    /////////////////////////// ROLE
    Route::middleware('auth')->group(function () {
        // create posts
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

        // edit role
        Route::get(ROLE_ROUTE . '/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put(ROLE_ROUTE, [RoleController::class, 'update'])->name('roles.update');

        // add permission to role
        Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

        // hard delete
        Route::delete(ROLE_ROUTE, [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    ///////////////////////////


    /////////////////////////// PERMISSION

    Route::middleware('auth')->group(function () {
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');

        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

        Route::get(PERMISSION_ROUTE . '/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put(PERMISSION_ROUTE, [PermissionController::class, 'update'])->name('permissions.update');

        Route::delete(PERMISSION_ROUTE, [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    ///////////////////////////


/////////////////////////// USER
    Route::middleware('auth')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/search-user', [SearchController::class, 'searchUser']);

        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

        Route::get(USER_ROUTE . '/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put(USER_ROUTE, [UserController::class, 'update'])->name('users.update');

        // hard delete
        Route::delete(USER_ROUTE, [UserController::class, 'destroy'])->name('users.destroy');

        // soft delete
        Route::post('/users/soft_delete', [UserController::class, 'softDelete']);
    });

///////////////////////////


    /////////////////////////// CATEGORY

    Route::middleware('auth')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

        Route::get(CATEGORY_ROUTE . '/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put(CATEGORY_ROUTE, [CategoryController::class, 'update'])->name('categories.update');

        // hard delete
        Route::delete(CATEGORY_ROUTE, [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    ///////////////////////////


    /////////////////////////// PRODUCT

    Route::middleware('auth')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        // search
        Route::post('/search-product', [SearchController::class, 'searchProduct']);

        Route::get(PRODUCT_ROUTE . '/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put(PRODUCT_ROUTE, [ProductController::class, 'update'])->name('products.update');

        // hard delete
        Route::delete(PRODUCT_ROUTE, [ProductController::class, 'destroy'])->name('products.destroy');
        // list soft delete
        Route::post('/products/trash', [ProductController::class, 'trashProduct']);
        // soft delete
        Route::post('/soft_delete', [ProductController::class, 'softDelete']);
    });

    ///////////////////////////

});
// file manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
