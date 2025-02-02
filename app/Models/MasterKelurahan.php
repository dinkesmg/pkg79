<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKelurahan extends Model
{
    use HasFactory;

    protected $table = "master_kelurahan";

    // public function kecamatan()
    // {
    //     return $this->belongsTo(Ref_Kecamatan::class, 'id_kecamatan', 'id');
    // }

    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kode_kecamatan', 'kode_parent');
    }
}