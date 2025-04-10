<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\PasienBPJS;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PasienBPJSController extends Controller
{
    public function data(Request $request)
    {
        $data = PasienBPJS::get();
        
        return response()->json($data);
    }

    public function data_simpus()
    {
        try {
            $data_login = [
                'email'   => "teknis.dkksemarang@gmail.com",
                'name'   => "simpus",
                'password' => "Pandanaran79!",
            ];
            $response_login = Http::asForm()->withHeaders([
                'Accept' => 'application/json'
            ])->post('http://119.2.50.170/db_lb1/api/login', $data_login);
            $token_login = '';

            if ($response_login->successful()) {
                // dd($response_login);
                $res_login = $response_login->json();
                $token_login = $res_login['access_token'];
                // dd($auth_login['access_token']);
            }
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data dari API',
                    'http_status' => $response_login->status(),
                    'error_body' => $response_login->body() // Menampilkan detail error dari API
                ], $response_login->status());
            }

            $page = 1;
            $lastPage = 1;

            do {
                $requestData = [
                    'tanggal_dari' => Carbon::now()->subDays(30)->toDateString(),
                    'tanggal_sampai' => Carbon::today()->toDateString(),
                    'page' => $page
                ];

                $response = Http::asForm()->withHeaders([
                    'Authorization' => 'Bearer ' . $token_login,
                    'Accept' => 'application/json'
                ])->timeout(180)->post('http://119.2.50.170/db_lb1/api/data_pasien_bpjs_simpus', $requestData);

                if (!$response->successful()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal mengambil data dari API halaman ' . $page,
                        'http_status' => $response->status(),
                        'error_body' => $response->body()
                    ], $response->status());
                }

                $json = $response->json();
                $data_pasien = $json['data'] ?? [];

                foreach ($data_pasien as $dt) {
                    $cek = PasienBPJS::where('kpusk', $dt['kpusk'])->where('nik', $dt['nik'])->first();

                    if (!$cek) {
                        $cek = new PasienBPJS();
                        $cek->kpusk = $dt['kpusk'];
                        $cek->nik = $dt['nik'];
                        $cek->no_reg = $dt['no_reg'];
                        $cek->nama = $dt['nama'];
                        $cek->tglLahir = $dt['tglLahir'];
                        $cek->kdProvider1 = $dt['kdProvider1'];
                        $cek->nmProvider1 = $dt['nmProvider1'];
                        $cek->save();
                    }

                    // $cek->kpusk = $dt['kpusk'];
                    // $cek->nik = $dt['nik'];
                    // $cek->no_reg = $dt['no_reg'];
                    // $cek->nama = $dt['nama'];
                    // $cek->tglLahir = $dt['tglLahir'];
                    // $cek->kdProvider1 = $dt['kdProvider1'];
                    // $cek->nmProvider1 = $dt['nmProvider1'];
                    // $cek->save();
                }

                // $currentPage = $json['current_page'] ?? $page;
                $lastPage = $json['last_page'] ?? $page;
                $page++;

                sleep(2);
            } while ($page <= $lastPage);

            Log::info('Pasien BPJS Berhasil');
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ]);
         // Langsung dump response JSON
        } catch (\Exception $e) {
            dd('API Request Error:', $e->getMessage());
        }
    }

}