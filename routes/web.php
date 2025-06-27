<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DiscourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/discourses', function () {
    return view('discourses.index');
})->name('discourses');

Route::get('/poems', function () {
    return view('poems.index');
})->name('poems');

Route::get('/activity', function () {
    return view('activity.index');
})->name('activity');

Route::get('/testimonials', function () {
    return view('testimonials.index');
})->name('testimonials');

Route::get('/about', function () {
    return view('about.index');
})->name('about');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Routes (placeholder for now)
    Route::get('/forgot-password', function () {
        return view('auth.passwords.email');
    })->name('password.request');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // User Dashboard (placeholder for now)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Discourse routes
Route::get('/discourses', [DiscourseController::class, 'index'])->name('discourses.index');
Route::get('/discourses/{slug}', [DiscourseController::class, 'show'])->name('discourses.show');
Route::post('/discourses/{slug}/enroll', [DiscourseController::class, 'enroll'])->middleware('auth')->name('discourses.enroll');

// My Discourses route (requires authentication)
Route::get('/my-discourses', [DiscourseController::class, 'myDiscourses'])
    ->middleware('auth')
    ->name('discourses.my');

// Video routes
Route::get('/discourses/{discourse_slug}/videos/{video_id}', [VideoController::class, 'show'])
    ->middleware('auth')
    ->name('videos.show');

// Free preview video route (no auth required)
Route::get('/discourses/{discourse_slug}/preview/{video_id}', [VideoController::class, 'preview'])
    ->name('videos.preview');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes (login, register)
    Route::middleware(['web', 'guest:admin'])->group(function () {
        // Admin Auth Routes
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);

        // Admin Registration Routes (only for development)
        if (!app()->isProduction()) {
            Route::get('/register', [App\Http\Controllers\Admin\AuthController::class, 'showRegistrationForm'])->name('register');
            Route::post('/register', [App\Http\Controllers\Admin\AuthController::class, 'createAdmin']);
        }
    });

    // Admin Logout (requires admin auth)
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])
        ->middleware(['web', 'auth:admin'])
        ->name('logout');

    // Protected Admin Routes
    Route::middleware(['web', 'auth:admin'])->group(function () {
        // Dashboard
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Discourse Management
        Route::resource('discourses', App\Http\Controllers\Admin\DiscourseController::class);

        // Video Management
        Route::get('/discourses/{discourse}/videos', [App\Http\Controllers\Admin\VideoController::class, 'index'])->name('discourses.videos.index');
        Route::get('/discourses/{discourse}/videos/create', [App\Http\Controllers\Admin\VideoController::class, 'create'])->name('discourses.videos.create');
        Route::post('/discourses/{discourse}/videos', [App\Http\Controllers\Admin\VideoController::class, 'store'])->name('discourses.videos.store');
        Route::get('/discourses/{discourse}/videos/{video}/edit', [App\Http\Controllers\Admin\VideoController::class, 'edit'])->name('discourses.videos.edit');
        Route::put('/discourses/{discourse}/videos/{video}', [App\Http\Controllers\Admin\VideoController::class, 'update'])->name('discourses.videos.update');
        Route::delete('/discourses/{discourse}/videos/{video}', [App\Http\Controllers\Admin\VideoController::class, 'destroy'])->name('discourses.videos.destroy');
        Route::post('/discourses/{discourse}/videos/reorder', [App\Http\Controllers\Admin\VideoController::class, 'reorder'])->name('discourses.videos.reorder');

        // YouTube API
        Route::post('/youtube/fetch-details', [App\Http\Controllers\Admin\VideoController::class, 'fetchYouTubeDetails'])->name('youtube.fetch-details');
    });
});
