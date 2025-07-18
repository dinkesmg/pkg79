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
use App\Models\MasterInstrumen;
use App\Models\MasterInstrumenSekolah;
use App\Models\MasterProvider;
use App\Models\MasterSekolah;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    public function instrumen(Request $request)
    {
        // dd()
        $search = $request->get('search');
        // $id = $request->get('id');

        $data = MasterInstrumen::where('val', 'like', '%' . $search . '%')
            ->get();
        // dd($data);

        if ($data->isNotEmpty()) {
            return response()->json(
                $data->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'val' => $item->val
                    ];
                })
            );
        }
        // $data = $data->get();

        // dd($data);
        // return response()->json($data);
        return response()->json([]);
    }

    public function instrumen_detail(Request $request)
    {
        $id = $request->get('id');
        // $id = $request->get('id');

        $data = MasterInstrumen::find($id);
        // dd($data);

        // if ($data->isNotEmpty()) {
        //     return response()->json(
        //         $data->map(function ($item) {
        //             return [
        //                 'id' => $item->id,
        //                 'val' => $item->val
        //             ];
        //         })
        //     );
        // }
        // $data = $data->get();

        // dd($data);
        return response()->json($data);
        // return response()->json([]);
    }

    public function data_simpus_master_provider1()
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
            } else {
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
                    'page' => $page
                ];

                $response = Http::asForm()->withHeaders([
                    'Authorization' => 'Bearer ' . $token_login,
                    'Accept' => 'application/json'
                ])->timeout(180)->post('http://119.2.50.170/db_lb1/api/data_master_provider1', $requestData);

                if (!$response->successful()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal mengambil data dari API halaman ' . $page,
                        'http_status' => $response->status(),
                        'error_body' => $response->body()
                    ], $response->status());
                }

                $json = $response->json();
                $data = $json['data'] ?? [];

                foreach ($data as $dt) {
                    // dd($dt);
                    $cek = MasterProvider::where('kdprovider', $dt['kdprovider'])->first();

                    if (!$cek) {
                        $cek = new MasterProvider();
                        $cek->kdprovider = $dt['kdprovider'];
                        $cek->nmprovider = $dt['nmprovider'];
                        $cek->save();
                    }
                }

                // $currentPage = $json['current_page'] ?? $page;
                $lastPage = $json['last_page'] ?? $page;
                $page++;

                sleep(2);
            } while ($page <= $lastPage);

            Log::info('Master Provider Berhasil');
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ]);
            // Langsung dump response JSON
        } catch (\Exception $e) {
            Log::info('Master Provider Gagal');
            dd('API Request Error:', $e->getMessage());
        }
    }

    public function instrumen_sekolah(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string',
            'kelas' => 'required|integer',
            'jenis_kelamin' => 'required|string|in:L,P',
        ]);

        $jenis = $validated['jenis'];
        $kelas = (int) $validated['kelas'];
        $jenis_kelamin = $validated['jenis_kelamin'];


        $data = MasterInstrumenSekolah::select('id', 'judul', 'pertanyaan', 'kelas', 'jenis_kelamin', 'objek', 'tipe_input', 'value_tipe_input')
            ->where('jenis', $jenis)
            ->whereJsonContains('kelas', $kelas)
            ->whereJsonContains('jenis_kelamin', $jenis_kelamin)
            ->get();

        return response()->json($data);
    }

    public function cari_sekolah(Request $request)
    {
        $term = $request->get('term');

        $id_puskesmas = $request->get('id_puskesmas');

        // $results = MasterSekolah::with('puskesmas')
        // ->where('nama', 'like', "%{$term}%")
        // ->get(['id', 'nama', 'alamat', 'id_puskesmas']);

        $query = MasterSekolah::with('puskesmas')
            ->where('nama', 'like', "%{$term}%");

        if ($id_puskesmas) {
            $query->where('id_puskesmas', $id_puskesmas);
        }

        $results = $query->get(['id', 'nama', 'alamat', 'id_puskesmas']);

        // Ubah hasil agar menyertakan nama_puskesmas
        $formatted = $results->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'alamat' => $item->alamat,
                'id_puskesmas' => $item->id_puskesmas,
                'nama_puskesmas' => optional($item->puskesmas)->nama, // hindari null error
            ];
        });

        return response()->json($formatted);
    }
}
