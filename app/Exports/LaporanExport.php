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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Riwayat::with(
            'pasien.ref_provinsi_ktp', 'pasien.ref_kota_kab_ktp', 'pasien.ref_kecamatan_ktp', 'pasien.ref_kelurahan_ktp',
            'pasien.ref_provinsi_dom', 'pasien.ref_kota_kab_dom', 'pasien.ref_kecamatan_dom', 'pasien.ref_kelurahan_dom',
            'pemeriksa','user')->get();
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
