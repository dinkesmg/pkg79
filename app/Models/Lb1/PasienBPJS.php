<?php

namespace App\Models\Lb1;

use Illuminate\Database\Eloquent\Model;

class PasienBPJS extends Model
{
    protected $connection = 'mysql_two';
    protected $table = 'tb_bpjs_pasien_simpus';

    // protected $primaryKey = 'no_reg';

    // protected $guarded = ['no_reg'];
    // public $timestamps = false;
}
