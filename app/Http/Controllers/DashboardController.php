<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }

    public function data(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        
        if($role=="Puskesmas"){
            $data = Riwayat::where('id_user', $id_user)->get();
        }

        return response()->json($data);
    }
    
}