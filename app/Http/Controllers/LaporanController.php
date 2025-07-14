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
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\Puskesmas;
use Carbon\Carbon;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('Laporan.index');
    }

    public function index_fktp_lain()
    {
        return view('Laporan.index_fktp_lain');
    }

    // public function data(Request $request)
    // {
    //     // dd("tes");
    //     $role = Auth::user()->role;
    //     $id_user = Auth::user()->id;
    //     $periodeDari = $request->periode_dari;
    //     $periodeSampai = $request->periode_sampai;
    //     // dd($role);
    //     set_time_limit(300);
    //     $query = Riwayat::with([
    //         'pasien.ref_provinsi_ktp',
    //         'pasien.ref_kota_kab_ktp',
    //         'pasien.ref_kecamatan_ktp',
    //         'pasien.ref_kelurahan_ktp',
    //         'pasien.ref_provinsi_dom',
    //         'pasien.ref_kota_kab_dom',
    //         'pasien.ref_kecamatan_dom',
    //         'pasien.ref_kelurahan_dom',
    //         'pemeriksa'
    //     ])->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
    //         ->orderBy('tanggal_pemeriksaan', 'desc');

    //     $instrumen = $request->instrumen;
    //     $sub_instrumen = $request->sub_instrumen;
    //     if ($request->sub_instrumen == "Pilih") {
    //         $sub_instrumen = null;
    //     }

    //     // Filter berdasarkan role
    //     if ($role == "Puskesmas") {
    //         $query->where('id_user', $id_user);
    //     }

    //     // if($instrumen != ""){
    //     //     // $query->where('hasil_pemeriksaan', $id_user);
    //     //     // $query->whereJsonContains('hasil_pemeriksaan', [$instrumen]);
    //     //     $query->whereRaw("JSON_EXTRACT(hasil_pemeriksaan, '$.\"$instrumen\"') IS NOT NULL");
    //     // }

    //     // Eksekusi query
    //     // $data = $query->get();
    //     if (!empty($instrumen)) {
    //         $data = $query->get()->filter(function ($item) use ($instrumen, $sub_instrumen) {
    //             // Pastikan JSON tidak null atau kosong sebelum di-decode
    //             if (empty($item->hasil_pemeriksaan)) {
    //                 return false;
    //             }

    //             // Decode JSON dengan error handling
    //             $hasil_pemeriksaan = json_decode($item->hasil_pemeriksaan, true);

    //             // Jika JSON tidak valid, return false
    //             if (json_last_error() !== JSON_ERROR_NONE) {
    //                 return false;
    //             }

    //             // Gunakan foreach untuk mencari instrumen dalam JSON array
    //             foreach ($hasil_pemeriksaan as $pemeriksaan) {
    //                 if (is_array($pemeriksaan) && isset($pemeriksaan[$instrumen])) {

    //                     // dd($pemeriksaan, $instrumen, $sub_instrumen);
    //                     // if(empty($sub_instrumen) && $pemeriksaan[$instrumen]==$sub_instrumen){
    //                     //     return true;
    //                     // }
    //                     // else{
    //                     //     return true;
    //                     // }

    //                     if (empty($sub_instrumen) && $pemeriksaan[$instrumen]) {
    //                         return true;
    //                     }
    //                     // Jika sub_instrumen tidak kosong dan nilainya cocok
    //                     if (!empty($sub_instrumen) && $pemeriksaan[$instrumen] == $sub_instrumen) {
    //                         return true;
    //                     }
    //                 }
    //             }

    //             return false;
    //         })->values()->toArray();
    //     } else {
    //         $data = $query->get();
    //     }



    //     // dd($data);
    //     return response()->json($data);
    // }

    public function data(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        $instrumen = $request->instrumen;
        $sub_instrumen = $request->sub_instrumen !== 'Pilih' ? $request->sub_instrumen : null;

        set_time_limit(300);

        $query = Riwayat::with([
            'pasien.ref_provinsi_ktp',
            'pasien.ref_kota_kab_ktp',
            'pasien.ref_kecamatan_ktp',
            'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom',
            'pasien.ref_kota_kab_dom',
            'pasien.ref_kecamatan_dom',
            'pasien.ref_kelurahan_dom',
            'pemeriksa'
        ])
            ->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
            ->orderBy('tanggal_pemeriksaan', 'desc');

        // Filter berdasarkan role
        if ($role === 'Puskesmas') {
            $query->where('id_user', $id_user);
        }

        $data = $query->get();

        // Jika ada filter instrumen
        if (!empty($instrumen)) {
            $data = $data->filter(function ($item) use ($instrumen, $sub_instrumen) {
                if (empty($item->hasil_pemeriksaan)) {
                    return false;
                }

                $hasil_pemeriksaan = json_decode($item->hasil_pemeriksaan, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($hasil_pemeriksaan)) {
                    return false;
                }

                foreach ($hasil_pemeriksaan as $pemeriksaan) {
                    if (is_array($pemeriksaan) && array_key_exists($instrumen, $pemeriksaan)) {
                        if (empty($sub_instrumen)) {
                            return !empty($pemeriksaan[$instrumen]);
                        }

                        return $pemeriksaan[$instrumen] == $sub_instrumen;
                    }
                }

                return false;
            })->values();
        }

        return response()->json($data);
    }

    public function data_fktp_lain(Request $request)
    {
        // dd("tes");
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        // dd($role);
        set_time_limit(300);
        $query = Riwayat::with([
            'pasien.ref_provinsi_ktp',
            'pasien.ref_kota_kab_ktp',
            'pasien.ref_kecamatan_ktp',
            'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom',
            'pasien.ref_kota_kab_dom',
            'pasien.ref_kecamatan_dom',
            'pasien.ref_kelurahan_dom',
            'pemeriksa'
        ])->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
            ->orderBy('tanggal_pemeriksaan', 'desc');

        $instrumen = $request->instrumen;

        // $query->where('tempat_periksa', "Puskesmas");
        $query->where('tempat_periksa', '!=', 'Puskesmas');

        // Filter berdasarkan role
        if ($role == "Puskesmas") {
            $query->where('id_user', $id_user);
        }

        // if($instrumen != ""){
        //     // $query->where('hasil_pemeriksaan', $id_user);
        //     // $query->whereJsonContains('hasil_pemeriksaan', [$instrumen]);
        //     $query->whereRaw("JSON_EXTRACT(hasil_pemeriksaan, '$.\"$instrumen\"') IS NOT NULL");
        // }

        // Eksekusi query
        // $data = $query->get();
        if (!empty($instrumen)) {
            $data = $query->get()->filter(function ($item) use ($instrumen) {
                // Pastikan JSON tidak null atau kosong sebelum di-decode
                if (empty($item->hasil_pemeriksaan)) {
                    return false;
                }

                // Decode JSON dengan error handling
                $hasil_pemeriksaan = json_decode($item->hasil_pemeriksaan, true);

                // Jika JSON tidak valid, return false
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return false;
                }

                // Gunakan foreach untuk mencari instrumen dalam JSON array
                foreach ($hasil_pemeriksaan as $pemeriksaan) {
                    if (is_array($pemeriksaan) && isset($pemeriksaan[$instrumen])) {
                        return true;
                    }
                }

                return false;
            })->values()->toArray();
        } else {
            $data = $query->get();
        }



        // dd($data);
        return response()->json($data);
    }

    // public function export(Request $request)
    // {
    //     $role = Auth::user()->role;
    //     $id_user = Auth::user()->id;
    //     $periodeDari = $request->periode_dari;
    //     $periodeSampai = $request->periode_sampai;
    //     $instrumen = $request->instrumen;
    //     $sub_instrumen = $request->sub_instrumen;
    //     $jenis = $request->jenis;
    //     $kecamatan_ktp = $request->kecamatan_ktp;
    //     $kelurahan_ktp = $request->kelurahan_ktp;
    //     // dd($request->all());

    //     // return Excel::download(new LaporanExport, 'riwayat.xlsx');
    //     return Excel::download(new LaporanExport($role, $id_user, $periodeDari, $periodeSampai, $instrumen, $sub_instrumen, $jenis, $kecamatan_ktp, $kelurahan_ktp), 'riwayat.xlsx');
    // }

    // public function index_wilayah()
    // {
    //     return view('Laporan.index_wilayah');
    // }

    // public function data_wilayah(Request $request)
    // {
    //     $role = Auth::user()->role;
    //     $id_user = Auth::user()->id;
    //     $periodeDari = $request->periode_dari;
    //     $periodeSampai = $request->periode_sampai;

    //     $kecamatan_ktp = $request->kecamatan_ktp;
    //     $kelurahan_ktp = $request->kelurahan_ktp;
    //     // dd($role);
    //     set_time_limit(300);
    //     $query = Riwayat::with([
    //         'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
    //         'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
    //         'pemeriksa'
    //     ])->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
    //         ->whereHas('pasien', function ($q) use ($kecamatan_ktp, $kelurahan_ktp) {
    //             $q->where('kecamatan_ktp', $kecamatan_ktp);
    //             if ($kelurahan_ktp != "") {
    //                 $q->where('kelurahan_ktp', $kelurahan_ktp);
    //             }
    //         })->orderBy('tanggal_pemeriksaan', 'desc');

    //     // Filter berdasarkan role
    //     if ($role == "Puskesmas") {
    //         $query->where('id_user', $id_user);
    //     }

    //     $data = $query->get();



    //     // dd($data);
    //     return response()->json($data);
    // }

    public function export(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        $instrumen = $request->instrumen;
        $sub_instrumen = $request->sub_instrumen;
        $jenis = $request->jenis;
        $kecamatan_ktp = $request->kecamatan_ktp;
        $kelurahan_ktp = $request->kelurahan_ktp;
        // dd($request->all());

        // return Excel::download(new LaporanExport($role, $id_user, $periodeDari, $periodeSampai, $instrumen, $sub_instrumen, $jenis, $kecamatan_ktp, $kelurahan_ktp), 'riwayat.xlsx');
        // $today = Carbon::now()->format('d-m-Y');
        $today = Carbon::now()->format('d-m-Y_H-i');
        $startDate = Carbon::parse($periodeDari)->format('d-m-Y');
        $endDate = Carbon::parse($periodeSampai)->format('d-m-Y');

        // Nama file
        $filename = "riwayat_{$startDate}_sampai_{$endDate}_exported_{$today}.xlsx";

        return Excel::download(
            new LaporanExport($role, $id_user, $periodeDari, $periodeSampai, $instrumen, $sub_instrumen, $jenis, $kecamatan_ktp, $kelurahan_ktp),
            $filename
        );
    }

    public function index_wilayah()
    {
        return view('Laporan.index_wilayah');
    }

    public function data_total_per_wilayah(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;

        $kecamatan_ktp = $request->kecamatan_ktp;
        $kelurahan_ktp = $request->kelurahan_ktp;
        // dd($role);
        // set_time_limit(300);

        $query = Riwayat::select('tanggal_pemeriksaan', 'id_pasien')
            ->with([
                'pasien' => function ($q) {
                    $q->select('id', 'nama', 'kecamatan_ktp', 'kelurahan_ktp');
                },
                'pasien.ref_kecamatan_ktp' => function ($q) {
                    $q->select('kode_kecamatan', 'nama'); // ambil hanya nama
                },
                'pasien.ref_kelurahan_ktp' => function ($q) {
                    $q->select('kode_kelurahan', 'nama'); // ambil hanya nama
                }
            ])
            ->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
            ->whereHas('pasien', function ($q) use ($kecamatan_ktp, $kelurahan_ktp) {
                if ($kecamatan_ktp != "" && $kecamatan_ktp != "0") {
                    $q->where('kecamatan_ktp', $kecamatan_ktp);
                }

                if ($kelurahan_ktp != "" && $kelurahan_ktp != "0") {
                    $q->where('kelurahan_ktp', $kelurahan_ktp);
                }
            })
            ->when($role == "Puskesmas", function ($q) use ($id_user) {
                $q->where('id_user', $id_user);
            })
            ->get();

        $query_kecamatan_list = MasterKecamatan::where('kode_parent', '3374');
        if ($kecamatan_ktp != "" && $kecamatan_ktp != "0") {
            // dd($kecamatan_ktp);
            $query_kecamatan_list = $query_kecamatan_list->where('kode_kecamatan', $kecamatan_ktp);
        }
        $kecamatan_list = $query_kecamatan_list->pluck('nama', 'kode_kecamatan');

        $grouped = $query->groupBy(function ($item) {
            return optional($item->pasien->ref_kelurahan_ktp)->kode_kelurahan;
        });

        // dd($grouped);

        // Susun hasil akhir
        $dt = [];

        foreach ($kecamatan_list as $kode => $nama) {
            // $kelurahanList = MasterKelurahan::where('kode_parent', $kode)->pluck('nama', 'kode_kelurahan');
            $query_kelurahan_list = MasterKelurahan::where('kode_parent', $kode);
            if ($kelurahan_ktp != "" && $kelurahan_ktp != "0") {
                $query_kelurahan_list = $query_kelurahan_list->where('kode_kelurahan', $kelurahan_ktp);
            }
            $kelurahan_list = $query_kelurahan_list->pluck('nama', 'kode_kelurahan');

            foreach ($kelurahan_list as $kode_kel => $nama_kel) {
                $dataKel = $grouped[$kode_kel] ?? collect([]);

                $dt[] = [
                    'kecamatan' => $nama,
                    'kode_kecamatan' => $kode,
                    'kode_kelurahan' => $kode_kel,
                    'kelurahan' => $nama_kel,
                    'data' => $dataKel,
                    'total' =>  $dataKel->count()
                ];
            }
        }

        // dd($dt);
        return response()->json($dt);
    }

    public function data_wilayah(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;

        $kecamatan_ktp = $request->kecamatan_ktp;
        $kelurahan_ktp = $request->kelurahan_ktp;
        // dd($role);
        set_time_limit(300);

        $data = Riwayat::with([
            'pasien.ref_provinsi_ktp',
            'pasien.ref_kota_kab_ktp',
            'pasien.ref_kecamatan_ktp',
            'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom',
            'pasien.ref_kota_kab_dom',
            'pasien.ref_kecamatan_dom',
            'pasien.ref_kelurahan_dom',
            'pemeriksa'
        ])
            ->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
            ->whereHas('pasien', function ($q) use ($kecamatan_ktp, $kelurahan_ktp) {
                if ($kecamatan_ktp != "" && $kecamatan_ktp != "0") {
                    $q->where('kecamatan_ktp', $kecamatan_ktp);
                }

                if ($kelurahan_ktp != "" && $kelurahan_ktp != "0") {
                    $q->where('kelurahan_ktp', $kelurahan_ktp);
                }
            })
            ->when($role == "Puskesmas", function ($q) use ($id_user) {
                $q->where('id_user', $id_user);
            })
            ->get();



        // dd($data);
        return response()->json($data);
    }

    public function index_sasaran_bpjs()
    {
        return view('Laporan.index_sasaran_bpjs');
    }
}
