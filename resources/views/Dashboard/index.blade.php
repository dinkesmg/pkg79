<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semar PKG79</title>
    <link rel="icon" href="{{ asset('logo_semarpkg79.png')}}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.header')
</head>
<style>
    .c_periode_sampai {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .c_jenis_kelamin {
        display: flex;
        margin-top: 7px;
    }

    .c_diagram_pie_jenis_kelamin {
        width: 80%;
    }

    .spinner-svg {
        width: 1rem;
        /* Ukuran kecil */
        height: 1rem;
        animation: spin 1s linear infinite;
        /* Animasi putar */
    }

    .card-shadow:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease-in-out;
    }

    .card-hasil:hover {
        background-color: #e5e7eb;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .c_periode_sampai {
            display: block;
            margin: 0 auto;
            align-items: center;
            margin-bottom: 10px;
        }

        .c_jenis_kelamin {
            display: block;
            width: 100%;
            margin-top: 0;
            margin-bottom: 0;
        }

        .c_diagram_pie_jenis_kelamin {
            width: 100%;
        }
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('layouts.sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="card" style="margin-bottom:0">
                                <div class="card-header" style="display:flex; align-items:center; justify-content:center">
                                    <!-- <i class="fa-solid fa-chart-area fa-bounce mr-1"></i> -->
                                    <h5 class="m-0">Dashboard</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="c_periode_sampai">
                                        <div style="display:flex; margin-right:10px; justify-content:center">
                                            <div style="margin-right:10px">Periode</div>
                                            <input type="date" id="dari"></input>
                                        </div>
                                        <div style="display:flex; margin-right:10px; justify-content:center">
                                            <div style="margin-right:10px">Sampai</div>
                                            <input type="date" id="sampai"></input>
                                        </div>
                                        <button id="btnCari" class="btn btn-sm btn-info" onclick="oc_cari()">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div id="loading_grafik_periode" style="text-align:center; display:none;">
                                    <img src="{{ asset('loading.gif') }}" alt="Loading..." width="80">
                                </div>
                                <div id="id_grafik_per_periode"></div>
                            </div>
                        </div>
                    </div>
                    <div class="small-box bg-yellow" style="width:100%">
                        <div class="inner text-center">
                            <p>Total Kunjungan Pasien : </p>
                            <div id="loading_total_kunjungan_pasien" style="text-align:center; display:none;">
                                <img src="{{ asset('loading.gif') }}" alt="Loading..." width="80">
                            </div>
                            <h3 id="total_kunjungan_pasien"></h3>
                        </div>
                    </div>

                    <div class="my-5">
                        <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4>
                        <h5 class="text-center bg-primary py-1">Kardiovaskular</h5>
                        <div>
                            <div class="row">
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="tekanan_darah" data-idInstrumen="9">
                                        <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Tekanan Darah
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-tekanan-darah">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                        <span class="mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg>
                                                        </span>
                                                        Tidak Hipertensi atau Prehipertensi: <span id="td-tidak-hipertensi">0</span>
                                                    </p>
                                                    <p>
                                                        <span class="mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg>
                                                        </span>
                                                        Hipertensi tanpa tanda bahaya: <span id="td-hipertensi-tanpa-bahaya">0</span>
                                                    </p>
                                                    <p>
                                                        <span class="mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg>
                                                        </span>
                                                        Hipertensi dengan tanda bahaya: <span id="td-hipertensi-dengan-bahaya">0</span>
                                                    </p>
                                                </div>

                                                <div class="progress">
                                                    <div id="progress-td-tidak-hipertensi" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-td-hipertensi-tanpa-bahaya" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-td-hipertensi-dengan-bahaya" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="gula_darah">
                                        <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Gula Darah
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-gula-darah">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                        <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Normal (GDS < 100): <span id="gd-normal">0</span>
                                                    </p>

                                                    <p>
                                                        <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Prediabetes (140 - 199): <span id="gd-prediabetes">0</span>
                                                    </p>

                                                    <p>
                                                        <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Hiperglikemia (GDS < 200): <span id="gd-hiperglikemia">0</span>
                                                    </p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-gd-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-gd-prediabetes" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-gd-hiperglikemia" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="status_gizi">
                                        <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Status Gizi
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-status-gizi">0</span>Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Normal: <span id="sg-normal">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Overweight: <span id="sg-overweight">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Underrweight: <span id="sg-underweight">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Obesitas: <span id="sg-obesitas">0</span></p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-sg-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-sg-overweight" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-sg-underweight" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-sg-obesitas" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="merokok">
                                            <div class="card card-shadow text-dark" style="height: 240px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Merokok
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-merokok">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Tidak Merokok: <span id="tidak-merokok">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Merokok: <span id="merokok">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-tidak-merokok" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-merokok" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="aktivitas_fisik">
                                            <div class="card card-shadow text-dark" style="height: 240px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Aktivitas Fisik
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-aktivitas-fisik">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Cukup: <span id="af-cukup">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Kurang: <span id="af-kurang">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-af-cukup" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-af-kurang" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="gigi">
                                        <div class="card card-shadow text-dark" style="height: 240px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Gigi
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-gigi">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                        <span class="mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg>
                                                        </span>
                                                        Tidak ada karies (normal): <span id="gg-normal">0</span>
                                                    </p>
                                                    <p>
                                                        <span class="mr-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg>
                                                        </span>
                                                        Ada karies, gigi goyang: <span id="gg-karies">0</span>
                                                    </p>
                                                </div>

                                                <div class="progress">
                                                    <div id="progress-gg-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-gg-karies" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="risiko_jantung">
                                        <div class="card card-shadow text-dark" style="height: 240px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Risiko Jantung
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-risiko-jantung">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                        <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>EKG Normal: <span id="rj-normal">0</span>
                                                    </p>

                                                    <p>
                                                        <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>EKG Tidak normal: <span id="rj-tidak-normal">0</span>
                                                    </p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-rj-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rj-tidak-normal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <a class="linkRiwayat" data-instrumen="fungsi_ginjal">
                                        <div class="card card-shadow text-dark" style="height: 240px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Fungsi Ginjal
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-fungsi-ginjal">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Normal: <span id="fg-normal">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                <circle cx="8" cy="8" r="8" />
                                                            </svg></span>Tidak normal: <span id="fg-tidak-normal">0</span></p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-fg-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-fg-tidak-normal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 p-2">
                                    <a class="linkRiwayat" data-instrumen="risiko_Stroke">
                                        <div class="card card-shadow text-dark" style="height: 280px; height: auto; min-height: 280px;">
                                            <div class="card-body card-hasil">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Risiko Stroke
                                                </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-risiko-stroke">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div class="d-flex justify-content-start flex-md-row flex-column">
                                                    <div class="mr-3">
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Normal: <span id="rs-normal">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Tinggi: <span id="rs-tinggi">0</span>
                                                        </p>

                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang: <span id="rs-ptm-rendah">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi: <span id="rs-ptm-sedang">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="gray" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah: <span id="rs-ptm-tinggi">0</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="progress">
                                                    <div id="progress-rs-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rs-tinggi" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rs-ptm-rendah" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rs-ptm-sedang" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rs-ptm-tinggi" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col p-2">
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-info py-1">Fungsi Indera</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-lg-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="tes_penglihatan">
                                            <div class="card card-shadow text-dark" style="height: 260px; height: auto; min-height: 260px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Mata (Tes Penglihatan)
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-tes-penglihatan">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Visus (6/6 - 6/12): <span id="tm-visus-66-612">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Abnormal (Visus < 6/12): <span id="tm-abnormal">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Visus Membaik: <span id="tm-visus-membaik">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Visus Membaik: <span id="tm-visus-tidak-membaik">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-tm-visus-66-612" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tm-abnormal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tm-visus-membaik" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tm-visus-tidak-membaik" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="tes_pendengaran">
                                            <div class="card card-shadow text-dark" style="height: 260px; height: auto; min-height: 260px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Telinga (Tes Pendengaran)
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-tes-pendengaran">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Lulus: <span id="tt-lulus">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Tidak lulus (Hasil normal): <span id="tt-tidak-lulus-normal">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Tidak lulus (ditemukan gangguan atau kelainan): <span id="tt-tidak-lulus-gangguan">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-tt-lulus" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tt-tidak-lulus-normal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tt-tidak-lulus-gangguan" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-success py-1">Kanker</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="kanker_leher_rahim">
                                            <div class="card card-shadow text-dark" style="height: 340px; height: auto; min-height: 340px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kanker Leher Rahim
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kanker-leher_rahim">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Tidak ada faktor resiko: <span id="kl-tidak-ada-faktor">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif: <span id="kl-ada-faktor-semua-negatif">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif: <span id="kl-ada-faktor-salah-satu-negatif">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Curiga kanker: <span id="kl-curiga-kanker">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-kl-tidak-ada-faktor" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kl-ada-faktor-semua-negatif" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kl-ada-faktor-salah-satu-negatif" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kl-curiga-kanker" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="kanker_payudara">
                                            <div class="card card-shadow text-dark" style="height: 340px; height: auto; min-height: 340px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kanker Payudara
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kanker-payudara">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Sadanis Negatif: <span id="kp-negatif">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Sadanis Positif pemeriksaan USG Normal: <span id="kp-positif-usg-normal">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Sadanis Positif pemeriksaan USG Simple Cyst: <span id="kp-positif-usg-simple-cyst">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Sadanis Positif pemeriksaan USG Non Simple cyst: <span id="kp-positif-usg-non-symple-cyst">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="grey" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Sadanis Positif resiko sangat tinggi: <span id="kp-positif-resiko-tinggi">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-kp-negatif" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kp-positif-usg-normal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kp-positif-usg-simple-cyst" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kp-positif-usg-non-symple-cyst" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kp-positif-resiko-tinggi" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="kanker_paru">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kanker Paru
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kanker-paru">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Risiko ringan: <span id="kp-risiko-ringan">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Risiko sedang atau tinggi: <span id="kp-risiko-sedang-tinggi">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-kp-risiko-ringan" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kp-risiko-sedang-tinggi" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="kanker_usus">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kanker Usus
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kanker-usus">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                APCS 0-1 Risiko rendah: <span id="ku-risiko-rendah">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                APCS 2-3 Risiko sedang: <span id="ku-risiko-sedang">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua: <span id="ku-risiko-tinggi-negatif-semua">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif: <span id="ku-risiko-rendah-salah-satu-positif">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-ku-risiko-rendah" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ku-risiko-sedang" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ku-risiko-tinggi-negatif-semua" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ku-risiko-rendah-salah-satu-positif" class="progress-bar bg-green" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-secondary py-1">Paru</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-8 p-2">
                                        <a class="linkRiwayat" data-instrumen="tuberkulosis">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Tuberkulosis
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-tuberkulosis">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Tidak terdapat tanda, gejala dan Kontak erat TB: <span id="tb-tidak-terdapat">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Terdapat kontak erat TB Positif tanpa gejala: <span id="tb-terdapat-positif-tanpa-gejala">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Terdapat kontak erat TB positif dengan gejala: <span id="tb-terdapat-dengan-gejala">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-tb-tidak-terdapat" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tb-terdapat-positif-tanpa-gejala" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-tb-terdapat-dengan-gejala" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-warning py-1">Jiwa</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-lg-12 col-lg-8 p-2">
                                        <a class="linkRiwayat" data-instrumen="kesehatan_jiwa">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kesehatan Jiwa
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kesehatan-jiwa">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div class="d-flex justify-content-around">
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Normal: <span id="kj-normal">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Tidak ada gangguan jiwa: <span id="kj-tidak-ada-gangguan">0</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Ada gangguan jiwa: <span id="kj-ada-gangguan">0</span>
                                                            </p>
                                                            <p>
                                                                <span class="mr-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8" />
                                                                    </svg>
                                                                </span>
                                                                Ada gangguan jiwa dengan penyulit: <span id="kj-ada-gangguan-penyulit">0</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-kj-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kj-tidak-ada-gangguan" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kj-ada-gangguan" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-kj-ada-gangguan-penyulit" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-4"></div>
                                    <!-- <div class="col"></div> -->
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-primary py-1">Hati</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="hepatitis_b">
                                            <div class="card card-shadow text-dark" style="height: 260px; height: auto; min-height: 260px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Hepatitis B
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-hepatitis-b">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            HBsAg Non Reaktif: <span id="hb-non-reaktif">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            HBsAg Reaktif: <span id="hb-reaktif">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-hb-non-reaktif" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-hb-reaktif" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="hepatitis_c">
                                            <div class="card card-shadow text-dark" style="height: 260px; height: auto; min-height: 260px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Hepatitis C
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-hepatitis-c">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Anti HCV Non Reaktif: <span id="hc-non-reaktif">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Anti HCV Reaktif: <span id="hc-reaktif">0</span>
                                                        </p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-hc-non-reaktif" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-hc-reaktif" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col p-2">
                                        <a class="linkRiwayat" data-instrumen="fibrosis_sirosis">
                                            <div class="card card-shadow text-dark" style="height: 260px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Fibrosis/Sirosis
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-fibrosis-sirosis">0</span>Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>APRI Score ≤ 0.5: <span id="fs-kurang">0</span></p>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>APRI Score >0.5: <span id="fs-lebih">0</span></p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-fs-kurang" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                        <div id="progress-fs-lebih" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-info py-1">Bayi Baru Lahir</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="pertumbuhan_bb">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Pertumbuhan (BB)
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-pertumbuhan-bb">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            BB Lahir >= 2500 gr: <span id="pb-lebih-2500">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            BBLR (2000 - < 2500 gr) dan sehat: <span id="pb-200-2500-sehat">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            BBLR (2000 - < 2500 gr) dan sakit: <span id="pb-200-2500-sakit">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            BBLR < 2000 gr: <span id="pb-kurang-2000">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-pb-lebih-2500" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-pb-200-2500-sehat" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-pb-200-2500-sakit" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-pb-kurang-2000" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 p-2">
                                        <a class="linkRiwayat" data-instrumen="penyakit_jantung_bawaan">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Penyakit Jantung Bawaan Kritis
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-penyakit-jantung_bawaan">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>>95%, Perbedaan < 3% di tangan kanan dan kaki: <span id="pj-lebih-90">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>90-95% atau perbedaan >3% di tangan dan kaki: <span id="pj-lebih-90-95">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>
                                                            < 90%: <span id="pj-kurang-90">0</span>
                                                        </p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-pj-lebih-90" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-pj-lebih-90-95" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-pj-kurang-90" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col p-2">
                                        <a class="linkRiwayat" data-instrumen="kekurangan_hormon_tiroid">
                                            <div class="card card-shadow text-dark" style="height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kekurangan Hormon Tiroid Sejak Lahir (TSHS)
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kekurangan-hormon_tiroid">0</span>Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>TSH Normal: <span id="ht-normal">0</span></p>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>TSH Tinggi: <span id="ht-tinggi">0</span></p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-ht-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                        <div id="progress-ht-tinggi" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="kekurangan_enzim_d6pd">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kekurangan Enzim Pelindung Sel Darah Merah (D6PD)
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kekurangan-enzim_d6pd">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Negatif: <span id="ed-negatif">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Positif: <span id="ed-positif">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-ed-negatif" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ed-positif" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="kekurangan_hormon_adrenal">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kekurangan Hormon Adrenal Sejak Lahir
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kekurangan-hormon_adrenal">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Negatif: <span id="ha-negatif">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Positif: <span id="ha-positif">0</span>
                                                        </p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-ha-negatif" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ha-positif" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="kelainan_saluran_empedu">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Kelainan Saluran Empedu
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-kelainan-saluran_empedu">0</span>Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Warna tinja Normal: <span id="se-normal">0</span></p>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Warna tinja Pucat: <span id="se-pucat">0</span></p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-se-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                        <div id="progress-se-pucat" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-info py-1">Lanjut Usia</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="ppok">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        PPOK
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-ppok">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Resiko rendah (PUMA < 6): <span id="po-rendah">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Resiko tinggi (PUMA >= 6): <span id="po-tinggi">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-po-rendah" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-po-tinggi" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="gangguan_penglihatan">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Gangguan Penglihatan
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-gangguan-penglihatan">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Tidak ada gangguan: <span id="gl-tidak-ada-gangguan">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ditemukan >= 1 gangguan: <span id="gl-ditemukan-gangguan">0</span>
                                                        </p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-gl-tidak-ada-gangguan" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-gl-ditemukan-gangguan" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="gangguan_penglihatan">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Gangguan Pendengaran
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-gangguan-pendengaran">0</span>Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Tidak ada gangguan: <span id="gd-tidak-ada-gangguan">0</span></p>
                                                        <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ditemukan >= 1 gangguan: <span id="gd-ditemukan-gangguan">0</span></p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-gd-tidak-ada-gangguan" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                        <div id="progress-gd-ditemukan-gangguan" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="gejala_depresi">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Gejala Depresi
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-gejala-depresi">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Tidak ada gangguan: <span id="gr-tidak-ada-gangguan">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Tidak depresi: <span id="gr-tidak-depresi">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Kemungkinan depresi: <span id="gr-kemungkinan-depresi">0</span>
                                                        </p>
                                                        <p>
                                                            <span class="mr-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg>
                                                            </span>
                                                            Depresi: <span id="gr-depresi">0</span>
                                                        </p>
                                                    </div>

                                                    <div class="progress">
                                                        <div id="progress-gr-tidak-ada-gangguan" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-gr-tidak-depresi" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-gr-kemungkinan-depresi" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-gr-gr-depresi" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-4 p-2">
                                        <a class="linkRiwayat" data-instrumen="activity_daily_living">
                                            <div class="card card-shadow text-dark" style="height: 320px; height: auto; min-height: 320px;">
                                                <div class="card-body card-hasil">
                                                    <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                        Activity Daily Living
                                                    </div>
                                                    <div class="card-text">
                                                        <p><span style="font-size: 28px" id="total-hasil-activity-daily_living">0</span> Orang</p>
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                    </div>
                                                    <div>
                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Mandiri: <span id="ad-mandiri">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ketergantungan ringan: <span id="ad-ketergantungan-ringan">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ketergantungan Sedang: <span id="ad-ketergantungan-sedang">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ketergantungan Berat: <span id="ad-ketergantungan-berat">0</span>
                                                        </p>

                                                        <p>
                                                            <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8" />
                                                                </svg></span>Ketergantungan total: <span id="ad-ketergantungan-total">0</span>
                                                        </p>
                                                    </div>
                                                    <div class="progress">
                                                        <div id="progress-ad-mandiri" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ad-ketergantungan-ringan" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ad-ketergantungan-sedang" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ad-ketergantungan-berat" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="progress-ad-ketergantungan-total" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'Admin')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h4>Total Per Puskesmas</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="idtabel" class="table table-bordered table-striped example" style="width:100%">
                                        <thead id="id_thead_total_per_puskesmas">
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- @//endif -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Per Kelompok Usia</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="small-box bg-blue" style="width:100%; margin-right:1px">
                                    <div class="inner text-center">
                                        <p>BBL</p>
                                        <h3 id="total_bbl"></h3>
                                    </div>
                                </div>
                                <div class="small-box bg-blue" style="width:100%; margin-left:1px">
                                    <div class="inner text-center">
                                        <p>Balita dan Pra Sekolah</p>
                                        <h3 id="total_balita_dan_pra_sekolah"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="small-box bg-blue" style="width:100%; margin-right:1px">
                                    <div class="inner text-center">
                                        <p>Dewasa 18-29 Tahun</p>
                                        <h3 id="total_dewasa_18_29_tahun"></h3>
                                    </div>
                                </div>
                                <div class="small-box bg-blue" style="width:100%; margin-right:1px; margin-left:1px">
                                    <div class="inner text-center">
                                        <p>Dewasa 30-39 Tahun</p>
                                        <h3 id="total_dewasa_30_39_tahun"></h3>
                                    </div>
                                </div>
                                <div class="small-box bg-blue" style="width:100%; margin-left:1px">
                                    <div class="inner text-center">
                                        <p>Dewasa 40-59 Tahun</p>
                                        <h3 id="total_dewasa_40_59_tahun"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="small-box bg-blue" style="width:100%">
                                <div class="inner text-center">
                                    <p>Lansia</p>
                                    <h3 id="total_lansia"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Total Per Jenis Pemeriksaan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="idtabel_per_jenis_pemeriksaan" class="table table-bordered table-striped example" style="width:100%">
                                <thead id="idtabel_header_per_jenis_pemeriksaan">
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Total Kesimpulan Hasil Pemeriksaan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="idtabel_kesimpulan_hasil" class="table table-bordered table-striped example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Puskesmas')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Total Pasien Faskes BPJS</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="idtabel_pasien_faskes_bpjs" class="table table-bordered table-striped example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Faskes BPJS</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    </div>
    </div>
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>

<script src="{{ asset('assets/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('assets/highcharts/modules/data.js') }}"></script>
<script src="{{ asset('assets/highcharts/modules/exporting.js') }}"></script>
<script src="{{ asset('assets/highcharts/modules/accessibility.js') }}"></script>
<script src="{{ asset('assets/highcharts/modules/map.js') }}"></script>

<script>
    document.querySelectorAll(".linkRiwayat").forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah redirect langsung

            // Ambil nilai periode dan sampai
            let dari = document.getElementById("dari").value;
            let sampai = document.getElementById("sampai").value;

            // Cek apakah tanggal diisi
            if (!dari || !sampai) {
                alert("Silakan isi periode dan sampai terlebih dahulu.");
                return;
            }

            // Ambil instrumen dari atribut data-instrumen
            let instrumen = link.getAttribute("data-instrumen");
            let id = link.getAttribute("data-idInstrumen");

            // Buat URL dengan parameter yang sesuai
            let url = `laporan?id=${id}&instrumen=${instrumen}&tgl_dari=${dari}&tgl_sampai=${sampai}`;

            // Redirect ke URL baru
            window.open(url, "_blank");
        });
    });
