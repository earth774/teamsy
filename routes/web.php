<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'show'])->name('home');

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
});

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
// Route::get('password/reset/{token}', 'Auth\PasswordResetController')->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::view('/team', 'team')->name('team.index');
    Route::view('/team/add-user', 'users.create')->name('users.create');

    // Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    // Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');

    // Route::get('logout', 'Auth\LogoutController')->name('logout');

    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');
    Route::get('/documents/{user}/{filename}', [DocumentController::class, 'show']);
});