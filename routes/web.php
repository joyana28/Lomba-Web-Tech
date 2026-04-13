<?php

use Illuminate\Support\Facades\Route;

// 🔐 AUTH CONTROLLERS
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// MAIN CONTROLLERS
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\DonorRequestController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationHistoryController;
use App\Http\Controllers\ReportController;

// 🏠 LANDING PAGE
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔁 OPTIONAL REDIRECT
Route::get('/home', function () {
    return redirect()->route('dashboard');
});


// 🔐 AUTH (HANYA UNTUK GUEST)
Route::middleware('guest')->group(function () {

    // LOGIN
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // REGISTER
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // 🔑 FORGOT PASSWORD
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});


// 🔒 PROTECTED ROUTES (LOGIN REQUIRED)
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // 🏠 DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 👤 PROFIL DONOR
    Route::prefix('donor')->group(function () {
        Route::get('/profile', [DonorProfileController::class, 'index'])->name('donor.profile');
        Route::post('/profile/update', [DonorProfileController::class, 'update'])->name('donor.profile.update');
    });

    // 🩸 DONOR REQUEST
    Route::prefix('requests')->group(function () {
        Route::get('/', [DonorRequestController::class, 'index'])->name('requests.index');
        Route::get('/create', [DonorRequestController::class, 'create'])->name('requests.create');
        Route::post('/', [DonorRequestController::class, 'store'])->name('requests.store');
        Route::get('/{request}', [DonorRequestController::class, 'show'])->name('requests.show');
    });

    // 🧠 MATCHING
    Route::get('/matching/{request}', [MatchingController::class, 'match'])->name('matching.run');

    // 🔔 NOTIFICATIONS
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    // 📜 HISTORY
    Route::get('/history', [DonationHistoryController::class, 'index'])->name('history.index');

    // 📊 REPORT
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});