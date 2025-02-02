<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKelurahan;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function provinsi(Request $request)
    {
        $search = $request->get('search');
        $data = MasterProvinsi::where('nama', 'like', '%' . $search . '%')->get();
     
        // dd($data);
        return response()->json($data);
    }

    public function kelurahan(Request $request)
    {
        $search = $request->get('search');
        $data = MasterKelurahan::where('nama', 'like', '%' . $search . '%')->get();
     
        // dd($data);
        return response()->json($data);
    }

}