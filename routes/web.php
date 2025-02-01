<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiwayatController;

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
        Route::get('/data', [RiwayatController::class, 'data'])->name('riwayat.data');
        Route::post('/hapus', [RiwayatController::class, 'hapus'])->name('riwayat.hapus');
        
        // });
});

Route::get('/daftar_puskesmas', [AuthController::class, 'daftar_puskesmas'])->name('daftar_puskesmas');


