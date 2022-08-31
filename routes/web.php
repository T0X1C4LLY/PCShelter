<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersCommentsController;
use App\Http\Controllers\UsersPostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logo', static function () {
    return response()->file('/var/www/html/public/storage/public/logo.png');
});

Route::get('/', [PostController::class, 'index'])->name('home');

Route::post('newsletter', NewsletterController::class);

Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::middleware('can:enter_dashboard')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)
        ->except(['show', 'create'])
        ->parameters(['posts' => 'post:id']);
    Route::get('admin/users', [AdminUserController::class, 'index']);
    Route::delete('admin/users/{user:id}', [AdminUserController::class, 'destroy']);
    Route::patch('admin/users/{user:id}/{id}', [AdminUserController::class, 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('user/account', [UserController::class, 'index']);
    Route::get('user/security', [UserController::class, 'security']);
    Route::post('user/change/username', [UserController::class, 'updateUsername']);
    Route::post('user/change/email', [UserController::class, 'updateEmail']);
    Route::post('user/change/name', [UserController::class, 'updateName']);
    Route::post('user/change/password', [UserController::class, 'updatePassword']);
    Route::post('user/change/delete', [UserController::class, 'deleteAccount']);

    Route::get('user/posts', [UsersPostsController::class, 'index'])->middleware('can:watch_own_posts');
    Route::get('user/posts/create', [UsersPostsController::class, 'create'])->middleware('can:create_post');
    Route::get('user/comments', [UsersCommentsController::class, 'index']);
});

require __DIR__.'/auth.php';
