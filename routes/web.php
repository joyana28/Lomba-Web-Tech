<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\DonorRequestController;
use App\Http\Controllers\DonorResponseController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationHistoryController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/home', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('dashboard')
            : view('user.home');
    })->name('user.home');

    Route::middleware('is_admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('donor')->group(function () {
        Route::get('/profile', [DonorProfileController::class, 'index'])->name('donor.profile');
        Route::post('/profile/update', [DonorProfileController::class, 'update'])->name('donor.profile.update');
    });

    Route::prefix('requests')->group(function () {

        Route::get('/', [DonorRequestController::class, 'index'])->name('requests.index');

        Route::post('/{request}/donate', [DonorResponseController::class, 'store'])->name('donor.respond');

        Route::middleware('is_admin')->group(function () {
            Route::get('/create', [DonorRequestController::class, 'create'])->name('requests.create');
            Route::post('/', [DonorRequestController::class, 'store'])->name('requests.store');
        });

        Route::get('/{request}', [DonorRequestController::class, 'show'])->name('requests.show');

        Route::post('/{request}/close', [DonorRequestController::class, 'close'])->name('requests.close');
        Route::post('/{request}/results/{result}/confirm', [DonorRequestController::class, 'confirmResult'])
        ->name('requests.results.confirm');
    });

    Route::get('/matching/{request}', [MatchingController::class, 'match'])->name('matching.run');

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    Route::get('/history', [DonationHistoryController::class, 'index'])->name('history.index');
});