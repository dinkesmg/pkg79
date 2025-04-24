<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pemeriksa;
use App\Models\Pasien;
use App\Models\Riwayat;
use App\Models\Mapping_simpus;
use App\Models\Mapping_kelurahan;
use App\Models\MasterProvider;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('Riwayat.index');
    }

    public function data(Request $request)
    {
        // dd("tes");
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        // dd($role);
        set_time_limit(360);

        $query = Riwayat::with([
            'pasien.bpjs' => function ($q) {
                $q->select('id', 'nik', 'nama', 'kdprovider1', 'nmprovider1');
            },
            'pemeriksa',
            'pasien.ref_provinsi_ktp' => function ($q) {
                $q->select('id', 'kode_provinsi', 'kode_parent', 'nama');
            },
            'pasien.ref_kota_kab_ktp' => function ($q) {
                $q->select('id', 'kode_kota_kab', 'kode_parent', 'nama');
            },
            'pasien.ref_kecamatan_ktp' => function ($q) {
                $q->select('id', 'kode_kecamatan', 'kode_parent', 'nama');
            },
            'pasien.ref_kelurahan_ktp' => function ($q) {
                $q->select('id', 'kode_kelurahan', 'kode_parent', 'nama');
            },
            'pasien.ref_provinsi_dom' => function ($q) {
                $q->select('id', 'kode_provinsi', 'kode_parent', 'nama');
            },
            'pasien.ref_kota_kab_dom' => function ($q) {
                $q->select('id', 'kode_kota_kab', 'kode_parent', 'nama');
            },
            'pasien.ref_kecamatan_dom' => function ($q) {
                $q->select('id', 'kode_kecamatan', 'kode_parent', 'nama');
            },
            'pasien.ref_kelurahan_dom' => function ($q) {
                $q->select('id', 'kode_kelurahan', 'kode_parent', 'nama');
            },
            // 'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom'
        ])
            ->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
            ->orderBy('tanggal_pemeriksaan', 'desc');

        if ($role == "Puskesmas") {
            $query->where('id_user', $id_user);
        } else if ($role == "FaskesLain") {
            $provider = MasterProvider::where('nmprovider', Auth::user()->nama)->first();
            // $query->where('kdProviderPst', )
            $query->whereHas('pasien.bpjs', function ($q) use ($provider) {
                // dd($provider->nmprovider);
                $q->where('nmprovider1', $provider->nmprovider);
            });
        }

        // Eksekusi query
        // $data = $query->get();

        // dd($data);
        // return response()->json($data);

        $perPage = $request->input('length', 10);  // jumlah per halaman
        $page = floor($request->input('start', 0) / $perPage) + 1;  // hi

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        // Return the paginated results in the DataTable format
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),  // You can adjust this if you apply additional filters
            'data' => $data->items(),
        ]);
    }

    public function tambah(Request $request)
    {
        // dd($request->all());
        // dd($request->tanggal_pemeriksaan);
        // if($request->nik;)
        $id_user = Auth::user()->id;
        $cari_pasien = Pasien::where('nik', $request->nik_pasien)->first();
        $id_pasien = '';
        if ($cari_pasien == null) {
            $pasien = new Pasien();
            $pasien->nik = $request->nik_pasien;
            $pasien->nama = $request->nama_pasien;
            $pasien->jenis_kelamin = $request->jenis_kelamin;
            $pasien->tgl_lahir = $request->tgl_lahir;
            $pasien->provinsi_ktp = $request->provinsi_ktp;
            $pasien->kota_kab_ktp = $request->kota_kab_ktp;
            $pasien->kecamatan_ktp = $request->kecamatan_ktp;
            $pasien->kelurahan_ktp = $request->kelurahan_ktp;
            $pasien->alamat_ktp = $request->alamat_ktp;

            $pasien->provinsi_dom = $request->provinsi_dom;
            $pasien->kota_kab_dom = $request->kota_kab_dom;
            $pasien->kecamatan_dom = $request->kecamatan_dom;
            $pasien->kelurahan_dom = $request->kelurahan_dom;
            $pasien->alamat_dom = $request->alamat_dom;

            $pasien->no_hp = $request->no_hp;
            $pasien->save();
            $id_pasien = $pasien->id;
        } else {
            $id_pasien = $cari_pasien->id;
            $cari_pasien->nama = $request->nama_pasien;
            $cari_pasien->jenis_kelamin = $request->jenis_kelamin;
            $cari_pasien->tgl_lahir = $request->tgl_lahir;
            $cari_pasien->provinsi_ktp = $request->provinsi_ktp;
            $cari_pasien->kota_kab_ktp = $request->kota_kab_ktp;
            $cari_pasien->kecamatan_ktp = $request->kecamatan_ktp;
            $cari_pasien->kelurahan_ktp = $request->kelurahan_ktp;
            $cari_pasien->alamat_ktp = $request->alamat_ktp;

            $cari_pasien->provinsi_dom = $request->provinsi_dom;
            $cari_pasien->kota_kab_dom = $request->kota_kab_dom;
            $cari_pasien->kecamatan_dom = $request->kecamatan_dom;
            $cari_pasien->kelurahan_dom = $request->kelurahan_dom;
            $cari_pasien->alamat_dom = $request->alamat_dom;

            $cari_pasien->no_hp = $request->no_hp;
            $cari_pasien->save();
        }

        // dd($cari_pasien);
        $cari_pemeriksa = Pemeriksa::where('nik', $request->nik_pemeriksa)->first();
        $id_pemeriksa = '';
        if ($cari_pemeriksa == null) {
            $pemeriksa = new Pemeriksa();
            $pemeriksa->nik = $request->nik_pemeriksa;
            $pemeriksa->nama = $request->nama_pemeriksa;
            $pemeriksa->save();
            $id_pemeriksa = $pemeriksa->id;
        } else {
            $id_pemeriksa = $cari_pemeriksa->id;
            $cari_pemeriksa->nik = $request->nik_pemeriksa;
            $cari_pemeriksa->nama = $request->nama_pemeriksa;
            $cari_pemeriksa->save();
        }

        $data = new Riwayat();
        $data->id_user = $id_user;
        $data->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
        $data->tempat_periksa = $request->tempat_periksa;
        $data->nama_fktp_pj = $request->nama_fktp_pj;
        $data->id_pemeriksa = $id_pemeriksa;
        $data->id_pasien = $id_pasien;
        $data->hasil_pemeriksaan = $request->ar_hasil_pemeriksaan ? json_encode($request->ar_hasil_pemeriksaan) : null;
        $data->kesimpulan_hasil_pemeriksaan = $request->kesimpulan_hasil_pemeriksaan;
        $data->program_tindak_lanjut = $request->program_tindak_lanjut ? json_encode($request->program_tindak_lanjut) : null;
        $data->save();

        return response()->json(['status' => "Berhasil", 'data' => $data]);
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        // dd($request->tanggal_pemeriksaan);
        // if($request->nik;)
        $id_user = Auth::user()->id;
        $cari_pasien = Pasien::where('nik', $request->nik_pasien)->first();
        $id_pasien = '';
        // if ($cari_pasien == null) {
        //     $pasien = new Pasien();
        //     $pasien->nik = $request->nik_pasien;
        //     $pasien->nama = $request->nama_pasien;
        //     $pasien->jenis_kelamin = $request->jenis_kelamin;
        //     $pasien->tgl_lahir = $request->tgl_lahir;
        //     $pasien->alamat = $request->alamat;
        //     $pasien->no_hp = $request->no_hp;
        //     $pasien->save();
        //     $id_pasien = $pasien->id;
        // } else {
        //     $id_pasien = $cari_pasien->id;
        //     $cari_pasien->nama = $request->nama_pasien;
        //     $cari_pasien->jenis_kelamin = $request->jenis_kelamin;
        //     $cari_pasien->tgl_lahir = $request->tgl_lahir;
        //     $cari_pasien->alamat = $request->alamat;
        //     $cari_pasien->no_hp = $request->no_hp;
        //     $cari_pasien->save();
        // }
        if ($cari_pasien == null) {
            $pasien = new Pasien();
            $pasien->nik = $request->nik_pasien;
            $pasien->nama = $request->nama_pasien;
            $pasien->jenis_kelamin = $request->jenis_kelamin;
            $pasien->tgl_lahir = $request->tgl_lahir;
            $pasien->provinsi_ktp = $request->provinsi_ktp;
            $pasien->kota_kab_ktp = $request->kota_kab_ktp;
            $pasien->kecamatan_ktp = $request->kecamatan_ktp;
            $pasien->kelurahan_ktp = $request->kelurahan_ktp;
            $pasien->alamat_ktp = $request->alamat_ktp;

            $pasien->provinsi_dom = $request->provinsi_dom;
            $pasien->kota_kab_dom = $request->kota_kab_dom;
            $pasien->kecamatan_dom = $request->kecamatan_dom;
            $pasien->kelurahan_dom = $request->kelurahan_dom;
            $pasien->alamat_dom = $request->alamat_dom;

            $pasien->no_hp = $request->no_hp;
            $pasien->save();
            $id_pasien = $pasien->id;
        } else {
            $id_pasien = $cari_pasien->id;
            $cari_pasien->nama = $request->nama_pasien;
            $cari_pasien->jenis_kelamin = $request->jenis_kelamin;
            $cari_pasien->tgl_lahir = $request->tgl_lahir;

            $cari_pasien->provinsi_ktp = $request->provinsi_ktp;
            $cari_pasien->kota_kab_ktp = $request->kota_kab_ktp;
            $cari_pasien->kecamatan_ktp = $request->kecamatan_ktp;
            $cari_pasien->kelurahan_ktp = $request->kelurahan_ktp;
            $cari_pasien->alamat_ktp = $request->alamat_ktp;

            $cari_pasien->provinsi_dom = $request->provinsi_dom;
            $cari_pasien->kota_kab_dom = $request->kota_kab_dom;
            $cari_pasien->kecamatan_dom = $request->kecamatan_dom;
            $cari_pasien->kelurahan_dom = $request->kelurahan_dom;
            $cari_pasien->alamat_dom = $request->alamat_dom;

            $cari_pasien->no_hp = $request->no_hp;
            $cari_pasien->save();
        }

        $cari_pemeriksa = Pemeriksa::where('nik', $request->nik_pemeriksa)->first();
        $id_pemeriksa = '';
        if ($cari_pemeriksa == null) {
            $pemeriksa = new Pemeriksa();
            $pemeriksa->nik = $request->nik_pemeriksa;
            $pemeriksa->nama = $request->nama_pemeriksa;
            $pemeriksa->save();
            $id_pemeriksa = $pemeriksa->id;
        } else {
            $id_pemeriksa = $cari_pemeriksa->id;
            $cari_pemeriksa->nik = $request->nik_pemeriksa;
            $cari_pemeriksa->nama = $request->nama_pemeriksa;
            $cari_pemeriksa->save();
        }

        $data = Riwayat::find($request->id);
        $data->id_user = $id_user;
        $data->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
        $data->tempat_periksa = $request->tempat_periksa;
        $data->nama_fktp_pj = $request->nama_fktp_pj;
        $data->id_pemeriksa = $id_pemeriksa;
        $data->id_pasien = $id_pasien;
        $data->hasil_pemeriksaan = $request->ar_hasil_pemeriksaan ? json_encode($request->ar_hasil_pemeriksaan) : null;
        $data->kesimpulan_hasil_pemeriksaan = $request->kesimpulan_hasil_pemeriksaan;
        $data->program_tindak_lanjut = $request->program_tindak_lanjut ? json_encode($request->program_tindak_lanjut) : null;
        $data->save();

        return response()->json(['status' => "Berhasil", 'data' => $data]);
    }

    public function hapus(Request $request)
    {
        $data = Riwayat::find($request->id);
        $data->delete();

        return response()->json(['status' => "Berhasil", 'data' => $data]);
    }

    // public function data_simpus_ckg(Request $request)
    // public function data_simpus_ckg()
    // {
    //     try {
    //         $data_login = [
    //             'email'   => "teknis.dkksemarang@gmail.com",
    //             'name'   => "simpus",
    //             'password' => "Pandanaran79!",
    //         ];
    //         $response_login = Http::asForm()->withHeaders([
    //             'Accept' => 'application/json'
    //         ])->post('http://119.2.50.170/db_lb1/api/login', $data_login);
    //         $token_login = '';

    //         if ($response_login->successful()) {
    //             // dd($response_login);
    //             $res_login = $response_login->json();
    //             $token_login = $res_login['access_token'];
    //             // dd($auth_login['access_token']);
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal mengambil data dari API',
    //                 'http_status' => $response_login->status(),
    //                 'error_body' => $response_login->body() // Menampilkan detail error dari API
    //             ], $response_login->status());
    //         }

    //         // dd($token_login);

    //         $page = 1;
    //         $lastPage = 1;

    //         // $data = [
    //         //     'tanggal_dari'   => "2025-04-05",
    //         //     'tanggal_sampai' => "2025-04-05",
    //         // ];
    //         // $data = [
    //         //     'tanggal_dari'   => Carbon::now()->subDays(30)->toDateString(), // kemarin
    //         //     'tanggal_sampai' => Carbon::today()->toDateString(),     // hari ini
    //         // ];


    //         do {
    //             $requestData = [
    //                 // 'tanggal_dari' => Carbon::now()->subDays(30)->toDateString(),
    //                 'tanggal_dari' => Carbon::now()->subDays(2)->toDateString(),
    //                 'tanggal_sampai' => Carbon::today()->toDateString(),
    //                 // 'tanggal_sampai' => Carbon::now()->subDays(1)->toDateString(),
    //                 'page' => $page
    //             ];

    //             $response = Http::asForm()->withHeaders([
    //                 'Authorization' => 'Bearer ' . $token_login,
    //                 'Accept' => 'application/json'
    //             ])->timeout(3600)->post('http://119.2.50.170/db_lb1/api/data_pasien_ckg_simpus', $requestData);

    //             // dd($response);
    //             if (!$response->successful()) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Gagal mengambil data dari API halaman ' . $page,
    //                     'http_status' => $response->status(),
    //                     'error_body' => $response->body()
    //                 ], $response->status());
    //             }

    //             $json = $response->json();
    //             $data = $json['data'] ?? [];

    //             // dd($data);
    //             // dd($json);

    //             foreach ($data as $dt) {
    //                 // dd($dt);
    //                 $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
    //                     ->whereHas('pasien', function ($query) use ($dt) {
    //                         $query->where('nik', $dt['nik']);
    //                     })->where('tanggal_pemeriksaan', $dt['tanggal'])->first();
    //                 // $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
    //                 // ->whereHas('pasien', function ($query) use ($dt) {
    //                 // $query->where('nik', "3321050110940006");
    //                 // })->first();
    //                 // dd($cek, $dt);
    //                 if ($cek) {
    //                     // dd($cek, $dt);
    //                     $usia = Carbon::parse($dt['tg_lahir'])->diffInYears(Carbon::parse($dt['tanggal']));

    //                     $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
    //                     $id_pasien = '';
    //                     if ($cari_pasien == null) {
    //                         // dd($cari_pasien, $dt, "null");
    //                         $pasien = new Pasien();
    //                         $pasien->nik = $dt['nik'];
    //                         $pasien->nama = $dt['nama'];
    //                         $pasien->jenis_kelamin = $dt['jkl'];
    //                         $pasien->tgl_lahir = $dt['tg_lahir'];
    //                         $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                         $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                         $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                         $pasien->provinsi_ktp = $prov;
    //                         $pasien->kota_kab_ktp = $kota_kab;
    //                         $pasien->kecamatan_ktp = $kec;
    //                         if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                             $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                             if ($cari_kelurahan != "") {
    //                                 $pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                             }
    //                         } else {
    //                             $pasien->kelurahan_ktp = "";
    //                         }
    //                         // dd($pasien->kelurahan_ktp, $dt['kdesa']);

    //                         // $pasien->kelurahan_ktp = "";
    //                         $pasien->alamat_ktp = $dt['jalan'];
    //                         $pasien->no_hp = $dt['telp'];
    //                         $pasien->save();
    //                         $id_pasien = $pasien->id;
    //                     } else {
    //                         // dd($cari_pasien, $dt, "gk null");
    //                         $id_pasien = $cari_pasien->id;
    //                         $cari_pasien->nik = $dt['nik'];
    //                         $cari_pasien->nama = $dt['nama'];
    //                         $cari_pasien->jenis_kelamin = $dt['jkl'];
    //                         $cari_pasien->tgl_lahir = $dt['tg_lahir'];
    //                         $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                         $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                         $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                         $cari_pasien->provinsi_ktp = $prov;
    //                         $cari_pasien->kota_kab_ktp = $kota_kab;
    //                         $cari_pasien->kecamatan_ktp = $kec;
    //                         if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                             $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                             if ($cari_kelurahan != "") {
    //                                 $cari_pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                             }
    //                         } else {
    //                             $cari_pasien->kelurahan_ktp = "";
    //                         }
    //                         // dd($cari_pasien->kelurahan_ktp, $dt['kdesa']);

    //                         // $cari_pasien->kelurahan_ktp = "";
    //                         $cari_pasien->alamat_ktp = $dt['jalan'];
    //                         $cari_pasien->no_hp = $dt['telp'];
    //                         $cari_pasien->save();
    //                     }
    //                     $cek->id_pasien = $id_pasien;

    //                     if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
    //                         $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);
    //                         if (is_array($hasil_pemeriksaan)) {
    //                             $mapping_simpus = Mapping_simpus::get();
    //                             $hp_baru = [];
    //                             $hp_lainnya = [];
    //                             $kesimpulan_hasil_pemeriksaan = null;
    //                             $program_tindak_lanjut = null;

    //                             foreach ($hasil_pemeriksaan as $hp) {
    //                                 if (!is_array($hp)) {
    //                                     continue; // Skip data yang tidak berbentuk array
    //                                 }
    //                                 foreach ($hp as $hp_obj => $hp_val) {
    //                                     // dd($hasil_pemeriksaan, $hp, $hp_obj, $hp_val);
    //                                     $sudah_cek = false; // Flag untuk menandai apakah sudah diproses

    //                                     foreach ($mapping_simpus as $ms) {
    //                                         // if($hp_obj=="status_gizi_bb_pb_atau_bb_tb"){
    //                                         // dd($hasil_pemeriksaan, $hp, $hp_obj, $ms);
    //                                         if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] == "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                 $hp_baru[] = [
    //                                                     $ms['val'] => $hp_val
    //                                                 ];
    //                                             }
    //                                             $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                             break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] == "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                 $hp_baru[] = [
    //                                                     $ms['val'] => $ms['status']
    //                                                 ];
    //                                             }
    //                                             $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                             break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] != "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             // dd($hp_obj);
    //                                             if ($hp_obj == "gigi_karies") {
    //                                                 // dd($hp_obj, $ms, $ms['val'], $hp_val, $usia, $dt, $hp_baru);

    //                                                 if ($usia <= 6 && $ms['kondisi'] == "<=6 tahun") {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $cari_gigi_karies_status = Mapping_simpus::where('val', 'gigi')->where('status_simpus', $hp_val)->where('kondisi', '<=6 tahun')->first();

    //                                                         $hp_baru[] = [
    //                                                             // $ms['val'] => $ms['status']
    //                                                             $ms['val'] => $cari_gigi_karies_status['status']
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($usia > 0 && $ms['kondisi'] == "dewasa") {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $cari_gigi_karies_status = Mapping_simpus::where('val', 'gigi')->where('status_simpus', $hp_val)->where('kondisi', 'dewasa')->first();

    //                                                         $hp_baru[] = [
    //                                                             // $ms['val'] => $ms['status']
    //                                                             $ms['val'] => $cari_gigi_karies_status['status']
    //                                                         ];
    //                                                     }
    //                                                     // dd($hp_obj, $ms, $usia, $dt, $hp_baru);
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                                 // dd($hp_obj, $ms, $usia, $dt, $hp_baru);

    //                                             } else {
    //                                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                     $hp_baru[] = [
    //                                                         $ms['val'] => $ms['status']
    //                                                     ];
    //                                                 }
    //                                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                             }
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] != "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             // dd($hp_obj);
    //                                             if ($hp_obj == "hasil_pemeriksaan_hb") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val >= 11) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Hemoglobin normal (≥11 g/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val < 11) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Hemoglobin di bawah normal (< 11 g/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             }
    //                                             if ($hp_obj == "hasil_apri_score") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val <= 0.5) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "APRI Score ≤ 0.5"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val > 0.5) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "APRI Score >0.5"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             }
    //                                             if ($hp_obj == "hasil_pemeriksaan_rapid_test_hb") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val < 12) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Tidak Normal (Hb <12 gr/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val >= 12) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Normal"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             } else {
    //                                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                     $hp_baru[] = [
    //                                                         $ms['val'] => $ms['status']
    //                                                     ];
    //                                                 }
    //                                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                             }
    //                                         }
    //                                         // }

    //                                     }

    //                                     // Jika data belum pernah dicek dalam mapping_simpus, simpan seluruh objek hp
    //                                     if (!$sudah_cek) {
    //                                         if (!in_array($hp, $hp_baru, true)) {
    //                                             if ($hp_obj == 'kesimpulan_hasil_pemeriksaan') {
    //                                                 // dd($hp_val);
    //                                                 $kesimpulan_hasil_pemeriksaan = $hp_val;
    //                                             } else if ($hp_obj == 'edukasi_yang_diberikan') {
    //                                                 $program_tindak_lanjut[]['edukasi'] = $hp_val;
    //                                             } else if ($hp_obj == 'rujuk_fktrl_dengan_keterangan') {
    //                                                 $program_tindak_lanjut[]['rujuk_fktrl'] = $hp_val;
    //                                             } else {
    //                                                 $hp_lainnya[] = $hp;
    //                                             }
    //                                         }
    //                                     }
    //                                 }
    //                             }

    //                             $hasil_pemeriksaan = json_encode($hp_baru);

    //                             // dd($hasil_pemeriksaan, $dt, $dt['hasil_pemeriksaan']);

    //                             $cek->hasil_pemeriksaan = $hasil_pemeriksaan;
    //                             $cek->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //                             $cek->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //                             $cek->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //                         }
    //                     }
    //                     $cek->save();

    //                     // dd($cek, $dt);

    //                 } else {
    //                     // dd($dt);
    //                     // if($dt['nik']=="3321050110940006"){
    //                     if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
    //                         // dd($dt);
    //                         $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

    //                         if (is_array($hasil_pemeriksaan)) {
    //                             $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
    //                             $id_pasien = '';
    //                             if ($cari_pasien == null) {
    //                                 $pasien = new Pasien();
    //                                 $pasien->nik = $dt['nik'];
    //                                 $pasien->nama = $dt['nama'];
    //                                 $pasien->jenis_kelamin = $dt['jkl'];
    //                                 $pasien->tgl_lahir = $dt['tg_lahir'];
    //                                 $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                                 $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                                 $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                                 $pasien->provinsi_ktp = $prov;
    //                                 $pasien->kota_kab_ktp = $kota_kab;
    //                                 $pasien->kecamatan_ktp = $kec;
    //                                 if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                                     $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                                     if ($cari_kelurahan != "") {
    //                                         $pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                                     }
    //                                 } else {
    //                                     $pasien->kelurahan_ktp = "";
    //                                 }
    //                                 // dd($pasien->kelurahan_ktp, $dt['kdesa']);
    //                                 $pasien->alamat_ktp = $dt['jalan'];
    //                                 $pasien->no_hp = $dt['telp'];
    //                                 $pasien->save();
    //                                 $id_pasien = $pasien->id;
    //                             } else {
    //                                 $id_pasien = $cari_pasien->id;
    //                                 $cari_pasien->nik = $dt['nik'];
    //                                 $cari_pasien->nama = $dt['nama'];
    //                                 $cari_pasien->jenis_kelamin = $dt['jkl'];
    //                                 $cari_pasien->tgl_lahir = $dt['tg_lahir'];
    //                                 $prov = $dt['nik'] ? substr($dt['nik'], 0, 2) : "";
    //                                 $kota_kab  = $dt['nik'] ? substr($dt['nik'], 0, 4) : "";
    //                                 $kec  = $dt['nik'] ? substr($dt['nik'], 0, 6) : "";
    //                                 $cari_pasien->provinsi_ktp = $prov;
    //                                 $cari_pasien->kota_kab_ktp = $kota_kab;
    //                                 $cari_pasien->kecamatan_ktp = $kec;
    //                                 if (!empty($dt['kdesa']) && $dt['kdesa'] != '') {
    //                                     $cari_kelurahan = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
    //                                     if ($cari_kelurahan != "") {
    //                                         $cari_pasien->kelurahan_ktp = $cari_kelurahan->kode_kelurahan_nasional;
    //                                     }
    //                                 } else {
    //                                     $cari_pasien->kelurahan_ktp = "";
    //                                 }
    //                                 // $cari_pasien->kelurahan_ktp = "";
    //                                 $cari_pasien->alamat_ktp = $dt['jalan'];
    //                                 $cari_pasien->no_hp = $dt['telp'];
    //                                 $cari_pasien->save();
    //                             }
    //                             $usia = Carbon::parse($dt['tg_lahir'])->diffInYears(Carbon::parse($dt['tanggal']));

    //                             $id_pemeriksa = null;
    //                             if (isset($dt['nik_dokter'])) {
    //                                 $cari_pemeriksa = Pemeriksa::where('nik', $dt['nik_dokter'])->first();
    //                                 $id_pemeriksa = '';
    //                                 if ($cari_pemeriksa == null) {
    //                                     $pemeriksa = new Pemeriksa();
    //                                     $pemeriksa->nik = $dt['nik_dokter'];
    //                                     $pemeriksa->nama = $dt['nama_dokter'];
    //                                     $pemeriksa->save();
    //                                     $id_pemeriksa = $pemeriksa->id;
    //                                 } else {
    //                                     $id_pemeriksa = $cari_pemeriksa->id;
    //                                     $cari_pemeriksa->nik = $dt['nik_dokter'];
    //                                     $cari_pemeriksa->nama = $dt['nama_dokter'];
    //                                     $cari_pemeriksa->save();
    //                                 }
    //                             }

    //                             $id_puskesmas = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])); //P08 -> 8
    //                             $puskesmas = Puskesmas::find($id_puskesmas);
    //                             $id_user = $id_puskesmas + 1;
    //                             $tempat_periksa = "Puskesmas";
    //                             $nama_fktp_pj = $puskesmas['nama'];

    //                             $mapping_simpus = Mapping_simpus::get();
    //                             $hp_baru = []; // Pastikan array awal kosong untuk menampung hasil unik
    //                             $hp_lainnya = [];
    //                             $kesimpulan_hasil_pemeriksaan = null;
    //                             $program_tindak_lanjut = null;

    //                             foreach ($hasil_pemeriksaan as $hp) {
    //                                 if (!is_array($hp)) {
    //                                     continue; // Skip data yang tidak berbentuk array
    //                                 }
    //                                 foreach ($hp as $hp_obj => $hp_val) {
    //                                     // dd($hasil_pemeriksaan, $hp, $hp_obj, $hp_val);
    //                                     $sudah_cek = false; // Flag untuk menandai apakah sudah diproses

    //                                     foreach ($mapping_simpus as $ms) {
    //                                         // if($hp_obj=="status_gizi_bb_pb_atau_bb_tb"){
    //                                         // dd($hasil_pemeriksaan, $hp, $hp_obj, $ms);
    //                                         if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] == "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                 $hp_baru[] = [
    //                                                     $ms['val'] => $hp_val
    //                                                 ];
    //                                             }
    //                                             $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                             break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] == "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                 $hp_baru[] = [
    //                                                     $ms['val'] => $ms['status']
    //                                                 ];
    //                                             }
    //                                             $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                             break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] != "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             // dd($hp_obj);
    //                                             if ($hp_obj == "gigi_karies") {
    //                                                 // dd($hp_obj);
    //                                                 if ($usia <= 6 && $ms['kondisi'] == "<=6 tahun") {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => $ms['status']
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($usia > 0 && $ms['kondisi'] == "dewasa") {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => $ms['status']
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             } else {
    //                                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                     $hp_baru[] = [
    //                                                         $ms['val'] => $ms['status']
    //                                                     ];
    //                                                 }
    //                                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                             }
    //                                         } else if ($hp_obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] != "") {
    //                                             // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
    //                                             // dd($hp_obj);
    //                                             if ($hp_obj == "hasil_pemeriksaan_hb") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val >= 11) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Hemoglobin normal (≥11 g/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val < 11) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Hemoglobin di bawah normal (< 11 g/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             }
    //                                             if ($hp_obj == "hasil_apri_score") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val <= 0.5) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "APRI Score ≤ 0.5"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val > 0.5) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "APRI Score >0.5"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             }
    //                                             if ($hp_obj == "hasil_pemeriksaan_rapid_test_hb") {
    //                                                 // dd($hp_val);
    //                                                 if ($hp_val < 12) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Tidak Normal (Hb <12 gr/dL)"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 } else if ($hp_val >= 12) {
    //                                                     if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                         $hp_baru[] = [
    //                                                             $ms['val'] => "Normal"
    //                                                         ];
    //                                                     }
    //                                                     $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                     break;
    //                                                 }
    //                                             } else {
    //                                                 if (!array_key_exists($ms['val'], $hp_baru)) {
    //                                                     $hp_baru[] = [
    //                                                         $ms['val'] => $ms['status']
    //                                                     ];
    //                                                 }
    //                                                 $sudah_cek = true; // Tandai bahwa data sudah dicek
    //                                                 break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
    //                                             }
    //                                         }
    //                                         // }

    //                                     }

    //                                     // Jika data belum pernah dicek dalam mapping_simpus, simpan seluruh objek hp
    //                                     if (!$sudah_cek) {
    //                                         if (!in_array($hp, $hp_baru, true)) {
    //                                             if ($hp_obj == 'kesimpulan_hasil_pemeriksaan') {
    //                                                 // dd($hp_val);
    //                                                 $kesimpulan_hasil_pemeriksaan = $hp_val;
    //                                             } else if ($hp_obj == 'edukasi_yang_diberikan') {
    //                                                 $program_tindak_lanjut[]['edukasi'] = $hp_val;
    //                                             } else if ($hp_obj == 'rujuk_fktrl_dengan_keterangan') {
    //                                                 $program_tindak_lanjut[]['rujuk_fktrl'] = $hp_val;
    //                                             } else {
    //                                                 $hp_lainnya[] = $hp;
    //                                             }
    //                                         }
    //                                     }
    //                                 }
    //                             }

    //                             $hasil_pemeriksaan = json_encode($hp_baru);
    //                             // $hasil_pemeriksaa = $hp_baru;
    //                             // dd($hp_baru, $hasil_pemeriksaan);

    //                             $data = new Riwayat();
    //                             $data->id_user = $id_user;
    //                             $data->tanggal_pemeriksaan = $dt['tanggal'];
    //                             $data->tempat_periksa = $tempat_periksa;
    //                             $data->nama_fktp_pj = $nama_fktp_pj;
    //                             $data->id_pemeriksa = $id_pemeriksa;
    //                             $data->id_pasien = $id_pasien;
    //                             $data->hasil_pemeriksaan = $hasil_pemeriksaan;
    //                             $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
    //                             $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
    //                             $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
    //                             $data->save();
    //                         }
    //                     } else {
    //                         $hasil_pemeriksaan = null;
    //                     }
    //                 }
    //             }

    //             $lastPage = $json['last_page'] ?? $page;
    //             $page++;

    //             sleep(10);
    //         } while ($page <= $lastPage);

    //         Log::info('Berhasil tambah riwayat');
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Berhasil',
    //             'http_status' => $response->status(),
    //             'data' => $data
    //         ], $response->status());
    //         // Langsung dump response JSON
    //     } catch (\Exception $e) {
    //         Log::info('Gagal Tambah Riwayat');
    //         dd('API Request Error:', $e->getMessage());
    //     }
    // }

    public function data_simpus_ckg()
    {
        try {
            $tanggal_dari = Carbon::now()->subDays(20)->toDateString();
            $tanggal_sampai = Carbon::now()->toDateString();
            Log::info("[Simpus CKG] Mulai sinkron dari {$tanggal_dari} sampai {$tanggal_sampai}");

            $data_login = [
                'email'    => "teknis.dkksemarang@gmail.com",
                'name'     => "simpus",
                'password' => "Pandanaran79!",
            ];
            Log::info('[Simpus CKG] Login API attempt', $data_login);

            $response_login = Http::asForm()
                ->withHeaders(['Accept' => 'application/json'])
                ->post('http://119.2.50.170/db_lb1/api/login', $data_login);

            if (!$response_login->successful()) {
                Log::error('[Simpus CKG] Login gagal', ['status' => $response_login->status(), 'body' => $response_login->body()]);
                return response()->json([
                    'status'      => 'error',
                    'message'     => 'Gagal login ke API',
                    'http_status' => $response_login->status(),
                    'error_body'  => $response_login->body(),
                ], $response_login->status());
            }

            $token_login = $response_login->json()['access_token'];
            Log::info('[Simpus CKG] Login berhasil');

            $page = 1;
            $lastPage = 1;
            $log_summary = [];

            do {
                Log::info("[Simpus CKG] Ambil data halaman {$page}");
                $requestData = [
                    'tanggal_dari'   => $tanggal_dari,
                    'tanggal_sampai' => $tanggal_sampai,
                    'page'           => $page,
                ];
                $response = Http::asForm()
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $token_login,
                        'Accept'        => 'application/json',
                    ])
                    ->timeout(3600)
                    ->post('http://119.2.50.170/db_lb1/api/data_pasien_ckg_simpus', $requestData);

                if (!$response->successful()) {
                    Log::error('[Simpus CKG] Gagal ambil data', ['page' => $page, 'status' => $response->status(), 'body' => $response->body()]);
                    return response()->json([
                        'status'      => 'error',
                        'message'     => 'Gagal mengambil data dari API halaman ' . $page,
                        'http_status' => $response->status(),
                        'error_body'  => $response->body(),
                    ], $response->status());
                }

                $json = $response->json();
                $data = $json['data'] ?? [];
                Log::info('[Simpus CKG] Data diterima', ['count' => count($data)]);

                foreach ($data as $dt) {
                    $pusk_code = intval(preg_replace('/[^0-9]/', '', $dt['kpusk']));
                    $puskesmas = optional(Puskesmas::find($pusk_code))->nama ?? 'Tidak Diketahui';
                    Log::info('[Simpus CKG] Proses record', ['tanggal' => $dt['tanggal'], 'nik' => $dt['nik'], 'puskesmas' => $puskesmas]);

                    $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
                        ->whereHas('pasien', function ($query) use ($dt) {
                            $query->where('nik', $dt['nik']);
                        })
                        ->where('tanggal_pemeriksaan', $dt['tanggal'])
                        ->first();

                    $usia = Carbon::parse($dt['tg_lahir'])->diffInYears(Carbon::parse($dt['tanggal']));
                    $id_pasien = '';

                    if ($cek) {
                        $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
                        if (!$cari_pasien) {
                            $pasien = new Pasien();
                            $pasien->nik = $dt['nik'];
                            $pasien->nama = $dt['nama'];
                            $pasien->jenis_kelamin = $dt['jkl'];
                            $pasien->tgl_lahir = $dt['tg_lahir'];
                            $prov = substr($dt['nik'], 0, 2) ?: '';
                            $kota_kab = substr($dt['nik'], 0, 4) ?: '';
                            $kec = substr($dt['nik'], 0, 6) ?: '';
                            $pasien->provinsi_ktp = $prov;
                            $pasien->kota_kab_ktp = $kota_kab;
                            $pasien->kecamatan_ktp = $kec;
                            if (!empty($dt['kdesa'])) {
                                $kel = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
                                $pasien->kelurahan_ktp = $kel ? $kel->kode_kelurahan_nasional : '';
                            } else {
                                $pasien->kelurahan_ktp = '';
                            }
                            $pasien->alamat_ktp = $dt['jalan'];
                            $pasien->no_hp = $dt['telp'];
                            $pasien->save();
                            $id_pasien = $pasien->id;
                        } else {
                            $cari_pasien->nik = $dt['nik'];
                            $cari_pasien->nama = $dt['nama'];
                            $cari_pasien->jenis_kelamin = $dt['jkl'];
                            $cari_pasien->tgl_lahir = $dt['tg_lahir'];
                            $prov = substr($dt['nik'], 0, 2) ?: '';
                            $kota_kab = substr($dt['nik'], 0, 4) ?: '';
                            $kec = substr($dt['nik'], 0, 6) ?: '';
                            $cari_pasien->provinsi_ktp = $prov;
                            $cari_pasien->kota_kab_ktp = $kota_kab;
                            $cari_pasien->kecamatan_ktp = $kec;
                            if (!empty($dt['kdesa'])) {
                                $kel = Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first();
                                $cari_pasien->kelurahan_ktp = $kel ? $kel->kode_kelurahan_nasional : '';
                            } else {
                                $cari_pasien->kelurahan_ktp = '';
                            }
                            $cari_pasien->alamat_ktp = $dt['jalan'];
                            $cari_pasien->no_hp = $dt['telp'];
                            $cari_pasien->save();
                            $id_pasien = $cari_pasien->id;
                        }
                        $cek->id_pasien = $id_pasien;

                        if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != 'null') {
                            $hasil = json_decode($dt['hasil_pemeriksaan'], true);
                            if (is_array($hasil)) {
                                $mapping_simpus = Mapping_simpus::get();
                                $hp_baru = [];
                                $hp_lainnya = [];
                                $kesimpulan = null;
                                $program = null;
                                foreach ($hasil as $hp) {
                                    if (!is_array($hp)) continue;
                                    foreach ($hp as $obj => $val) {
                                        $sudah = false;
                                        foreach ($mapping_simpus as $ms) {
                                            // if($hp_obj=="status_gizi_bb_pb_atau_bb_tb"){
                                            // dd($hasil_pemeriksaan, $hp, $hp_obj, $ms);
                                            if ($obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] == "") {
                                                // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
                                                if (!array_key_exists($ms['val'], $hp_baru)) {
                                                    $hp_baru[] = [
                                                        $ms['val'] => $val
                                                    ];
                                                }
                                                $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
                                            } else if ($obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] == "") {
                                                // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
                                                if (!array_key_exists($ms['val'], $hp_baru)) {
                                                    $hp_baru[] = [
                                                        $ms['val'] => $ms['status']
                                                    ];
                                                }
                                                $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
                                            } else if ($obj == $ms['val_simpus'] && $ms['status_simpus'] != "" && $ms['kondisi'] != "") {
                                                // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
                                                // dd($hp_obj);
                                                if ($obj == "gigi_karies") {
                                                    // dd($hp_obj);
                                                    if ($usia <= 6 && $ms['kondisi'] == "<=6 tahun") {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => $ms['status']
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    } else if ($usia > 0 && $ms['kondisi'] == "dewasa") {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => $ms['status']
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    }
                                                } else {
                                                    if (!array_key_exists($ms['val'], $hp_baru)) {
                                                        $hp_baru[] = [
                                                            $ms['val'] => $ms['status']
                                                        ];
                                                    }
                                                    $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                    break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
                                                }
                                            } else if ($obj == $ms['val_simpus'] && $ms['status_simpus'] == "" && $ms['kondisi'] != "") {
                                                // Cek apakah sudah ada dalam array hasil agar tidak push dua kali
                                                // dd($hp_obj);
                                                if ($obj == "hasil_pemeriksaan_hb") {
                                                    // dd($hp_val);
                                                    if ($val >= 11) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "Hemoglobin normal (≥11 g/dL)"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    } else if ($val < 11) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "Hemoglobin di bawah normal (< 11 g/dL)"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    }
                                                }
                                                if ($obj == "hasil_apri_score") {
                                                    // dd($hp_val);
                                                    if ($val <= 0.5) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "APRI Score ≤ 0.5"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    } else if ($val > 0.5) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "APRI Score >0.5"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    }
                                                }
                                                if ($obj == "hasil_pemeriksaan_rapid_test_hb") {
                                                    // dd($hp_val);
                                                    if ($val < 12) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "Tidak Normal (Hb <12 gr/dL)"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    } else if ($val >= 12) {
                                                        if (!array_key_exists($ms['val'], $hp_baru)) {
                                                            $hp_baru[] = [
                                                                $ms['val'] => "Normal"
                                                            ];
                                                        }
                                                        $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                        break;
                                                    }
                                                } else {
                                                    if (!array_key_exists($ms['val'], $hp_baru)) {
                                                        $hp_baru[] = [
                                                            $ms['val'] => $ms['status']
                                                        ];
                                                    }
                                                    $sudah_cek = true; // Tandai bahwa data sudah dicek
                                                    break; // Keluar dari loop mapping_simpus agar tidak terus mengecek
                                                }
                                            }
                                            // }

                                        }
                                        if (!$sudah) {
                                            if ($obj === 'kesimpulan_hasil_pemeriksaan') {
                                                $kesimpulan = $val;
                                            } elseif ($obj === 'edukasi_yang_diberikan') {
                                                $program[]['edukasi'] = $val;
                                            } elseif ($obj === 'rujuk_fktrl_dengan_keterangan') {
                                                $program[]['rujuk_fktrl'] = $val;
                                            } else {
                                                $hp_lainnya[] = $hp;
                                            }
                                        }
                                    }
                                }
                                $cek->hasil_pemeriksaan = json_encode($hp_baru);
                                $cek->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
                                $cek->kesimpulan_hasil_pemeriksaan = $kesimpulan;
                                $cek->program_tindak_lanjut = $program ? json_encode($program) : null;
                            }
                        }
                        $cek->save();
                        Log::info('[Simpus CKG] Riwayat updated', ['id' => $cek->id]);
                    } else {
                        if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != 'null') {
                            $hasil = json_decode($dt['hasil_pemeriksaan'], true);
                            if (is_array($hasil)) {
                                $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
                                if (!$cari_pasien) {
                                    // buat pasien baru
                                    $pasien = new Pasien();
                                    $pasien->nik = $dt['nik'];
                                    $pasien->nama = $dt['nama'];
                                    $pasien->jenis_kelamin = $dt['jkl'];
                                    $pasien->tgl_lahir = $dt['tg_lahir'];
                                    // substring dan mapping kelurahan sama seperti update
                                    $pasien->alamat_ktp = $dt['jalan'];
                                    $pasien->no_hp = $dt['telp'];
                                    $pasien->save();
                                    $id_pasien = $pasien->id;
                                } else {
                                    $id_pasien = $cari_pasien->id;
                                }
                                $id_pemeriksa = null;
                                if (isset($dt['nik_dokter'])) {
                                    $dok = Pemeriksa::where('nik', $dt['nik_dokter'])->first();
                                    if (!$dok) {
                                        $p = new Pemeriksa();
                                        $p->nik = $dt['nik_dokter'];
                                        $p->nama = $dt['nama_dokter'];
                                        $p->save();
                                        $id_pemeriksa = $p->id;
                                    } else {
                                        $dok->nik = $dt['nik_dokter'];
                                        $dok->nama = $dt['nama_dokter'];
                                        $dok->save();
                                        $id_pemeriksa = $dok->id;
                                    }
                                }
                                $id_pusk = intval(preg_replace('/[^0-9]/', '', $dt['kpusk']));
                                $pusk = Puskesmas::find($id_pusk);
                                $id_user = $id_pusk + 1;
                                $tempat = 'Puskesmas';
                                $nama_fktp = $pusk ? $pusk->nama : 'Tidak Diketahui';

                                // mapping hasil pemeriksaan sama seperti di update
                                $mapping = Mapping_simpus::get();
                                $hp_baru = [];
                                $hp_lainnya = [];
                                $kesimpulan = null;
                                $program = null;
                                foreach ($hasil as $hp) {
                                    if (is_array($hp)) {
                                        foreach ($hp as $obj => $val) {
                                            $s = false;
                                            foreach ($mapping as $ms) {
                                                if ($obj === $ms['val_simpus']) {
                                                    if ($ms['status_simpus'] == '' && $ms['kondisi'] == '') {
                                                        if (!isset($hp_baru[$ms['val']])) {
                                                            $hp_baru[$ms['val']] = $val;
                                                        }
                                                        $s = true;
                                                    } elseif ($ms['status_simpus'] != '' && $ms['kondisi'] == '') {
                                                        if (!isset($hp_baru[$ms['val']])) {
                                                            $hp_baru[$ms['val']] = $ms['status'];
                                                        }
                                                        $s = true;
                                                    } else {
                                                        if (!isset($hp_baru[$ms['val']])) {
                                                            $hp_baru[$ms['val']] = $ms['status'];
                                                        }
                                                        $s = true;
                                                    }
                                                    break;
                                                }
                                            }
                                            if (!$s) {
                                                if ($obj === 'kesimpulan_hasil_pemeriksaan') {
                                                    $kesimpulan = $val;
                                                } elseif ($obj === 'edukasi_yang_diberikan') {
                                                    $program[]['edukasi'] = $val;
                                                } elseif ($obj === 'rujuk_fktrl_dengan_keterangan') {
                                                    $program[]['rujuk_fktrl'] = $val;
                                                } else {
                                                    $hp_lainnya[] = $hp;
                                                }
                                            }
                                        }
                                    }
                                }

                                $riwayat = new Riwayat();
                                $riwayat->id_user = $id_user;
                                $riwayat->tanggal_pemeriksaan = $dt['tanggal'];
                                $riwayat->tempat_periksa = $tempat;
                                $riwayat->nama_fktp_pj = $nama_fktp;
                                $riwayat->id_pemeriksa = $id_pemeriksa;
                                $riwayat->id_pasien = $id_pasien;
                                $riwayat->hasil_pemeriksaan = json_encode($hp_baru);
                                $riwayat->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
                                $riwayat->kesimpulan_hasil_pemeriksaan = $kesimpulan;
                                $riwayat->program_tindak_lanjut = $program ? json_encode($program) : null;
                                $riwayat->save();
                                Log::info('[Simpus CKG] Riwayat insert berhasil', ['id' => $riwayat->id]);
                            }
                        }
                    }
                }

                Log::info('[Simpus CKG] Halaman selesai', ['page' => $page, 'count' => count($data)]);
                $lastPage = $json['last_page'] ?? $page;
                $page++;
                sleep(10);
            } while ($page <= $lastPage);

            $grouped = collect($log_summary)->groupBy('tanggal');
            foreach ($grouped as $tgl => $items) {
                $byP = collect($items)->groupBy('nama_puskesmas');
                foreach ($byP as $pus => $ent) {
                    Log::info("[Simpus CKG] Ringkasan {$tgl}|{$pus}|" . count($ent));
                }
            }

            Log::info('[Simpus CKG] Selesai seluruh proses');
            return response()->json(['status' => 'success', 'message' => 'Berhasil', 'http_status' => 200, 'data_count' => count($log_summary)], 200);
        } catch (\Exception $e) {
            Log::error('[Simpus CKG] Exception', ['msg' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function cari_nik_pasien(Request $request)
    {
        $data = Pasien::with(
            'ref_provinsi_ktp',
            'ref_kota_kab_ktp',
            'ref_kecamatan_ktp',
            'ref_kelurahan_ktp',
            'ref_provinsi_dom',
            'ref_kota_kab_dom',
            'ref_kecamatan_dom',
            'ref_kelurahan_dom'
        )->where('nik', $request->nik)->first();

        return response()->json($data);
    }

    public function tindak_lanjut_faskes_lain(Request $request)
    {
        $data = Riwayat::find($request->id);
        $data->tindak_lanjut_faskes_lain = $request->tindak_lanjut_faskes_lain;
        $data->save();

        return response()->json(['status' => "Berhasil", 'data' => $data]);
    }
}