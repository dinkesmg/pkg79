<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = "pasien";

    public function ref_provinsi_ktp()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_ktp', 'kode_provinsi');
    }

    public function ref_kota_kab_ktp()
    {
        return $this->belongsTo(MasterKotaKab::class, 'kota_kab_ktp', 'kode_kota_kab');
    }

    public function ref_kecamatan_ktp()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan_ktp', 'kode_kecamatan');
    }

    public function ref_kelurahan_ktp()
    {
        return $this->belongsTo(MasterKelurahan::class, 'kelurahan_ktp', 'kode_kelurahan');
    }

    public function ref_provinsi_dom()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_dom', 'kode_provinsi');
    }

    public function ref_kota_kab_dom()
    {
        return $this->belongsTo(MasterKotaKab::class, 'kota_kab_dom', 'kode_kota_kab');
    }

    public function ref_kecamatan_dom()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan_dom', 'kode_kecamatan');
    }

    public function ref_kelurahan_dom()
    {
        return $this->belongsTo(MasterKelurahan::class, 'kelurahan_dom', 'kode_kelurahan');
    }

    public function bpjs()
    {
        return $this->belongsTo(PasienBPJS::class, 'nik', 'nik');
    }

    // public function kecamatan()
    // {
    //     return $this->belongsTo(Ref_Kecamatan::class, 'id_kecamatan', 'id');
    // }

    // public function kelurahan()
    // {
    //     return $this->belongsTo(Ref_Kelurahan::class, 'id_kelurahan', 'id');
    // }
}