<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TripsController;
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
Route::get('/events/{recordid}', [EventsController::class, 'show'])->name('events.show');



// Trip
Route::prefix('/trips')->middleware(['auth'])->group(function () {
    Route::post('/{recordid}/create', [TripsController::class, 'create'])->name('trips.create');
    Route::get('/{trip_id}/{recordid}/join', [TripsController::class, 'showJoin'])->name('trips.join.show');
    Route::put('/{trip_id}/{recordid}/join', [TripsController::class, 'join'])->name('trips.join');
});

// Profile
Route::prefix('/profile')->group(function () {
    Route::get('/{user}', [UsersController::class, 'profile'])->name('profile.show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('profile.edit');
        Route::post('/{user}/edit', [UsersController::class, 'update'])->name('profile.update');
    });

});



require __DIR__.'/auth.php';
