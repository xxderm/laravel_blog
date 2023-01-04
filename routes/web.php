<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Gate;

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

Route::get('/', [HomeController::class, 'Show']);

Route::middleware('guest')->namespace('\App\Http\Controllers')->group(function() {
    Route::get('login', function() { return view('login'); })->name('login');
    Route::post('login', [LoginController::class, 'SignIn']);

    Route::get('signup', function() { return view('signup'); });
    Route::post('signup', [LoginController::class, 'SignUp']);
});

Route::get('/profile', [ProfileController::class, 'Show'])->middleware('auth')->name('/profile');

Route::get('/profile/logout', [LoginController::class, 'LogOut'])->middleware('auth')->name('/profile/logout');

Route::get('/profile/verify', [ProfileController::class, 'SendVerifyNotify'])->middleware('auth')->name('/profile/verify');

Route::get('/email/verify/{id}/{hash}', [ProfileController::class, 'Verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/password-change', [ProfileController::class, 'PasswordSendReset'])->middleware('auth')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('reset_pass', ['token' => $token, 'user' => Auth::user()]);
})->middleware('auth')->name('password.reset');

Route::post('/change', [ProfileController::class, 'PasswordUpdate'])->middleware('auth')->name('password.update');

Route::get('/view-post/{id}', function ($id) {
    return view('view_post', ['post' => Post::find($id)]);
})->middleware('auth')->name('view-post');

Route::post('/view-post/push-comment/{id}', [PostController::class, 'PushComment'])->middleware('auth')->name('view-post.push-comment');

Route::get('/view-post/like-comment/{id}', [PostController::class, 'LikeComment'])->middleware('auth')->name('view-post.like-comment');

Route::get('/profile/new-post', function () {
    return view('new_post', ['user' => Auth::user()]);
})->middleware('auth')->name('profile.new-post');

Route::post('/profile/new-post', [PostController::class, 'AddPost'])->middleware('auth')->name('profile.new-post');

Route::get('/profile/delete-post/{id}', [PostController::class, 'DeletePost'])->middleware('auth')->name('profile.delete-post');

Route::get('/profile/edit-post/{id}', [PostController::class, 'EditViewPost'])->middleware('auth')->name('profile.edit-post');

Route::post('/profile/edit-post/{id}', [PostController::class, 'UpdatePost'])->middleware('auth')->name('profile.edit-post');