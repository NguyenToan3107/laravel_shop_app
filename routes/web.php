<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
//
//Route::get('/', function () {
//    return view('welcome');
//});

const POST_ROUTE = '/posts/{post}';
const ROLE_ROUTE = '/roles/{role}';
const PERMISSION_ROUTE = '/permissions/{permission}';
const USER_ROUTE = '/users/{user}';
const PRODUCT_ROUTE = '/products/{product}';
const CATEGORY_ROUTE = '/categories/{category}';

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/////////////////////////// POST
Route::group(['middleware' => ['auth', 'can:create post']], function () {
    // posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
});

Route::group(['middleware' => ['auth', 'can:view post']], function () {
    // posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/search-post', [SearchController::class, 'searchPost']);
});

Route::group(['middleware' => ['auth', 'can:edit post']], function () {
    Route::get(POST_ROUTE. '/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put(POST_ROUTE, [PostController::class, 'update'])->name('posts.update');
});

Route::group(['middleware' => ['auth', 'can:delete post']], function () {
    // hard delete
    Route::delete(POST_ROUTE, [PostController::class, 'destroy'])->name('posts.destroy');
    // soft delete
    Route::post('/posts/soft_delete', [PostController::class, 'softDelete']);
});

///////////////////////////

require __DIR__.'/auth.php';


/////////////////////////// ROLE
Route::group(['middleware' => ['auth', 'can:create role']], function () {
    // posts
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
});

Route::group(['middleware' => ['auth', 'can:view role']], function () {
    // posts
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
});

Route::group(['middleware' => ['auth', 'can:edit role']], function () {
    Route::get(ROLE_ROUTE. '/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put(ROLE_ROUTE, [RoleController::class, 'update'])->name('roles.update');

    // add permission to role
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
});

Route::group(['middleware' => ['auth', 'can:delete role']], function () {
    // hard delete
    Route::delete(ROLE_ROUTE, [RoleController::class, 'destroy'])->name('roles.destroy');
});

///////////////////////////



/////////////////////////// PERMISSION
Route::group(['middleware' => ['auth', 'can:create permission']], function () {
    // posts
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
});

Route::group(['middleware' => ['auth', 'can:view permission']], function () {
    // posts
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
});

Route::group(['middleware' => ['auth', 'can:edit permission']], function () {
    Route::get(PERMISSION_ROUTE. '/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put(PERMISSION_ROUTE, [PermissionController::class, 'update'])->name('permissions.update');

});
Route::group(['middleware' => ['auth', 'can:delete permission']], function () {
    // hard delete
    Route::delete(PERMISSION_ROUTE, [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

///////////////////////////




/////////////////////////// USER
Route::group(['middleware' => ['auth', 'can:create user']], function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
});

Route::group(['middleware' => ['auth', 'can:view user']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/search-user', [SearchController::class, 'searchUser']);
});

Route::group(['middleware' => ['auth', 'can:edit user']], function () {
    Route::get(USER_ROUTE. '/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put(USER_ROUTE, [UserController::class, 'update'])->name('users.update');
});
Route::group(['middleware' => ['auth', 'can:delete user']], function () {
    // hard delete
    Route::delete(USER_ROUTE, [UserController::class, 'destroy'])->name('users.destroy');

    // soft delete
    Route::post('/users/soft_delete', [UserController::class, 'softDelete']);
});

///////////////////////////




/////////////////////////// CATEGORY
Route::group(['middleware' => ['auth', 'can:create category']], function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
});

Route::group(['middleware' => ['auth', 'can:view category']], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
});

Route::group(['middleware' => ['auth', 'can:edit category']], function () {
    Route::get(CATEGORY_ROUTE. '/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put(CATEGORY_ROUTE, [CategoryController::class, 'update'])->name('categories.update');
});
Route::group(['middleware' => ['auth', 'can:delete category']], function () {
    // hard delete
    Route::delete(CATEGORY_ROUTE, [CategoryController::class, 'destroy'])->name('categories.destroy');
});

///////////////////////////





/////////////////////////// PRODUCT
Route::group(['middleware' => ['auth', 'can:create product']], function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
});

Route::group(['middleware' => ['auth', 'can:view product']], function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // search
    Route::post('/search-product', [SearchController::class, 'searchProduct']);
});

Route::group(['middleware' => ['auth', 'can:edit product']], function () {
    Route::get(PRODUCT_ROUTE. '/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put(PRODUCT_ROUTE, [ProductController::class, 'update'])->name('products.update');
});
Route::group(['middleware' => ['auth', 'can:delete product']], function () {
    // hard delete
    Route::delete(PRODUCT_ROUTE, [ProductController::class, 'destroy'])->name('products.destroy');
    // list soft delete
    Route::post('/products/trash', [ProductController::class, 'trashProduct']);
    // soft delete
    Route::post('/soft_delete', [ProductController::class, 'softDelete']);
});

///////////////////////////

// file manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
