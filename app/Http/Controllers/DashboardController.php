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
            $data[$ind]['total'] = Riwayat::where('id_user', $pusk->id)
                ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->get()
                ->count();
        }
        // dd($data);

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
                $data[$ind]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where(function ($query) {
                        $query->where('kesimpulan_hasil_pemeriksaan', "")
                              ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                    })
                    ->get()
                    ->count();
            }
            $data[$ind+1]['status'] = $v;
            $data[$ind+1]['total'] = Riwayat::where('id_user', $id_user)
                ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->where('kesimpulan_hasil_pemeriksaan', $v)
                ->get()
                ->count();
        }

        return response()->json($data);
    }
    
}