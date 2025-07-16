<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard_Total_Jenis_Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = "dashboard_total_jenis_pemeriksaan";

    protected $guarded = [];
    // public function puskesmas()
    // {
    //     return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id');
    // }
}
