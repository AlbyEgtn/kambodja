<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OwnerAbsensiController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\KasirDashboardController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\ResepController;

Route::get('/', function () {
    return view('../auth/login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:2,1')->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard masing-masing role
Route::middleware(['auth','role:Karyawan'])
    ->get('karyawan.dashboard',function () {
        return view('karyawan.dashboard');
})->name('karyawan.dashboard');

Route::middleware(['auth','role:Kasir'])->get('/kasir', function () {
    return "Dashboard Kasir";
})->name('dashboard.kasir');

// OWNER
Route::middleware(['auth', 'role:Owner'])->group(function () {

    Route::get('/owner/verifikasi-absensi', function () {
        return view('owner.verifikasi-absensi');
    });

    Route::get('/owner/laporan-statistik', function () {
        return view('owner.laporan-statistik');
    });

    /// Management Akun
    Route::get('/owner/akun', [UserManagementController::class, 'index'])->name('owner.akun');
    Route::post('/owner/akun', [UserManagementController::class, 'store'])->name('owner.akun.store');
    Route::put('/owner/akun/{id}', [UserManagementController::class, 'update'])->name('owner.akun.update');
    Route::delete('/owner/akun/{id}', [UserManagementController::class, 'destroy'])->name('owner.akun.destroy');

    /// Bahan Baku
    Route::get('/owner/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan.index');
    Route::post('/owner/bahan-baku', [BahanBakuController::class, 'store'])->name('bahan.store');
    Route::put('/owner/bahan-baku/{id}', [BahanBakuController::class, 'update'])->name('bahan.update');
    Route::delete('/owner/bahan-baku/{id}', [BahanBakuController::class, 'destroy'])->name('bahan.destroy');

    /// Dashboard
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');

    /// Verifikasi Absen
    Route::get('/owner/verifikasi-absensi', [OwnerAbsensiController::class, 'index']);
    Route::post('/owner/verifikasi-absensi/{id}/approve', [OwnerAbsensiController::class, 'approve']);
    Route::post('/owner/verifikasi-absensi/{id}/reject', [OwnerAbsensiController::class, 'reject']);

    /// Resep
    Route::get('/owner/resep', [ResepController::class, 'index'])->name('resep.index');
    Route::post('/owner/resep', [ResepController::class, 'store'])->name('resep.store');
    Route::post('/owner/resep/menu', [ResepController::class, 'storeMenu'])->name('resep.menu.store');
    Route::delete('/owner/resep/{id}', [ResepController::class, 'destroy'])->name('resep.destroy');
    Route::get('/owner/resep/{menuId}/json', [ResepController::class, 'getResepJson']);
    Route::put('/owner/resep/{menuId}', [ResepController::class, 'update'])->name('resep.update');
    Route::delete('/owner/menu/{id}', [ResepController::class, 'destroyMenu'])->name('menu.destroy');

});

// Karyawan & Kasir
// Absensi Karyawan / Kasir
Route::middleware(['auth', 'role:Karyawan,Kasir'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absen.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absen.masuk');
    Route::post('/absensi/keluar', [AbsensiController::class, 'keluar'])->name('absen.keluar');
});



// KASIR
Route::middleware(['auth','role:Kasir'])->group(function () {
    Route::get('/kasir/dashboard', [AbsensiController::class, 'dashboardKasir'])
        ->name('kasir.dashboard');
    Route::get('/kasir/beranda', [KasirDashboardController::class, 'index'])->name('kasir.beranda');
    Route::get('/kasir/transaksi', [KasirTransaksiController::class, 'index'])->name('kasir.transaksi');
    Route::post('/kasir/transaksi/simpan', [KasirTransaksiController::class, 'simpan'])->name('kasir.transaksi.simpan');
    Route::get('/kasir/riwayat', [KasirTransaksiController::class, 'riwayat'])->name('kasir.riwayat');
});


// KARYAWAN
Route::middleware(['auth', 'role:Karyawan,Kasir'])->group(function () {
    Route::get('/karyawan/dashboard', function () {
        return redirect()->route('karyawan.dashboard');
    });

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absen.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absen.masuk');
    Route::post('/absensi/keluar', [AbsensiController::class, 'keluar'])->name('absen.keluar');
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absen.riwayat');
});




/// TEST ABSEN