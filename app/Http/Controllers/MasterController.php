<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKotaKab;
use App\Models\MasterKelurahan;
use App\Models\MasterKecamatan;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function provinsi(Request $request)
    {
        $search = $request->get('search');
        $data = MasterProvinsi::where('nama', 'like', '%' . $search . '%')->get();
     
        // dd($data);
        // return response()->json($data);
        // if ($data) {
        //     // dd($data);
        //     return response()->json([
        //         ['kode' => $data->kode_provinsi, 'nama' => $data->nama]
        //     ]);
        // }
        if ($data->isNotEmpty()) { // Check if data exists
            return response()->json(
                $data->map(function ($item) {
                    return [
                        'kode' => $item->kode_provinsi,
                        'nama' => $item->nama
                    ];
                })
            );
        }
    
        return response()->json([]);
    }

    public function kota_kab(Request $request)
    {
        // $search = $request->get('search');
        $search = $request->get('search');
        $kode_parent = $request->get('kode_parent');

        $data = MasterKotaKab::where('kode_parent', $kode_parent)
            ->where('nama', 'like', '%' . $search . '%')
            ->get();
     
        // dd($data);
        // return response()->json($data);
        // if ($data) {
        //     return response()->json([
        //         ['id' => $data->kode_kota_kab, 'nama' => $data->nama]
        //     ]);
        // }

        if ($data->isNotEmpty()) { // Check if data exists
            return response()->json(
                $data->map(function ($item) {
                    return [
                        'kode' => $item->kode_kota_kab,
                        'nama' => $item->nama
                    ];
                })
            );
        }
    
        return response()->json([]);
    }

    public function kecamatan(Request $request)
    {
        $search = $request->get('search');
        $kode_parent = $request->get('kode_parent');

        $data = MasterKecamatan::where('kode_parent', $kode_parent)
            ->where('nama', 'like', '%' . $search . '%')
            ->get();
     
        // dd($data);
        // return response()->json($data);
        // if ($data) {
        //     return response()->json([
        //         ['id' => $data->id, 'nama' => $data->nama]
        //     ]);
        // }
        if ($data->isNotEmpty()) { // Check if data exists
            return response()->json(
                $data->map(function ($item) {
                    return [
                        'kode' => $item->kode_kecamatan,
                        'nama' => $item->nama
                    ];
                })
            );
        }
    
        return response()->json([]);
    }

    public function kelurahan(Request $request)
    {
        // $search = $request->get('search');
        // $kode_kecamatan = $request->get('kode_kecamatan');
        // $kode_kelurahan = $request->get('kode_kelurahan');
        
        // $data = MasterKelurahan::where('kode_parent', $kode_kecamatan);
     
        $search = $request->get('search');
        $kode_parent = $request->get('kode_parent');

        $data = MasterKelurahan::where('kode_parent', $kode_parent)
            ->where('nama', 'like', '%' . $search . '%')
            ->get();
     
        // if($search!=""){
        //     $data = $data->where('nama', 'like', '%' . $search . '%');
        // }
        // if($kode_kelurahan!=""){
        //     $data = $data->where('kode_kelurahan', $kode_kelurahan);
        // }
        if ($data->isNotEmpty()) { // Check if data exists
            return response()->json(
                $data->map(function ($item) {
                    return [
                        'kode' => $item->kode_kelurahan,
                        'nama' => $item->nama
                    ];
                })
            );
        }
        // $data = $data->get();
        
        // dd($data);
        // return response()->json($data);
        return response()->json([]);
    }

}