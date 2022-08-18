<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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
//    Route::resource('admin/posts', AdminPostController::class)->except('show')->parameter('post', 'post:id');
    Route::post('admin/posts', [AdminPostController::class, 'store']); //LINIJKA WYŻEJ ROBI TO WSZYSTKO CO TE 6
    Route::get('admin/posts/create', [AdminPostController::class, 'create']);
    Route::get('admin/posts', [AdminPostController::class, 'index']);
    Route::get('admin/posts/{post:id}/edit', [AdminPostController::class, 'edit']);
    Route::patch('admin/posts/{post:id}', [AdminPostController::class, 'update']);
    Route::delete('admin/posts/{post:id}', [AdminPostController::class, 'destroy']);
});

Route::get('user/account', [UserController::class, 'index'])->middleware('auth');
Route::get('user/security', [UserController::class, 'security'])->middleware('auth');
Route::post('user/change/username', [UserController::class, 'updateUsername'])->middleware('auth');
Route::post('user/change/email', [UserController::class, 'updateEmail'])->middleware('auth');
Route::post('user/change/name', [UserController::class, 'updateName'])->middleware('auth');
Route::post('user/change/password', [UserController::class, 'updatePassword'])->middleware('auth');

require __DIR__.'/auth.php';
