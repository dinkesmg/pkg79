<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterInstrumenSekolah;
use App\Models\PasienSekolah;
use App\Models\FormPersetujuan;
use App\Models\FormPersetujuanTandaTangan;
use App\Models\RiwayatSekolah;

class CkgSekolahController extends Controller
{
    public function index()
    {
        return view('CKG_sekolah.index');
    }

    public function index_screening()
    {
        return view('CKG_Sekolah.Screening_CKG_Sekolah.index');
    }

    public function get_instrument_sekolah(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|integer|min:1|max:12',
            'jenis_kelamin' => 'required|string|in:L,P',
        ]);

        $kelas = (int) $validated['kelas'];
        $jenis_kelamin = $validated['jenis_kelamin'];

        $data = MasterInstrumenSekolah::whereJsonContains('kelas', $kelas)
            ->whereJsonContains('jenis_kelamin', $jenis_kelamin)
            ->where('jenis', 'mandiri')
            ->get();

        return response()->json([
            'total' => $data->count(),
            'data' => $data,
        ]);
    }

    public function simpan(Request $request)
    {
        $data = $request->all();

    //      $validated = $request->validate([
    //     'nisn' => 'nullable|string|max:20',
    //     'nik' => 'required|string|size:16',
    //     'nama_lengkap' => 'required|string|max:255',
    //     'tempat_lahir' => 'required|string|max:100',
    //     'tanggal_lahir' => 'required|numeric|min:1|max:31',
    //     'bulan_lahir' => 'required|numeric|min:1|max:12',
    //     'tahun_lahir' => 'required|numeric|min:1900|max:' . date('Y'),
    //     // 'golongan_darah' => 'nullable|string|in:A,B,AB,O',
    //     'jenis_kelamin' => 'required|string|in:L,P',
    //     'provinsi' => 'required|string',
    //     'kota' => 'required|string',
    //     'kecamatan' => 'required|string',
    //     'kelurahan' => 'required|string',
    //     'alamat' => 'required|string',

    //     'dom-provinsi' => 'required|string',
    //     'dom-kota' => 'required|string',
    //     'dom-kecamatan' => 'required|string',
    //     'dom-kelurahan' => 'required|string',
    //     'dom-alamat' => 'required|string',

    //     'kelas' => 'required|numeric|min:1|max:12',
    //     'disabilitas_tidak_ada' => 'required|in:true,false',
    //     'nama_ortu_wali' => 'required|string|max:255',
    //     'no_hp' => 'required|string|max:20',

    //     'persetujuan' => 'required|in:Setuju,Tidak',
    //     // 'tanda_tangan' => 'required|string|min:10', // pastikan base64 atau svg string minimal
    //     'puskesmas' => 'required|integer',
    //     'id_sekolah' => 'required|integer',
    // ], [
    //     'nik.required' => 'NIK wajib diisi',
    //     'nama_lengkap.required' => 'Nama lengkap wajib diisi',
    //     'persetujuan.in' => 'Persetujuan harus Setuju atau Tidak',
    //     'tanda_tangan.required' => 'Tanda tangan wajib diisi',
    // ]);


        DB::beginTransaction();
        try {
            // Simpan data pasien_sekolah
            $pasien = new PasienSekolah();
            $pasien->nisn = $data['nisn'] ?? null;
            $pasien->nik = $data['nik'] ?? null;
            $pasien->nama = $data['nama_lengkap'] ?? null;
            $pasien->tempat_lahir = $data['tempat_lahir'] ?? null;
            $pasien->tanggal_lahir = $this->formatTanggal($data);
            $pasien->golongan_darah = $data['golongan_darah'] ?? null;
            $pasien->jenis_kelamin = $data['jenis_kelamin'] ?? null;

            $pasien->provinsi_ktp = $data['provinsi'] ?? null;
            $pasien->kota_kab_ktp = $data['kota'] ?? null;
            $pasien->kecamatan_ktp = $data['kecamatan'] ?? null;
            $pasien->kelurahan_ktp = $data['kelurahan'] ?? null;
            $pasien->alamat_ktp = $data['alamat'] ?? null;

            $pasien->provinsi_dom = $data['dom-provinsi'] ?? null;
            $pasien->kota_kab_dom = $data['dom-kota'] ?? null;
            $pasien->kecamatan_dom = $data['dom-kecamatan'] ?? null;
            $pasien->kelurahan_dom = $data['dom-kelurahan'] ?? null;
            $pasien->alamat_dom = $data['dom-alamat'] ?? null;

            $pasien->kelas = $data['kelas'] ?? null;
            $pasien->jenis_disabilitas = (isset($data['disabilitas_tidak_ada']) && $data['disabilitas_tidak_ada'] === 'true') ? 'Tidak Ada' : 'Ada';
            $pasien->nama_orangtua_wali = $data['nama_ortu_wali'] ?? null;
            $pasien->telp = $data['no_hp'] ?? null;
            $pasien->save();

            // Simpan form_persetujuan
            $persetujuan = new FormPersetujuan();
            $persetujuan->id_pasien_sekolah = $pasien->id;
            $persetujuan->tanggal = now()->toDateString();
            $persetujuan->id_master_puskesmas = $data['puskesmas'] ?? null;
            $persetujuan->id_master_sekolah = $data['id_sekolah'] ?? null; // sesuaikan jika perlu mapping dari nama
            $persetujuan->persetujuan = ($data['persetujuan'] ?? '') === 'Setuju' ? 1 : 0;
            $persetujuan->save();

            
            $ttd = new FormPersetujuanTandaTangan();
            $ttd->id_form_persetujuan = $persetujuan->id;
            $ttd->value = $data['tanda_tangan'] ?? null;
            $ttd->save();

            $jawaban = [];
            $excludeKeys = [
                'alamat', 'alamat_sekolah', 'alamat_sesuai_kk', 'bulan_lahir', 'checkbox-alamat-sesuai',
                'disabilitas_tidak_ada', 'dom-alamat', 'dom-kecamatan', 'dom-kelurahan', 'dom-kota',
                'dom-provinsi', 'golongan_darah', 'jenis_kelamin', 'kecamatan', 'kelas', 'kelurahan', 'kota',
                'nama_lengkap', 'nama_ortu_wali', 'nama_sekolah', 'nik', 'nisn', 'no_hp', 'persetujuan',
                'provinsi', 'puskesmas', 'tahun_lahir', 'tempat_lahir', 'tanggal_lahir', 'tanda_tangan',
                'id_sekolah', 'Intelektual', 'umur'
            ];

            $jawaban = collect($data)
                ->except($excludeKeys)
                ->toArray();

            $riwayat = new RiwayatSekolah();
            $riwayat->id_pasien_sekolah = $pasien->id;
            $riwayat->id_puskesmas = $data['puskesmas'] ?? null;
            
            $flattened = [];

            foreach ($jawaban as $key => $value) {
                // Konversi "YA" menjadi "Ya", "TIDAK" menjadi "Tidak"
                if (strtoupper($value) === 'YA' || strtoupper($value) === 'TIDAK') {
                    $value = ucfirst(strtolower($value));
                }
                $flattened[] = [$key => $value];
            }

            $riwayat->skrining_mandiri = json_encode($flattened, JSON_UNESCAPED_UNICODE);


            $riwayat->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function formatTanggal($data)
    {
        $hari = $data['tanggal_lahir'] ?? '1';
        $bulan = $data['bulan_lahir'] ?? '1';
        $tahun = $data['tahun_lahir'] ?? null;

        if ($tahun) {
            return sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
        }
        return null;
    }

    
}
