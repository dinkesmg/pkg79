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

    public function data(Request $request)
    {
        // dd("tes");
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        // dd($role);
        set_time_limit(300);
        $query = Riwayat::with([
            'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
            'pemeriksa'
        ])->whereBetween('tanggal_pemeriksaan', [$periodeDari, $periodeSampai])
          ->orderBy('tanggal_pemeriksaan', 'desc');

        $instrumen = $request->instrumen;
        $sub_instrumen = $request->sub_instrumen;
    
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
            $data = $query->get()->filter(function ($item) use ($instrumen, $sub_instrumen) {
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
                        
                    // dd($pemeriksaan, $instrumen, $sub_instrumen);
                        // if(empty($sub_instrumen) && $pemeriksaan[$instrumen]==$sub_instrumen){
                        //     return true;
                        // }
                        // else{
                        //     return true;
                        // }

                        if (empty($sub_instrumen) && $pemeriksaan[$instrumen]) {
                            return true;
                        }
                        // Jika sub_instrumen tidak kosong dan nilainya cocok
                        if (!empty($sub_instrumen) && $pemeriksaan[$instrumen] == $sub_instrumen) {
                            return true;
                        }
                    }
                }
            
                return false;
            })->values()->toArray();
            
        }
        else{
            $data = $query->get();
        }


        
        // dd($data);
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
            'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
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
            
        }
        else{
            $data = $query->get();
        }


        
        // dd($data);
        return response()->json($data);
    }

    public function export(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        $periodeDari = $request->periode_dari;
        $periodeSampai = $request->periode_sampai;
        $instrumen = $request->instrumen;
        $sub_instrumen = $request->sub_instrumen;
        $jenis = $request->jenis;
        // dd($request->all());

        // return Excel::download(new LaporanExport, 'riwayat.xlsx');
        return Excel::download(new LaporanExport($role, $id_user, $periodeDari, $periodeSampai, $instrumen, $sub_instrumen, $jenis), 'riwayat.xlsx');
    }
}