<?php

namespace App\Exports;

use App\Models\RiwayatSekolah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LaporanSasaranSekolahExport implements FromCollection, WithHeadings, WithMapping
{
    private $counter = 0;
    protected $role, $id_user, $periodeDari, $periodeSampai, $nama_sekolah, $kelas;

    public function __construct($role, $id_user, $periodeDari, $periodeSampai, $nama_sekolah, $kelas)
    {
        $this->role = $role;
        $this->id_user = $id_user;
        $this->periodeDari = $periodeDari;
        $this->periodeSampai = $periodeSampai;
        $this->nama_sekolah = $nama_sekolah;
        $this->kelas = $kelas;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // $data = Riwayat::with(
        //     'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
        //     'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
        //     'pemeriksa','user')->get();

        $query = RiwayatSekolah::with([
            'pasien_sekolah.ref_provinsi_ktp' => function ($q) {
                $q->select('id', 'kode_provinsi', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kota_kab_ktp' => function ($q) {
                $q->select('id', 'kode_kota_kab', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kecamatan_ktp' => function ($q) {
                $q->select('id', 'kode_kecamatan', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kelurahan_ktp' => function ($q) {
                $q->select('id', 'kode_kelurahan', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_provinsi_dom' => function ($q) {
                $q->select('id', 'kode_provinsi', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kota_kab_dom' => function ($q) {
                $q->select('id', 'kode_kota_kab', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kecamatan_dom' => function ($q) {
                $q->select('id', 'kode_kecamatan', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_kelurahan_dom' => function ($q) {
                $q->select('id', 'kode_kelurahan', 'kode_parent', 'nama');
            },
            'pasien_sekolah.ref_master_sekolah' => function ($q) {
                $q->select('id', 'nama', 'alamat');
            },
            'puskesmas' => function ($q) {
                $q->select('id', 'nama');
            },
        ])
            ->join('form_persetujuan', function ($join) {
                $join->on('riwayat_sekolah.id_pasien_sekolah', '=', 'form_persetujuan.id_pasien_sekolah')
                    ->whereRaw('DATE(riwayat_sekolah.created_at) = form_persetujuan.tanggal');
            })
            ->whereBetween('riwayat_sekolah.created_at', ["{$this->periodeDari} 00:00:00", "{$this->periodeSampai} 23:59:59"])
            ->orderBy('riwayat_sekolah.created_at', 'desc')
            ->select('riwayat_sekolah.*', 'form_persetujuan.tanggal as form_persetujuan_tanggal', 'form_persetujuan.persetujuan');

        if ($this->role == "Puskesmas") {
            $query->where('id_puskesmas', ($this->id_user - 1));
        }

        if ($this->nama_sekolah != null) {
            $nama_sekolah = $this->nama_sekolah;

            $query->whereHas('pasien_sekolah', function ($q) use ($nama_sekolah) {
                $q->where('id_sekolah', $nama_sekolah);
            });
        }

        if ($this->kelas != null) {
            $kelas = $this->kelas;

            $query->whereHas('pasien_sekolah', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }



        $data = $query->get();

        // dd($data);
        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pemeriksaan',
            'Nama FKTP Pemeriksa',
            'Persetujuan',
            'Nama Sekolah',
            'NIK',
            'Nama',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Umur',
            'Kelas'
        ];
    }

    /**
     * Kustomisasi data yang diekspor.
     */
    public function map($riwayat): array
    {
        $this->counter++;
        // Persetujuan
        $persetujuan = $riwayat->persetujuan == "1" ? "setuju" : "tidak";

        // Umur
        $tglLahir = Carbon::parse($riwayat->pasien_sekolah->tanggal_lahir);
        $tglPeriksa = Carbon::parse($riwayat->form_tanggal_persetujuan);
        $diff = $tglLahir->diff($tglPeriksa);
        $umur = $diff->y . ' tahun ' . $diff->m . ' bulan ' . $diff->d . ' hari';

        return [
            $this->counter,
            Carbon::parse($riwayat->form_tanggal_persetujuan)->format('d-m-Y'),
            $riwayat->puskesmas->nama,
            $persetujuan,
            $riwayat->pasien_sekolah->ref_master_sekolah->nama ?? '-',
            $riwayat->pasien_sekolah->nik ?? '-',
            $riwayat->pasien_sekolah->nama ?? '-',
            $riwayat->pasien_sekolah->jenis_kelamin ?? '-',
            $riwayat->pasien_sekolah->tanggal_lahir ?? '-',
            $umur,
            $riwayat->pasien_sekolah->kelas ?? '-',
        ];
    }
}
