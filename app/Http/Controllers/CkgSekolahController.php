<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkgSekolahController extends Controller
{
    public function index()
    {
        return view('CKG_sekolah.index');
    }

    public function index_screening()
    {
        return view('CKG_Sekolah.Screening_CKG_Sekolah.index');
    }
}
