<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodPostController;
use App\Http\Controllers\SkillPostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('store.register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin'])->name('store.login');
    Route::post('/demo-login', [AuthController::class, 'demoLogin'])->name('demo.login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Food Posts
    Route::prefix('/food')->name('food.')->group(function () {
        Route::get('/', [FoodPostController::class, 'index'])->name('index');
        Route::get('/create', [FoodPostController::class, 'create'])->name('create');
        Route::post('/', [FoodPostController::class, 'store'])->name('store');
        Route::get('/{foodPost}', [FoodPostController::class, 'show'])->name('show');
        Route::get('/{foodPost}/edit', [FoodPostController::class, 'edit'])->name('edit');
        Route::put('/{foodPost}', [FoodPostController::class, 'update'])->name('update');
        Route::delete('/{foodPost}', [FoodPostController::class, 'destroy'])->name('destroy');
    });

    // Skill Posts
    Route::prefix('/skills')->name('skills.')->group(function () {
        Route::get('/', [SkillPostController::class, 'index'])->name('index');
        Route::get('/create', [SkillPostController::class, 'create'])->name('create');
        Route::post('/', [SkillPostController::class, 'store'])->name('store');
        Route::get('/{skillPost}', [SkillPostController::class, 'show'])->name('show');
        Route::get('/{skillPost}/edit', [SkillPostController::class, 'edit'])->name('edit');
        Route::put('/{skillPost}', [SkillPostController::class, 'update'])->name('update');
        Route::delete('/{skillPost}', [SkillPostController::class, 'destroy'])->name('destroy');
    });

    // Messages
    Route::prefix('/messages')->name('messages.')->group(function () {
        Route::get('/inbox', [MessageController::class, 'inbox'])->name('inbox');
        Route::get('/sent', [MessageController::class, 'sent'])->name('sent');
        Route::get('/conversation/{userId}', [MessageController::class, 'conversation'])->name('conversation');
        Route::get('/conversation/{userId}/fetch', [MessageController::class, 'fetch'])->name('fetch');
        Route::post('/send/{userId}', [MessageController::class, 'sendMessage'])->name('send');
        Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('mark-as-read');
    });

    // Ratings
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // Notifications
    Route::prefix('/notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/read', [NotificationController::class, 'markRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
    });

    // Claims (food)
    Route::post('/food/{foodPost}/claim', [ClaimController::class, 'store'])->name('claims.store');
    Route::get('/my-claims', [ClaimController::class, 'myClaims'])->name('claims.index');
    Route::post('/claims/{claim}/accept', [ClaimController::class, 'accept'])->name('claims.accept');
    Route::post('/claims/{claim}/decline', [ClaimController::class, 'decline'])->name('claims.decline');
    Route::post('/claims/{claim}/complete', [ClaimController::class, 'complete'])->name('claims.complete');
    Route::post('/claims/{claim}/cancel', [ClaimController::class, 'cancel'])->name('claims.cancel');

    // Bookings (skills)
    Route::post('/skills/{skillPost}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.index');
    Route::post('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{booking}/decline', [BookingController::class, 'decline'])->name('bookings.decline');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Public profiles
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Profile editing
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Favorites / Saved
    Route::get('/saved', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/food/{foodPost}/save', [FavoriteController::class, 'toggleFood'])->name('favorites.food');
    Route::post('/skills/{skillPost}/save', [FavoriteController::class, 'toggleSkill'])->name('favorites.skill');

    // Community impact
    Route::get('/impact', [ImpactController::class, 'index'])->name('impact');

    // Admin
    Route::prefix('/admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/verify', [AdminController::class, 'toggleVerify'])->name('users.verify');
        Route::post('/users/{user}/admin', [AdminController::class, 'toggleAdmin'])->name('users.admin');
        Route::delete('/food/{foodPost}', [AdminController::class, 'deleteFood'])->name('food.delete');
        Route::delete('/skills/{skillPost}', [AdminController::class, 'deleteSkill'])->name('skills.delete');
    });
});
