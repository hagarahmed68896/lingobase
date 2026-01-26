<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar', 'es'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::prefix('grammar')->group(function () {
    Route::get('/', [GrammarController::class, 'index'])->name('grammar.index');
    Route::get('/placement-test', [App\Http\Controllers\PlacementController::class, 'index'])->name('grammar.placement');
    
    // Protected routes - require authentication
    Route::middleware('auth')->group(function () {
        Route::get('/{language}/{level}', [GrammarController::class, 'showLevel'])->name('grammar.level');
        Route::get('/{language}/{level}/{lesson}', [GrammarController::class, 'showLesson'])->name('grammar.lesson');
    });
});

Route::prefix('stories')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('stories.index');
    
    // Protected routes - require authentication
    Route::middleware('auth')->group(function () {
        Route::get('/{language}/{level}', [StoryController::class, 'showLevel'])->name('stories.level');
        Route::get('/{language}/{level}/{story}', [StoryController::class, 'showStory'])->name('stories.show');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('languages', App\Http\Controllers\Admin\LanguageController::class);
    Route::resource('grammar', App\Http\Controllers\Admin\GrammarController::class);
    Route::resource('stories', App\Http\Controllers\Admin\StoryController::class);
});
