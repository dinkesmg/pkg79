<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function data_simpus_ckg(Request $request)
    {
        $data = [
            // 'tgl_dari'   => $request->input('tgl_dari'),
            // 'tgl_sampai' => $request->input('tgl_sampai'),
        ];

        // Kirim POST request ke API CodeIgniter
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer sem4rpkg79!*',
            'Accept' => 'application/json'
        ])->post('http://192.168.80.249/simpus_dev_pcare/api/dashboard_semarpkg', $data);

        // Ambil response dari API
        if ($response->successful()) {
            $data = $response->json()['data'];
            foreach($data as $dt){
                $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])->where('tanggal_pemeriksaan' , '2025-02-10')->get();
                dd($cek[0]);
            }
            dd($data);
            return response()->json($response->json(), 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data dari API',
                'http_status' => $response->status(),
                'error_body' => $response->body() // Menampilkan detail error dari API
            ], $response->status());
        }
    }



}