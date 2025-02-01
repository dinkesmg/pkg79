<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Puskesmas;
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

    public function daftar_puskesmas(){
        $puskesmas = Puskesmas::get();

        // dd($puskesmas);
        foreach ($puskesmas as $p) {
            $user = new User();
            $user->nama = $p->nama;
            $user->password = bcrypt("PKG79" . $p->kode_p);
            $user->role = "Puskesmas";
            $user->save();
        }
    }
}