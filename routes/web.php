<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ChatController;
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

    Route::get('/{trip_id}', [TripsController::class, 'show'])->name('trips.show');

    Route::post('/{trip_id}', [TripsController::class, 'update'])->name('trips.update');

    Route::get('/{trip_id}/{user_id}/leave', [TripsController::class, 'leaveUser'])->name('trips.leave.user');
    Route::get('/{trip_id}/{user_id}/remove', [TripsController::class, 'removeUser'])->name('trips.remove.user');
    Route::get('/{trip_id}/delete', [TripsController::class, 'delete'])->name('trips.delete');

    Route::get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::get('/chat/rooms/{room}/messages', [ChatController::class, 'messages']);
    Route::post('/chat/{room}', [ChatController::class, 'storeMessage']);
});

// Profile
Route::prefix('/profile')->group(function () {
    Route::get('/{user}', [UsersController::class, 'profile'])->name('profile.show');

    Route::middleware(['auth'])->group(function () {
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('profile.edit');
        Route::post('/{user}/edit', [UsersController::class, 'update'])->name('profile.update');
        Route::delete('/user/avatar', [UsersController::class, 'destroyProfileAvatar'])->name('profile.current-user-avatar.destroy');
    });

});



require __DIR__.'/auth.php';
