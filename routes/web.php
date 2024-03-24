<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

// Home
Route::get('/', [Controllers\MainController::class, 'index'])->name('home');

// Auth
Route::middleware(['auth'])->group(function () {

    // Shorten
    Route::post('/shorten', [Controllers\LinksController::class, 'shorten'])->name('shorten');

    // Links
    Route::get('/links', [Controllers\LinksController::class, 'index'])->name('links');

    // Stats
    Route::post('/stats', [Controllers\LinksController::class, 'stats'])->name('stats');

    // Logout
    Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');

    // Delete
    Route::post('/delete', [Controllers\LinksController::class, 'delete'])->name('delete');
});

// Auth
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [Controllers\AuthController::class, 'login'])->name('login');
});

// Visit
Route::get('/{token}', [Controllers\LinksController::class, 'visit'])->name('visit');
