<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Semar PKG79</title>

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
        // peta()
    })

    function oc_cari(){
        grafik();
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

    function grafik(){
        // var jenis = $('#jenis').val()
        var dari = $('#dari').val()
        var sampai = $('#sampai').val()
        var x_grafik = ar_x_grafik(dari, sampai);
        var x_grafik_format = ar_x_grafik_ubah_format(dari, sampai);
        // console.log(x_grafik)
        $('#div_loading').css('display', 'flex').show();
        $('#konten').hide()

        $.ajax({
            url: "{{url('dashboard/data')}}",
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
                console.log(data)
                // console.log(jenis)
                $('#div_loading').hide();
                $('#konten').show()
                var dari = $('#dari').val()
                var sampai = $('#sampai').val()
                var periode_format = ar_x_grafik_ubah_format(dari, sampai);
                var ar_periode = ar_x_grafik(dari, sampai);

                var col_tanggal = []
                for (var i = 0; i < ar_periode.length; i++) {
                    (function(i) {
                        col_tanggal.push({
                                data: i
                            });
                    })(i);
                }

                var semua_data = data

                var pasien_skrining_dasar = []
                pasien_skrining_dasar = ar_periode.map((tanggal, index) => {
                    var pasien_tanggal = semua_data.filter(val => val.riwayat.tanggal == tanggal);
                    var total_pasien_tanggal = pasien_tanggal.length
                    return total_pasien_tanggal;
                });

                var pasien_skrining_msn = []
                var data_pasien_msn = semua_data.filter(val => val.msn != null && val.msn != "null");
                var data_pasien_bukan_msn = semua_data.filter(val => val.msn == null || val.msn == "null");

                pasien_skrining_msn = ar_periode.map((tanggal, index) => {
                    var pasien_tanggal = data_pasien_msn.filter(val => val.riwayat.tanggal == tanggal);
                    var total_pasien_tanggal = pasien_tanggal.length
                    return total_pasien_tanggal;
                });

                Highcharts.chart('grafik', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Total Kunjungan Pasien',
                    },
                    xAxis: {
                        categories: periode_format,
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
                            name: 'Pasien Dasar',
                            color: '#17a2b8',
                            data: pasien_skrining_dasar
                        },
                        {
                            name: 'Pasien MSN',
                            color: '#ffc107',
                            data: pasien_skrining_msn
                        }
                    ]
                });

                var dt = data
                var total_pasien = dt.length
                var total_pasien_msn = 0
                if(total_pasien!=0){
                    total_pasien_msn = dt.filter(item => item.msn != null && item.msn !="null").length;
                    diagram_pie_total_pasien_dan_pasien_msn(dt);
                }
                var persen_total_pasien_msn = (total_pasien_msn/total_pasien)*100
                persen_total_pasien_msn = persen_total_pasien_msn.toFixed(2);
                persen_total_pasien_msn = parseFloat(persen_total_pasien_msn);

                // console.log(total_pasien)
                $('#total_pasien').html(total_pasien);
                $('#total_pasien_msn').html(total_pasien_msn+" ("+persen_total_pasien_msn+" %)");

                kelompok_umur(data)
                deteksi_dini(data)
                tempat_pemeriksaan(data)
                tabel(data)
            }
        })
    }

    function kelompok_umur(data){
        data.forEach(item => {
            let tgl_lahir = item.pasien.tgl_lahir;
            let tanggal_pemeriksaan = item.riwayat.tanggal;

            let umur_pasien = hitung_umur(tgl_lahir, tanggal_pemeriksaan);

            item.pasien.umur = umur_pasien;
        });
        var total_data = data.length

        var kelompok_umur = ["0_1", "2_5", "6_10", "11_19", "20_44", "45_59", "60_150"]

        kelompok_umur.forEach(kelompok => {
            let [minAge, maxAge] = kelompok.split('_').map(Number);
            let total = data.filter(item => {
                            let umur = item.pasien.umur;
                            return umur >= minAge && umur <= maxAge;
                        }).length;
            let persentase = (total/total_data)*100
            persentase = persentase.toFixed(2);
            persentase = parseFloat(persentase);


            $(`#persentase_umur_${kelompok}_tahun`).html(persentase+" %");
            $(`#total_umur_${kelompok}_tahun`).html(total);
        });
    }

    function diagram_pie_total_pasien_dan_pasien_msn(data){
        var total_laki_laki = data.filter(item => item.pasien != null && item.pasien.jenis_kelamin == "Laki-laki").length;
        var total_perempuan = data.filter(item => item.pasien != null && item.pasien.jenis_kelamin == "Perempuan").length;
        var total = total_laki_laki+total_perempuan

        var persen_laki_laki = (total_laki_laki/total)*100;
        var persen_perempuan = (total_perempuan/total)*100;

        persen_laki_laki = persen_laki_laki.toFixed(2);
        persen_perempuan = persen_perempuan.toFixed(2);

        persen_laki_laki = parseFloat(persen_laki_laki);
        persen_perempuan = parseFloat(persen_perempuan);

        $('#persen_laki_laki').html("<h5>"+persen_laki_laki+" % </h5>")
        $('#persen_perempuan').html("<h5>"+persen_perempuan+" % </h5>")

        $('#total_laki_laki').html(total_laki_laki);
        $('#total_perempuan').html(total_perempuan);


        // console.log(total_laki_laki)
        // console.log(total_perempuan)
        // console.log(persen_laki_laki)
        // console.log(persen_perempuan)

        Highcharts.chart('id_diagram_pie_total_pasien_dan_pasien_msn', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Jenis Kelamin'
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        distance: 20,
                        formatter: function() {
                            return this.point.percentage.toFixed(2) + '%';
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Persentase',
                colorByPoint: true,
                data: [{
                    name: 'Laki-laki',
                    y: persen_laki_laki,
                    color: 'blue'
                }, {
                    name: 'Perempuan',
                    y: persen_perempuan,
                    color: '#e83e8c'
                }
                ]
            }]
        });
    }

    function hitung_umur(tgl_lahir, tgl_pemeriksaan) {
        let birthDate = new Date(tgl_lahir);
        let ageDate = new Date(tgl_pemeriksaan);

        let age = ageDate.getFullYear() - birthDate.getFullYear();
        let monthDiff = ageDate.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && ageDate.getDate() < birthDate.getDate())) {
            age--;
        }

        return age;
    }

    function deteksi_dini(data){
        deteksi_dini_imt(data)
        deteksi_dini_tekanan_darah(data)
        deteksi_dini_gula_darah(data)
    }

    function deteksi_dini_imt(data){
        var total_pasien = data.length

        var pasien_imt = data.filter(val => val.berat_badan != null && !isNaN(val.berat_badan) && val.berat_badan != 0 &&
            val.tinggi_badan != null && !isNaN(val.tinggi_badan) && val.tinggi_badan != 0)

        var total_pasien_imt = pasien_imt.length
        $('#id_total_imt').html(total_pasien_imt);

        var total_persentase_pasien_imt = ((total_pasien_imt/total_pasien)*100).toFixed(2)
        $('#id_total_persentase_imt').html(total_persentase_pasien_imt+" %");

        var hitung_imt = {
            sangat_kurus: 0,
            kurus: 0,
            normal: 0,
            gemuk: 0,
            obesitas: 0
        };

        var data_imt = pasien_imt.map(row => {
            var imt = row.berat_badan / ((row.tinggi_badan / 100) * (row.tinggi_badan / 100));
            var imt_format = imt.toFixed(2);

            if (imt < 17) {
                hitung_imt.sangat_kurus++;
            } else if (imt >= 17 && imt < 18.5) {
                hitung_imt.kurus++;
            } else if (imt >= 18.5 && imt <= 25) {
                hitung_imt.normal++;
            } else if (imt > 25 && imt <= 27) {
                hitung_imt.gemuk++;
            } else if (imt > 27) {
                hitung_imt.obesitas++;
            }

            return {
                imt: imt_format
            };
        });

        $('#id_total_imt_sangat_kurus').html(hitung_imt.sangat_kurus);
        $('#id_total_imt_kurus').html(hitung_imt.kurus);
        $('#id_total_imt_normal').html(hitung_imt.normal);
        $('#id_total_imt_gemuk').html(hitung_imt.gemuk);
        $('#id_total_imt_obesitas').html(hitung_imt.obesitas);

        var persentase_imt_sangat_kurus = (((hitung_imt.sangat_kurus)/total_pasien_imt)*100).toFixed(2)
        var persentase_imt_kurus = (((hitung_imt.kurus)/total_pasien_imt)*100).toFixed(2)
        var persentase_imt_normal = (((hitung_imt.normal)/total_pasien_imt)*100).toFixed(2)
        var persentase_imt_gemuk = (((hitung_imt.gemuk)/total_pasien_imt)*100).toFixed(2)
        var persentase_imt_obesitas = (((hitung_imt.obesitas)/total_pasien_imt)*100).toFixed(2)

        $('#id_persentase_imt_sangat_kurus').html("("+persentase_imt_sangat_kurus+" %)");
        $('#id_persentase_imt_kurus').html("("+persentase_imt_kurus+" %)");
        $('#id_persentase_imt_normal').html("("+persentase_imt_normal+" %)");
        $('#id_persentase_imt_gemuk').html("("+persentase_imt_gemuk+" %)");
        $('#id_persentase_imt_obesitas').html("("+persentase_imt_obesitas+" %)");

        var progress_bar_val = [
            { obj: 'sangat_kurus', warna: '#0008FF', persentase: persentase_imt_sangat_kurus},
            { obj: 'kurus', warna: '#00D0FF', persentase: persentase_imt_kurus},
            { obj: 'normal', warna: '#0AE26A', persentase: persentase_imt_normal},
            { obj: 'gemuk', warna: '#FF9300', persentase: persentase_imt_gemuk},
            { obj: 'obesitas', warna: '#FF1900', persentase: persentase_imt_obesitas},
        ]

        var bg_color = ''
        progress_bar_val.map(item => {
            bg_color+='<div style="background-color:'+item.warna+'; width:'+item.persentase+'%; height:100%; padding:0; margin:0"></div>'
            var id_circle_imt=$('#id_circle_imt_'+item.obj)
            id_circle_imt.css('color', item.warna);
        })

        $('#id_progress_bar_imt').html(bg_color)

    }

    function deteksi_dini_tekanan_darah(data){
        var total_pasien = data.length

        var pasien_tekanan_darah = data.filter(val => val.sistole != null && !isNaN(val.sistole) && val.sistole != 0 &&
            val.diastole != null && !isNaN(val.diastole) && val.diastole != 0)

        var total_pasien_tekanan_darah = pasien_tekanan_darah.length
        $('#id_total_tekanan_darah').html(total_pasien_tekanan_darah);

        var total_persentase_pasien_tekanan_darah = ((total_pasien_tekanan_darah/total_pasien)*100).toFixed(2)
        $('#id_total_persentase_tekanan_darah').html(total_persentase_pasien_tekanan_darah+" %");

        var hitung_tekanan_darah = {
            normal: 0,
            pra_hipertensi: 0,
            hipertensi_tingkat_1: 0,
            hipertensi_tingkat_2: 0,
            hipertensi_sistolik_terisolasi: 0,
        };

        var data_tekanan_darah = pasien_tekanan_darah.map(row => {
            var sistole = row.sistole
            var diastole = row.diastole

            if (sistole < 120 && diastole < 80) {
                hitung_tekanan_darah.normal++
            } else if (sistole >= 160 || diastole >= 100) {
                hitung_tekanan_darah.hipertensi_tingkat_2++
            } else if (sistole >= 140 && sistole <= 159 || diastole >= 90 && diastole <= 99) {
                hitung_tekanan_darah.hipertensi_tingkat_1++
            } else if (sistole >= 120 && sistole <= 139 || diastole >= 80 && diastole <= 89) {
                hitung_tekanan_darah.pra_hipertensi++
            } else if (sistole >= 140 && diastole < 90) {
                hitung_tekanan_darah.hipertensi_sistolik_terisolasi++
            }
        });

        $('#id_total_tekanan_darah_normal').html(hitung_tekanan_darah.normal);
        $('#id_total_tekanan_darah_pra_hipertensi').html(hitung_tekanan_darah.pra_hipertensi);
        $('#id_total_tekanan_darah_hipertensi_tingkat_1').html(hitung_tekanan_darah.hipertensi_tingkat_1);
        $('#id_total_tekanan_darah_hipertensi_tingkat_2').html(hitung_tekanan_darah.hipertensi_tingkat_2);
        $('#id_total_tekanan_darah_hipertensi_sistolik_terisolasi').html(hitung_tekanan_darah.hipertensi_sistolik_terisolasi);

        var persentase_tekanan_darah_normal = (((hitung_tekanan_darah.normal)/total_pasien_tekanan_darah)*100).toFixed(2)
        var persentase_tekanan_darah_pra_hipertensi = (((hitung_tekanan_darah.pra_hipertensi)/total_pasien_tekanan_darah)*100).toFixed(2)
        var persentase_tekanan_darah_hipertensi_tingkat_1 = (((hitung_tekanan_darah.hipertensi_tingkat_1)/total_pasien_tekanan_darah)*100).toFixed(2)
        var persentase_tekanan_darah_hipertensi_tingkat_2 = (((hitung_tekanan_darah.hipertensi_tingkat_2)/total_pasien_tekanan_darah)*100).toFixed(2)
        var persentase_tekanan_darah_hipertensi_sistolik_terisolasi = (((hitung_tekanan_darah.hipertensi_sistolik_terisolasi)/total_pasien_tekanan_darah)*100).toFixed(2)

        $('#id_persentase_tekanan_darah_normal').html("("+persentase_tekanan_darah_normal+" %)");
        $('#id_persentase_tekanan_darah_pra_hipertensi').html("("+persentase_tekanan_darah_pra_hipertensi+" %)");
        $('#id_persentase_tekanan_darah_hipertensi_tingkat_1').html("("+persentase_tekanan_darah_hipertensi_tingkat_1+" %)");
        $('#id_persentase_tekanan_darah_hipertensi_tingkat_2').html("("+persentase_tekanan_darah_hipertensi_tingkat_2+" %)");
        $('#id_persentase_tekanan_darah_hipertensi_sistolik_terisolasi').html("("+persentase_tekanan_darah_hipertensi_sistolik_terisolasi+" %)");

        var progress_bar_val = [
            { obj: 'hipertensi_sistolik_terisolasi', warna: '#0008FF', persentase: persentase_tekanan_darah_hipertensi_sistolik_terisolasi},
            { obj: 'pra_hipertensi', warna: '#F9EF17', persentase: persentase_tekanan_darah_pra_hipertensi},
            { obj: 'normal', warna: '#0AE26A', persentase: persentase_tekanan_darah_normal},
            { obj: 'hipertensi_tingkat_1', warna: '#FF9300', persentase: persentase_tekanan_darah_hipertensi_tingkat_1},
            { obj: 'hipertensi_tingkat_2', warna: '#FF1900', persentase: persentase_tekanan_darah_hipertensi_tingkat_2},
        ]

        var bg_color = ''
        progress_bar_val.map(item => {
            bg_color+='<div style="background-color:'+item.warna+'; width:'+item.persentase+'%; height:100%; padding:0; margin:0"></div>'
            var id_circle_imt=$('#id_circle_tekanan_darah_'+item.obj)
            id_circle_imt.css('color', item.warna);
        })

        $('#id_progress_bar_tekanan_darah').html(bg_color)



    }

    function deteksi_dini_gula_darah(data){
        var total_pasien = data.length

        var pasien_gula_darah = data.filter(val => val.gula_darah_sewaktu != null && !isNaN(val.gula_darah_sewaktu) && val.gula_darah_sewaktu != 0
            || val.gula_darah_puasa != null && !isNaN(val.gula_darah_puasa) && val.gula_darah_puasa != 0
            || val.HbA1c != null && !isNaN(val.HbA1c) && val.HbA1c != 0)

        var total_pasien_gula_darah = pasien_gula_darah.length
        $('#id_total_gula_darah').html(total_pasien_gula_darah);

        var total_persentase_pasien_gula_darah = ((total_pasien_gula_darah/total_pasien)*100).toFixed(2)
        $('#id_total_persentase_gula_darah').html(total_persentase_pasien_gula_darah+" %");

        var hitung_gula_darah = {
            normal: 0,
            pre_diabetes: 0,
            diabetes: 0,
        };

        var data_gula_darah = pasien_gula_darah.map(row => {
            if(row.gula_darah_sewaktu != null && row.gula_darah_sewaktu < 200
                || row.gula_darah_puasa != null && row.gula_darah_puasa < 126
                || row.HbA1c != null && row.HbA1c < 5.7){
                    hitung_gula_darah.normal++
            }
            else if(row.HbA1c != null && row.HbA1c >= 5.7 && row.HbA1c <= 6.4){
                    hitung_gula_darah.pre_diabetes++
            }
            else if(row.gula_darah_sewaktu != null && row.gula_darah_sewaktu >= 200
                || row.gula_darah_puasa != null && row.gula_darah_puasa >= 126
                || row.HbA1c != null && row.HbA1c >= 6.5){
                    hitung_gula_darah.diabetes++
            }
        })

        $('#id_total_gula_darah_normal').html(hitung_gula_darah.normal);
        $('#id_total_gula_darah_pre_diabetes').html(hitung_gula_darah.pre_diabetes);
        $('#id_total_gula_darah_diabetes').html(hitung_gula_darah.diabetes);

        var persentase_gula_darah_normal = (((hitung_gula_darah.normal)/total_pasien_gula_darah)*100).toFixed(2)
        var persentase_gula_darah_pre_diabetes = (((hitung_gula_darah.pre_diabetes)/total_pasien_gula_darah)*100).toFixed(2)
        var persentase_gula_darah_diabetes = (((hitung_gula_darah.diabetes)/total_pasien_gula_darah)*100).toFixed(2)

        $('#id_persentase_gula_darah_normal').html("("+persentase_gula_darah_normal+" %)");
        $('#id_persentase_gula_darah_pre_diabetes').html("("+persentase_gula_darah_pre_diabetes+" %)");
        $('#id_persentase_gula_darah_diabetes').html("("+persentase_gula_darah_diabetes+" %)");

        var progress_bar_val = [
            { obj: 'normal', warna: '#0AE26A', persentase: persentase_gula_darah_normal},
            { obj: 'pre_diabetes', warna: '#FF9300', persentase: persentase_gula_darah_pre_diabetes},
            { obj: 'diabetes', warna: '#FF1900', persentase: persentase_gula_darah_diabetes},
        ]

        var bg_color = ''
        progress_bar_val.map(item => {
            bg_color+='<div style="background-color:'+item.warna+'; width:'+item.persentase+'%; height:100%; padding:0; margin:0"></div>'
            var id_circle_imt=$('#id_circle_gula_darah_'+item.obj)
            id_circle_imt.css('color', item.warna);
        })

        $('#id_progress_bar_gula_darah').html(bg_color)

    }



    function getDynamicData(row, index) {
        if (Array.isArray(row.data) && row.data.length > index) {
            return row.data[index];
        } else {
            return '';
        }
    }

    function tabel(data){
        if(role_auth=="Admin" || role_auth=="Bidang"){
            tabel_puskesmas(data)
        }
        tabel_kelurahan(data)
    }

    function tabel_puskesmas(data){
        if ($.fn.DataTable.isDataTable('#tabel_puskesmas')) {
            $('#tabel_puskesmas').DataTable().clear();
            $('#tabel_puskesmas').DataTable().destroy();
        }

        $.ajax({
            url: "{{url('puskesmas/data')}}",
            type: 'GET',
            dataType: 'json',
            async: true,
            success: function(dt_puskesmas) {
                // console.log(dt_puskesmas)
                var dari = $('#dari').val()
                var sampai = $('#sampai').val()
                var x_grafik = ar_x_grafik_ubah_format(dari, sampai);
                var ar_periode = ar_x_grafik(dari, sampai);

                // console.log(x_grafik)

                var col_header = ["No", "Puskesmas", "Total"]

                // console.log(col_header)
                var header = col_header.map(column => `<th>${column}</th>`).join('');
                $('#id_header_tabel_puskesmas').html(header);

                // console.log(col_tanggal)

                let puskesmasData = dt_puskesmas.map(pusk => {
                    let data_pasien_puskesmas = data.filter(val => val.id_puskesmas == pusk.id);

                    return {
                        id_puskesmas: pusk.id,
                        nama_puskesmas:  pusk.nama,
                        total: data_pasien_puskesmas.length,
                        // data: data_pasien_puskesmas,
                        // ...col_tanggal_body
                    }
                })

                puskesmasData.sort((a, b) => b.total - a.total);

                var col = [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { 'data': 'nama_puskesmas' },
                    { 'data': 'total'},
                    // ...col_tanggal,
                ]

                // console.log(puskesmasData)

                $('#tabel_puskesmas').dataTable( {
                    destroy : true,
                    scrollX : true,
                    data: puskesmasData,
                    columns: col
                });
            }
        })
    }

    function tabel_kelurahan(data){
        if ($.fn.DataTable.isDataTable('#tabel_kelurahan')) {
            $('#tabel_kelurahan').DataTable().clear();
            $('#tabel_kelurahan').DataTable().destroy();
        }

        $.ajax({
            url: "{{url('ref_kelurahan')}}",
            type: 'GET',
            dataType: 'json',
            async: true,
            success: function(dt_kelurahan) {
                console.log("kel")

                var dari = $('#dari').val()
                var sampai = $('#sampai').val()
                var x_grafik = ar_x_grafik_ubah_format(dari, sampai);
                var ar_periode = ar_x_grafik(dari, sampai);
                // console.log(ar_periode)
                var col_header = ["No", "Kelurahan", "Kecamatan", "Total"]

                var header = col_header.map(column => `<th>${column}</th>`).join('');
                $('#id_header_tabel_kelurahan').html(header);

                let kelurahanData = dt_kelurahan.map(kel => {
                    let data_pasien_kelurahan = data.filter(val => val.riwayat.id_kelurahan == kel.id);

                    return {
                        id_kelurahan: kel.id,
                        nama_kelurahan:  kel.nama_kelurahan,
                        nama_kecamatan: kel.r_kode_kecamatan.nama_kecamatan,
                        total: data_pasien_kelurahan.length,
                        // ...col_tanggal_body
                    }
                })

                kelurahanData.sort((a, b) => b.total - a.total);

                var col = [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { 'data': 'nama_kelurahan' },
                    { 'data': 'nama_kecamatan' },
                    { 'data': 'total'},
                    // ...col_tanggal,
                ]

                // console.log(col)

                $('#tabel_kelurahan').dataTable( {
                    destroy : true,
                    scrollX : true,
                    data: kelurahanData,
                    columns: col
                });


                // console.log(kelurahanData)
            }
        })


    }

    function tempat_pemeriksaan(data){
        var ar_tempat_pemeriksaan = ['posyandu', 'balai pertemuan', 'kantor/instansi', 'opd kota semarang', 'tempat ibadah', 'lapangan', 'swalayan/mall/pasar', 'sekolah/kampus', 'lainnya']

        let tempatPemeriksaanData = ar_tempat_pemeriksaan.map(nama => {
            let data_tempat_pemeriksaan = data.filter(val => val.riwayat.tempat_pemeriksaan == nama);

            return {
                tempat_pemeriksaan: nama,
                total: data_tempat_pemeriksaan.length,
            }
        })

        // console.log(tempatPemeriksaanData)

        let cardsHTML = tempatPemeriksaanData.map(item => `
            <div class="col-sm-3 col-md-2">
                <div class="card">
                    <div class="card-body">
                        <div>${item.tempat_pemeriksaan}</div>
                        <div style="margin-left:auto; font-weight:bold">${item.total}</div>
                    </div>
                </div>
            </div>`).join('');

        $('#id_tempat_pemeriksaan').html(cardsHTML);
    }

    function oc_modal(){
        $('#exampleModal .modal-title').text('Perhatian!').css('color', 'red');
        var html='\
            <div class="mb-3" style="color:red">\
                Anda akan mengunduh file yang mengandung\
                <span style="font-weight: bold; font-size: 17px;">data pribadi pasien</span>\
                harap hati-hati dan bertanggung jawab dalam penggunaannya!\
            </div>\
            <div style="color:red">Apakah ingin lanjut?</div>'

        $('#exampleModal .modal-body').html(html);
        $('#exampleModal .modal-footer').html('<button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button><button type="button" class="btn btn-danger" onclick="oc_export()">Ya</button>');
        $('#exampleModal').modal('show');
    }

    function oc_export(){
        console.log("export")
        var dari = $('#dari').val()
        var sampai = $('#sampai').val()
        var jenis = $('#jenis').val()
        // let result = col.map(item => item.map(obj => obj.data).join(', ')).join(', ');
        // let result = col.map(item => item.map(obj => obj.data));
        // let result = col.map(items => items.map(obj => obj.data));
        // let ar_col = col.map(obj => obj.data).filter(item => item !== undefined);
        // let ar2 = [];
        let ar_col = []
        let functionCount = 0;

        col.forEach((item, index) => {
            if (typeof item.data === 'string') {
                ar_col.push(item.data);
            } else if (typeof item.data === 'function') {
                // ar_col.push(functionCount.toString());
                // functionCount++;
                ar_col.push(`data.${functionCount}`);
                functionCount++;
            }
        });

        console.log(jenis)
        console.log(col_header)
        console.log(col)
        console.log(ar_col)
        // console.log(Array.isArray(col))
        // console.log(result)
        // window.location.href = "{{ url('dashboard/export') }}/"+dari+"/"+sampai;
        window.location.href = "{{ url('dashboard/export') }}?dari=" + dari + "&sampai=" + sampai + "&col_header=" + col_header + "&col=" + ar_col + "&jenis=" + jenis;
    }

</script>
</html>
