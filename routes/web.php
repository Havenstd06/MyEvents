<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Socialite
Route::get('oauth/{driver}', [SocialController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [SocialController::class, 'handleProviderCallback'])->name('social.callback');

// Home
Route::get('/', [EventsController::class, 'home'])->name('home');

// Profile
Route::prefix('/profile')->middleware(['auth'])->group(function () {
    Route::get('/', [UsersController::class, 'profile'])->name('profile');
    Route::post('/edit', [UsersController::class, 'updateUser'])->name('profile.update');
});



require __DIR__.'/auth.php';
