<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterInstrumenSekolah;
use App\Models\PasienSekolah;
use App\Models\FormPersetujuan;
use App\Models\FormPersetujuanTandaTangan;
use App\Models\RiwayatSekolah;
use App\Models\Puskesmas;
use App\Models\MasterSekolah;
use App\Models\MasterProvinsi;
use App\Models\MasterKotaKab;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\SimpanSkriningRequest;
use Illuminate\Support\Str;
use Imagick;

class CkgSekolahController extends Controller
{
    public function index()
    {
        return view('CKG_Sekolah.index');
    }

    public function index_screening()
    {
        return view('CKG_Sekolah.Screening_CKG_Sekolah.index');
    }

    public function index_success()
    {
        return view('CKG_Sekolah.Screening_CKG_Sekolah.Success_Page.index');
    }

    public function index_failed()
    {
        return view('CKG_Sekolah.Failed_Page.index');
    }

    public function get_instrument_sekolah(Request $request)
    {
        // dd($request->all());
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

    public function get_peserta_didik(Request $request)
    {
        $data = $this->getDataPesertaDidik($request->nik);
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'NIK tidak ditemukan',
            ], 404);
        }
        return response()->json($data);
    }


    public function get_tanda_tangan(Request $request)
    {
        $id = $request->input('id_form_persetujuan');

        // Validasi input sederhana
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID Form Persetujuan tidak ditemukan.',
            ], 400);
        }

        $tandaTangan = FormPersetujuanTandaTangan::where('id_form_persetujuan', $id)->first();

        if (!$tandaTangan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tanda tangan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'image_base64' => $tandaTangan->value,
        ]);
    }

    // public function get_screening_peserta(Request $request)
    // {
    //     $id_pasien = $request->id_pasien;
    //     $data_screening = RiwayatSekolah::where('id_pasien_sekolah', $id_pasien)->first();

    //     return response()->json($data_screening);
    // }

    public function simpan(SimpanSkriningRequest $request)
    {
        $data = $request->all();

        $kelas = (int) $request->kelas;
        $jenis_kelamin = $request->jenis_kelamin;
        if ($jenis_kelamin === 'Laki-laki') {
            $jenis_kelamin = 'L';
            $data['jenis_kelamin'] = "Laki-laki";
        } elseif ($jenis_kelamin === 'Perempuan') {
            $jenis_kelamin = 'P';
            $data['jenis_kelamin'] = "Perempuan";
        }


        $instrumen_sekolah = MasterInstrumenSekolah::whereJsonContains('kelas', $kelas)
            ->whereJsonContains('jenis_kelamin', $jenis_kelamin)
            ->where('jenis', 'mandiri')
            ->get(['objek']);

        // $status_objek = [];

        // foreach ($instrumen_sekolah as $item) {
        //     $objek = $item->objek;
        //     $status_objek[$objek] = array_key_exists($objek, $data);
        // }

        $jumlah_instrumen_sekolah_yang_belum_diisi = $instrumen_sekolah->filter(function ($item) use ($data) {
            return !array_key_exists($item->objek, $data);
        })->count();
        // dd($jumlah_instrumen_sekolah_yang_belum_diisi);
        if ($jumlah_instrumen_sekolah_yang_belum_diisi > 0) {
            // return response()->json(['success' => false, 'message' => 'Semua Kuesioner Harus Diisi']);
            return response()->json([
                'success' => false,
                'message' => 'Semua Kuesioner Harus Diisi'
            ], 400);
        }

        $pasien = PasienSekolah::where('nik', $data['nik'])->first();

        if ($pasien) {
            $sudahAda = RiwayatSekolah::where('id_pasien_sekolah', $pasien->id)
                ->whereYear('created_at', now()->year)
                ->exists();

            if ($sudahAda) {
                return response()->json([
                    'success' => false,
                    'message' => "Data dengan NIK {$data['nik']} sudah pernah disubmit pada tahun ini."
                ], 409);
            }
        }


        DB::beginTransaction();
        try {
            // Simpan data pasien_sekolah

            if ($pasien == null) {
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

                $pasien->id_sekolah = $data['id_sekolah'] ?? null;
                $pasien->kelas = $data['kelas'] ?? null;

                $jenisDisabilitasList = ['Fisik', 'Intelektual', 'Mental', 'Sensorik'];
                $disabilitas = [];

                if (isset($data['disabilitas_tidak_ada']) && $data['disabilitas_tidak_ada'] === 'true') {
                    $disabilitas = ['Tidak ada'];
                } else {
                    foreach ($jenisDisabilitasList as $jenis) {
                        if (!empty($data[$jenis]) && $data[$jenis] === 'true') {
                            $disabilitas[] = $jenis;
                        }
                    }
                }

                $pasien->jenis_disabilitas = json_encode($disabilitas);

                $pasien->nik_orangtua_wali = $data['nik_ortu_wali'] ?? null;
                $pasien->nama_orangtua_wali = $data['nama_ortu_wali'] ?? null;
                $pasien->telp = $data['no_hp'] ?? null;
                $pasien->save();
            }

            $riwayat = RiwayatSekolah::where('id_pasien_sekolah', $pasien->id)
                ->whereYear('created_at', now()->year)
                ->first();

            if ($riwayat == null) {
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
                    'provinsi', 'puskesmas', 'tahun_lahir', 'tempat_lahir', 'tanggal_lahir', 'tanda_tangan', 'nama_puskesmas',
                    'id_sekolah', 'Intelektual', 'umur', 'Fisik', 'Sensorik', 'Mental', 'nik_ortu_wali'
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
            }


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function simpan_data_diri(SimpanSkriningRequest $request)
    {
        $data = $request->all();

        // Validasi jika NIK sudah pernah didaftarkan tahun ini
        $sudahAda = PasienSekolah::where('nik', $data['nik'])
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'success' => false,
                'message' => "Data dengan NIK {$data['nik']} sudah pernah didaftarkan pada tahun ini.",
                'error_data_diri' => true
            ], 422);
        }

        DB::beginTransaction();
        try {
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

            $pasien->id_sekolah = $data['id_sekolah'] ?? null;
            $pasien->kelas = $data['kelas'] ?? null;

            $jenisDisabilitasList = ['Fisik', 'Intelektual', 'Mental', 'Sensorik'];
            $disabilitas = [];

            if (isset($data['disabilitas_tidak_ada']) && $data['disabilitas_tidak_ada'] === 'true') {
                $disabilitas = ['Tidak ada'];
            } else {
                foreach ($jenisDisabilitasList as $jenis) {
                    if (!empty($data[$jenis]) && $data[$jenis] === 'true') {
                        $disabilitas[] = $jenis;
                    }
                }
            }

            $pasien->jenis_disabilitas = json_encode($disabilitas);
            $pasien->nama_orangtua_wali = $data['nama_ortu_wali'] ?? null;
            $pasien->telp = $data['no_hp'] ?? null;
            $pasien->save();

            // Simpan persetujuan
            $persetujuan = new FormPersetujuan();
            $persetujuan->id_pasien_sekolah = $pasien->id;
            $persetujuan->tanggal = now()->toDateString();
            $persetujuan->id_master_puskesmas = $data['puskesmas'] ?? null;
            $persetujuan->id_master_sekolah = $data['id_sekolah'] ?? null;
            $persetujuan->persetujuan = ($data['persetujuan'] ?? '') === 'Setuju' ? 1 : 0;
            $persetujuan->save();

            $ttd = new FormPersetujuanTandaTangan();
            $ttd->id_form_persetujuan = $persetujuan->id;
            $ttd->value = $data['tanda_tangan'] ?? null;
            $ttd->save();

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

    public function convertSvgToBase64Png($svgBase64)
    {
        // Ambil bagian base64 saja (hilangkan prefix)
        $svgContent = base64_decode(Str::after($svgBase64, 'base64,'));

        $imagick = new Imagick();
        $imagick->readImageBlob($svgContent);
        $imagick->setImageFormat("png");

        $pngData = $imagick->getImageBlob();
        return 'data:image/png;base64,' . base64_encode($pngData);
    }

    public function downloadPdf(Request $request)
    {
        $nik = $request->nik;
        $data = $this->getDataPesertaDidikForPdf($nik); // pakai yang khusus PDF

        if (!$data) {
            abort(404, 'Data tidak ditemukan');
        }

        $tanda_tangan = null;
        if ($data['persetujuan']) {
            $ttd = FormPersetujuanTandaTangan::where('id_form_persetujuan', $data['persetujuan']['id'])->first();
            $tanda_tangan = $ttd?->value;

            if (Str::startsWith($tanda_tangan, 'data:image/svg+xml')) {
                $tanda_tangan = $this->convertSvgToBase64Png($tanda_tangan);
            }
        }

        $pdf = Pdf::loadView(
            'CKG_Sekolah.Screening_CKG_Sekolah.Success_Page.pdf.index',
            compact('data', 'tanda_tangan')
        )->setPaper('A4', 'portrait');

        return $pdf->download('Pendaftaran_' . $nik . '.pdf');
    }

    private function getDataPesertaDidik($nik)
    {
        $pasien = PasienSekolah::where('nik', $nik)->first();
        if (!$pasien) return null;

        $data = $pasien->toArray();
        $data['tempat_tanggal_lahir'] = $pasien->tempat_lahir . ', ' . date('d-m-Y', strtotime($pasien->tanggal_lahir));
        $data['jenis_kelamin'] = $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';

        $lahir = new \DateTime($pasien->tanggal_lahir);
        $umur = (new \DateTime())->diff($lahir)->y;
        $data['umur'] = $umur . ' tahun';

        $nama_sekolah = isset($pasien->ref_sekolah) ? $pasien->ref_sekolah->nama : '-';
        $alamat_sekolah = isset($pasien->ref_sekolah) ? $pasien->ref_sekolah->alamat : '-';

        $data['nama_sekolah'] = $nama_sekolah;
        $data['alamat_sekolah'] = $alamat_sekolah;

        // $data['nama_sekolah'] = $pasien->ref_sekolah?->nama ?? '-';
        // $data['alamat_sekolah'] = $pasien->ref_sekolah?->alamat ?? '-';

        $form_persetujuan = FormPersetujuan::where('id_pasien_sekolah', $pasien->id)->first();
        $data['persetujuan'] = $form_persetujuan ? $form_persetujuan->toArray() : null;

        if ($form_persetujuan) {
            $data['puskesmas'] = optional(Puskesmas::find($form_persetujuan->id_master_puskesmas))->nama;
            // $data['screening'] = json_decode($riwayat->skrining_mandiri, true);
        }

        $riwayat = RiwayatSekolah::where('id_pasien_sekolah', $pasien->id)->first();
        if ($riwayat) {
            // $data['puskesmas'] = optional(Puskesmas::find($riwayat->id_puskesmas))->nama;
            $data['screening'] = json_decode($riwayat->skrining_mandiri, true);
        }

        $data['provinsi_ktp'] = optional(
            MasterProvinsi::where('kode_provinsi', $pasien->provinsi_ktp)->first()
        )->nama;

        $data['kota_kab_ktp'] = optional(
            MasterKotaKab::where('kode_kota_kab', $pasien->kota_kab_ktp)->first()
        )->nama;

        $data['kecamatan_ktp'] = optional(
            MasterKecamatan::where('kode_kecamatan', $pasien->kecamatan_ktp)->first()
        )->nama;

        $data['kelurahan_ktp'] = optional(
            MasterKelurahan::where('kode_kelurahan', $pasien->kelurahan_ktp)->first()
        )->nama;

        $data['provinsi_dom'] = optional(
            MasterProvinsi::where('kode_provinsi', $pasien->provinsi_dom)->first()
        )->nama;

        $data['kota_kab_dom'] = optional(
            MasterKotaKab::where('kode_kota_kab', $pasien->kota_kab_dom)->first()
        )->nama;

        $data['kecamatan_dom'] = optional(
            MasterKecamatan::where('kode_kecamatan', $pasien->kecamatan_dom)->first()
        )->nama;

        $data['kelurahan_dom'] = optional(
            MasterKelurahan::where('kode_kelurahan', $pasien->kelurahan_dom)->first()
        )->nama;


        return $data;
    }

    private function getDataPesertaDidikForPdf($nik)
    {
        $data = $this->getDataPesertaDidik($nik);
        if (!$data) return null;

        $pasien = PasienSekolah::where('nik', $nik)->first();
        $riwayat = RiwayatSekolah::where('id_pasien_sekolah', $pasien->id)->first();

        // Parse hasil screening
        $screeningRaw = json_decode($riwayat->skrining_mandiri, true) ?? [];

        // Ubah hasil screening menjadi array asosiatif [objek => jawaban]
        $jawabanList = [];
        foreach ($screeningRaw as $item) {
            $key = array_key_first($item);
            $jawabanList[$key] = $item[$key];
        }

        // Konversi jenis kelamin
        $kelas = (int) $pasien->kelas;
        $jenis_kelamin = $pasien->jenis_kelamin;
        if ($jenis_kelamin === 'Laki-laki') {
            $jenis_kelamin = 'L';
            $data['jenis_kelamin'] = "Laki-laki";
        } elseif ($jenis_kelamin === 'Perempuan') {
            $jenis_kelamin = 'P';
            $data['jenis_kelamin'] = "Perempuan";
        }

        // Ambil instrumen berdasarkan kelas dan jenis kelamin
        $instrumen_sekolah = MasterInstrumenSekolah::whereJsonContains('kelas', $kelas)
            ->whereJsonContains('jenis_kelamin', $jenis_kelamin)
            ->where('jenis', 'mandiri')
            ->get(['objek', 'pertanyaan']);

        // Siapkan hasil screening dengan pertanyaan
        $data['screening'] = [];
        foreach ($instrumen_sekolah as $item) {
            $data['screening'][] = [
                'pertanyaan' => $item->pertanyaan,
                'jawaban' => $jawabanList[$item->objek] ?? '-'
            ];
        }

        return $data;
    }


}
