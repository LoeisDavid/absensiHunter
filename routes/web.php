<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DetailController;
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
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/scan/absen',[ScanController::class, 'absen'])->name('scan.absen');

    // Data Diri (tampil setelah scan)
    Route::get('/anggota/show', [AnggotaController::class, 'show'])->name('anggota.show');

    // Tabel Absensi
    Route::get('/absensi/peserta',  [AbsensiController::class, 'peserta'])->name('absensi.peserta');
    Route::get('/absensi/pengurus', [AbsensiController::class, 'pengurus'])->name('absensi.pengurus');
    
    // Rekap / Detail Absensi
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/{id}', [RekapController::class, 'show'])->name('rekap.show');
    
    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');


    // Anggota
    Route::get('/anggota', [MemberController::class, 'index'])->name('member.index');
    Route::get('/anggota/peserta', [MemberController::class, 'peserta'])->name('member.peserta');
    Route::get('/anggota/pengurus', [MemberController::class, 'pengurus'])->name('member.pengurus');


    // Detail Absensi
    Route::get('/detail', [DetailController::class, 'index'])->name('detail.index');
});

