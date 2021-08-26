<?php

use App\Http\Controllers\Auth\SocialController;
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
Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::get('/Profil/user', function () {
    return Inertia::render('Profil'),
});

require __DIR__.'/auth.php';
