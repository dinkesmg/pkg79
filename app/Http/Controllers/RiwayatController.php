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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('Riwayat.index');
    }

    public function data()
    {
        // dd("tes");
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        // dd($role);
        set_time_limit(300);
        // $data = Riwayat::with(['pasien', 'pemeriksa'])->get();
        if($role=="Puskesmas"){
            $data = Riwayat::with([
                'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp' , 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
                'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom' , 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
                'pemeriksa'])->where('id_user', $id_user)->orderBy('tanggal_pemeriksaan', 'desc')->get();
        }
        else if($role=="Admin"){
            $data = Riwayat::with([
                'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp' , 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
                'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom' , 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
                'pemeriksa'])->orderBy('tanggal_pemeriksaan', 'desc')->get();
        }

        
        // dd($data);
        return response()->json($data);
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

    public function data_simpus_ckg(Request $request)
    {
        $data = [
            // 'tgl_dari'   => $request->input('tgl_dari'),
            // 'tgl_sampai' => $request->input('tgl_sampai'),
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer sem4rpkg79!*',
                'Accept' => 'application/json'
            // ])->post('http://119.2.50.170:6714/ngemplak/api/dashboard_semarpkg', $data);
            ])->post('http://119.2.50.170:9092/simpus_dev_pcare/api/dashboard_semarpkg', $data);
        
            if ($response->successful()) {
                // dd($response->json());
                $data = $response->json()['data'];
            
                foreach($data as $dt){
                    // dd($dt);
                    $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
                    ->whereHas('pasien', function ($query) use ($dt) {
                        $query->where('nik', $dt['nik']);
                    })->where('tanggal_pemeriksaan', $dt['tanggal'])->first();
                    // $cek = Riwayat::with(['pasien', 'pemeriksa', 'user'])
                    // ->whereHas('pasien', function ($query) use ($dt) {
                        // $query->where('nik', "3321050110940006");
                    // })->first();
                    
                    if ($cek) {
                        // dd($cek, $dt);
                    } else {
                        // dd($cek, $dt);
                        // $cari_pasien = Pasien::where('nik', $dt['nik'])->first();
                        // dd($cari_pasien, $dt);
                        // $id_pasien = '';
                        // if ($cari_pasien == null) {
                        //     $pasien = new Pasien();
                        //     $pasien->nik = $dt['nik'];
                        //     $pasien->nama = $dt['nama'];
                        //     $pasien->jenis_kelamin = $dt['jkl'];
                        //     $pasien->tgl_lahir = $dt['tg_lahir'];
                        //     $prov = $dt['nik']? substr($nik, 0, 2):"";
                        //     $kota_kab  = $dt['nik']? substr($nik, 0, 4):"";
                        //     $kec  = $dt['nik']? substr($nik, 0, 6):"";
                        //     $pasien->provinsi_ktp = $prov;
                        //     $pasien->kota_kab_ktp = $kota_kab;
                        //     $pasien->kecamatan_ktp = $kec;
                        //     $pasien->kelurahan_ktp = "";
                        //     $pasien->alamat_ktp = $dt['jalan'];
                
                        //     // $pasien->provinsi_dom = $request->provinsi_dom;
                        //     // $pasien->kota_kab_dom = $request->kota_kab_dom;
                        //     // $pasien->kecamatan_dom = $request->kecamatan_dom;
                        //     // $pasien->kelurahan_dom = $request->kelurahan_dom;
                        //     // $pasien->alamat_dom = $request->alamat_dom;
                
                        //     $pasien->no_hp = $dt['telp'];
                        //     // $pasien->save();
                        //     $id_pasien = $pasien->id;
                        // } else {
                        //     $id_pasien = $cari_pasien->id;
                        //     $cari_pasien->nik = $dt['nik'];
                        //     $cari_pasien->nama = $dt['nama'];
                        //     $cari_pasien->jenis_kelamin = $dt['jkl'];
                        //     $cari_pasien->tgl_lahir = $dt['tg_lahir'];
                        //     $prov = $dt['nik']? substr($nik, 0, 2):"";
                        //     $kota_kab  = $dt['nik']? substr($nik, 0, 4):"";
                        //     $kec  = $dt['nik']? substr($nik, 0, 6):"";
                        //     $cari_pasien->provinsi_ktp = $prov;
                        //     $cari_pasien->kota_kab_ktp = $kota_kab;
                        //     $cari_pasien->kecamatan_ktp = $kec;
                        //     $cari_pasien->kelurahan_ktp = "";
                        //     $cari_pasien->alamat_ktp = $dt['jalan'];

                        //     // $cari_pasien->provinsi_dom = $request->provinsi_dom;
                        //     // $cari_pasien->kota_kab_dom = $request->kota_kab_dom;
                        //     // $cari_pasien->kecamatan_dom = $request->kecamatan_dom;
                        //     // $cari_pasien->kelurahan_dom = $request->kelurahan_dom;
                        //     // $cari_pasien->alamat_dom = $request->alamat_dom;
                
                        //     $cari_pasien->no_hp = $dt['telp'];
                        //     // $cari_pasien->save();
                        // }
                        if($dt['nik']=="3321050110940006"){
                            if (!empty($dt['hasil_pemeriksaan'])) {
                                $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

                                $hp_baru = [];
                                $mapping_simpus = Mapping_simpus::get();
                                foreach($hasil_pemeriksaan as $hp){
                                    foreach($hp as $hp_obj => $hp_val){
                                        foreach($mapping_simpus as $ms){
                                            // dd($ms['val']);
                                            if($hp_obj==$ms['val_simpus'] && $ms['status_simpus']==""){
                                                $hp_baru[] = [
                                                    $ms['val'] => $hp_val
                                                ];
                                            }
                                            else if($hp_obj==$ms['val_simpus'] && $ms['status_simpus']!=""){
                                                dd($hasil_pemeriksaan, $hp, $hp_obj, $ms, $hp_baru);
                                            }
                                        }
                                    }
                                    
                                }
                                $hasil_pemeriksaan = $hp_baru;
                                
                            } else {
                                $hasil_pemeriksaan = null;
                            }
                            dd($hasil_pemeriksaan);
                        }
                        // $dt = isset($dt['hasil_pemeriksaan'])
                        
                        
                        // dd($dt);
                    }
                }
            }
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data dari API',
                    'http_status' => $response->status(),
                    'error_body' => $response->body() // Menampilkan detail error dari API
                ], $response->status());
            }
         // Langsung dump response JSON
        } catch (\Exception $e) {
            dd('API Request Error:', $e->getMessage());
        }
    }

}