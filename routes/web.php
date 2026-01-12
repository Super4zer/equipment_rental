<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Peminjam Routes - Must be before resource routes to avoid conflicts
    Route::prefix('peminjam')->group(function () {
        Route::get('/browse', [App\Http\Controllers\PeminjamController::class, 'browse'])->name('peminjam.browse');
        Route::get('/my-bookings', [App\Http\Controllers\PeminjamanController::class, 'indexPeminjam'])->name('peminjam.bookings');
        Route::get('/favorites', [App\Http\Controllers\PeminjamController::class, 'favorites'])->name('peminjam.favorites');
        Route::get('/notifications', [App\Http\Controllers\PeminjamController::class, 'notifications'])->name('peminjam.notifications');
        Route::get('/alat/{alat}', [App\Http\Controllers\PeminjamController::class, 'show'])->name('peminjam.alat.show');
        Route::get('/peminjaman/create', [App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjam.create');
        Route::post('/peminjaman/store', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');
    });
    
    // Admin & Petugas Routes
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('alat', AlatController::class);
        
        // Petugas Routes
        Route::get('/verifikasi', [App\Http\Controllers\PeminjamanController::class, 'verifikasiIndex'])->name('verifikasi.index');
        Route::post('/verifikasi/{peminjaman}/approve', [App\Http\Controllers\PeminjamanController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/{peminjaman}/reject', [App\Http\Controllers\PeminjamanController::class, 'reject'])->name('verifikasi.reject');
        
        Route::get('/pengembalian', [App\Http\Controllers\PeminjamanController::class, 'pengembalianIndex'])->name('pengembalian.index');
        Route::post('/pengembalian/{peminjaman}/process', [App\Http\Controllers\PeminjamanController::class, 'processReturn'])->name('pengembalian.process');
    });
});
