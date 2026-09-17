<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LegalController;
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\PlayerController;
use App\Http\Controllers\Front\PodcastApplyController;
use App\Http\Controllers\Front\PodcastController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\SponsorController;
use App\Http\Controllers\Front\TeamController;
use App\Http\Controllers\Front\TournamentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public frontend routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About & Team
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/team', [TeamController::class, 'index'])->name('team');
Route::get('/team/{slug}', [TeamController::class, 'show'])->name('team.show');

// Players
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player:slug}', [PlayerController::class, 'show'])->name('players.show');

// Tournaments
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{slug}', [TournamentController::class, 'show'])->name('tournaments.show');

// Champions Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Sponsors & Partners
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors');

// Membership / Registration
Route::get('/join/player', [MembershipController::class, 'joinPlayer'])->name('membership.player');
Route::post('/join/player', [MembershipController::class, 'storePlayer'])->name('membership.player.store');
Route::get('/join/brand', [MembershipController::class, 'joinBrand'])->name('membership.brand');
Route::post('/join/brand', [MembershipController::class, 'storeBrand'])->name('membership.brand.store');

// Podcast
Route::get('/podcast', [PodcastController::class, 'index'])->name('podcast');
Route::get('/podcast/apply', [PodcastApplyController::class, 'create'])->name('podcast.apply');
Route::post('/podcast/apply', [PodcastApplyController::class, 'store'])->name('podcast.apply.store');

// News (official updates, results, announcements)
Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Blogs (insights, interviews, opinion pieces)
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

// FAQs
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Legal
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('terms');

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});
