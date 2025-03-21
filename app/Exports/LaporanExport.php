<?php

namespace App\Exports;

use App\Models\Riwayat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    private $counter = 0;
    protected $role, $id_user, $periodeDari, $periodeSampai, $instrumen, $jenis;

    public function __construct($role, $id_user, $periodeDari, $periodeSampai, $instrumen, $jenis)
    {
        $this->role = $role;
        $this->id_user = $id_user;
        $this->periodeDari = $periodeDari;
        $this->periodeSampai = $periodeSampai;
        $this->instrumen = $instrumen;
        $this->jenis = $jenis;
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

        $query = Riwayat::with([
            'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
            'pemeriksa','user'
        ])->whereBetween('tanggal_pemeriksaan', [$this->periodeDari, $this->periodeSampai])
          ->orderBy('tanggal_pemeriksaan', 'desc');

        $instrumen = $this->instrumen;
        $jenis = $this->jenis;
    
        if($jenis == "fktp_lain"){
            $query->where('tempat_periksa', '!=', 'Puskesmas');
        }
        
        // Filter berdasarkan role
        if ($this->role == "Puskesmas") {
            $query->where('id_user', $this->id_user);
        }

        if (!empty($instrumen)) {
            $data = $query->get()->filter(function ($item) use ($instrumen) {
                // Pastikan JSON tidak null atau kosong sebelum di-decode
                if (empty($item->hasil_pemeriksaan)) {
                    return false;
                }
            
                // Decode JSON dengan error handling
                $hasil_pemeriksaan = json_decode($item->hasil_pemeriksaan, true);
            
                // Jika JSON tidak valid, return false
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return false;
                }
            
                // Gunakan foreach untuk mencari instrumen dalam JSON array
                foreach ($hasil_pemeriksaan as $pemeriksaan) {
                    if (is_array($pemeriksaan) && isset($pemeriksaan[$instrumen])) {
                        return true;
                    }
                }
            
                return false;
            })->values();
            
        }
        else{
            $data = $query->get();
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Faskes', 
            'Tanggal Pemeriksaan', 
            'Tempat Periksa', 
            'Nama FKTP PJ', 
            'Nama Pasien',
            'Jenis Kelamin',
            // 'Tanggal Lahir',
            'Umur',
            'Provinsi KTP',
            'Kota Kab KTP',
            'Kecamatan KTP',
            'Kelurahan KTP',
            'Alamat KTP',
            'No HP',
            'Hasil Pemeriksaan',
            'Hasil Pemeriksaan Lainnya',
            'Kesimpulan Hasil Pemeriksaan',
            'Program Tindak Lanjut'
        ];
    }

    /**
     * Kustomisasi data yang diekspor.
     */
    public function map($riwayat): array
    {
        $hasilPemeriksaan = json_decode($riwayat->hasil_pemeriksaan, true);
    
        $format_hasil_pemeriksaan = $hasilPemeriksaan 
            ? implode(', ', array_map(fn($item) => implode(', ', array_map(fn($key, $value) => "$key: $value", array_keys($item), $item)), $hasilPemeriksaan)) 
            : '-';

        $hasilPemeriksaanLainnya = json_decode($riwayat->hasil_pemeriksaan_lainnya, true);

        $format_hasil_pemeriksaan_lainnya = $hasilPemeriksaanLainnya 
            ? implode(', ', array_map(fn($item) => implode(', ', array_map(fn($key, $value) => "$key: $value", array_keys($item), $item)), $hasilPemeriksaan)) 
            : '-';

        $program_tindak_lanjut = json_decode($riwayat->program_tindak_lanjut, true);

        // $format_program_tindak_lanjut = $program_tindak_lanjut 
        //     ? implode(', ', array_map(fn($item) => implode(', ', array_map(fn($key, $value) => "$key: $value", array_keys($item), $item)), $hasilPemeriksaan)) 
        //     : '-';
        $format_program_tindak_lanjut = is_array($program_tindak_lanjut) && !empty($program_tindak_lanjut)
            ? implode(', ', array_map(fn($item) => implode(', ', array_map(fn($key, $value) => "$key: $value", array_keys($item), $item)), $program_tindak_lanjut))
            : '-';

        if (isset($riwayat->pasien) && isset($riwayat->pasien->tgl_lahir) && isset($riwayat->tanggal_pemeriksaan)) {
            $tglLahir = Carbon::parse($riwayat->pasien->tgl_lahir);
            $tglPeriksa = Carbon::parse($riwayat->tanggal_pemeriksaan);
        
            $diff = $tglLahir->diff($tglPeriksa);
        
            $umur = $diff->y . ' tahun ' . $diff->m . ' bulan ' . $diff->d . ' hari';
        } else {
            $umur = '';
        }

        return [
            ++$this->counter,
            $riwayat->user ? $riwayat->user->nama : "-",
            // $riwayat->tanggal_pemeriksaan,
            Carbon::parse($riwayat->tanggal_pemeriksaan)->format('d-m-Y'),
            $riwayat->tempat_periksa,
            $riwayat->nama_fktp_pj,
            isset($riwayat->pasien->nama) ? $riwayat->pasien->nama:"-",
            isset($riwayat->pasien->jenis_kelamin) ? $riwayat->pasien->jenis_kelamin:"-", 
            // isset($riwayat->pasien->tgl_lahir) ? Carbon::parse($riwayat->pasien->tgl_lahir)->format('d-m-Y'):"-", 
            $umur,
            isset($riwayat->pasien->ref_provinsi_ktp->nama) ? $riwayat->pasien->ref_provinsi_ktp->nama : '-',
            isset($riwayat->pasien->ref_kota_kab_ktp->nama) ? $riwayat->pasien->ref_kota_kab_ktp->nama : '-',
            isset($riwayat->pasien->ref_kecamatan_ktp->nama) ? $riwayat->pasien->ref_kecamatan_ktp->nama : '-',
            isset($riwayat->pasien->ref_kelurahan_ktp->nama) ? $riwayat->pasien->ref_kelurahan_ktp->nama : '-',
            isset($riwayat->pasien->alamat_ktp) ? $riwayat->pasien->alamat_ktp:"-",
            isset($riwayat->pasien->no_hp) ? $riwayat->pasien->no_hp:"-",
            // $riwayat->hasil_pemeriksaan,
            $format_hasil_pemeriksaan,
            // $riwayat->hasil_pemeriksaan_lainnya,
            $format_hasil_pemeriksaan_lainnya,
            $riwayat->kesimpulan_hasil_pemeriksaan,
            // $riwayat->program_tindak_lanjut,
            $format_program_tindak_lanjut,
        ];
    }
}
