<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [AuthController::class, 'index'])->name('/');
Route::post('auth_cek', [AuthController::class, 'cek'])->name('auth.cek');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('riwayat')->group(function () {
    // Route::middleware(['auth', 'cekrole:Admin|Puskesmas'])->group(function () {
        Route::get('/', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::post('/tambah', [RiwayatController::class, 'tambah'])->name('riwayat.tambah');
        Route::post('/edit', [RiwayatController::class, 'edit'])->name('riwayat.edit');
        Route::get('/data', [RiwayatController::class, 'data'])->name('riwayat.data');
        Route::post('/hapus', [RiwayatController::class, 'hapus'])->name('riwayat.hapus');
        
        // });
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::get('/data_per_puskesmas', [DashboardController::class, 'data_per_puskesmas'])->name('dashboard.data_per_puskesmas');
    Route::get('/data_per_usia', [DashboardController::class, 'data_per_usia'])->name('dashboard.data_per_usia');
    Route::get('/data_kesimpulan_hasil', [DashboardController::class, 'data_kesimpulan_hasil'])->name('dashboard.data_kesimpulan_hasil');
});

Route::get('/daftar_puskesmas', [AuthController::class, 'daftar_puskesmas'])->name('daftar_puskesmas');
Route::get('master_provinsi', [MasterController::class, 'provinsi'])->name('master_provinsi.data');
Route::get('master_kota_kab', [MasterController::class, 'kota_kab'])->name('master_kota_kab.data');
Route::get('master_kecamatan', [MasterController::class, 'kecamatan'])->name('master_kecamatan.data');
Route::get('master_kelurahan', [MasterController::class, 'kelurahan'])->name('master_kelurahan.data');


