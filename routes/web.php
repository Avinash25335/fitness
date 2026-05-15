<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\DietPlanController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TrainerSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminWorkoutController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/privacy', function () { return view('home'); })->name('privacy');
Route::get('/terms', function () { return view('home'); })->name('terms');
Route::get('/contact', function () { return view('home'); })->name('contact');

// 🔑 Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔑 Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Workouts
    Route::get('/workouts', [WorkoutPlanController::class, 'index'])->name('workouts.index');
    Route::get('/workouts/{workout}', [WorkoutPlanController::class, 'show'])->name('workouts.show');
    Route::post('/workouts/{workout}/start', [WorkoutPlanController::class, 'start'])->name('workouts.start');

    // Nutrition Hub
    Route::get('/diets', [DietPlanController::class, 'index'])->name('diets.index');
    Route::post('/diets/{diet}/follow', [DietPlanController::class, 'follow'])->name('diets.follow');
    Route::get('/diets/{diet}/download', [DietPlanController::class, 'download'])->name('diets.download');

    // Transformation / Progress
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress', [ProgressController::class, 'store'])->name('progress.store');
    Route::post('/progress/goal', [ProgressController::class, 'updateGoal'])->name('progress.goal.update');

    // Elite Marketplace
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    // Content Library
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

    // 🏋️ Trainer Booking System (Conflict-Proof)
    Route::post('/book-session', [TrainerSessionController::class, 'book'])->name('trainer.book');
    Route::get('/booked-slots/{trainer}/{date}', [TrainerSessionController::class, 'getBookedSlots'])->name('trainer.slots');
    Route::post('/cancel-session/{id}', [TrainerSessionController::class, 'cancel'])->name('trainer.cancel');
    Route::get('/my-sessions', [TrainerSessionController::class, 'myBookings'])->name('trainer.my-bookings');

    // API Internal Endpoints
    Route::prefix('api')->group(function () {
        // Workout Tracking & Progress
        Route::post('/plan/start/{planId}', [\App\Http\Controllers\Api\WorkoutController::class, 'startPlan']);
        Route::get('/progress/{planId}', [\App\Http\Controllers\Api\WorkoutController::class, 'getProgress']);
        Route::post('/exercise/complete', [\App\Http\Controllers\Api\WorkoutController::class, 'completeExercise']);
        Route::post('/session/complete/{sessionId}', [\App\Http\Controllers\Api\WorkoutController::class, 'completeSession']);
        Route::post('/session/pause/{sessionId}', [\App\Http\Controllers\Api\WorkoutController::class, 'pauseSession']);
        Route::post('/session/resume/{sessionId}', [\App\Http\Controllers\Api\WorkoutController::class, 'resumeSession']);
        Route::get('/adaptive-plan', [\App\Http\Controllers\Api\WorkoutController::class, 'adaptivePlan']);
        Route::get('/recommendation', [\App\Http\Controllers\Api\WorkoutController::class, 'getRecommendation']);
        Route::get('/achievements', [\App\Http\Controllers\Api\WorkoutController::class, 'checkAchievements']);
        Route::get('/weekly-stats', [\App\Http\Controllers\Api\WorkoutController::class, 'weeklyStats']);

        Route::get('/user-stats', [DashboardController::class, 'getStats']);
        Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'index']);
        Route::post('/book-trainer', [\App\Http\Controllers\BookingController::class, 'book']);
        Route::post('/cancel-booking/{id}', [\App\Http\Controllers\BookingController::class, 'cancel']);
        Route::get('/available-slots/{trainer}', [\App\Http\Controllers\BookingController::class, 'availableSlots']);
        Route::get('/diet', [\App\Http\Controllers\DietPlanController::class, 'getDiet']);
        Route::post('/generate-diet', [\App\Http\Controllers\DietPlanController::class, 'generateDiet']);
    });
});

// 👑 Admin Control Panel
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    Route::resource('workouts', AdminWorkoutController::class);
    Route::resource('blog', AdminBlogController::class);
});
