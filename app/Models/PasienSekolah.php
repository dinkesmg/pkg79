<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienSekolah extends Model
{
    use HasFactory;

    protected $table = "pasien_sekolah";

    public $timestamps = false;

    protected $guarded = [];

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

    public function ref_sekolah()
    {
        return $this->belongsTo(MasterSekolah::class, 'id_sekolah', 'id');
    }

    public function ref_riwayat_sekolah()
    {
        return $this->hasOne(RiwayatSekolah::class, 'id_pasien_sekolah', 'id');
    }

    public function ref_master_sekolah()
    {
        return $this->hasOne(MasterSekolah::class, 'id', 'id_sekolah');
    }
}
