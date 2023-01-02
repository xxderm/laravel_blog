<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;

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
