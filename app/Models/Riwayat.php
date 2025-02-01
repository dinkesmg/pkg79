<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = "riwayat";

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function pemeriksa()
    {
        return $this->belongsTo(Pemeriksa::class, 'id_pemeriksa', 'id');
    }
 
}