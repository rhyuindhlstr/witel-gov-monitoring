<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KunjunganPelangganController;
use App\Http\Controllers\PembayaranPelangganController;
use App\Http\Controllers\NotificationController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
require __DIR__ . '/auth.php';

// Dashboard and Attributes - accessible by authenticated users
Route::middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->middleware(\App\Http\Middleware\AdminMiddleware::class)
        ->name('dashboard');

    // SSGS Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SSGS Module Routes
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('kunjungan', KunjunganPelangganController::class);
    Route::resource('pembayaran', PembayaranPelangganController::class);

    // Data Wilayah (Accessible by all roles)
    Route::resource('wilayah', WilayahController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
});

// Admin-only routes (Wilayah & User Management)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});
