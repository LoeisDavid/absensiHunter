<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

// ─── Auth ───────────────────────────────────────────────────────────
Route::get('/',       [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// ─── Protected (Admin Only) ──────────────────────────────────────────
Route::middleware(AuthMiddleware::class)->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Scan
    Route::get('/scan',       [ScanController::class, 'index'])->name('scan');
    Route::post('/scan/absen',[ScanController::class, 'absen'])->name('scan.absen');

    // Data Diri (tampil setelah scan)
    Route::get('/anggota/show', [AnggotaController::class, 'show'])->name('anggota.show');

    // Tabel Absensi
    Route::get('/absensi/peserta',  [AbsensiController::class, 'peserta'])->name('absensi.peserta');
    
});
Route::get('/absensi/pengurus', [AbsensiController::class, 'pengurus'])->name('absensi.pengurus');
