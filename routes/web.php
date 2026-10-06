<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReservasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Reservasi & Manajemen Jadwal Ratna Wedding
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama / Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// 2. Autentikasi Pengguna (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// 3. Autentikasi (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Alur Reservasi Pelanggan
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/check-slots', [ReservasiController::class, 'checkSlots'])->name('reservasi.checkSlots');
    Route::get('/reservasi/{kode_reservasi}', [ReservasiController::class, 'show'])->name('reservasi.show');
    Route::post('/reservasi/{kode_reservasi}/upload-bukti', [ReservasiController::class, 'uploadBukti'])->name('reservasi.uploadBukti');
    Route::get('/riwayat-reservasi', [ReservasiController::class, 'riwayat'])->name('reservasi.riwayat');
});
