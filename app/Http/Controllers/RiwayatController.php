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
use Illuminate\Support\Facades\Validator;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('Riwayat.index');
    }

    public function data()
    {
        // dd("tes");
        $id_user = Auth::user()->id;
        // $data = Riwayat::with(['pasien', 'pemeriksa'])->get();
        $data = Riwayat::with(['pasien', 'pemeriksa'])->where('id_user', $id_user)->get();

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
            $pasien->alamat = $request->alamat;
            $pasien->no_hp = $request->no_hp;
            $pasien->save();
            $id_pasien = $pasien->id;
        } else {
            $id_pasien = $cari_pasien->id;
            $cari_pasien->nama = $request->nama_pasien;
            $cari_pasien->jenis_kelamin = $request->jenis_kelamin;
            $cari_pasien->tgl_lahir = $request->tgl_lahir;
            $cari_pasien->alamat = $request->alamat;
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

}