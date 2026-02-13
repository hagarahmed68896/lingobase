<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

use App\Http\Controllers\ContactController;

Route::get('/', function (Request $request) {
    if (Auth::check() && Auth::user()->is_admin) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    return view('welcome');
});

Route::get('/help', function () {
    return view('help');
})->name('help');

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

// Basic Public Index Routes
Route::prefix('grammar')->group(function () {
    Route::get('/', [GrammarController::class, 'index'])->name('grammar.index');
    Route::get('/{language}/{level}', [GrammarController::class, 'showLevel'])->name('grammar.level');
    Route::get('/{language}/{level}/{lesson}', [GrammarController::class, 'showLesson'])->name('grammar.lesson');
});

// Placement Test (Public Intro)
Route::get('grammar/placement-test', [App\Http\Controllers\PlacementController::class, 'index'])->name('grammar.placement');
Route::prefix('stories')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('stories.index');
    Route::get('/{language}/{level}', [StoryController::class, 'showLevel'])->name('stories.level');
    Route::get('/{language}/{level}/{story}', [StoryController::class, 'showStory'])->name('stories.show');
});

// Protected Profile, Favorites & Placement Test
Route::middleware('auth')->group(function () {
    // Placement Test (Protected Actions)
    Route::prefix('grammar/placement-test')->group(function () {
        Route::post('/start', [App\Http\Controllers\API\PlacementTestController::class, 'start'])->name('grammar.placement.start');
        Route::get('/{testId}/question', [App\Http\Controllers\API\PlacementTestController::class, 'getQuestion']);
        Route::post('/{testId}/answer', [App\Http\Controllers\API\PlacementTestController::class, 'submitAnswer']);
        Route::post('/{testId}/navigate', [App\Http\Controllers\API\PlacementTestController::class, 'navigateToQuestion']);
        Route::post('/{testId}/complete', [App\Http\Controllers\API\PlacementTestController::class, 'completeTest']);
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Protected Grammar Quiz
    Route::get('grammar/{language}/{level}/{lesson}/quiz', [GrammarController::class, 'showQuiz'])->name('grammar.quiz');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('languages', App\Http\Controllers\Admin\LanguageController::class);
    Route::resource('grammar', App\Http\Controllers\Admin\GrammarController::class);
    Route::resource('stories', App\Http\Controllers\Admin\StoryController::class);
});

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
