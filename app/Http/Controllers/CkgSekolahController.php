<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkgSekolahController extends Controller
{
    public function index()
    {
        return view('CKG_sekolah.index');
    }
}
