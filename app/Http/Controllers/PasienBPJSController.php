<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\PasienBPJS;
use Illuminate\Support\Facades\Validator;

class PasienBPJSController extends Controller
{
    public function data(Request $request)
    {
        $data = PasienBPJS::get();
        
        
        return response()->json($data);
    }

}