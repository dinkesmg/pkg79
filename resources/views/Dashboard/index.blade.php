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
        display:flex;
        justify-content:center;
        margin-bottom:10px;
    }
    .c_jenis_kelamin {
        display: flex;
        margin-top: 7px;
    }
    .c_diagram_pie_jenis_kelamin {
        width:80%;
    }

    @media (max-width: 768px) {
        .c_periode_sampai {
            display:block;
            margin: 0 auto;
            align-items:center;
            margin-bottom:10px;
        }
        .c_jenis_kelamin {
            display: block;
            width: 100%;
            margin-top: 0;
            margin-bottom: 0;
        }

        .c_diagram_pie_jenis_kelamin {
            width:100%;
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
                                        <button class="btn btn-sm btn-info" onclick="oc_cari()"> Cari</button>
                                    </div>
                                    <!-- <div id="peta" style="min-width: 310px; height: 400px; margin: 0 auto"></div> -->
                                    <!-- <div id="div_loading" style="display: none; justify-content: center;">
                                        <img src="{{ asset('gambar/loading.gif') }}" alt="Loading..." />
                                    </div> -->
                                    <!-- <div id="konten" style="display: none;">
                                        <div id="grafik"></div>
                                        <div style="display:flex; justify-content:center">
                                            <div class="small-box bg-info" style="width:100%">
                                                <div class="inner text-center">
                                                    <h3 id="total_pasien"></h3>
                                                    <p>Total Pasien</p>
                                                </div>
                                                <a href="{{url('laporan/skrining_dasar')}}" class="small-box-footer" target="_blank">Laporan <i class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                            <div class="small-box bg-yellow" style="width:100%">
                                                <div class="inner text-center">
                                                    <h3 id="total_pasien_msn"></h3>
                                                    <p>Total Pasien MSN</p>
                                                </div>
                                                <a href="{{url('laporan/skrining_msn')}}" class="small-box-footer" target="_blank">Laporan <i class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="c_jenis_kelamin mb-3">
                                            <div class="small-box bg-blue col-sm-6 col-md-2" style="margin-top:20px">
                                                <div class="inner text-center">
                                                    <i class="ion ion-male"></i>
                                                    <p>Laki-laki</p>
                                                    <div id="persen_laki_laki"></div>
                                                    <h3 id="total_laki_laki"></h3>
                                                </div>
                                            </div>
                                            <div class="c_diagram_pie_jenis_kelamin" id="id_diagram_pie_total_pasien_dan_pasien_msn"></div>
                                            <div class="small-box bg-pink col-sm-6 col-md-2" style="margin-top:20px">
                                                <div class="inner text-center">
                                                    <i class="ion ion-female"></i>
                                                    <p>Perempuan</p>
                                                    <div id="persen_perempuan"></div>
                                                    <h3 id="total_perempuan"></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3" style="display:flex; justify-content:center; font-weight:bold; font-size:17px; background-color:#17A2B8; color:white">
                                            Kelompok Umur
                                        </div>
                                        <div style="text-align:center">
                                            <div class="row mb-3">
                                                <div class="col-sm-3 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div>0 - 1 Tahun</div>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_0_1_tahun"></h5>
                                                            <span id="persentase_umur_0_1_tahun" class="text-success"><i class="fas fa-caret-up"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div>2 - 5 Tahun</div>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_2_5_tahun"></h5>
                                                            <span id="persentase_umur_2_5_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div>6 - 10 Tahun</div>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_6_10_tahun"></h5>
                                                            <span id="persentase_umur_6_10_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <span class="description-text">11 - 19 Tahun</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_11_19_tahun"></h5>
                                                            <span id="persentase_umur_11_19_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-4 col-6" >
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <span class="description-text">20 - 44 Tahun</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_20_44_tahun"></h5>
                                                            <span id="persentase_umur_20_44_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <span class="description-text">45 - 59 Tahun</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_45_59_tahun"></h5>
                                                            <span id="persentase_umur_45_59_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                        <span class="description-text">> 60 Tahun</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 id="total_umur_60_150_tahun"></h5>
                                                            <span id="persentase_umur_60_150_tahun" class="text-success"><i class="fas fa-caret-left"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3" style="display:flex; justify-content:center; font-weight:bold; font-size:17px; background-color:#17A2B8; color:white">
                                            Deteksi Dini
                                        </div>
                                        <div id="id_imt" class="row" style="text-align:center; flex-wrap:wrap">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="card" style="height:100%">
                                                    <div class="card-header">
                                                        <div>Indeks Massa Tubuh (IMT)</div>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 id="id_total_imt"></h5>
                                                        <span id="id_total_persentase_imt" class="text-success"></span>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_imt_sangat_kurus" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Sangat Kurus</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_imt_sangat_kurus"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_imt_sangat_kurus" style="margin-right:3px; font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_imt_kurus" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Kurus</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_imt_kurus"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_imt_kurus" style="margin-right:3px; font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_imt_normal" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Normal</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_imt_normal"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_imt_normal" style="margin-right:3px; font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_imt_gemuk" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Gemuk</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_imt_gemuk"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_imt_gemuk" style="font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_imt_obesitas" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px;">Obesitas</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_imt_obesitas"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center">
                                                                <div id="id_persentase_imt_obesitas" style="font-size:15px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer" style="background-color:white">
                                                        <div id="id_progress_bar_imt" style="display:flex;  height:15px; padding:0; margin-top:auto"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="card" style="height:100%">
                                                    <div class="card-header">
                                                        <div>Tekanan Darah</div>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 id="id_total_tekanan_darah"></h5>
                                                        <span id="id_total_persentase_tekanan_darah" class="text-success"></span>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_tekanan_darah_normal" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Normal</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_tekanan_darah_normal"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_tekanan_darah_normal" style="margin-right:3px; font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_tekanan_darah_pra_hipertensi" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Pra Hipertensi</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_tekanan_darah_pra_hipertensi"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_tekanan_darah_pra_hipertensi" style="font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_tekanan_darah_hipertensi_tingkat_1" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px;">Hipertensi Tingkat 1</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_tekanan_darah_hipertensi_tingkat_1"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center">
                                                                <div id="id_persentase_tekanan_darah_hipertensi_tingkat_1" style="font-size:15px"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_tekanan_darah_hipertensi_tingkat_2" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px;">Hipertensi Tingkat 2</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_tekanan_darah_hipertensi_tingkat_2"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center">
                                                                <div id="id_persentase_tekanan_darah_hipertensi_tingkat_2" style="font-size:15px"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_tekanan_darah_hipertensi_sistolik_terisolasi" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px;">Hipertensi Sistolik Terisolasi</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_tekanan_darah_hipertensi_sistolik_terisolasi"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center">
                                                                <div id="id_persentase_tekanan_darah_hipertensi_sistolik_terisolasi" style="font-size:15px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer" style="background-color:white">
                                                        <div id="id_progress_bar_tekanan_darah" style="display:flex; align-items:center; height:15px; padding:0; margin:0"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="card" style="height:100%">
                                                    <div class="card-header">
                                                        <div>Gula Darah</div>
                                                    </div>
                                                    <div class="card-body" style="height:100%">
                                                        <h5 id="id_total_gula_darah"></h5>
                                                        <span id="id_total_persentase_gula_darah" class="text-success"></span>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_gula_darah_normal" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Normal</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_gula_darah_normal"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_gula_darah_normal" style="margin-right:3px; font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_gula_darah_pre_diabetes" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px">Pre Diabetes</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_gula_darah_pre_diabetes"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center;">
                                                                <div id="id_persentase_gula_darah_pre_diabetes" style="font-size:15px;"></div>
                                                            </div>
                                                        </div>
                                                        <div style="display:flex; align-items:center">
                                                            <i id="id_circle_gula_darah_diabetes" class="fa-solid fa-circle" style="margin-right:3px"></i>
                                                            <div style="display:flex; align-items:center;">
                                                                <div style="margin-right:3px;">Diabetes</div>
                                                                <div style="margin-right:3px">:</div>
                                                                <div id="id_total_gula_darah_diabetes"></div>
                                                            </div>
                                                            <div style="display:flex; margin-left: auto; align-items:center">
                                                                <div id="id_persentase_gula_darah_diabetes" style="font-size:15px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer" style="background-color:white">
                                                        <div id="id_progress_bar_gula_darah" style="display:flex; align-items:center; height:15px; padding:0; margin:0"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3" style="display:flex; justify-content:center; font-weight:bold; font-size:17px; background-color:#17A2B8; color:white">
                                            Tempat Pemeriksaan
                                        </div>
                                        <div class="row" id="id_tempat_pemeriksaan"></div>
                                        @if(Auth::user()->role=="Admin" || Auth::user()->role=="Bidang")
                                        <div class="mt-3" style="display:flex; justify-content:center; font-weight:bold; font-size:17px; background-color:#17A2B8; color:white">
                                            Puskesmas
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="tabel_puskesmas" class="table table-bordered table-striped example" style="width:100%">
                                                    <thead>
                                                        <tr id="id_header_tabel_puskesmas"></tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mt-3" style="display:flex; justify-content:center; font-weight:bold; font-size:17px; background-color:#17A2B8; color:white">
                                            Kelurahan Lokasi Kegiatan
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="tabel_kelurahan" class="table table-bordered table-striped example" style="width:100%">
                                                    <thead>
                                                        <tr id="id_header_tabel_kelurahan"></tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    9
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div id="id_grafik_per_periode"></div>
                            </div>
                        </div>
                    </div>
                    <div class="small-box bg-yellow" style="width:100%">
                        <div class="inner text-center">
                            <p>Total Kunjungan Pasien : </p>
                            <h3 id="total_kunjungan_pasien"></h3>
                        </div>
                    </div>

                    <div class="my-5">
                        <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4>
                        <h5 class="text-center bg-primary py-1">Kardiovaskular</h5>
                        <div>
                            <div class="row">
                                <div class="col p-2">
                                    <div class="card" style="height: 320px;">
                                        <div class="card-body">
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
                                </div>
                                <div class="col p-2" >
                                    <div class="card" style="height: 320px;">
                                        <div class ="card-body">
                                            <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                Gula Darah
                                            </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-gula-darah">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Normal (GDS < 100): <span id="gd-normal">0</span>
                                                    </p>    
                                                
                                                    <p>
                                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Prediabetes (140 - 199): <span id="gd-prediabetes">0</span>
                                                    </p>    
                                                
                                                    <p>
                                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Hiperglikemia (GDS < 200): <span id="gd-hiperglikemia">0</span>
                                                    </p>    
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-gd-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-gd-prediabetes" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-gd-hiperglikemia" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col p-2" >
                                    <div class="card" style="height: 320px;">
                                        <div class ="card-body">
                                            <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                Status Gizi
                                            </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-status-gizi">0</span>Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div> 
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Normal: <span id="sg-normal">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Overweight: <span id="sg-overweight">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Underrweight: <span id="sg-underweight">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Obesitas: <span id="sg-obesitas">0</span></p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-sg-normal" class="progress-bar bg-warning" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-sg-overweight" class="progress-bar bg-primary" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-sg-underweight" class="progress-bar bg-danger" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                        <div id="progress-sg-obesitas" class="progress-bar bg-success" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                <div class="col p-2">
                                    <div class="card" style="height: 240px;">
                                        <div class="card-body">
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
                                </div>
                                <div class="col p-2">
                                    <div class="card" style="height: 240px;">
                                        <div class="card-body">
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
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col p-2">
                                    <div class="card" style="height: 240px;">
                                        <div class="card-body">
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
                                </div>
                                <div class="col p-2" >
                                    <div class="card" style="height: 240px;">
                                        <div class ="card-body">
                                            <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                Risiko Jantung
                                            </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-risiko-jantung">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div>
                                                    <p>
                                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>EKG Normal: <span id="rj-normal">0</span>
                                                    </p>    
                                                
                                                    <p>
                                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>EKG Tidak normal: <span id="rj-tidak-normal">0</span>
                                                    </p>      
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-rj-normal" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="progress-rj-tidak-normal" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col p-2" >
                                    <div class="card" style="height: 240px;">
                                        <div class ="card-body">
                                            <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                Fungsi Ginjal
                                            </div>
                                                <div class="card-text">
                                                    <p><span style="font-size: 28px" id="total-hasil-fungsi-ginjal">0</span> Orang</p>
                                                    <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                                </div>
                                                <div> 
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="yellow" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Normal: <span id="fg-normal">0</span></p>
                                                    <p><span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="blue" class="bi bi-circle-fill" viewBox="0 0 16 16">  <circle cx="8" cy="8" r="8"/></svg></span>Tidak normal: <span id="fg-tidak-normal">0</span></p>
                                                </div>
                                                <div class="progress">
                                                    <div id="progress-fg-normal" class="progress-bar bg-warning" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                    <div id="progress-fg-tidak-normal" class="progress-bar bg-primary" role="progressbar"
                                                        style="width: 0%" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip"></div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 p-2">
                                    <div class="card" style="height: 280px;">
                                        <div class="card-body">
                                            <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                Risiko Stroke
                                            </div>
                                            <div class="card-text">
                                                <p><span style="font-size: 28px" id="total-hasil-risiko-stroke">0</span> Orang</p>
                                                <!-- <p>Lorem ipsum dolor sit amet consectetur.</p> -->
                                            </div>
                                            <div class="d-flex justify-content-start">
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
                                <div class="col p-2">
                                    <div class="card" style="height: 260px;">
                                        <div class="card-body">
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
                                </div>
                                <div class="col p-2">
                                    <div class="card" style="height: 260px;">
                                        <div class="card-body">
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
                                </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-center bg-success py-1">Kanker</h5>
                            <div class="">
                                <!-- <h4 class="font-weight-normal">Hasil Cek Kesehatan Gratis</h4> -->
                                <div class="row">
                                    <div class="col p-2">
                                        <div class="card" style="height: 260px;">
                                            <div class="card-body">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Kanker Leher Rahim
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
                                    </div>
                                    <div class="col p-2">
                                        <div class="card" style="height: 260px;">
                                            <div class="card-body">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Kanker Payudara
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col p-2">
                                        <div class="card" style="height: 260px;">
                                            <div class="card-body">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Kanker Paru
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
                                    </div>
                                    <div class="col p-2">
                                        <div class="card" style="height: 260px;">
                                            <div class="card-body">
                                                <div style="font-size: 24px" class="card-title text font-weight-bold">
                                                    Kanker Usus
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'Admin')
                    <div class="row">
                        <div class="col-12">
                          
                                    <div><h4>Total Per Puskesmas</h4></div>
                                </div>
                                <div class="card-body">
                                <table id="idtabel" class="table table-bordered table-striped example" style="width:100%">
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
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div><h4>Per Kelompok Usia</h4></div>
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
                                    <div><h4>Total Per Jenis Pemeriksaan</h4></div>
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
                                    <div><h4>Total Kesimpulan Hasil Pemeriksaan</h4></div>
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
    var role_auth = "{{ Auth::user()->role }}"
    $(document).ready(function () {
        var currentDate = new Date();

        var formattedDate = currentDate.getFullYear() + '-' +
                            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                            ('0' + currentDate.getDate()).slice(-2);

        $('#dari').val(formattedDate);
        $('#sampai').val(formattedDate);

        // grafik();
        if(role_auth == "Admin"){
            tabel_per_puskesmas()
        }
        hasil_pemeriksaan()
        grafik_per_periode()
        per_kelompok_usia()
        tabel_kesimpulan_hasil()
        tabel_per_jenis_pemeriksaan()
        // peta()
    })

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });

    function oc_cari(){
        // grafik();
        if(role_auth == "Admin"){
            tabel_per_puskesmas()
        }
        hasil_pemeriksaan()
        grafik_per_periode()
        per_kelompok_usia()
        tabel_kesimpulan_hasil()
        tabel_per_jenis_pemeriksaan()
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

    function grafik_per_periode(){
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
                'dari':dari,
                'sampai':sampai,
                'x_grafik':x_grafik
            },
            dataType: 'json',
            async: true,
            success: function(data) {
                // console.log(data.grafik)
                // console.log(data)
                // console.log(jenis)
                // $('#div_loading').hide();
                // $('#konten').show()
                // var dari = $('#dari').val()
                // var sampai = $('#sampai').val()
                // var periode_format = ar_x_grafik_ubah_format(dari, sampai);
                // var ar_periode = ar_x_grafik(dari, sampai);

                var col_tanggal = []
                for (var i = 0; i < x_grafik.length; i++) {
                    (function(i) {
                        col_tanggal.push({
                                data: i
                            });
                    })(i);
                }

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
                    series: [
                        {
                            name: 'Total Pasien',
                            color: '#ffc107',
                            data: data
                        },
                    ]
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
            }
        })
    }
    
    function tabel_per_puskesmas(){
        // semua_riwayat = []
    //    console.log("tabel")
        let col = 
        [
            {
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { 'data': 'nama' },
            { 'data': 'total' },
        ]

        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        $('#idtabel').dataTable( {
            destroy : true,
            scrollX : true,
            ajax :  {
                url: "{{url('dashboard/data_per_puskesmas')}}",
                type: "GET",
                data: function (d) {
                    d.tgl_dari = $('#dari').val();
                    d.tgl_sampai = $('#sampai').val();
                },
                dataSrc: '',
            },
            columns: col
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
            "Tidak ada faktor resiko": "klr-tidak-ada-faktor",
            "Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif": "klr-ada-faktor-semua-negatif",
            "Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif": "klr-ada-faktor-salah-satu-negatif",
            "Curiga kanker": "klr-curiga-kanker"
        },
        "kanker_payudara": {
            "Sadanis Negatif": "kp-negatif",
            "Sadanis Positif pemeriksaan USG Normal": "kp-positif-usg-normal",
            "Sadanis Positif pemeriksaan USG Simple Cyst": "kp-positif-usg-simple-cyst",
            "Sadanis Positif pemeriksaan USG Non Simple cyst": "kp-positif-usg-non-symple-cyst",
            "Sadanis Positif resiko sangat tinggi": "kp-positif-resiko-tinggi"
        },
        "kanker_paru": {
            "Risiko ringan": "kpr-risiko-ringan",
            "Risiko sedang atau tinggi": "kpr-risiko-sedang-tinggi"
        },
        "kanker_usus": {
            "APCS 0-1 Risiko rendah": "ku-risiko-rendah",
            "APCS 2-3 Risiko sedang": "ku-risiko-sedang",
            "APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua": "ku-risiko-tinggi-negatif-semua",
            "APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif": "ku-risiko-rendah-salah-satu-positif"
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
            data: { tgl_dari, tgl_sampai },
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

                // Re-initialize tooltips
                $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
            },
            error: function(xhr, status, error) {
                console.error("API Error:", status, error);
            }
        });
    }




    function per_kelompok_usia(){
        let tgl_dari = $('#dari').val();
        let tgl_sampai = $('#sampai').val();

        $.ajax({
            url: `{{url('dashboard/data_per_usia')}}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tgl_dari : $('#dari').val(),
                tgl_sampai : $('#sampai').val(),
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

    function tabel_kesimpulan_hasil(){
        let col = 
        [
            {
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { 'data': 'status' },
            { 'data': 'total' },
        ]

        
        $('#idtabel_kesimpulan_hasil').dataTable( {
            destroy : true,
            scrollX : true,
            ajax :  {
                url: "{{url('dashboard/data_kesimpulan_hasil')}}",
                type: "GET",
                data: function (d) {
                    d.tgl_dari = $('#dari').val();
                    d.tgl_sampai = $('#sampai').val();
                },
                // dataSrc: '',
                dataSrc: function(json) {
                    let totalSum = json.reduce((sum, row) => sum + (parseInt(row.total) || 0), 0);
                    
                    $('#total_kunjungan_pasien').text(totalSum);

                    return json; // Return data for DataTable
                },
            },
            columns: col
        });
    }

    function tabel_per_jenis_pemeriksaan(){
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

        let col = [
            {
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "sasaran", title: "Sasaran", width: "150px" },
            { data: "no", title: "No", width: "50px" },
            { data: "jenis_pemeriksaan", title: "Jenis Pemeriksaan", width: "200px" },
            { data: "total", title: "Jumlah Sasaran", width: "120px" },

            // { data: "total", title: "Jumlah Sasaran", width: "120px" }
            
        ];
        // let col = 
        // [
        //     // {
        //     //     render: function(data, type, row, meta) {
        //     //         return meta.row + meta.settings._iDisplayStart + 1;
        //     //     },
        //     // },
        //     { 'data': 'sasaran' },
        //     { 'data': 'no' },
        //     { 'data': 'jenis_pemeriksaan' },
        //     { 'data': 'total' },
        //     // { 'data': 'tgl' },
        // ]

        // x_grafik.forEach(tgl => {
        //     // console.log("tgl"+tgl)
        //     // col.push({ 'data': tgl });
        //     col.push({
        //         render: function(data, type, row, meta) {
        //             console.log(row.per_tgl[tgl])
        //             return row.per_tgl[tgl]; // Handle undefined cases
        //         }
        //     });
        // });
        // x_grafik.forEach(tgl => {
        //     col.push({
        //         data: `per_tgl.${tgl}`,
        //         title: tgl,
        //         render: function(data, type, row) {
        //             console.log(`Processing date ${tgl}:`, row.per_tgl); // Debugging
        //             return row.per_tgl && row.per_tgl[tgl] !== undefined ? row.per_tgl[tgl] : '-';
        //         }
        //     });
        // });
        x_grafik.forEach(tgl => {
            let format_tgl = tgl.split("-").reverse().join("-");

            col.push({
                data: `per_tgl.${tgl}`, // ✅ Matches JSON structure
                title: format_tgl,
                width: "100px", // ✅ Ensures proper width assignment
                defaultContent: "-",
                render: function (data, type, row) {
                    return row.per_tgl && row.per_tgl[tgl] != undefined ? row.per_tgl[tgl] : "-";
                }
            });
        });

        // console.log("col")
        // console.log(col)

        $.ajax({
            url: `{{url('dashboard/data_per_jenis_pemeriksaan')}}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tgl_dari : $('#dari').val(),
                tgl_sampai : $('#sampai').val(),
                ar_tgl : x_grafik,
            },
            success: function(response) {
                // console.log(response)
            }
        })

        // $('#idtabel_per_jenis_pemeriksaan').dataTable( {
        //     destroy : true,
        //     scrollX : true,
        //     autoWidth: false,
        //     columnDefs: [{ width: "120px", targets: "_all" }],
        //     ajax :  {
        //         url: "{{url('dashboard/data_per_jenis_pemeriksaan')}}",
        //         type: "GET",
        //         data: function (d) {
        //             d.tgl_dari = $('#dari').val();
        //             d.tgl_sampai = $('#sampai').val();
        //             d.ar_tgl = x_grafik;
        //         },
        //         // dataSrc: '',
        //         dataSrc: function(json) {
        //             // let totalSum = json.reduce((sum, row) => sum + (parseInt(row.total) || 0), 0);
                    
        //             // $('#total_kunjungan_pasien').text(totalSum);
        //             console.log("AJAX Data Response:", json);
        //             return json; // Return data for DataTable
        //         },
        //     },
        //     columns: col
        // }, 1000);
        // setTimeout(() => {
            $("#idtabel_per_jenis_pemeriksaan").DataTable({
                destroy: true,
                scrollX: true, // ✅ Fixes horizontal scrolling issues
                // autoWidth: false, // ✅ Prevents sWidth undefined error
                // columnDefs: [{ width: "120px", targets: "_all" }],
                ajax: {
                    url: "{{url('dashboard/data_per_jenis_pemeriksaan')}}",
                    type: "GET",
                    data: function (d) {
                        d.tgl_dari = $("#dari").val();
                        d.tgl_sampai = $("#sampai").val();
                        d.ar_tgl = x_grafik;
                    },
                    dataSrc: function (json) {
                        // console.log("AJAX Data Response:", json);
                        return json;
                    },
                },
                columns: col
            });
        // }, 1000);
    }

</script>
</html>
