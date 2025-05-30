<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksa extends Model
{
    use HasFactory;

    protected $table = "pemeriksa";

    protected $guarded = [];

    // public function kecamatan()
    // {
    //     return $this->belongsTo(Ref_Kecamatan::class, 'id_kecamatan', 'id');
    // }

    // public function kelurahan()
    // {
    //     return $this->belongsTo(Ref_Kelurahan::class, 'id_kelurahan', 'id');
    // }
}