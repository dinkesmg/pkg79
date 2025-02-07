<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }

    // public function data(Request $request)
    // {
    //     $role = Auth::user()->role;
    //     $id_user = Auth::user()->id;
        
    //     if($role=="Puskesmas"){
    //         $data = Riwayat::where('id_user', $id_user)->get();
    //     }

    //     return response()->json($data);
    // }

    public function data_grafik_per_periode(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        
        $ar_x = $request->x_grafik;
        $data = [];
        foreach ($ar_x as $ind => $tgl) {
            // dd($ind);
            $q_riwayat = Riwayat::where('tanggal_pemeriksaan', $tgl);
            if ($role == "Admin") {
                // $data[$ind] =  $q_riwayat->get();
                $data[$ind] =  $q_riwayat->count();
            } else if ($role == "Puskesmas") {
                // $data[$ind] = $q_riwayat->where('id_user', $id_user+1)->get();
                $data[$ind] = $q_riwayat->where('id_user', $id_user+1)->count();
            } 
            
        }
        // dd($data);

        return response()->json($data);
    }

    public function data_per_puskesmas(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        // $id_user = Auth::user()->id;
        
        if($role=="Admin"){
            $data = Riwayat::get();
        }

        $puskesmas = Puskesmas::get();

        $data = [];
        foreach($puskesmas as $ind => $pusk){
            $data[$ind]['nama'] = $pusk->nama;
            $data[$ind]['total'] = Riwayat::where('id_user', $pusk->id+1)
                ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->get()
                ->count();
        }
        // dd($data);

        return response()->json($data);
    }

    public function data_per_usia(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        $data = [
            "bbl" => 0,
            "balita_dan_pra_sekolah" => 0,
            "dewasa_18_29_tahun" => 0,
            "dewasa_30_39_tahun" => 0,
            "dewasa_40_59_tahun" => 0,
            "lansia" => 0
        ];

        $queryBbl = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
            ->whereHas('pasien', function ($query) {
                $query->whereRaw("DATEDIFF(tanggal_pemeriksaan, tgl_lahir) BETWEEN 0 AND 28");
            });

        if ($role == "Puskesmas") {
            $queryBbl->where('id_user', $id_user);
        }

        $data['bbl'] = $queryBbl->count();
        // $data['bbl'] = $queryBbl->get();

        $ageGroups = [
            'balita_dan_pra_sekolah' => [1, 6],
            'dewasa_18_29_tahun' => [18, 29],
            'dewasa_30_39_tahun' => [30, 39],
            'dewasa_40_59_tahun' => [40, 59],
            'lansia' => [60, 150]
        ];

        foreach ($ageGroups as $key => [$min, $max]) {
            $query = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->whereHas('pasien', function ($query) use ($min, $max) {
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, tanggal_pemeriksaan) BETWEEN ? AND ?", [$min, $max]);
                });

            if ($role == "Puskesmas") {
                $query->where('id_user', $id_user);
            }

            $data[$key] = $query->count();
            // $data[$key] = $query->get();
        }



        return response()->json($data);
    }

    public function data_kesimpulan_hasil(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        $v_kesimpulan_hasil_pemeriksaan = [
            "Normal dan faktor resiko tidak terdeteksi",
            "Normal dengan faktor resiko",
            "Menunjukkan kondisi pra penyakit",
            "Menunjukkan kondisi penyakit"
        ];

        $data = [];


        foreach($v_kesimpulan_hasil_pemeriksaan as $ind => $v){
            if($ind==0){
                $data[$ind]['status'] = "Proses";
                if($role=="Puskesmas"){
                    $data[$ind]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where(function ($query) {
                        $query->where('kesimpulan_hasil_pemeriksaan', "")
                              ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                    })
                    ->get()
                    ->count();
                }
                else if($role=="Admin"){
                    $data[$ind]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where(function ($query) {
                        $query->where('kesimpulan_hasil_pemeriksaan', "")
                              ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                    })
                    ->get()
                    ->count();
                }
            }
            $data[$ind+1]['status'] = $v;
            if($role=="Puskesmas"){
                $data[$ind+1]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where('kesimpulan_hasil_pemeriksaan', $v)
                    ->get()
                    ->count();
            }
            else if($role=="Admin"){
                $data[$ind+1]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->where('kesimpulan_hasil_pemeriksaan', $v)
                ->get()
                ->count();
            }
            
        }

        return response()->json($data);
    }
    
}