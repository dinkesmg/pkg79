<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterInstrumenSekolah;

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

    public function get_instrument_sekolah(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|integer|min:1|max:12',
            'jenis_kelamin' => 'required|string|in:L,P',
        ]);

        $kelas = (int) $validated['kelas'];
        $jenis_kelamin = $validated['jenis_kelamin'];

        $data = MasterInstrumenSekolah::whereJsonContains('kelas', $kelas)
            ->whereJsonContains('jenis_kelamin', $jenis_kelamin)
            ->get();

        return response()->json($data);
    }
    
}
