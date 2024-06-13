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


Route::get('/', [DashboardController::class, 'index']);

//Route::group(['middleware' => ['role:admin']], function () {
//});

// permissions
Route::resource('permissions', PermissionController::class);
// roles
Route::resource('roles', RoleController::class);
Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

// users
Route::resource('users', UserController::class);

//Auth::routes();
// login & register
Route::get('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/store', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/access', [AuthController::class, 'access']);


// products
Route::resource('products', ProductController::class);
Route::post('/soft_delete', [ProductController::class, 'softDelete']);

// categories
Route::resource('categories', CategoryController::class);

// posts
Route::resource('posts', PostController::class);
Route::post('/posts/soft_delete', [PostController::class, 'softDelete']);

Route::get('/showCategories', [ProductController::class, 'showCategories']);

Route::get('/sortByProduct', [ProductController::class, 'sortByProduct']);
Route::get('/sortByCategory', [ProductController::class, 'sortByCategory']);


// search
Route::post('/search-product', [SearchController::class, 'searchProduct']);
Route::post('/search-post', [SearchController::class, 'searchPost']);
Route::post('/search-user', [SearchController::class, 'searchUser']);


// trash
Route::post('/products/trash', [ProductController::class, 'trashProduct']);

//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