</script>

<script>
    var role_auth = "{{ Auth::user()->role }}"
    $(document).ready(function() {
        var currentDate = new Date();

        var formattedDate = currentDate.getFullYear() + '-' +
            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
            ('0' + currentDate.getDate()).slice(-2);

        $('#dari').val(formattedDate);
        $('#sampai').val(formattedDate);

        // grafik();
        if (role_auth == "Admin") {
            tabel_per_puskesmas()
        }
        hasil_pemeriksaan()
        grafik_per_periode()
        per_kelompok_usia()
        tabel_kesimpulan_hasil()
        tabel_per_jenis_pemeriksaan()
        // peta()
    })

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    async function oc_cari() {
        const btn = document.getElementById("btnCari");

        // Tambahkan efek loading dengan SVG spinner
        btn.innerHTML = `<img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Gray_circles_rotate.gif" class="spinner-svg"> Loading...`;
        btn.disabled = true;

        // Gunakan setTimeout agar perubahan tombol dirender lebih dulu
        setTimeout(async () => {
            try {
                let tasks = [];

                if (role_auth === "Admin") {
                    tasks.push(tabel_per_puskesmas());
                }

                tasks.push(hasil_pemeriksaan());
                tasks.push(grafik_per_periode());
                tasks.push(per_kelompok_usia());
                tasks.push(tabel_kesimpulan_hasil());
                tasks.push(tabel_per_jenis_pemeriksaan());

                // Tunggu semua fungsi selesai sebelum menghilangkan efek loading
                await Promise.all(tasks);
            } catch (error) {
                console.error("Terjadi kesalahan:", error);
            } finally {
                // Kembalikan tombol ke kondisi semula
                btn.innerHTML = "Cari";
                btn.disabled = false;
            }
        }, 100); // Beri jeda agar spinner bisa muncul sebelum tugas berjalan
    }

    function ar_x_grafik(dari, sampai) {
        var startDate = new Date(dari);
        var endDate = new Date(sampai);
        var dateArray = [];

        while (startDate <= endDate) {
            var formattedDate = startDate.getFullYear() + '-' +
                ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' +
                ('0' + startDate.getDate()).slice(-2);
            dateArray.push(formattedDate);
            startDate.setDate(startDate.getDate() + 1);
        }

        return dateArray;
    }

    function ar_x_grafik_ubah_format(dari, sampai) {
        var startDate = new Date(dari);
        var endDate = new Date(sampai);
        var dateArray = [];

        while (startDate <= endDate) {
            var formattedDate = ('0' + startDate.getDate()).slice(-2) + '-' +
                ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' +
                startDate.getFullYear();
            dateArray.push(formattedDate);
            startDate.setDate(startDate.getDate() + 1);
        }

        return dateArray;
    }

    function grafik_per_periode() {
        var dari = $('#dari').val()
        var sampai = $('#sampai').val()
        var x_grafik = ar_x_grafik(dari, sampai);
        var x_grafik_format = ar_x_grafik_ubah_format(dari, sampai);
        // console.log(x_grafik)
        // console.log(x_grafik_format)
        // $('#div_loading').css('display', 'flex').show();
        // $('#konten').hide()

        $.ajax({
            url: "{{url('dashboard/data_grafik_per_periode')}}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                // 'jenis':jenis,
                'dari': dari,
                'sampai': sampai,
                'x_grafik': x_grafik
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                $('#id_grafik_per_periode').hide();
                $('#total_kunjungan_pasien').hide();
                $('#loading_grafik_periode').show();
                $('#loading_total_kunjungan_pasien').show();
            },
            success: function(data) {
                // console.log(data.grafik)
                console.log(data)
                // console.log(jenis)
                // $('#div_loading').hide();
                // $('#konten').show()
                // var dari = $('#dari').val()
                // var sampai = $('#sampai').val()
                // var periode_format = ar_x_grafik_ubah_format(dari, sampai);
                // var ar_periode = ar_x_grafik(dari, sampai);

                // var col_tanggal = []
                // for (var i = 0; i < x_grafik.length; i++) {
                //     (function(i) {
                //         col_tanggal.push({
                //             data: i
                //         });
                //         console.log(i)
                //     })(i);
                // }

                let total_kunjungan_pasien = 0
                for (let i = 0; i < data.length; i++) {
                    total_kunjungan_pasien += data[i]
                }
                $('#total_kunjungan_pasien').text(total_kunjungan_pasien);
                // console.log(col_tanggal)

                // var semua_data = data


                Highcharts.chart('id_grafik_per_periode', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Total Kunjungan Pasien',
                    },
                    xAxis: {
                        categories: x_grafik_format,
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total Pasien'
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.1,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Total Pasien',
                        color: '#ffc107',
                        data: data
                    }, ]
                });

                // var dt = data
                // var total_pasien = dt.length
                // var total_pasien_msn = 0
                // if(total_pasien!=0){
                //     total_pasien_msn = dt.filter(item => item.msn != null && item.msn !="null").length;
                //     diagram_pie_total_pasien_dan_pasien_msn(dt);
                // }
                // var persen_total_pasien_msn = (total_pasien_msn/total_pasien)*100
                // persen_total_pasien_msn = persen_total_pasien_msn.toFixed(2);
                // persen_total_pasien_msn = parseFloat(persen_total_pasien_msn);

                // // console.log(total_pasien)
                // $('#total_pasien').html(total_pasien);
                // $('#total_pasien_msn').html(total_pasien_msn+" ("+persen_total_pasien_msn+" %)");

                // kelompok_umur(data)
                // deteksi_dini(data)
                // tempat_pemeriksaan(data)
                // tabel(data)
                $('#loading_grafik_periode').hide();
                $('#loading_total_kunjungan_pasien').hide();
                $('#id_grafik_per_periode').show();
                $('#total_kunjungan_pasien').show();
            }
        })
    }

    function tabel_per_puskesmas() {
        if ($.fn.DataTable.isDataTable("#idtabel")) {
            $("#idtabel").DataTable().destroy();
            // $("#idtabel").empty(); // ✅ Remove old table content
        }
        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        let x_grafik = ar_x_grafik(tgl_dari, tgl_sampai);
        let x_grafik_format = ar_x_grafik_ubah_format(tgl_dari, tgl_sampai);

        let html_header =
            '<tr>\
                <th>No</th>\
                <th>Nama</th>\
                <th>Total</th>';
        x_grafik_format.forEach(tgl => {
            html_header += `<th>${tgl}</th>`;
        });
        html_header += `</tr>`;

        $('#id_thead_total_per_puskesmas').html(html_header);

        let col = [{
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                // 'data': 'nama',
                // 'width': "150px"
                data: "nama",
                title: "Nama",
                // width: "150px"

            },
            {
                // 'data': 'total',
                // 'width': '150px'
                data: "total",
                title: "Total",
                // width: "150px"
            },
        ]

        x_grafik.forEach(tgl => {
            let format_tgl = tgl.split("-").reverse().join("-");

            col.push({
                data: `per_tgl.${tgl}`, // ✅ Matches JSON structure
                // title: format_tgl,
                // width: "100px", // ✅ Ensures proper width assignment
                defaultContent: "-",
                render: function(data, type, row) {
                    // console.log(row.per_tgl[tgl])
                    return row.per_tgl && row.per_tgl[tgl] != undefined ? row.per_tgl[tgl] : "-";
                }
            });
        });

        console.log(col)


        $('#idtabel').dataTable({
            destroy: true,
            scrollX: true,
            ajax: {
                url: "{{url('dashboard/data_per_puskesmas')}}",
                type: "GET",
                data: function(d) {
                    d.tgl_dari = $('#dari').val();
                    d.tgl_sampai = $('#sampai').val();
                },
                dataSrc: '',
            },
            columns: col,
            dom: 'Bfrtip',
            // buttons: [{
            //     extend: 'excelHtml5',
            //     title: 'Data Per Puskesmas',
            //     className: 'btn btn-success',
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // }]
            buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-success',
                text: 'Export Excel',
                title: null, // Kosongkan agar tidak pakai <title> tag dari dokumen
                filename: function() {
                    const tglDari = $('#dari').val().split('-').reverse().join('-');     // dd-mm-yyyy
                    const tglSampai = $('#sampai').val().split('-').reverse().join('-'); // dd-mm-yyyy

                    const now = new Date();
                    const pad = n => n.toString().padStart(2, '0');

                    const cutOffDate = `${pad(now.getDate())}-${pad(now.getMonth() + 1)}-${now.getFullYear()}`;
                    const jam = `${pad(now.getHours())}.${pad(now.getMinutes())}`;

                    return `Data_Per_Puskesmas_${tglDari}_${tglSampai}_CutOff_${cutOffDate}_${jam}`;
                },
                exportOptions: {
                    columns: ':visible'
                }
            }]
        });
    }

    const idMapping = {
        "tekanan_darah": {
            "Tidak terdiagnosis Hipertensi atau prehipertensi": "td-tidak-hipertensi",
            "Terdiagnosis hipertensi tanpa tanda bahaya": "td-hipertensi-tanpa-bahaya",
            "Terdiagnosis hipertensi dengan tanda bahaya": "td-hipertensi-dengan-bahaya"
        },
        "gula_darah": {
            "Normal (GDS<100)": "gd-normal",
            "Prediabetes (GDS 140 - 199)": "gd-prediabetes",
            "Hiperglikemia (GDS > 200)": "gd-hiperglikemia"
        },
        "status_gizi": {
            "Normal": "sg-normal",
            "Overweight": "sg-overweight",
            "Underweight": "sg-underweight",
            "Obesitas": "sg-obesitas"
        },
        "merokok": {
            "Tidak merokok": "tidak-merokok",
            "Merokok": "merokok"
        },
        "aktivitas_fisik": {
            "Cukup": "af-cukup",
            "Kurang": "af-kurang"
        },
        "gigi": {
            "Tidak ada karies (normal)": "gg-normal",
            "Ada karies, gigi goyang": "gg-karies"
        },
        "risiko_stroke": {
            "Normal": "rs-normal",
            "Tinggi": "rs-tinggi",
            "Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah": "rs-ptm-rendah",
            "Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang": "rs-ptm-sedang",
            "Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi": "rs-ptm-tinggi"
        },
        "risiko_jantung": {
            "EKG Normal": "rj-normal",
            "EKG Tidak normal": "rj-tidak-normal"
        },
        "fungsi_ginjal": {
            "Normal": "fg-normal",
            "Tidak normal": "fg-tidak-normal"
        },

    };

    const idMappingFungsiIndera = {
        "tes_penglihatan": {
            "Visus (6\/6 - 6\/12)": "tm-visus-66-612",
            "Abnormal (Visus <6\/12)": "tm-abnormal",
            "Visus membaik": "tm-visus-membaik",
            "Visus tidak membaik": "tm-visus-tidak-membaik"
        },
        "tes_pendengaran": {
            "Lulus": "tt-lulus",
            "Tidak lulus (Hasil normal)": "tt-tidak-lulus-normal",
            "Tidak lulus (ditemukan gangguan atau kelainan)": "tt-tidak-lulus-gangguan"
        }
    }

    const idMappingKanker = {
        "kanker_leher_rahim": {
            "Tidak ada faktor resiko": "kl-tidak-ada-faktor",
            "Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif": "kl-ada-faktor-semua-negatif",
            "Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif": "kl-ada-faktor-salah-satu-negatif",
            "Curiga kanker": "kl-curiga-kanker"
        },
        "kanker_payudara": {
            "Sadanis Negatif": "kp-negatif",
            "Sadanis Positif pemeriksaan USG Normal": "kp-positif-usg-normal",
            "Sadanis Positif pemeriksaan USG Simple Cyst": "kp-positif-usg-simple-cyst",
            "Sadanis Positif pemeriksaan USG Non Simple cyst": "kp-positif-usg-non-symple-cyst",
            "Sadanis Positif resiko sangat tinggi": "kp-positif-resiko-tinggi"
        },
        "kanker_paru": {
            "Risiko ringan": "kp-risiko-ringan",
            "Risiko sedang atau tinggi": "kp-risiko-sedang-tinggi"
        },
        "kanker_usus": {
            "APCS 0-1 Risiko rendah": "ku-risiko-rendah",
            "APCS 2-3 Risiko sedang": "ku-risiko-sedang",
            "APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua": "ku-risiko-tinggi-negatif-semua",
            "APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif": "ku-risiko-rendah-salah-satu-positif"
        }
    }

    const idMappingParu = {
        "tuberkulosis": {
            'Tidak terdapat tanda, gejala dan Kontak erat TB': "tb-tidak-terdapat",
            'Terdapat kontak erat TB Positif tanpa gejala': "tb-terdapat-positif-tanpa-gejala",
            'Terdapat kontak erat TB positif dengan gejala': "tb-terdapat-dengan-gejala"
        }
    }

    const idMappingJiwa = {
        "kesehatan_jiwa": {
            "Normal": "kj-normal",
            "Tidak ada gangguan jiwa": "kj-tidak-ada-gangguan",
            "Ada gangguan jiwa": "kj-ada-gangguan",
            "Ada gangguan jiwa dengan penyulit": "kj-ada-gangguan-penyulit"
        }
    }

    const idMappingHati = {
        "hepatitis_b": {
            "HBsAg Non Reaktif": "hb-non-reaktif",
            "HBsAg Reaktif": "hb-reaktif"
        },
        "hepatitis_c": {
            "Anti HCV Non Reaktif": "hc-non-reaktif",
            "Anti HCV Reaktif": "hc-reaktif"
        },
        "fibrosis_sirosis": {
            "APRI Score ≤ 0.5": "fs-kurang",
            "APRI Score >0.5": "fs-lebih"
        }
    }

    const idMappingBbl = {
        "pertumbuhan_bb": {
            "BB Lahir \u2265 2500 gr": "pb-lebih-2500",
            "BBLR (2000 - < 2500 gr) dan sehat": 'pb-200-2500-sehat',
            "BBLR (2000 - <2500 gr) dan sakit": 'pb-200-2500-sakit',
            "BBLR < 2000 gr": 'pb-kurang-2000'
        },
        "penyakit_jantung_bawaan": {
            ">95%, Perbedaan <3% di tangan kanan dan kaki": 'pj-lebih-90',
            "90-95% atau perbedaan >3% di tangan dan kaki": 'pj-lebih-90-95',
            "<90%": 'pj-kurang-90'
        },
        "kekurangan_hormon_tiroid": {
            "TSH Normal": 'ht-normal',
            "TSH Tinggi": 'ht-tinggi'
        },
        "kekurangan_enzim_d6pd": {
            "Negatif": 'ed-negatif',
            "Positif": 'ed-positif'
        },
        "kekurangan_hormon_adrenal": {
            "Negatif": 'ha-negatif',
            "Positif": 'ha-positif'
        },
        "kelainan_saluran_empedu": {
            "Warna tinja Normal": 'se-normal',
            "Warna tinja Pucat": 'se-pucat'
        }
    }

    const idMappingLanjutUsia = {
        "ppok": {
            "Resiko rendah (PUMA < 6)": 'po-rendah',
            "Resiko tinggi (PUMA \u2265 6)": 'po-tinggi'
        },
        "gangguan_penglihatan": {
            "Tidak ada gangguan": 'gl-tidak-ada-gangguan',
            "Ditemukan \u22651 gangguan": 'gl-ditemukan-gangguan'
        },
        "gangguan_pendengaran": {
            "Tidak ada gangguan": 'gd-tidak-ada-gangguan',
            "Ditemukan \u22651 gangguan": 'gd-ditemukan-gangguan'
        },
        "gejala_depresi": {
            "Tidak ada gangguan": 'gr-tidak-ada-gangguan',
            "Tidak depresi": 'gr-tidak-depresi',
            "Kemungkinan depresi": "gr-kemungkinan-depresi",
            "Depresi": "gr-depresi"
        },
        "activity_daily_living": {
            "Mandiri": 'ad-mandiri',
            "Ketergantungan ringan": 'ad-ketergantungan-ringan',
            "Ketergantungan Sedang": 'ad-ketergantungan-sedang',
            "Ketergantungan Berat": 'ad-ketergantungan-berat',
            "Ketergantungan total": 'ad-ketergantungan-total'
        }
    }

    function hasil_pemeriksaan() {
        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        $.ajax({
            url: `{{url('dashboard/data_hasil_pemeriksaan')}}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tgl_dari,
                tgl_sampai
            },
            success: function(response) {
                console.log("API Response:", response);

                if (!response.kardiovaskular) {
                    console.error("Data kardiovaskular tidak ditemukan!");
                    return;
                }

                if (!response.fungsi_indera) {
                    console.error("Data fungsi_indera tidak ditemukan!");
                    return;
                }

                if (!response.kanker) {
                    console.error("Data kanker tidak ditemukan!");
                    return;
                }

                // 🔹 Memproses Data Kardiovaskular
                Object.keys(idMapping).forEach(category => {
                    let data = response.kardiovaskular[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMapping[category]).forEach(key => {
                        let elementId = idMapping[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                // 🔹 Memproses Data Fungsi Indera
                Object.keys(idMappingFungsiIndera).forEach(category => {
                    let data = response.fungsi_indera[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingFungsiIndera[category]).forEach(key => {
                        let elementId = idMappingFungsiIndera[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                // 🔹 Memproses Data Kanker
                Object.keys(idMappingKanker).forEach(category => {
                    let data = response.kanker[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingKanker[category]).forEach(key => {
                        let elementId = idMappingKanker[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                Object.keys(idMappingParu).forEach(category => {
                    let data = response.paru[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingParu[category]).forEach(key => {
                        let elementId = idMappingParu[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                Object.keys(idMappingJiwa).forEach(category => {
                    let data = response.jiwa[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingJiwa[category]).forEach(key => {
                        let elementId = idMappingJiwa[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                Object.keys(idMappingHati).forEach(category => {
                    let data = response.hati[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingHati[category]).forEach(key => {
                        let elementId = idMappingHati[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                Object.keys(idMappingBbl).forEach(category => {
                    let data = response.bbl[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingBbl[category]).forEach(key => {
                        let elementId = idMappingBbl[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                Object.keys(idMappingLanjutUsia).forEach(category => {
                    let data = response.lanjut_usia[category] || {};
                    let total = Object.values(data).reduce((a, b) => a + b, 0);
                    let totalId = `#total-hasil-${category.replace('_', '-')}`;

                    if ($(totalId).length > 0) {
                        $(totalId).text(total.toLocaleString('id-ID'));
                    } else {
                        console.warn(`⚠ ID total tidak ditemukan: ${totalId}`);
                    }

                    Object.keys(idMappingLanjutUsia[category]).forEach(key => {
                        let elementId = idMappingLanjutUsia[category][key];
                        let value = data[key] || 0;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                        if ($(`#${elementId}`).length > 0) {
                            $(`#${elementId}`).text(`${value.toLocaleString('id-ID')} (${percentage}%)`);
                        } else {
                            console.warn(`⚠ Elemen tidak ditemukan: ${elementId}`);
                        }

                        let progressBarId = `#progress-${elementId}`;
                        if ($(progressBarId).length > 0) {
                            $(progressBarId)
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage)
                                .attr('data-toggle', 'tooltip')
                                .attr('title', `${percentage}%`);
                        } else {
                            console.warn(`⚠ Progress bar tidak ditemukan: ${progressBarId}`);
                        }
                    });
                });

                // Re-initialize tooltips
                $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
            },
            error: function(xhr, status, error) {
                console.error("API Error:", status, error);
            }
        });
    }

    function per_kelompok_usia() {
        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        $.ajax({
            url: `{{url('dashboard/data_per_usia')}}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tgl_dari: $('#dari').val(),
                tgl_sampai: $('#sampai').val(),
            },
            success: function(response) {
                // console.log(response)
                // $('#bbl').val(res);
                $('#total_bbl').html(response.bbl);
                $('#total_balita_dan_pra_sekolah').html(response.balita_dan_pra_sekolah);
                $('#total_dewasa_18_29_tahun').html(response.dewasa_18_29_tahun);
                $('#total_dewasa_30_39_tahun').html(response.dewasa_30_39_tahun);
                $('#total_dewasa_40_59_tahun').html(response.dewasa_40_59_tahun);
                $('#total_lansia').html(response.lansia);

            }
        })
    }

    function tabel_per_jenis_pemeriksaan() {
        if ($.fn.DataTable.isDataTable("#idtabel_per_jenis_pemeriksaan")) {
            $("#idtabel_per_jenis_pemeriksaan").DataTable().destroy();
            $("#idtabel_per_jenis_pemeriksaan").empty(); // ✅ Remove old table content
        }
        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        let x_grafik = ar_x_grafik(tgl_dari, tgl_sampai);
        let x_grafik_format = ar_x_grafik_ubah_format(tgl_dari, tgl_sampai);

        let html_header =
            '<tr>\
                            <th>No</th>\
                            <th>Sasaran</th>\
                            <th>No</th>\
                            <th>Jenis Pemeriksaan</th>\
                            <th>Jumlah Sasaran</th>';
        x_grafik_format.forEach(tgl => {
            html_header += `<th>${tgl}</th>`;
        });
        html_header += `</tr>`;

        // console.log(html_header);

        $('#idtabel_header_per_jenis_pemeriksaan').html(html_header);

        let col = [{
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: "sasaran",
                title: "Sasaran",
                width: "150px"
            },
            {
                data: "no",
                title: "No",
                width: "50px"
            },
            {
                data: "jenis_pemeriksaan",
                title: "Jenis Pemeriksaan",
                width: "200px"
            },
            {
                data: "total",
                title: "Jumlah Sasaran",
                width: "120px"
            },

            // { data: "total", title: "Jumlah Sasaran", width: "120px" }

        ];

        x_grafik.forEach(tgl => {
            let format_tgl = tgl.split("-").reverse().join("-");

            col.push({
                data: `per_tgl.${tgl}`, // ✅ Matches JSON structure
                title: format_tgl,
                width: "100px", // ✅ Ensures proper width assignment
                defaultContent: "-",
                render: function(data, type, row) {
                    return row.per_tgl && row.per_tgl[tgl] != undefined ? row.per_tgl[tgl] : "-";
                }
            });
        });

        $("#idtabel_per_jenis_pemeriksaan").DataTable({
            destroy: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{url('dashboard/data_per_jenis_pemeriksaan')}}",
                type: "GET",
                data: function(d) {
                    d.tgl_dari = $("#dari").val();
                    d.tgl_sampai = $("#sampai").val();
                    d.ar_tgl = x_grafik;
                },
                dataSrc: function(json) {
                    // console.log("AJAX Data Response:", json);
                    // return json;
                    return json.data;
                },
            },
            columns: col,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data Per Puskesmas',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible'
                }
            }]
        });
        // }, 1000);
    }

    function tabel_kesimpulan_hasil() {
        let col = [{
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                'data': 'status'
            },
            {
                'data': 'total'
            },
        ]


        $('#idtabel_kesimpulan_hasil').dataTable({
            destroy: true,
            scrollX: true,
            ajax: {
                url: "{{url('dashboard/data_kesimpulan_hasil')}}",
                type: "GET",
                data: function(d) {
                    d.tgl_dari = $('#dari').val();
                    d.tgl_sampai = $('#sampai').val();
                },
                // dataSrc: '',
                dataSrc: function(json) {
                    let totalSum = json.reduce((sum, row) => sum + (parseInt(row.total) || 0), 0);

                    // $('#total_kunjungan_pasien').text(totalSum);

                    return json; // Return data for DataTable
                },
            },
            columns: col
        });

        tabel_pasien_faskes_bpjs()
    }

    function tabel_pasien_faskes_bpjs() {
        console.log("pasien faskes bpjs")

        let col = [{
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                'data': 'nama'
            },
            {
                'data': 'total'
            },
        ]


        $('#idtabel_pasien_faskes_bpjs').dataTable({
            destroy: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{url('dashboard/data_pasien_faskes_bpjs')}}",
                type: "GET",
                data: function(d) {
                    d.tgl_dari = $('#dari').val();
                    d.tgl_sampai = $('#sampai').val();
                    d.start = d.start || 0;
                    d.length = d.length || 10;
                },
                // dataSrc: '',
                dataSrc: function(json) {
                    console.log(json)
                    return json.data; // Return data for DataTable
                },
            },
            columns: col, 
        });

    }
</script>

</html>