<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProvinsi extends Model
{
    use HasFactory;

    protected $table = "master_provinsi";

    // public function kecamatan()
    // {
    //     return $this->belongsTo(Ref_Kecamatan::class, 'id_kecamatan', 'id');
    // }

    // public function kelurahan()
    // {
    //     return $this->belongsTo(Ref_Kelurahan::class, 'id_kelurahan', 'id');
    // }
}