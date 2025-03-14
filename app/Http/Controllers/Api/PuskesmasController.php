<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riwayat;

class PuskesmasController extends Controller
{
    public function data(Request $req)
    {
        $id_user = $req->id+1;

        $data = Riwayat::with('pasien')->where('id_user', $id_user)->whereHas('pasien', function($query){
            $query->whereNotNull('nik')->where('nik', '!=', '');
        })->get();

        return response()->json($data);
    }
}
