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
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }

    public function detail_pasien_hasil_pemeriksaan(Request $request)
    {
        $props = $request->query('props');
        // dd($props);

        return view('Dashboard.Pasien_Hasil_Pemeriksaan.index', compact('props'));
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

    public function data_hasil_pemeriksaan(Request $request)
    {
        $role = Auth::user()->role;
        $id_user = Auth::user()->id;

        // dd($id_user);

        $query = Riwayat::select('hasil_pemeriksaan')
            ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai]);

        if ($role == 'Puskesmas') {
            $query = $query->where('id_user', $id_user);
        }

        $data = $query->get();
        // $data = Riwayat::select('hasil_pemeriksaan')
        //     ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])->get();

        // if ($role == "Admin") {
        //     $query->where('id_user', $id_user);
        // }

        $result = [
            'kardiovaskular' => [
                'status_gizi' => [
                    'Normal' => 0,
                    'Overweight' => 0,
                    'Underweight' => 0,
                    'Obesitas' => 0,
                ],
                'gula_darah' => [
                    'Normal (GDS<100)' => 0,
                    'Prediabetes (GDS 140 - 199)' => 0,
                    'Hiperglikemia (GDS > 200)' => 0,
                ],
                'tekanan_darah' => [
                    'Tidak terdiagnosis Hipertensi atau prehipertensi' => 0,
                    'Terdiagnosis hipertensi tanpa tanda bahaya' => 0,
                    'Terdiagnosis hipertensi dengan tanda bahaya' => 0,
                ],
                'merokok' => [
                    'Tidak merokok' => 0,
                    'Merokok' => 0
                ],
                'aktivitas_fisik' => [
                    'Cukup' => 0,
                    'Kurang' => 0
                ],
                'gigi' => [
                    'Tidak ada karies (normal)' => 0,
                    'Ada karies, gigi goyang' => 0,
                ],
                'risiko_stroke' => [
                    'Normal' => 0,
                    'Tinggi' => 0,
                    'Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah' => 0,
                    'Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang' => 0,
                    'Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi' => 0
                ],
                'risiko_jantung' => [
                    'EKG Normal' => 0,
                    'EKG Tidak normal' => 0
                ],
                'fungsi_ginjal' => [
                    'Normal' => 0,
                    'Tidak normal' => 0
                ]
            ],
            'fungsi_indera' => [
                'tes_penglihatan' => [
                    'Visus (6/6 - 6/12)' => 0,
                    'Abnormal (Visus <6/12)' => 0,
                    'Visus membaik' => 0,
                    'Visus tidak membaik' => 0
                ],
                'tes_pendengaran' => [
                    'Lulus' => 0,
                    'Tidak lulus (Hasil normal)' => 0,
                    'Tidak lulus (ditemukan gangguan atau kelainan)' => 0
                ]
            ],
            'kanker' => [
                'kanker_leher_rahim' => [
                    'Tidak ada faktor resiko' => 0,
                    'Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif' => 0,
                    'Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif' => 0,
                    'Curiga kanker' => 0
                ],
                'kanker_payudara' => [
                    'Sadanis Negatif' => 0,
                    'Sadanis Positif pemeriksaan USG Normal' => 0,
                    'Sadanis Positif pemeriksaan USG Simple Cyst' => 0,
                    'Sadanis Positif pemeriksaan USG Non Simple cyst' => 0,
                    'Sadanis Positif resiko sangat tinggi' => 0
                ],
                'kanker_paru' => [
                    'Risiko ringan' => 0,
                    'Risiko sedang atau tinggi' => 0
                ],
                'kanker_usus' => [
                    'APCS 0-1 Risiko rendah' => 0,
                    'APCS 2-3 Risiko sedang' => 0,
                    'APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua' => 0,
                    'APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif' => 0
                ],
            ],
            'paru' => [
                'tuberkulosis' => [
                    'Tidak terdapat tanda, gejala dan Kontak erat TB' => 0,
                    'Terdapat kontak erat TB Positif tanpa gejala' => 0,
                    'Terdapat kontak erat TB positif dengan gejala' => 0
                ]
            ],
            'jiwa' => [
                'kesehatan_jiwa' => [
                    'Normal' => 0,
                    'Tidak ada gangguan jiwa' => 0,
                    'Ada gangguan jiwa' => 0,
                    'Ada gangguan jiwa dengan penyulit' => 0
                ]
            ],
            'hati' => [
                'hepatitis_b' => [
                    'HBsAg Non Reaktif' => 0,
                    'HBsAg Reaktif' => 0
                ],
                'hepatitis_c' => [
                    'Anti HCV Non Reaktif' => 0,
                    'Anti HCV Reaktif' => 0
                ],
                'fibrosis_sirosis' => [
                    'APRI Score ≤ 0.5' => 0,
                    'APRI Score >0.5' => 0
                ]
            ],
            'bbl' => [
                'pertumbuhan_bb' => [
                    'BB Lahir ≥ 2500 gr' => 0,
                    'BBLR (2000 - < 2500 gr) dan sehat' => 0,
                    'BBLR (2000 - <2500 gr) dan sakit' => 0,
                    'BBLR < 2000 gr' => 0
                ],
                'penyakit_jantung_bawaan' => [
                    '>95%, Perbedaan <3% di tangan kanan dan kaki' => 0,
                    '90-95% atau perbedaan >3% di tangan dan kaki' => 0,
                    '<90%' => 0
                ],
                'kekurangan_hormon_tiroid' => [
                    'TSH Normal' => 0,
                    'TSH Tinggi' => 0
                ],
                'kekurangan_enzim_d6pd' => [
                    'Negatif' => 0,
                    'Positif' => 0
                ],
                'kekurangan_hormon_adrenal' => [
                    'Negatif' => 0,
                    'Positif' => 0
                ],
                'kelainan_saluran_empedu' => [
                    'Warna tinja Normal' => 0,
                    'Warna tinja Pucat' => 0
                ]
            ],
            'lanjut_usia' => [
                'ppok' => [
                    'Resiko rendah (PUMA < 6)' => 0,
                    'Resiko tinggi (PUMA ≥ 6)' => 0
                ],
                'gangguan_penglihatan' => [
                    'Tidak ada gangguan' => 0,
                    'Ditemukan ≥1 gangguan' => 0
                ],
                'gangguan_pendengaran' => [
                    'Tidak ada gangguan' => 0,
                    'Ditemukan ≥1 gangguan' => 0
                ],
                'gejala_depresi' => [
                    'Tidak ada gangguan' => 0,
                    'Tidak depresi' => 0,
                    'Kemungkinan depresi' => 0,
                    'Depresi' => 0
                ],
                'activity_daily_living' => [
                    'Mandiri' => 0,
                    'Ketergantungan ringan' => 0,
                    'Ketergantungan Sedang' => 0,
                    'Ketergantungan Berat' => 0,
                    'Ketergantungan total' => 0
                ]
            ]
        ];

        foreach ($data as $item) {
            if ($item->hasil_pemeriksaan) {
                $hasil = json_decode($item->hasil_pemeriksaan, true);

                foreach ($hasil as $pemeriksaan) {
                    $keys = ['status_gizi', 'gula_darah', 'tekanan_darah', 'merokok', 'aktivitas_fisik', 'gigi', 'risiko_stroke', 'risiko_jantung', 'fungsi_ginjal'];
                    $indera_keys = ['tes_penglihatan', 'tes_pendengaran'];
                    $kanker_keys = ['kanker_leher_rahim', 'kanker_payudara', 'kanker_paru', 'kanker_usus'];
                    $paru_keys = ['tuberkulosis'];
                    $jiwa_keys = ['kesehatan_jiwa'];
                    $hati_keys = ['hepatitis_b', 'hepatitis_c', 'fibrosis_sirosis'];
                    $bbl_keys = ['pertumbuhan_bb', 'penyakit_jantung_bawaan', 'kekurangan_hormon_tiroid', 'kekurangan_enzim_d6pd', 'kekurangan_hormon_adrenal', 'kelainan_saluran_empedu'];
                    $lanjut_usia_keys = ['ppok', 'gangguan_penglihatan', 'gangguan_pendengaran', 'gejala_depresi', 'activity_daily_living'];

                    foreach ($keys as $key) {
                        if (isset($pemeriksaan[$key])) {
                            $value = $pemeriksaan[$key];
                            if (isset($result['kardiovaskular'][$key][$value])) {
                                $result['kardiovaskular'][$key][$value]++;
                            }
                        }
                    }
                }

                foreach ($indera_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['fungsi_indera'][$key][$value])) {
                            $result['fungsi_indera'][$key][$value]++;
                        }
                    }
                }

                foreach ($kanker_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['kanker'][$key][$value])) {
                            $result['kanker'][$key][$value]++;
                        }
                    }
                }

                foreach ($paru_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['paru'][$key][$value])) {
                            $result['paru'][$key][$value]++;
                        }
                    }
                }

                foreach ($jiwa_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['jiwa'][$key][$value])) {
                            $result['jiwa'][$key][$value]++;
                        }
                    }
                }

                foreach ($hati_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['hati'][$key][$value])) {
                            $result['hati'][$key][$value]++;
                        }
                    }
                }

                foreach ($bbl_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['bbl'][$key][$value])) {
                            $result['bbl'][$key][$value]++;
                        }
                    }
                }

                foreach ($lanjut_usia_keys as $key) {
                    if (isset($pemeriksaan[$key])) {
                        $value = $pemeriksaan[$key];
                        if (isset($result['lanjut_usia'][$key][$value])) {
                            $result['lanjut_usia'][$key][$value]++;
                        }
                    }
                }
            }
        }

        return response()->json($result);
    }

    public function data_pasien_hasil_pemeriksaan(Request $request)
    {
        $props = $request->query('props'); // Ambil parameter dari request

        if (!$props) {
            return response()->json(['error' => 'Parameter props diperlukan'], 400);
        }

        // \Log::info("Props yang diterima: " . $props);

        // Menggunakan JSON_EXTRACT() karena MariaDB tidak mendukung JSON_CONTAINS()
        $data = Riwayat::whereRaw("JSON_EXTRACT(hasil_pemeriksaan, '$[*].$props') IS NOT NULL")
            ->get();

        if ($data->isEmpty()) {
            // \Log::warning("Data tidak ditemukan untuk props: " . $props);
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }


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

        if ($role == "Admin") {
            $data = Riwayat::get();
        }

        $tgl_dari = Carbon::parse($request->tgl_dari);
        $tgl_sampai = Carbon::parse($request->tgl_sampai);

        // $tgl_dari = $request->tgl_dari;
        // $tgl_sampai = $request->tgl_sampai;

        $tgl_ar  = [];

        for ($tgl = $tgl_dari->copy(); $tgl->lte($tgl_sampai); $tgl->addDay()) {
            $tgl_ar[] = $tgl->format('Y-m-d');
        }

        // dd($tgl_ar, $tgl_dari);

        $puskesmas = Puskesmas::get();

        $data = [];
        foreach ($puskesmas as $ind => $pusk) {
            $data[$ind]['nama'] = $pusk->nama;
            $data[$ind]['total'] = Riwayat::where('id_user', $pusk->id + 1)
                ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                ->get()
                ->count();
            foreach ($tgl_ar as $v_ta) {
                $data[$ind]['per_tgl'][$v_ta] = Riwayat::where('id_user', $pusk->id + 1)
                    ->where('tanggal_pemeriksaan', $v_ta)
                    ->get()
                    ->count();
            }
            // $data[$ind]['per_tgl']
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


        foreach ($v_kesimpulan_hasil_pemeriksaan as $ind => $v) {
            if ($ind == 0) {
                $data[$ind]['status'] = "Proses";
                if ($role == "Puskesmas") {
                    $data[$ind]['total'] = Riwayat::where('id_user', $id_user)
                        ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                        ->where(function ($query) {
                            $query->where('kesimpulan_hasil_pemeriksaan', "")
                                ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                        })
                        ->get()
                        ->count();
                } else if ($role == "Admin") {
                    $data[$ind]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                        ->where(function ($query) {
                            $query->where('kesimpulan_hasil_pemeriksaan', "")
                                ->orWhereNull('kesimpulan_hasil_pemeriksaan');
                        })
                        ->get()
                        ->count();
                }
            }
            $data[$ind + 1]['status'] = $v;
            if ($role == "Puskesmas") {
                $data[$ind + 1]['total'] = Riwayat::where('id_user', $id_user)
                    ->whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
                    ->where('kesimpulan_hasil_pemeriksaan', $v)
                    ->get()
                    ->count();
            } else if ($role == "Admin") {
                $data[$ind + 1]['total'] = Riwayat::whereBetween('tanggal_pemeriksaan', [$request->tgl_dari, $request->tgl_sampai])
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

        $data = array_merge(
            $dt_per_jenis_pemeriksaan_bbl,
            $dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah,
            $dt_per_jenis_pemeriksaan_dewasa,
            $dt_per_jenis_pemeriksaan_lansia
        );



        return response()->json($data);
    }

    private function dt_per_jenis_pemeriksaan_bbl($role, $id_user, $ar_tgl, $tgl_dari, $tgl_sampai)
    {
        $queryBbl = Riwayat::with('pasien')->whereBetween('tanggal_pemeriksaan', [$tgl_dari, $tgl_sampai])
            ->whereHas('pasien', function ($query) {
                $query->whereRaw("DATEDIFF(tanggal_pemeriksaan, tgl_lahir) BETWEEN 0 AND 28");
            });

        if ($role == "Puskesmas") {
            $queryBbl->where('id_user', $id_user);
        }

        $data_bbl = $queryBbl->get();

        $jp_bbl = [
            'kekurangan_hormon_tiroid', 'kekurangan_enzim_d6pd', 'kekurangan_hormon_adrenal',
            'penyakit_jantung_bawaan', 'kelainan_saluran_empedu', 'pertumbuhan_bb'
        ];

        $dt_bbl = [];
        foreach ($data_bbl as $ind => $v_bbl) {
            $dt_bbl[$ind]['sasaran'] = "bbl";
            $dt_bbl[$ind]['hasil_pemeriksaan'] = json_decode($v_bbl->hasil_pemeriksaan, true);

            foreach ($jp_bbl as $v_jp_bbl) {
                $dt_bbl[$ind][$v_jp_bbl] = 0;
            }
            if (is_array($dt_bbl[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt_bbl[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp_bbl as $v_jp_bbl) {
                        // if (!isset($dt_bbl[$ind][$v_jp_bbl])) {
                        //     $dt_bbl[$ind][$v_jp_bbl] = 0;
                        // }

                        if (isset($item[$v_jp_bbl]) && $item[$v_jp_bbl] !== null) {
                            $dt_bbl[$ind][$v_jp_bbl] = 1;
                        }
                    }
                }
            } else {
                foreach ($jp_bbl as $v_jp_bbl) {
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
                'no' => $ind + 1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal_bbl
            ];
        }

        foreach ($dt_bbl as $item) {
            foreach ($total_jenis_pemeriksaan_bbl as $ind => $t_bbl) {
                if ($item[$t_bbl['jenis_pemeriksaan']] == 1) {
                    $total_jenis_pemeriksaan_bbl[$ind]['total']++;
                    $total_jenis_pemeriksaan_bbl[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan_bbl;
    }

    private function dt_per_jenis_pemeriksaan_balita_dan_pra_sekolah($ar_tgl, $tgl_dari, $tgl_sampai, $data)
    {
        $jp = [
            // 'indeks_pbu_tbu',
            'indeks_bbpb_bbtb',
            // 'indeks_bbu',
            'perkembangan',
            'tuberkulosis', 'telinga', 'pupil_putih', 'gigi', 'talasemia', 'gula_darah'
        ];

        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "balita_dan_pra_sekolah";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);

            foreach ($jp as $v_jp) {
                $dt[$ind][$v_jp] = 0;
            }
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        // if (!isset($dt[$ind][$v_jp])) {
                        //     $dt[$ind][$v_jp] = 0;
                        //     // $dt[$ind][$v_jp] = [];
                        // }

                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        } else {
                            $dt[$ind][$v_jp] = 0;
                        }
                    }
                }
            } else {
                foreach ($jp as $v_jp) {
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
                'no' => $ind + 1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach ($total_jenis_pemeriksaan as $ind => $t) {
                if ($item[$t['jenis_pemeriksaan']] == 1) {
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }

    private function dt_per_jenis_pemeriksaan_dewasa($ar_tgl, $tgl_dari, $tgl_sampai, $data)
    {
        $jp = [
            'merokok', 'aktivitas_fisik', 'status_gizi', 'gigi', 'tekanan_darah',
            'gula_darah', 'risiko_stroke', 'risiko_jantung', 'fungsi_ginjal',
            'tuberkulosis', 'ppok', 'kanker_payudara', 'kanker_leher_rahim',
            'kanker_paru', 'kanker_usus', 'tes_penglihatan', 'tes_pendengaran',
            'edps', 'phq', 'hepatits_b', 'hepatitis_c', 'fibrosis_sirosis',
            'anemia', 'sifilis', 'hiv'
        ];

        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "dewasa";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);

            foreach ($jp as $v_jp) {
                $dt[$ind][$v_jp] = 0;
            }
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        // if (!isset($dt[$ind][$v_jp])) {
                        //     $dt[$ind][$v_jp] = 0;
                        //     // $dt[$ind][$v_jp] = [];
                        // }

                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        }
                    }
                }
            } else {
                foreach ($jp as $v_jp) {
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
                'no' => $ind + 1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach ($total_jenis_pemeriksaan as $ind => $t) {
                if ($item[$t['jenis_pemeriksaan']] == 1) {
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }

    private function dt_per_jenis_pemeriksaan_lansia($ar_tgl, $tgl_dari, $tgl_sampai, $data)
    {
        $jp = [
            'gejala_depresi', 'merokok', 'aktivitas_fisik', 'status_gizi',
            'gigi', 'tekanan_darah', 'gula_darah', 'risiko_stroke', 'risiko_jantung',
            'fungsi_ginjal', 'tuberkulosis', 'ppok', 'kanker_payudara', 'kanker_leher_rahim',
            'kanker_paru', 'kanker_usus', 'tes_penglihatan', 'tes_pendengaran',
            'gejala_depresi', 'hepatits_b', 'hepatitis_c', 'fibrosis_sirosis',

        ];

        $dt = [];
        foreach ($data as $ind => $v) {
            $dt[$ind]['sasaran'] = "lansia";
            $dt[$ind]['hasil_pemeriksaan'] = json_decode($v->hasil_pemeriksaan, true);

            foreach ($jp as $v_jp) {
                $dt[$ind][$v_jp] = 0;
            }
            if (is_array($dt[$ind]['hasil_pemeriksaan'])) {
                foreach ($dt[$ind]['hasil_pemeriksaan'] as $item) {
                    foreach ($jp as $v_jp) {
                        // if (!isset($dt[$ind][$v_jp])) {
                        //     $dt[$ind][$v_jp] = 0;
                        //     // $dt[$ind][$v_jp] = [];
                        // }

                        if (isset($item[$v_jp]) && $item[$v_jp] !== null) {
                            $dt[$ind][$v_jp] = 1;
                            // dd($v);
                            // $dt[$ind][$v_jp][] = $v;
                            // dd($dt);
                        }
                    }
                }
            } else {
                foreach ($jp as $v_jp) {
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
                'no' => $ind + 1,
                'total' => 0,
                'per_tgl' => $total_per_tanggal
            ];
        }

        foreach ($dt as $item) {
            foreach ($total_jenis_pemeriksaan as $ind => $t) {
                if ($item[$t['jenis_pemeriksaan']] == 1) {
                    $total_jenis_pemeriksaan[$ind]['total']++;
                    $total_jenis_pemeriksaan[$ind]['per_tgl'][$item['tgl']]++;
                }
            }
        }

        return $total_jenis_pemeriksaan;
    }
}
