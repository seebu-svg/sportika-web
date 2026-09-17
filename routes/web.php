<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PlayerController;
use App\Http\Controllers\Front\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public frontend routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player:slug}', [PlayerController::class, 'show'])->name('players.show');

Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});
