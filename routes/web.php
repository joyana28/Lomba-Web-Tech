<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\DonorRequestController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationHistoryController;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
    return view('welcome');
});


// 🔐 AUTH
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// 🔒 PROTECTED ROUTES (LOGIN REQUIRED)
Route::middleware(['auth'])->group(function () {

    // 🏠 DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 👤 PROFIL DONOR
    Route::get('/donor/profile', [DonorProfileController::class, 'index'])->name('donor.profile');
    Route::post('/donor/profile/update', [DonorProfileController::class, 'update'])->name('donor.profile.update');

    // 🩸 DONOR REQUEST
    Route::get('/requests', [DonorRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [DonorRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests/store', [DonorRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}', [DonorRequestController::class, 'show'])->name('requests.show');

    // 🧠 MATCHING
    Route::get('/matching/{requestId}', [MatchingController::class, 'match'])->name('matching.run');

    // 🔔 NOTIFICATIONS
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // 📜 HISTORY
    Route::get('/history', [DonationHistoryController::class, 'index'])->name('history.index');

    // 📊 REPORT
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

});