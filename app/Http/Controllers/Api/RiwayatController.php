<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Pasien;
use App\Models\Mapping_simpus;
use App\Models\Mapping_kelurahan;
use App\Models\Pemeriksa;
use App\Models\Puskesmas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProsesTambahRiwayat;

class RiwayatController extends Controller
{
    // public function tambah(Request $req)
    // {
    //     set_time_limit(300);

    //     $dt = $req->all();

    //     $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
    //         ->whereHas('pasien', function ($query) use ($dt) {
    //             $query->where('nik', $dt['nik']);
    //         })->where('tanggal_pemeriksaan', $dt['tanggal'])->first();
    //     if ($cek) {
    //         // dd($cek, $dt);
    //         $usia = Carbon::parse($dt['tg_lahir'])->diffInYears(Carbon::parse($dt['tanggal']));

    //         $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
    //         $id_pasien = '';
    //         if ($cari_pasien == null) {
    //             // dd($cari_pasien, $dt, "null");
    //             $pasien = new Pasien();
    //             $pasien->nik = $dt['nik'];
    //             $pasien->nama = $dt['nama'];
    //             $pasien->jenis_kelamin = $dt['jkl'];
    //             $pasien->tgl_lahir = $dt['tg_lahir'];
    //             $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //             $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //             $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //             $pasien->provinsi_ktp = $prov;
    //             $pasien->kota_kab_ktp = $kota_kab;
    //             $pasien->kecamatan_ktp = $kec;
    //             if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                 $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                 if ($cari_kelurahan != "") {
    //                     $pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                 }
    //             } else {
    //                 $pasien->kelurahan_ktp = "";
    //             }
    //             // dd($pasien->kelurahan_ktp, $dt['kdesa']);

    //             // $pasien->kelurahan_ktp = "";
    //             $pasien->alamat_ktp = $dt['jalan'];
    //             $pasien->no_hp = $dt['telp'];
    //             $pasien->save();
    //             $id_pasien = $pasien->id;
    //         } else {
    //             // dd($cari_pasien, $dt, "gk null");
    //             $id_pasien = $cari_pasien->id;
    //             $cari_pasien->nik = $dt['nik'];
    //             $cari_pasien->nama = $dt['nama'];
    //             $cari_pasien->jenis_kelamin = $dt['jkl'];
    //             $cari_pasien->tgl_lahir = $dt['tg_lahir'];
    //             $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //             $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //             $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //             $cari_pasien->provinsi_ktp = $prov;
    //             $cari_pasien->kota_kab_ktp = $kota_kab;
    //             $cari_pasien->kecamatan_ktp = $kec;
    //             if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                 $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                 if ($cari_kelurahan != "") {
    //                     $cari_pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                 }
    //             } else {
    //                 $cari_pasien->kelurahan_ktp = "";
    //             }
    //             // dd($cari_pasien->kelurahan_ktp, $dt['kdesa']);

    //             // $cari_pasien->kelurahan_ktp = "";
    //             $cari_pasien->alamat_ktp = $dt['jalan'];
    //             $cari_pasien->no_hp = $dt['telp'];
    //             $cari_pasien->save();
    //         }
    //         $cek->id_pasien = $id_pasien;

    //         if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
    //             $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);
    //             if (is_array($hasil_pemeriksaan)) {
    //                 $mapping_simpus = Mapping_simpus::get();
    //                 $hp_baru = [];
    //                 $hp_lainnya = [];
    //                 $kesimpulan_hasil_pemeriksaan = null;
    //                 $program_tindak_lanjut = null;

    //                 foreach ($hasil_pemeriksaan as $hp) {
    //                     if (!is_array($hp)) {
    //                         continue; // Skip data yang tidak berbentuk array
    //                     }
    //                     foreach ($hp as $hp_obj => $hp_val) {
    //                         // dd($hasil_pemeriksaan, $hp, $hp_obj, $hp_val);
    //                         $sudah_cek = false; // Flag untuk menandai apakah sudah diproses

