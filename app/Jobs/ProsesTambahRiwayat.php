<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Riwayat;
use App\Models\Mapping_kelurahan;
use App\Models\Mapping_simpus;
use App\Models\Pemeriksa;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\Log;

class ProsesTambahRiwayat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $dt;

    public function __construct(array $dt)
    {
        $this->dt = $dt;
        // Log::info('Job ProsesTambahRiwayat dikirim', $dt);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // try {
        // Log::info('Job ProsesTambahRiwayat mulai dijalankan');
        $dt = $this->dt;

        $nik = $dt['nik'];
        $tanggal = $dt['tanggal'];
        $tgl_lahir = $dt['tg_lahir'];
        $usia = Carbon::parse($tgl_lahir)->diffInYears(Carbon::parse($tanggal));

        $pasien = Pasien::updateOrCreate(
            ['nik' => $nik],
            [
                'nama' => $dt['nama'],
                'jenis_kelamin' => $dt['jkl'],
                'tgl_lahir' => $tgl_lahir,
                'provinsi_ktp' => substr($nik, 0, 2),
                'kota_kab_ktp' => substr($nik, 0, 4),
                'kecamatan_ktp' => substr($nik, 0, 6),
                'kelurahan_ktp' => optional(Mapping_kelurahan::where('kode_kelurahan_lokal', $dt['kdesa'])->first())->kode_kelurahan_nasional ?? '',
                'alamat_ktp' => $dt['jalan'],
                'no_hp' => $dt['telp']
            ]
        );

        $riwayat = Riwayat::with(['pasien', 'pemeriksa', 'user'])
            ->whereHas('pasien', fn($q) => $q->where('nik', $nik))
            ->where('tanggal_pemeriksaan', $tanggal)
            ->first();

        $mapping_simpus = Mapping_simpus::all();
        $hp_baru = [];
        $hp_lainnya = [];
        $kesimpulan_hasil_pemeriksaan = null;
        $program_tindak_lanjut = null;

        if (!empty($dt['hasil_pemeriksaan']) && $dt['hasil_pemeriksaan'] != "null") {
            $hasil_pemeriksaan = json_decode($dt['hasil_pemeriksaan'], true);

            foreach ($hasil_pemeriksaan as $hp) {
                if (!is_array($hp)) continue;

                foreach ($hp as $hp_obj => $hp_val) {
                    $matched = $mapping_simpus->firstWhere('val_simpus', $hp_obj);
                    if (!$matched) {
                        if ($hp_obj === 'kesimpulan_hasil_pemeriksaan') $kesimpulan_hasil_pemeriksaan = $hp_val;
                        elseif ($hp_obj === 'edukasi_yang_diberikan') $program_tindak_lanjut[] = ['edukasi' => $hp_val];
                        elseif ($hp_obj === 'rujuk_fktrl_dengan_keterangan') $program_tindak_lanjut[] = ['rujuk_fktrl' => $hp_val];
                        else $hp_lainnya[] = $hp;
                        continue;
                    }

                    $val = $matched->val;
                    $status = $matched->status;
                    $kondisi = $matched->kondisi;
                    $status_simpus = $matched->status_simpus;

                    if ($hp_obj == 'gigi_karies' && $status_simpus && $kondisi) {
                        $matchedGigi = $mapping_simpus->filter(
                            fn($m) =>
                            $m->val === 'gigi' &&
                                $m->status_simpus === $hp_val &&
                                $m->kondisi === ($usia <= 6 ? '<=6 tahun' : 'dewasa')
                        )->first();
                        $status = $matchedGigi->status ?? $status;
                    } elseif ($hp_obj === 'hasil_pemeriksaan_hb') {
                        $status = $hp_val >= 11 ? 'Hemoglobin normal (≥11 g/dL)' : 'Hemoglobin di bawah normal (< 11 g/dL)';
                    } elseif ($hp_obj === 'hasil_apri_score') {
                        $status = $hp_val <= 0.5 ? 'APRI Score ≤ 0.5' : 'APRI Score >0.5';
                    } elseif ($hp_obj === 'hasil_pemeriksaan_rapid_test_hb') {
                        $status = $hp_val < 12 ? 'Tidak Normal (Hb <12 gr/dL)' : 'Normal';
                    }

                    $hp_baru[$val] = $status;
                }
            }
        }

        $data = $riwayat ?: new Riwayat();
        $data->id_user = intval(preg_replace('/[^0-9]/', '', $dt['kpusk'])) + 1;
        $data->tanggal_pemeriksaan = $tanggal;
        $data->tempat_periksa = 'Puskesmas';
        $data->nama_fktp_pj = optional(Puskesmas::find($data->id_user - 1))->nama;
        $data->id_pasien = $pasien->id;
        $data->id_pemeriksa = optional(Pemeriksa::updateOrCreate(
            ['nik' => $dt['nik_dokter'] ?? null],
            ['nama' => $dt['nama_dokter'] ?? null]
        ))->id;
        $data->hasil_pemeriksaan = json_encode($hp_baru);
        $data->hasil_pemeriksaan_lainnya = $hp_lainnya ? json_encode($hp_lainnya) : null;
        $data->kesimpulan_hasil_pemeriksaan = $kesimpulan_hasil_pemeriksaan;
        $data->program_tindak_lanjut = $program_tindak_lanjut ? json_encode($program_tindak_lanjut) : null;
        $data->save();

        // return response()->json(['status' => 'success']);
        Log::info('tambah manual: status=' . ($riwayat ? "update" : "tambah") . ' pusk=' . $dt['kpusk'] . "tanggal=" . $tanggal . " pasien=" . $pasien->nama);
        // return response()->json($dt);
        // } catch (\Throwable $e) {
        //     Log::error('Error tambah(): ' . $e->getMessage());
        //     // return response()->json(['error' => $e->getMessage()], 500);
        // }
    }
}