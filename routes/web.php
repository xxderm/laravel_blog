<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

Route::get('/profile/verify', function(Request $req) {
    Auth::user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware('auth')->name('/profile/verify');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/password-change', function (Request $request) {
    $credentials = ['email' => Auth::user()->email];
    $status = Password::sendResetLink($credentials);
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['message' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('auth')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('reset_pass', ['token' => $token, 'user' => Auth::user()]);
})->middleware('auth')->name('password.reset');

Route::post('/change', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
    return redirect()->route('/profile')->with('message', __($status));
})->middleware('auth')->name('password.update');

Route::get('/view-post/{id}', function ($id) {
    return view('view_post', ['post' => Post::find($id)]);
})->middleware('auth')->name('view-post');

Route::post('/view-post/push-comment/{id}', function (Request $req, $id) {
    $content = $req->input('content');
    Comment::create([
        'user_id' => Auth::user()->id,
        'post_id' => $id,
        'content' => $content,
        'votes' => '0'
    ]);
    return back();
})->middleware('auth')->name('view-post.push-comment');

Route::get('/view-post/like-comment/{id}', function ($commentId) {
    $comment = Comment::find($commentId);
    ++$comment->votes;
    $comment->save();
    return back();
})->middleware('auth')->name('view-post.like-comment');

Route::get('/profile/new-post', function () {
    return view('new_post', ['user' => Auth::user()]);
})->middleware('auth')->name('profile.new-post');

Route::post('/profile/new-post', function (Request $req) {
    $post = Post::create([
        'user_id' => Auth::user()->id,
        'title' => $req->input('title'),
        'desc' => $req->input('desc'),
        'content' => $req->input('content'),
        'votes' => '0'
    ]);
    return redirect()->route('/profile')->with('message', 'Опубликовано!');
})->middleware('auth')->name('profile.new-post');

Route::get('/profile/delete-post/{id}', function ($id) {
    return back();
})->middleware('auth')->name('profile.delete-post');