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
use App\Models\Pasien;
use App\Models\Lb1\PasienBPJS as PasienBPJS_Simpus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PasienBPJSController extends Controller
{
    public function data(Request $request)
    {
        $data = PasienBPJS::get();
        
        return response()->json($data);
    }

    public function get_data_simpus()
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
                    // 'tanggal_dari' => Carbon::now()->subDays(3)->toDateString(),
                    // 'tanggal_sampai' => Carbon::today()->toDateString(),
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
                        
                        $raw = $dt['kdProviderPst'];
                        $firstDecode = json_decode($raw, true);
                        $kdProvider = $firstDecode['kdProvider'] ?? null;
                        $nmProvider = $firstDecode['nmProvider'] ?? null;

                        $cek->kdProvider1 = $kdProvider;
                        $cek->nmProvider1 = $nmProvider;
                        // $cek->kdProvider1 = $dt['kdProvider1'];
                        // $cek->nmProvider1 = $dt['nmProvider1'];
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
                // $lastPage = $json['last_page'] ?? $page;
                // $page++;

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

    public function filter_data_simpus()
    {
        // $semua = PasienBPJS::get();
        // // dd($semua);
        // foreach ($semua as $val) {
        //     // dd($val);
        //     $cek = PasienBPJS::where('kpusk', $val->kpusk)->where('nik', $val->nik)->get();
        //     if($cek->count() > 1) {
        //         $pasien = PasienBPJS::find($val->id);
        //         dd($pasien);
        //     }

            
        // }

        // $data = PasienBPJS::paginate(1000);

        // $data = PasienBPJS::selectRaw('MAX(updated_at) as updated_at, nik, kpusk')
        // ->groupBy('nik', 'kpusk')
        // ->get();
        // foreach ($data as $val) {
        //     $cek = PasienBPJS::where('kpusk', $val->kpusk)
        //         ->where('nik', $val->nik)
        //         ->orderBy('updated_at', 'desc')
        //         ->get();

        //     if ($cek->count() > 1) {
        //         // Ambil yang paling baru
        //         $acuan = $cek->first();

        //         foreach ($cek as $item) {
        //             dd($item);
        //             // Update semuanya agar sama seperti yang terbaru
        //             $item->kdprovider1 = $acuan->kdprovider1;
        //             $item->nmprovider1 = $acuan->nmprovider1;
        //             $item->save();
        //         }
        //     }
        // }

        $duplikatNik = PasienBPJS::select('nik')
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('nik');

        $data = PasienBPJS::whereIn('nik', $duplikatNik)
            ->limit(50)
            ->get();

        // dd($data);
        return response()->json($data);
        
    }

    public function convert_data_simpus()
    {
        // $data_simpus = DB::connection('mysql_two')
        //     ->table('tb_bpjs_pasien_simpus')
        //     ->select('id', 'nik', 'kdProvider1', 'nmProvider1', 'last_update')
        //     // ->where('nik', '1271044803980003')
        //     ->orderBy('last_update', 'desc')
        //     ->get()
        //     ->groupBy('nik')
        //     ->map->first()
        //     ->values();

        // $results = [];

        // foreach ($data_simpus as $dt) {
        //     $data = Pasien::where('nik', $dt->nik)->first();
        //     // dd($data);
        //     if ($data) {
        //         $data->kd_provider = $dt->kdProvider1;
        //         $data->tgl_update_provider = $dt->last_update;
        //         $data->save();
        //         $results[] = $data;
        //     }
        // }

        $results = [];

        DB::connection('mysql_two')
            ->table('tb_bpjs_pasien_simpus')
            ->select('id', 'nik', 'kdProvider1', 'last_update')
            ->orderBy('id') // pastikan ada urutan stabil
            ->chunk(1000, function ($rows) use (&$results) {
                $latestData = $rows
                    ->groupBy('nik')
                    ->map->first()
                    ->values();

                foreach ($latestData as $dt) {
                    $data = Pasien::where('nik', $dt->nik)->first();
                    if ($data) {
                        $data->kd_provider = $dt->kdProvider1;
                        $data->tgl_update_provider = $dt->last_update;
                        $data->save();
                        // Log::info('Convert Pasien BPJS', $data->id);
                        Log::info('Convert Pasien BPJS', ['id' => $data->id]);
                        $results[] = $data->id; // Simpan ID saja untuk menghindari kelebihan memori
                    }
                }
            });

        // Log::info('Convert Pasien BPJS Total', count($results));
        Log::info('Convert Pasien BPJS Total', ['total' => count($results)]);
        // dd(count($results));
        return;
            
        // dd($results);
    }

}