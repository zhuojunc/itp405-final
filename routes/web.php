<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/parties', [PartyController::class, 'index'])->name('party.index');
    Route::get('/parties/new', [PartyController::class, 'create'])->name('party.create');
    Route::get('/parties/{id}', [PartyController::class, 'show'])->name('party.show');
    Route::post('/parties', [PartyController::class, 'store'])->name('party.store');
    Route::post('/profile/{id}', [partyController::class, 'unfavorite'])->name('party.unfavorite');
    Route::post('/parties/{id}', [partyController::class, 'favorite'])->name('party.favorite');
    Route::get('/parties/{partyId}/restaurants/{restaurantId}', [CommentController::class, 'index'])->name('comment.index');
    Route::post('/comments/new', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::post('/comments/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::post('/comments/{id}/delete', [CommentController::class, 'delete'])->name('comment.delete');
});
Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}


