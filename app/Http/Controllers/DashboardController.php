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

    // public function data(Request $request)
    // {
    //     $role = Auth::user()->role;
    //     $id_user = Auth::user()->id;
        
    //     if($role=="Puskesmas"){
    //         $data = Riwayat::where('id_user', $id_user)->get();
    //     }

    //     return response()->json($data);
    // }

    public function data_grafik_per_periode(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;
        
        $ar_x = $request->x_grafik;
        $data = [];
        foreach ($ar_x as $ind => $tgl) {
            // dd($ind);
            $q_riwayat = Riwayat::where('tanggal_pemeriksaan', $tgl);
            if ($role == "Admin") {
                // $data[$ind] =  $q_riwayat->get();
                $data[$ind] =  $q_riwayat->count();
            } else if ($role == "Puskesmas") {
                // $data[$ind] = $q_riwayat->where('id_user', $id_user+1)->get();
                $data[$ind] = $q_riwayat->where('id_user', $id_user)->count();
            } 
            
        }
        // dd($data);

        return response()->json($data);
    }

    public function data_per_puskesmas(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        // $id_user = Auth::user()->id;
        
        if($role=="Admin"){
            $data = Riwayat::get();
        }

        $puskesmas = Puskesmas::get();

        $data = [];
        foreach($puskesmas as $ind => $pusk){
            $data[$ind]['nama'] = $pusk->nama;
            $data[$ind]['total'] = Riwayat::where('id_user', $pusk->id+1)
                ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->get()
                ->count();
        }
        // dd($data);

        return response()->json($data);
    }

    public function data_per_usia(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        $data = [
            "bbl" => 0,
            "balita_dan_pra_sekolah" => 0,
            "dewasa_18_29_tahun" => 0,
            "dewasa_30_39_tahun" => 0,
            "dewasa_40_59_tahun" => 0,
            "lansia" => 0
        ];

        $queryBbl = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
            ->whereHas('pasien', function ($query) {
                $query->whereRaw("DATEDIFF(tanggal_pemeriksaan, tgl_lahir) BETWEEN 0 AND 28");
            });

        if ($role == "Puskesmas") {
            $queryBbl->where('id_user', $id_user);
        }

        $data['bbl'] = $queryBbl->count();
        // $data['bbl'] = $queryBbl->get();

        $ageGroups = [
            'balita_dan_pra_sekolah' => [1, 6],
            'dewasa_18_29_tahun' => [18, 29],
            'dewasa_30_39_tahun' => [30, 39],
            'dewasa_40_59_tahun' => [40, 59],
            'lansia' => [60, 150]
        ];

        foreach ($ageGroups as $key => [$min, $max]) {
            $query = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->whereHas('pasien', function ($query) use ($min, $max) {
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, tanggal_pemeriksaan) BETWEEN ? AND ?", [$min, $max]);
                });

            if ($role == "Puskesmas") {
                $query->where('id_user', $id_user);
            }

            $data[$key] = $query->count();
            // $data[$key] = $query->get();
        }



        return response()->json($data);
    }

    public function data_kesimpulan_hasil(Request $request)
    {
        // dd($request->all());
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        $v_kesimpulan_hasil_pemeriksaan = [
            "Normal dan faktor resiko tidak terdeteksi",
            "Normal dengan faktor resiko",
            "Menunjukkan kondisi pra penyakit",
            "Menunjukkan kondisi penyakit"
        ];

        $data = [];


        foreach($v_kesimpulan_hasil_pemeriksaan as $ind => $v){
            if($ind==0){
                $data[$ind]['status'] = "Proses";
                if($role=="Puskesmas"){
                    $data[$ind]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where(function ($query) {
                        $query->where('kesimpulan_hasil_pemeriksaan', "")
                              ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                    })
                    ->get()
                    ->count();
                }
                else if($role=="Admin"){
                    $data[$ind]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where(function ($query) {
                        $query->where('kesimpulan_hasil_pemeriksaan', "")
                              ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                    })
                    ->get()
                    ->count();
                }
            }
            $data[$ind+1]['status'] = $v;
            if($role=="Puskesmas"){
                $data[$ind+1]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where('kesimpulan_hasil_pemeriksaan', $v)
                    ->get()
                    ->count();
            }
            else if($role=="Admin"){
                $data[$ind+1]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->where('kesimpulan_hasil_pemeriksaan', $v)
                ->get()
                ->count();
            }
            
        }

        return response()->json($data);
    }
    
    public function data_per_jenis_pemeriksaan(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        $ar_tgl = $request->ar_tgl;
        $tgl_dari = $request->tgl_dari;
        $tgl_sampai = $request->tgl_sampai;

        $dt_per_jenis_pemeriksaan_bbl = $this->dt_per_jenis_pemeriksaan_bbl($role, $id_user, $ar_tgl, $tgl_dari, $tgl_sampai);
        
        $dt_per_usia = [];

        $ageGroups = [
            'balita_dan_pra_sekolah' => [1, 6],
            // 'dewasa_18_29_tahun' => [18, 29],
            // 'dewasa_30_39_tahun' => [30, 39],
            // 'dewasa_40_59_tahun' => [40, 59],
            'dewasa' => [18, 59],
            'lansia' => [60, 150]
        ];

        foreach ($ageGroups as $key => [$min, $max]) {
            $query = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->whereHas('pasien', function ($query) use ($min, $max) {
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, tgl_lahir, tanggal_pemeriksaan) BETWEEN ? AND ?", [$min, $max]);
                });

            if ($role == "Puskesmas") {
                $query->where('id_user', $id_user);
            }

            // $data[$key] = $query->count();
            $dt_per_usia[$key] = $query->get();
        }

        // dd($dt_per_usia['balita_dan_pra_sekolah']);

        $dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah = $this->dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah($ar_tgl, $tgl_dari, $tgl_sampai, $dt_per_usia['balita_dan_pra_sekolah']);
        $dt_per_jenis_pemeriksaan_dewasa = $this->dt_per_jenis_pemeriksaan_dewasa($ar_tgl, $tgl_dari, $tgl_sampai, $dt_per_usia['dewasa']);
        $dt_per_jenis_pemeriksaan_lansia = $this->dt_per_jenis_pemeriksaan_lansia($ar_tgl, $tgl_dari, $tgl_sampai, $dt_per_usia['lansia']);
        
        $data = array_merge($dt_per_jenis_pemeriksaan_bbl,
            $dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah,
            $dt_per_jenis_pemeriksaan_dewasa,
            $dt_per_jenis_pemeriksaan_lansia);

        

        return response()->json($data);
    }

    private function dt_per_jenis_pemeriksaan_bbl($role, $id_user, $ar_tgl, $tgl_dari, $tgl_sampai){
        $queryBbl = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$tgl_dari, $tgl_sampai])
        ->whereHas('pasien', function ($query) {
            $query->whereRaw("DATEDIFF(tanggal_pemeriksaan, tgl_lahir) BETWEEN 0 AND 28");
        });

        if ($role == "Puskesmas") {
            $queryBbl->where('id_user', $id_user);
        }

        $data_bbl = $queryBbl->get();
        
        $jp_bbl = ['kekurangan_hormon_tiroid','kekurangan_enzim_d6pd','kekurangan_hormon_adrenal',
                        'penyakit_jantung_bawaan','kelainan_saluran_empedu','pertumbuhan_bb'];
        
        $dt_bbl = [];
        foreach ($data_bbl as $ind => $v_bbl) {
            $dt_bbl[$ind]['sasaran'] = "bbl";
            $dt_bbl[$ind]['hasil_pemeriksaan'] = json_decode($v_bbl->hasil_pemeriksaan, true);
        
            if (is_array($dt_bbl[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt_bbl[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp_bbl as $v_jp_bbl) {
                        if (!isset($dt_bbl[$ind][$v_jp_bbl])) {
                            $dt_bbl[$ind][$v_jp_bbl] = 0;
                        }
        
                        if (isset($item[$v_jp_bbl]) && $item[$v_jp_bbl] !== null) {
                            $dt_bbl[$ind][$v_jp_bbl] = 1;
                        }
                    }
                }
            }
            else{
                foreach($jp_bbl as $v_jp_bbl){
                    $dt_bbl[$ind][$v_jp_bbl] = 0;
                }
            }
            
            $dt_bbl[$ind]['tgl'] = $v_bbl->tanggal_pemeriksaan;
        }

        // $data = [];

        $total_jenis_pemeriksaan_bbl = [];
        $total_per_tanggal_bbl = [];

        foreach ($ar_tgl as $v_ar_tgl) {
            $total_per_tanggal_bbl[$v_ar_tgl] = 0;
        }

        foreach ($jp_bbl as $ind => $v_jp_bbl) {
            $total_jenis_pemeriksaan_bbl[] = [
                'sasaran' => 'bbl',
                'jenis_pemeriksaan' => $v_jp_bbl,
                'no' => $ind+1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal_bbl
            ];
        }

        foreach ($dt_bbl as $item) {
            foreach($total_jenis_pemeriksaan_bbl as $ind => $t_bbl){
                if($item[$t_bbl['jenis_pemeriksaan']]==1){
                    $total_jenis_pemeriksaan_bbl[$ind]['total']++;
                    $total_jenis_pemeriksaan_bbl[$ind]['per_tgl'][$item['tgl']]++;        
                }
            }

        }

        return $total_jenis_pemeriksaan_bbl;
    }

    private function dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah($ar_tgl, $tgl_dari, $tgl_sampai, $data){
        $jp = [
            // 'indeks_pbu_tbu',
            'indeks_bbpb_bbtb',
            // 'indeks_bbu',
            'perkembangan',
                'tuberkulosis','telinga','pupil_putih','gigi','talasemia','gula_darah'];
        
        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "balita_dan_pra_sekolah";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);
        
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        if (!isset($dt[$ind][$v_jp])) {
                            $dt[$ind][$v_jp] = 0;
                            // $dt[$ind][$v_jp] = [];
                        }
        
                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        }
                    }
                }
            }
            else{
                foreach($jp as $v_jp){
                    $dt[$ind][$v_jp] = 0;
                }
            }
            
            $dt[$ind]['tgl'] = $v->tanggal_pemeriksaan;
        }

        // dd($dt);

        // $data = [];

        $total_jenis_pemeriksaan = [];
        $total_per_tanggal = [];

        foreach ($ar_tgl as $v_ar_tgl) {
            $total_per_tanggal[$v_ar_tgl] = 0;
        }

        foreach ($jp as $ind => $v_jp) {
            $total_jenis_pemeriksaan[] = [
                'sasaran' => 'balita_dan_pra_sekolah',
                'jenis_pemeriksaan' => $v_jp,
                'no' => $ind+1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach($total_jenis_pemeriksaan as $ind => $t){
                if($item[$t['jenis_pemeriksaan']]==1){
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }

    private function dt_per_jenis_pemeriksaan_dewasa($ar_tgl, $tgl_dari, $tgl_sampai, $data){
        $jp = [
            'merokok','aktivitas_fisik','status_gizi','gigi','tekanan_darah',
            'gula_darah','risiko_stroke','risiko_jantung','fungsi_ginjal',
            'tuberkulosis','ppok','kanker_payudara','kanker_leher_rahim',
            'kanker_paru','kanker_usus','tes_penglihatan','tes_pendengaran',
            'edps','phq','hepatits_b','hepatitis_c','fibrosis_sirosis',
            'anemia','sifilis','hiv'
        ];
        
        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "dewasa";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);
        
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        if (!isset($dt[$ind][$v_jp])) {
                            $dt[$ind][$v_jp] = 0;
                            // $dt[$ind][$v_jp] = [];
                        }
        
                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        }
                    }
                }
            }
            else{
                foreach($jp as $v_jp){
                    $dt[$ind][$v_jp] = 0;
                }
            }
            
            $dt[$ind]['tgl'] = $v->tanggal_pemeriksaan;
        }

        // dd($dt);

        // $data = [];

        $total_jenis_pemeriksaan = [];
        $total_per_tanggal = [];

        foreach ($ar_tgl as $v_ar_tgl) {
            $total_per_tanggal[$v_ar_tgl] = 0;
        }

        foreach ($jp as $ind => $v_jp) {
            $total_jenis_pemeriksaan[] = [
                'sasaran' => 'dewasa',
                'jenis_pemeriksaan' => $v_jp,
                'no' => $ind+1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach($total_jenis_pemeriksaan as $ind => $t){
                if($item[$t['jenis_pemeriksaan']]==1){
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }

    private function dt_per_jenis_pemeriksaan_lansia($ar_tgl, $tgl_dari, $tgl_sampai, $data){
        $jp = [
            'gejala_depresi','merokok','aktivitas_fisik','status_gizi',
            'gigi','tekanan_darah','gula_darah','risiko_stroke','risiko_jantung',
            'fungsi_ginjal','tuberkulosis','ppok','kanker_payudara','kanker_leher_rahim',
            'kanker_paru','kanker_usus','tes_penglihatan','tes_pendengaran',
            'gejala_depresi','hepatits_b','hepatitis_c','fibrosis_sirosis',
            
        ];
        
        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "lansia";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);
        
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        if (!isset($dt[$ind][$v_jp])) {
                            $dt[$ind][$v_jp] = 0;
                            // $dt[$ind][$v_jp] = [];
                        }
        
                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        }
                    }
                }
            }
            else{
                foreach($jp as $v_jp){
                    $dt[$ind][$v_jp] = 0;
                }
            }
            
            $dt[$ind]['tgl'] = $v->tanggal_pemeriksaan;
        }

        // dd($dt);

        // $data = [];

        $total_jenis_pemeriksaan = [];
        $total_per_tanggal = [];

        foreach ($ar_tgl as $v_ar_tgl) {
            $total_per_tanggal[$v_ar_tgl] = 0;
        }

        foreach ($jp as $ind => $v_jp) {
            $total_jenis_pemeriksaan[] = [
                'sasaran' => 'lansia',
                'jenis_pemeriksaan' => $v_jp,
                'no' => $ind+1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach($total_jenis_pemeriksaan as $ind => $t){
                if($item[$t['jenis_pemeriksaan']]==1){
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }

}