<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PasienBPJSController;
use App\Http\Controllers\CkgSekolahController;
use App\Http\Controllers\Api\PuskesmasController;
// use App\Http\Controllers\CkgSekolahController;

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
    Route::get('/data_simpus_ckg', [RiwayatController::class, 'data_simpus_ckg'])->name('data_simpus_ckg');
    Route::get('/data_simpus_ckg_h3', [RiwayatController::class, 'data_simpus_ckg_h3'])->name('data_simpus_ckg_h3');

    Route::get('/cari_nik_pasien', [RiwayatController::class, 'cari_nik_pasien'])->name('cari_nik_pasien');
    Route::post('/tindak_lanjut_faskes_lain', [RiwayatController::class, 'tindak_lanjut_faskes_lain'])->name('riwayat.tindak_lanjut_faskes_lain');

    // });
});

Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/fktp_lain', [LaporanController::class, 'index_fktp_lain'])->name('laporan.index_fktp_lain');
    Route::get('/data', [LaporanController::class, 'data'])->name('laporan.data');
    Route::get('/data_fktp_lain', [LaporanController::class, 'data_fktp_lain'])->name('laporan.data_fktp_lain');
    Route::get('/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/wilayah', [LaporanController::class, 'index_wilayah'])->name('laporan.index_wilayah');
    Route::get('/data_wilayah', [LaporanController::class, 'data_wilayah'])->name('laporan.data_wilayah');
    Route::get('/data_total_per_wilayah', [LaporanController::class, 'data_total_per_wilayah'])->name('laporan.data_total_per_wilayah');
    Route::get('/sasaran_bpjs', [LaporanController::class, 'index_sasaran_bpjs'])->name('laporan.index_sasaran_bpjs');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/detail', [DashboardController::class, 'detail_pasien_hasil_pemeriksaan'])->name('dashboard.pasien_hasil_pemeriksaan.index');
    Route::post('/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::post('/data_grafik_per_periode', [DashboardController::class, 'data_grafik_per_periode'])->name('dashboard.data_grafik_per_periode');
    Route::get('/data_per_puskesmas', [DashboardController::class, 'data_per_puskesmas'])->name('dashboard.data_per_puskesmas');
    Route::get('/data_per_usia', [DashboardController::class, 'data_per_usia'])->name('dashboard.data_per_usia');
    Route::get('/data_kesimpulan_hasil', [DashboardController::class, 'data_kesimpulan_hasil'])->name('dashboard.data_kesimpulan_hasil');
    Route::get('/data_per_jenis_pemeriksaan', [DashboardController::class, 'data_per_jenis_pemeriksaan'])->name('dashboard.data_per_jenis_pemeriksaan');
    Route::get('/data_hasil_pemeriksaan', [DashboardController::class, 'data_hasil_pemeriksaan'])->name('dashboard.data_hasil_pemeriksaan');
    Route::get('/data_pasien_hasil_pemeriksaan', [DashboardController::class, 'data_pasien_hasil_pemeriksaan'])->name('dashboard.data_pasien_hasil_pemeriksaan');
    Route::get('/data_pasien_faskes_bpjs', [DashboardController::class, 'data_pasien_faskes_bpjs'])->name('dashboard.data_pasien_faskes_bpjs');
});

Route::prefix('pasien_bpjs')->group(function () {
    Route::get('/data', [PasienBPJSController::class, 'data'])->name('pasien.data');
    Route::get('/get_data_simpus', [PasienBPJSController::class, 'get_data_simpus'])->name('pasien.get_data_simpus');
    Route::get('/filter_data_simpus', [PasienBPJSController::class, 'filter_data_simpus'])->name('pasien.filter_data_simpus');
    Route::get('/convert_data_simpus', [PasienBPJSController::class, 'convert_data_simpus'])->name('pasien.convert_data_simpus');
});

Route::prefix('data_simpus')->group(function () {
    Route::get('/master_provider1', [MasterController::class, 'data_simpus_master_provider1'])->name('data_simpus.provider1');
});

Route::prefix('pkg_sekolah')->group(function () {
    Route::get('/', [CkgSekolahController::class, 'index'])->name('ckg_sekolah.index');
    Route::get('/screening', [CkgSekolahController::class, 'index_screening'])->name('screening_ckg_sekolah.index');
});

Route::get('daftar_provider', [AuthController::class, 'daftar_provider'])->name('daftar_provider');
Route::get('master_provinsi', [MasterController::class, 'provinsi'])->name('master_provinsi.data');
Route::get('master_kota_kab', [MasterController::class, 'kota_kab'])->name('master_kota_kab.data');
Route::get('master_kecamatan', [MasterController::class, 'kecamatan'])->name('master_kecamatan.data');
Route::get('master_kelurahan', [MasterController::class, 'kelurahan'])->name('master_kelurahan.data');
Route::get('master_instrumen', [MasterController::class, 'instrumen'])->name('master_instrumen.data');
Route::get('master_instrumen/detail', [MasterController::class, 'instrumen_detail'])->name('master_instrumen.detail');
Route::get('master_instrumen_sekolah', [MasterController::class, 'instrumen_sekolah'])->name('master_instrumen_sekolah.data');
Route::get('/master_sekolah/cari', [MasterController::class, 'cari_sekolah'])->name('cari_sekolah.data');
Route::get('/master_puskesmas/search', [PuskesmasController::class, 'search']);
Route::get('master_puskesmas', [PuskesmasController::class, 'all'])->name('master_puskesmas.data');

Route::get('/instrumen_sekolah', [CkgSekolahController::class, 'get_instrument_sekolah']);

Route::post('/pkg_sekolah/simpan', [CkgSekolahController::class, 'simpan'])->name('simpan_ckg_skolah.data');
