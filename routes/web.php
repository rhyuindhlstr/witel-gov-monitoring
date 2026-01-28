<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// SSGS Module Routes - Protected by auth middleware
Route::middleware(['auth'])->group(function () {
    // Pelanggan Management
    Route::resource('pelanggan', App\Http\Controllers\PelangganController::class);
    
    // Kunjungan Pelanggan Management
    Route::resource('kunjungan', App\Http\Controllers\KunjunganPelangganController::class);
    
    // Pembayaran Pelanggan Management
    Route::resource('pembayaran', App\Http\Controllers\PembayaranPelangganController::class);

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markRead');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
});
