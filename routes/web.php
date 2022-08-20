<?php

use App\Http\Controllers\AdminPostController;
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
    return response()->file('/var/www/html/public/storage/logo.png');
});

Route::get('/', [PostController::class, 'index'])->name('home');

Route::post('newsletter', NewsletterController::class);

Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)
        ->except('show')
        ->parameters(['posts' => 'post:id']);
//    Route::post('admin/posts', [AdminPostController::class, 'store']); //LINIJKA WYŻEJ ROBI TO WSZYSTKO CO TE 6
//    Route::get('admin/posts/create', [AdminPostController::class, 'create']);
//    Route::get('admin/posts', [AdminPostController::class, 'index']);
//    Route::get('admin/posts/{post:id}/edit', [AdminPostController::class, 'edit']);
//    Route::patch('admin/posts/{post:id}', [AdminPostController::class, 'update']);
//    Route::delete('admin/posts/{post:id}', [AdminPostController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('user/account', [UserController::class, 'index']);
    Route::get('user/security', [UserController::class, 'security']);
    Route::post('user/change/username', [UserController::class, 'updateUsername']);
    Route::post('user/change/email', [UserController::class, 'updateEmail']);
    Route::post('user/change/name', [UserController::class, 'updateName']);
    Route::post('user/change/password', [UserController::class, 'updatePassword']);
    Route::post('user/change/delete', [UserController::class, 'deleteAccount']);

    Route::get('user/posts', [UsersPostsController::class, 'index'])->middleware('can:creator');
    Route::get('user/comments', [UsersCommentsController::class, 'index']);
});



require __DIR__.'/auth.php';