    //                         foreach ($mapping_simpus as $ms) {
    //                             // if($hp_obj=="status_gizi_bb_pb_atau_bb_tb"){
    //                             // dd($hasil_pemeriksaan, $hp, $hp_obj, $ms);
    //                             if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] == "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                     $hp_baru[] = [
    //                                         $ms['val'] => $hp_val
    //                                     ];
    //                                 }
    //                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] == "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                     $hp_baru[] = [
    //                                         $ms['val'] => $ms['status']
    //                                     ];
    //                                 }
    //                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] != "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 // dd($hp_obj);
    //                                 if ($hp_obj == "gigi_karies") {
    //                                     // dd($hp_obj, $ms, $ms['val'], $hp_val, $usia, $dt, $hp_baru);

    //                                     if ($usia <= 6 && $ms['kondisi'] == "<=6 tahun") {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $cari_gigi_karies_status = Mapping_simpus::where('val', 'gigi')->where('status_simpus', $hp_val)->where('kondisi', '<=6 tahun')->first();

    //                                             $hp_baru[] = [
    //                                                 // $ms['val'] => $ms['status']
    //                                                 $ms['val'] => $cari_gigi_karies_status['status']
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($usia > 0 && $ms['kondisi'] == "dewasa") {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $cari_gigi_karies_status = Mapping_simpus::where('val', 'gigi')->where('status_simpus', $hp_val)->where('kondisi', 'dewasa')->first();

    //                                             $hp_baru[] = [
    //                                                 // $ms['val'] => $ms['status']
    //                                                 $ms['val'] => $cari_gigi_karies_status['status']
    //                                             ];
    //                                         }
    //                                         // dd($hp_obj, $ms, $usia, $dt, $hp_baru); 
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                     // dd($hp_obj, $ms, $usia, $dt, $hp_baru);

    //                                 } else {
    //                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                         $hp_baru[] = [
    //                                             $ms['val'] => $ms['status']
    //                                         ];
    //                                     }
    //                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                     break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                 }
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] != "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 // dd($hp_obj);
    //                                 if ($hp_obj == "hasil_pemeriksaan_hb") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val >= 11) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Hemoglobin normal (≥11 g/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val < 11) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Hemoglobin di bawah normal (< 11 g/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 }
    //                                 if ($hp_obj == "hasil_apri_score") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val <= 0.5) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "APRI Score ≤ 0.5"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val > 0.5) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "APRI Score >0.5"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 }
    //                                 if ($hp_obj == "hasil_pemeriksaan_rapid_test_hb") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val < 12) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Tidak Normal (Hb <12 gr/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val >= 12) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Normal"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 } else {
    //                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                         $hp_baru[] = [
    //                                             $ms['val'] => $ms['status']
    //                                         ];
    //                                     }
    //                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                     break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                 }
    //                             }
    //                             // }

    //                         }

