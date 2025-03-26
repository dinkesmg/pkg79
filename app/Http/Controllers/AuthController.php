<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\MasterProvider;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.index');
    }

    public function cek(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'password' => 'required',
            // 'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['nama' => $request->nama, 'password' => $request->password])) {
            return redirect()->route('riwayat.index');
        } else {
            // dd("gagal");
            return redirect()->route('/');
            // return redirect()->route('/')->with('error', 'Nama atau password salah.');
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }

    public function daftar_provider(){
        $data = MasterProvider::get();

        // dd($puskesmas);
        foreach ($data as $p) {
            $cek = User::where('nama', $p->nmprovider)->first();
            if(!$cek){
                $user = new User();
                $user->nama = $p->nmprovider;
                $user->password = bcrypt($p->kdprovider);
                $user->role = "FaskesLain";
                $user->save();
            }
        }
    }
}