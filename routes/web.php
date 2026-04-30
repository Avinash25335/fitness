<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\DietPlanController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminWorkoutController;
use App\Http\Controllers\AdminBlogController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/workouts', [WorkoutPlanController::class, 'index'])->name('workouts.index');
Route::get('/workouts/{workout}', [WorkoutPlanController::class, 'show'])->name('workouts.show');

Route::get('/diets', [DietPlanController::class, 'index'])->name('diets.index');
Route::get('/diets/{diet}', [DietPlanController::class, 'show'])->name('diets.show');
Route::post('/diets/{diet}/follow', [DietPlanController::class, 'follow'])->name('diets.follow');
Route::get('/diets/{diet}/download', [DietPlanController::class, 'download'])->name('diets.download');

Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

// Static Pages
Route::view('/privacy', 'pages.static', ['title' => 'Privacy Policy'])->name('privacy');
Route::view('/terms', 'pages.static', ['title' => 'Terms of Service'])->name('terms');
Route::view('/contact', 'pages.static', ['title' => 'Contact Us'])->name('contact');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Socialite Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Auth routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');

    // Progress
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress', [ProgressController::class, 'store'])->name('progress.store');

    // Workout Logs
    Route::post('/workout-logs', [App\Http\Controllers\WorkoutLogController::class, 'store'])->name('workout-logs.store');

    // Trainers
    Route::post('/trainers/book', [TrainerController::class, 'book'])->name('trainers.book');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    Route::resource('workouts', AdminWorkoutController::class);
    Route::resource('blog', AdminBlogController::class);
});