    //                         // Jika data belum pernah dicek dalam mapping_simpus, simpan seluruh objek hp
    //                         if (!$sudah_cek) {
    //                             if (!in_array($hp, $hp_baru, true)) {
    //                                 if ($hp_obj == 'kesimpulan_hasil_pemeriksaan') {
    //                                     // dd($hp_val);
    //                                     $kesimpulan_hasil_pemeriksaan = $hp_val;
    //                                 } else if ($hp_obj == 'edukasi_yang_diberikan') {
    //                                     $program_tindak_lanjut[]['edukasi'] = $hp_val;
    //                                 } else if ($hp_obj == 'rujuk_fktrl_dengan_keterangan') {
    //                                     $program_tindak_lanjut[]['rujuk_fktrl'] = $hp_val;
    //                                 } else {
    //                                     $hp_lainnya[] = $hp;
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }

    //                 $hasil_pemeriksaan = json_encode($hp_baru);

    //                 // dd($hasil_pemeriksaan, $dt, $dt['hasil_pemeriksaan']);

    //                 $cek->hasil_pemeriksaan = $hasil_pemeriksaan;
    //                 $cek->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //                 $cek->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //                 $cek->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //             }
    //         }
    //         $cek->save();

    //         // dd($cek, $dt);

    //     } else {
    //         // dd($dt);
    //         // if($dt['nik']=="3321050110940006"){
    //         if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
    //             // dd($dt);
    //             $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

    //             if (is_array($hasil_pemeriksaan)) {
    //                 $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
    //                 $id_pasien = '';
    //                 if ($cari_pasien == null) {
    //                     $pasien = new Pasien();
    //                     $pasien->nik = $dt['nik'];
    //                     $pasien->nama = $dt['nama'];
    //                     $pasien->jenis_kelamin = $dt['jkl'];
    //                     $pasien->tgl_lahir = $dt['tg_lahir'];
    //                     $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                     $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                     $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                     $pasien->provinsi_ktp = $prov;
    //                     $pasien->kota_kab_ktp = $kota_kab;
    //                     $pasien->kecamatan_ktp = $kec;
    //                     if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                         $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                         if ($cari_kelurahan != "") {
    //                             $pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                         }
    //                     } else {
    //                         $pasien->kelurahan_ktp = "";
    //                     }
    //                     // dd($pasien->kelurahan_ktp, $dt['kdesa']);
    //                     $pasien->alamat_ktp = $dt['jalan'];
    //                     $pasien->no_hp = $dt['telp'];
    //                     $pasien->save();
    //                     $id_pasien = $pasien->id;
    //                 } else {
    //                     $id_pasien = $cari_pasien->id;
    //                     $cari_pasien->nik = $dt['nik'];
    //                     $cari_pasien->nama = $dt['nama'];
    //                     $cari_pasien->jenis_kelamin = $dt['jkl'];
    //                     $cari_pasien->tgl_lahir = $dt['tg_lahir'];
    //                     $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                     $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                     $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                     $cari_pasien->provinsi_ktp = $prov;
    //                     $cari_pasien->kota_kab_ktp = $kota_kab;
    //                     $cari_pasien->kecamatan_ktp = $kec;
    //                     if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                         $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                         if ($cari_kelurahan != "") {
    //                             $cari_pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                         }
    //                     } else {
    //                         $cari_pasien->kelurahan_ktp = "";
    //                     }
    //                     // $cari_pasien->kelurahan_ktp = "";
    //                     $cari_pasien->alamat_ktp = $dt['jalan'];
    //                     $cari_pasien->no_hp = $dt['telp'];
    //                     $cari_pasien->save();
    //                 }
    //                 $usia = Carbon::parse($dt['tg_lahir'])->diffInYears(Carbon::parse($dt['tanggal']));

    //                 $id_pemeriksa = null;
    //                 if (isset($dt['nik_dokter'])) {
    //                     $cari_pemeriksa = Pemeriksa::where('nik', $dt['nik_dokter'])->first();
    //                     $id_pemeriksa = '';
    //                     if ($cari_pemeriksa == null) {
    //                         $pemeriksa = new Pemeriksa();
    //                         $pemeriksa->nik = $dt['nik_dokter'];
    //                         $pemeriksa->nama = $dt['nama_dokter'];
    //                         $pemeriksa->save();
    //                         $id_pemeriksa = $pemeriksa->id;
    //                     } else {
    //                         $id_pemeriksa = $cari_pemeriksa->id;
    //                         $cari_pemeriksa->nik = $dt['nik_dokter'];
    //                         $cari_pemeriksa->nama = $dt['nama_dokter'];
    //                         $cari_pemeriksa->save();
    //                     }
    //                 }

    //                 $id_puskesmas = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])); //P08 -> 8
    //                 $puskesmas = Puskesmas::find($id_puskesmas);
    //                 $id_user = $id_puskesmas + 1;
    //                 $tempat_periksa = "Puskesmas";
    //                 $nama_fktp_pj = $puskesmas['nama'];

    //                 $mapping_simpus = Mapping_simpus::get();
    //                 $hp_baru = []; // Pastikan array awal kosong untuk menampung hasil unik
    //                 $hp_lainnya = [];
    //                 $kesimpulan_hasil_pemeriksaan = null;
    //                 $program_tindak_lanjut = null;

    //                 foreach ($hasil_pemeriksaan as $hp) {
    //                     if (!is_array($hp)) {
    //                         continue; // Skip data yang tidak berbentuk array
    //                     }
    //                     foreach ($hp as $hp_obj => $hp_val) {
    //                         // dd($hasil_pemeriksaan, $hp, $hp_obj, $hp_val);
    //                         $sudah_cek = false; // Flag untuk menandai apakah sudah diproses

    //                         foreach ($mapping_simpus as $ms) {
    //                             // if($hp_obj=="status_gizi_bb_pb_atau_bb_tb"){
    //                             // dd($hasil_pemeriksaan, $hp, $hp_obj, $ms);
    //                             if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] == "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                     $hp_baru[] = [
    //                                         $ms['val'] => $hp_val
    //                                     ];
    //                                 }
    //                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] == "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                     $hp_baru[] = [
    //                                         $ms['val'] => $ms['status']
    //                                     ];
    //                                 }
    //                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] != "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 // dd($hp_obj);
    //                                 if ($hp_obj == "gigi_karies") {
    //                                     // dd($hp_obj);
    //                                     if ($usia <= 6 && $ms['kondisi'] == "<=6 tahun") {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => $ms['status']
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($usia > 0 && $ms['kondisi'] == "dewasa") {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => $ms['status']
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 } else {
    //                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                         $hp_baru[] = [
    //                                             $ms['val'] => $ms['status']
    //                                         ];
    //                                     }
    //                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                     break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                 }
    //                             } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] != "") {
    //                                 // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                 // dd($hp_obj);
    //                                 if ($hp_obj == "hasil_pemeriksaan_hb") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val >= 11) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Hemoglobin normal (≥11 g/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val < 11) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Hemoglobin di bawah normal (< 11 g/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 }
    //                                 if ($hp_obj == "hasil_apri_score") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val <= 0.5) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "APRI Score ≤ 0.5"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val > 0.5) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "APRI Score >0.5"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 }
    //                                 if ($hp_obj == "hasil_pemeriksaan_rapid_test_hb") {
    //                                     // dd($hp_val);
    //                                     if ($hp_val < 12) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Tidak Normal (Hb <12 gr/dL)"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     } else if ($hp_val >= 12) {
    //                                         if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                             $hp_baru[] = [
    //                                                 $ms['val'] => "Normal"
    //                                             ];
    //                                         }
    //                                         $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                         break;
    //                                     }
    //                                 } else {
    //                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                         $hp_baru[] = [
    //                                             $ms['val'] => $ms['status']
    //                                         ];
    //                                     }
    //                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                     break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                 }
    //                             }
    //                             // }

    //                         }

    //                         // Jika data belum pernah dicek dalam mapping_simpus, simpan seluruh objek hp
    //                         if (!$sudah_cek) {
    //                             if (!in_array($hp, $hp_baru, true)) {
    //                                 if ($hp_obj == 'kesimpulan_hasil_pemeriksaan') {
    //                                     // dd($hp_val);
    //                                     $kesimpulan_hasil_pemeriksaan = $hp_val;
    //                                 } else if ($hp_obj == 'edukasi_yang_diberikan') {
    //                                     $program_tindak_lanjut[]['edukasi'] = $hp_val;
    //                                 } else if ($hp_obj == 'rujuk_fktrl_dengan_keterangan') {
    //                                     $program_tindak_lanjut[]['rujuk_fktrl'] = $hp_val;
    //                                 } else {
    //                                     $hp_lainnya[] = $hp;
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }

    //                 $hasil_pemeriksaan = json_encode($hp_baru);
    //                 // $hasil_pemeriksaa = $hp_baru;
    //                 // dd($hp_baru, $hasil_pemeriksaan);

    //                 $data = new Riwayat();
    //                 $data->id_user = $id_user;
    //                 $data->tanggal_pemeriksaan = $dt['tanggal'];
    //                 $data->tempat_periksa = $tempat_periksa;
    //                 $data->nama_fktp_pj = $nama_fktp_pj;
    //                 $data->id_pemeriksa = $id_pemeriksa;
    //                 $data->id_pasien = $id_pasien;
    //                 $data->hasil_pemeriksaan = $hasil_pemeriksaan;
    //                 $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //                 $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //                 $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //                 $data->save();
    //             }

    //             // dd($data);


    //             // dd($dt, $hasil_pemeriksaa, $hasil_pemeriksaan, $id_puskesmas, $puskesmas, $id_user, $hp_lainnya, $kesimpulan_hasil_pemeriksaan, $program_tindak_lanjut);    
    //         } else {
    //             $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
    //             $id_pasien = '';
    //             if ($cari_pasien == null) {
    //                 $pasien = new Pasien();
    //                 $pasien->nik = $dt['nik'];
    //                 $pasien->nama = $dt['nama'];
    //                 $pasien->jenis_kelamin = $dt['jkl'];
    //                 $pasien->tgl_lahir = $dt['tg_lahir'];
    //                 // $nik = $dt['nik'] ?? '';
    //                 // if (strpos($nik, 'non-') == 0) {
    //                 $prov = "";
    //                 $kota_kab  = "";
    //                 $kec  = "";
    //                 // } else {
    //                 //     $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                 //     $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                 //     $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                 // }
    //                 $pasien->provinsi_ktp = $prov;
    //                 $pasien->kota_kab_ktp = $kota_kab;
    //                 $pasien->kecamatan_ktp = $kec;
    //                 // if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                 //     $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                 //     if ($cari_kelurahan != "") {
    //                 //         $pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                 //     } else {
    //                 //         $pasien->kelurahan_ktp = "";
    //                 //     }
    //                 // } else {
    //                 $pasien->kelurahan_ktp = "";
    //                 // }
    //                 // dd($pasien->kelurahan_ktp, $dt['kdesa']);
    //                 $pasien->alamat_ktp = $dt['jalan'];
    //                 $pasien->no_hp = $dt['telp'];
    //                 $pasien->save();
    //                 $id_pasien = $pasien->id;
    //             } else {
    //                 $id_pasien = $cari_pasien->id;
    //                 $cari_pasien->nik = $dt['nik'];
    //                 $cari_pasien->nama = $dt['nama'];
    //                 $cari_pasien->jenis_kelamin = $dt['jkl'];
    //                 $cari_pasien->tgl_lahir = $dt['tg_lahir'];
    //                 $nik = $dt['nik'] ?? '';
    //                 if (strpos($nik, 'non-') === 0) {
    //                     $prov = "";
    //                     $kota_kab  = "";
    //                     $kec  = "";
    //                 } else {
    //                     $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                     $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                     $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                 }
    //                 // $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                 // $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                 // $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                 $cari_pasien->provinsi_ktp = $prov;
    //                 $cari_pasien->kota_kab_ktp = $kota_kab;
    //                 $cari_pasien->kecamatan_ktp = $kec;
    //                 if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                     $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                     if ($cari_kelurahan != "") {
    //                         $cari_pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                     } else {
    //                         $cari_pasien->kelurahan_ktp = "";
    //                     }
    //                 } else {
    //                     $cari_pasien->kelurahan_ktp = "";
    //                 }
    //                 // $cari_pasien->kelurahan_ktp = "";
    //                 $cari_pasien->alamat_ktp = $dt['jalan'];
    //                 $cari_pasien->no_hp = $dt['telp'];
    //                 $cari_pasien->save();
    //             }
    //             $id_pemeriksa = null;

    //             $id_puskesmas = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])); //P08 -> 8
    //             $puskesmas = Puskesmas::find($id_puskesmas);
    //             $id_user = $id_puskesmas + 1;
    //             $tempat_periksa = "Puskesmas";
    //             $nama_fktp_pj = $puskesmas['nama'];
    //             $mapping_simpus = Mapping_simpus::get();
    //             $hp_baru = []; // Pastikan array awal kosong untuk menampung hasil unik
    //             $hp_lainnya = [];
    //             $kesimpulan_hasil_pemeriksaan = null;
    //             $program_tindak_lanjut = null;
    //             $hasil_pemeriksaan = null;

    //             $data = new Riwayat();
    //             $data->id_user = $id_user;
    //             $data->tanggal_pemeriksaan = $dt['tanggal'];
    //             $data->tempat_periksa = $tempat_periksa;
    //             $data->nama_fktp_pj = $nama_fktp_pj;
    //             $data->id_pemeriksa = $id_pemeriksa;
    //             $data->id_pasien = $id_pasien;
    //             $data->hasil_pemeriksaan = $hasil_pemeriksaan;
    //             $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //             $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //             $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //             $data->save();
    //         }
    //         // dd($dt, $hasil_pemeriksaan);
    //         // }
    //         // $dt = isset($dt['hasil_pemeriksaan'])


    //         // dd($dt);
    //     }

    //     // $id_user = $req->id+1;

    //     // $data = Riwayat::with('pasien')->where('id_user', $id_user)->whereHas('pasien', function($query){
    //     //     $query->whereNotNull('nik')->where('nik', '!=', '');
    //     // })->get();

    //     return response()->json($dt);
    // }

    // public function tambah(Request $req)
    // {
    //     try {
    //         $dt = $req->all();

    //         $nik = $dt['nik'];
    //         $tanggal = $dt['tanggal'];
    //         $tgl_lahir = $dt['tg_lahir'];
    //         $usia = Carbon::parse($tgl_lahir)->diffInYears(Carbon::parse($tanggal));

    //         $pasien = Pasien::updateOrCreate(
    //             ['nik' => $nik],
    //             [
    //                 'nama' => $dt['nama'],
    //                 'jenis_kelamin' => $dt['jkl'],
    //                 'tgl_lahir' => $tgl_lahir,
    //                 'provinsi_ktp' => substr($nik, 0, 2),
    //                 'kota_kab_ktp' => substr($nik, 0, 4),
    //                 'kecamatan_ktp' => substr($nik, 0, 6),
    //                 'kelurahan_ktp' => optional(Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first())->kode_kelurahan_nasional ?? '',
    //                 'alamat_ktp' => $dt['jalan'],
    //                 'no_hp' => $dt['telp']
    //             ]
    //         );

    //         $riwayat = Riwayat::with(['pasien', 'pemeriksa', 'user'])
    //             ->whereHas('pasien', fn($q) => $q->where('nik', $nik))
    //             ->where('tanggal_pemeriksaan', $tanggal)
    //             ->first();

    //         $mapping_simpus = Mapping_simpus::all();
    //         $hp_baru = [];
    //         $hp_lainnya = [];
    //         $kesimpulan_hasil_pemeriksaan = null;
    //         $program_tindak_lanjut = null;

    //         if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
    //             $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

    //             foreach ($hasil_pemeriksaan as $hp) {
    //                 if (!is_array($hp)) continue;

    //                 foreach ($hp as $hp_obj => $hp_val) {
    //                     $matched = $mapping_simpus->firstWhere('val_simpus', $hp_obj);
    //                     if (!$matched) {
    //                         if ($hp_obj === 'kesimpulan_hasil_pemeriksaan') $kesimpulan_hasil_pemeriksaan = $hp_val;
    //                         elseif ($hp_obj === 'edukasi_yang_diberikan') $program_tindak_lanjut[] = ['edukasi' => $hp_val];
    //                         elseif ($hp_obj === 'rujuk_fktrl_dengan_keterangan') $program_tindak_lanjut[] = ['rujuk_fktrl' => $hp_val];
    //                         else $hp_lainnya[] = $hp;
    //                         continue;
    //                     }

    //                     $val = $matched->val;
    //                     $status = $matched->status;
    //                     $kondisi = $matched->kondisi;
    //                     $status_simpus = $matched->status_simpus;

    //                     if ($hp_obj == 'gigi_karies' && $status_simpus && $kondisi) {
    //                         $matchedGigi = $mapping_simpus->filter(
    //                             fn($m) =>
    //                             $m->val === 'gigi' &&
    //                                 $m->status_simpus === $hp_val &&
    //                                 $m->kondisi === ($usia <= 6 ? '<=6 tahun' : 'dewasa')
    //                         )->first();
    //                         $status = $matchedGigi->status ?? $status;
    //                     } elseif ($hp_obj === 'hasil_pemeriksaan_hb') {
    //                         $status = $hp_val >= 11 ? 'Hemoglobin normal (≥11 g/dL)' : 'Hemoglobin di bawah normal (< 11 g/dL)';
    //                     } elseif ($hp_obj === 'hasil_apri_score') {
    //                         $status = $hp_val <= 0.5 ? 'APRI Score ≤ 0.5' : 'APRI Score >0.5';
    //                     } elseif ($hp_obj === 'hasil_pemeriksaan_rapid_test_hb') {
    //                         $status = $hp_val < 12 ? 'Tidak Normal (Hb <12 gr/dL)' : 'Normal';
    //                     }

    //                     $hp_baru[$val] = $status;
    //                 }
    //             }
    //         }

    //         $data = $riwayat ?: new Riwayat();
    //         $data->id_user = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])) + 1;
    //         $data->tanggal_pemeriksaan = $tanggal;
    //         $data->tempat_periksa = 'Puskesmas';
    //         $data->nama_fktp_pj = optional(Puskesmas::find($data->id_user - 1))->nama;
    //         $data->id_pasien = $pasien->id;
    //         $data->id_pemeriksa = optional(Pemeriksa::updateOrCreate(
    //             ['nik' => $dt['nik_dokter'] ?? null],
    //             ['nama' => $dt['nama_dokter'] ?? null]
    //         ))->id;
    //         $data->hasil_pemeriksaan = json_encode($hp_baru);
    //         $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //         $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //         $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //         $data->save();

    //         // return response()->json(['status' => 'success']);
    //         Log::info('tambah manual: status=' . ($riwayat ? "update" : "tambah") . ' pusk=' . $dt['kpusk'] . "tanggal=" . $tanggal . " pasien=" . $pasien->nama);
    //         return response()->json($dt);
    //     } catch (\Throwable $e) {
    //         Log::error('Error tambah manual(): ' . $e->getMessage());
    //         // return response()->json(['error' => $e->getMessage()], 500);
    //     }

    //     // try {
    //     //     // Log::info('Job ProsesTambahRiwayat proses');
    //     //     ProsesTambahRiwayat::dispatch($req->all());
    //     //     // Log::info('Job ProsesTambahRiwayat berhasil');
    //     // } catch (\Throwable $e) {
    //     //     Log::error('Error tambah manual(): ' . $e->getMessage());
    //     // }
    // }

    public function tambah(Request $req)
    {
        try {
            $currentHour = now()->hour;

            // Jika dalam jam 08:00 - 12:59, lempar exception agar masuk ke catch
            if ($currentHour >= 8 && $currentHour < 13) {
                Log::error('Error tambah manual masih jam pelayanan');
            
                throw new \Exception('Request ditolak karena dalam jam kerja (07:00 - 14:00)');
            }

            $dt = $req->all();

            $nik = $dt['nik'];
            $tanggal = $dt['tanggal'];
            $tgl_lahir = $dt['tg_lahir'];
            $usia = Carbon::parse($tgl_lahir)->diffInYears(Carbon::parse($tanggal));

            $riwayat = Riwayat::with(['pasien', 'pemeriksa', 'user'])
                ->whereHas('pasien', fn($q) => $q->where('nik', $nik))
                ->where('tanggal_pemeriksaan', $tanggal)
                ->first();

            if (!$riwayat) {
                $pasien = Pasien::updateOrCreate(
                    ['nik' => $nik],
                    [
                        'nama' => $dt['nama'],
                        'jenis_kelamin' => $dt['jkl'],
                        'tgl_lahir' => $tgl_lahir,
                        'provinsi_ktp' => substr($nik, 0, 2),
                        'kota_kab_ktp' => substr($nik, 0, 4),
                        'kecamatan_ktp' => substr($nik, 0, 6),
                        'kelurahan_ktp' => optional(Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first())->kode_kelurahan_nasional ?? '',
                        'alamat_ktp' => $dt['jalan'],
                        'no_hp' => $dt['telp']
                    ]
                );

                // $riwayat = Riwayat::with(['pasien', 'pemeriksa', 'user'])
                //     ->whereHas('pasien', fn($q) => $q->where('nik', $nik))
                //     ->where('tanggal_pemeriksaan', $tanggal)
                //     ->first();

                
                $mapping_simpus = Mapping_simpus::all();
                $hp_baru = [];
                $hp_lainnya = [];
                $kesimpulan_hasil_pemeriksaan = null;
                $program_tindak_lanjut = null;

                if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
                    $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

                    foreach ($hasil_pemeriksaan as $hp) {
                        if (!is_array($hp)) continue;

                        foreach ($hp as $hp_obj => $hp_val) {
                            $matched = $mapping_simpus->firstWhere('val_simpus', $hp_obj);
                            if (!$matched) {
                                if ($hp_obj === 'kesimpulan_hasil_pemeriksaan') $kesimpulan_hasil_pemeriksaan = $hp_val;
                                elseif ($hp_obj === 'edukasi_yang_diberikan') $program_tindak_lanjut[] = ['edukasi' => $hp_val];
                                elseif ($hp_obj === 'rujuk_fktrl_dengan_keterangan') $program_tindak_lanjut[] = ['rujuk_fktrl' => $hp_val];
                                else $hp_lainnya[] = $hp;
                                continue;
                            }

                            $val = $matched->val;
                            $status = $matched->status;
                            $kondisi = $matched->kondisi;
                            $status_simpus = $matched->status_simpus;

                            if ($hp_obj == 'gigi_karies' && $status_simpus && $kondisi) {
                                $matchedGigi = $mapping_simpus->filter(
                                    fn($m) =>
                                    $m->val === 'gigi' &&
                                        $m->status_simpus === $hp_val &&
                                        $m->kondisi === ($usia <= 6 ? '<=6 tahun' : 'dewasa')
                                )->first();
                                $status = $matchedGigi->status ?? $status;
                            } elseif ($hp_obj === 'hasil_pemeriksaan_hb') {
                                $status = $hp_val >= 11 ? 'Hemoglobin normal (≥11 g/dL)' : 'Hemoglobin di bawah normal (< 11 g/dL)';
                            } elseif ($hp_obj === 'hasil_apri_score') {
                                $status = $hp_val <= 0.5 ? 'APRI Score ≤ 0.5' : 'APRI Score >0.5';
                            } elseif ($hp_obj === 'hasil_pemeriksaan_rapid_test_hb') {
                                $status = $hp_val < 12 ? 'Tidak Normal (Hb <12 gr/dL)' : 'Normal';
                            }

                            $hp_baru[$val] = $status;
                        }
                    }
                }

                // if (!$riwayat) {
                    $data = new Riwayat();
                    $data->id_user = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])) + 1;
                    $data->tanggal_pemeriksaan = $tanggal;
                    $data->tempat_periksa = 'Puskesmas';
                    $data->nama_fktp_pj = optional(Puskesmas::find($data->id_user - 1))->nama;
                    $data->id_pasien = $pasien->id;
                    // $data->id_pemeriksa = optional(Pemeriksa::updateOrCreate(
                    //     ['nik' => $dt['nik_dokter'] ?? null],
                    //     ['nama' => $dt['nama_dokter'] ?? null]
                    // ))->id;
                    $data->id_pemeriksa = null;
                    // $data->hasil_pemeriksaan = json_encode($hp_baru);
                    $data->hasil_pemeriksaan = json_encode(count($hp_baru) ? [$hp_baru] : null);
                    $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
                    $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
                    $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
                    $data->save();
            }

            // return response()->json(['status' => 'success']);
            Log::info('tambah manual: status=' . ($riwayat ? "update" : "tambah") . ' pusk=' . $dt['kpusk'] . "tanggal=" . $tanggal . " pasien=" . $dt['nama']);
            // Log::info('tambah manual');
            
            // return response()->json($dt);
            return response()->json();
        } catch (\Throwable $e) {
            Log::error('Error tambah manual(): ' . $e->getMessage());
            return response()->json();
        } 

        // try {
        //     // Log::info('Job ProsesTambahRiwayat proses');
        //     ProsesTambahRiwayat::dispatch($req->all());
        //     // Log::info('Job ProsesTambahRiwayat berhasil');
        // } catch (\Throwable $e) {
        //     Log::error('Error tambah manual(): ' . $e->getMessage());
        // }
    }
}