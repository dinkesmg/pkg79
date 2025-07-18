<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSekolah extends Model
{
    use HasFactory;

    protected $table = "riwayat_sekolah";

    protected $casts = [
        'hasil_pemeriksaan' => 'array',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id');
    }

    public function pasien_sekolah()
    {
        return $this->belongsTo(PasienSekolah::class, 'id_pasien_sekolah', 'id');
    }
}
