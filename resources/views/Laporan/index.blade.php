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
                                    <h5 class="m-0">Laporan</h5>
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
                            <div class="row">
                                <div class="col-md-1 text-center">Periode dari</div>
                                <div class="col-md-2"><input id="periode_dari" type="date"></input></div>
                                <div class="col-md-1 text-center">sampai</div>
                                <div class="col-md-2"><input id="periode_sampai" type="date"></input></div>
                                <div class="col-md-1 text-center">Instrumen Pemeriksaan</div>
                                <div class="col-md-4"><select class="form-control" id="instrumen" style="width: 100%;"></select></div>
                                <div class="col-md-1"><button onclick="tabel()">Cari</button></div>
                            </div>
                            <div style="display:flex; justify-content:center; margin-top:30px">
                                <button class= "btn btn-sm btn-success" onclick="oc_export()">Export</button>
                            </div>
                            <div style="margin-top:30px">
                                <table id="idtabel" class="table table-bordered table-striped example" style="width:100%; margin-top:30px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width:150px;">Aksi</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Tempat Periksa</th>
                                        <th>Nama FKTP</th>
                                        <!-- <th>Pemeriksa</th> -->
                                        <!-- <th>NIK</th> -->
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <!-- <th>Tanggal Lahir</th> -->
                                        <!-- <th>Hasil Pemeriksaan Kesehatan</th> -->
                                        <th>Kesimpulan Hasil</th>
                                        <!-- <th>Program Tindak Lanjut</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                            </div>
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
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@include('layouts.footer')
</body>
<script>
    var Toast
    var role_auth = "{{Auth::user()->role}}";

    $(document).ready(function () {
        let hari_ini = new Date().toISOString().split('T')[0];

        $('#periode_dari').val(hari_ini);
        $('#periode_sampai').val(hari_ini);
        
        $('#instrumen').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            // dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_instrumen') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data) {
                    let results = data.map(item => ({
                        id: item.id,
                        text: item.val
                    }));
                    

                    console.log("Final Results for Select2:", results); // Debugging

                    return { results };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });

        tabel()
        
        Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    })

    var semua_riwayat = []

    function tabel(){
        semua_riwayat = []
       
        let col = 
        [
            {
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { 'render': function (data, type, row, meta) {
                let hasil_pemeriksaan = JSON.parse(row.hasil_pemeriksaan)
                let program_tindak_lanjut = JSON.parse(row.program_tindak_lanjut)                
                
                // var cek = semua_riwayat.some(function(entry) {
                //     return entry.id == row.id;
                // });

                // if (!cek) {
                //     semua_riwayat.push({
                //         id: row.id,
                //         tanggal_pemeriksaan: row.tanggal_pemeriksaan,
                //         tempat_periksa: row.tempat_periksa ? row.tempat_periksa : "",
                //         nama_fktp_pj: row.nama_fktp_pj ? row.nama_fktp_pj : "",
                //         pemeriksa_nik: row.pemeriksa && row.pemeriksa.nik ? row.pemeriksa.nik : "",
                //         pemeriksa_nama: row.pemeriksa && row.pemeriksa.nama ? row.pemeriksa.nama : "",                        
                //         pasien_nik: row.pasien && row.pasien.nik ? row.pasien.nik : "",
                //         pasien_nama: row.pasien && row.pasien.nama ? row.pasien.nama : "",
                //         pasien_jenis_kelamin: row.pasien && row.pasien.jenis_kelamin ? row.pasien.jenis_kelamin : "",
                //         pasien_tgl_lahir: row.pasien && row.pasien.tgl_lahir ? row.pasien.tgl_lahir : "",
                //         pasien_alamat: row.pasien && row.pasien.alamat ? row.pasien.alamat : "",
                //         pasien_no_hp: row.pasien && row.pasien.no_hp ? row.pasien.no_hp : "",
                //         hasil_pemeriksaan: hasil_pemeriksaan,
                //         kesimpulan_hasil_pemeriksaan: row.kesimpulan_hasil_pemeriksaan ? row.kesimpulan_hasil_pemeriksaan : "",
                //         program_tindak_lanjut: program_tindak_lanjut,
                //     });
                // }

                var index = semua_riwayat.findIndex(entry => entry.id == row.id);

                if (index !== -1) {
                    semua_riwayat[index] = {
                        id: row.id,
                        tanggal_pemeriksaan: row.tanggal_pemeriksaan,
                        tempat_periksa: row.tempat_periksa ? row.tempat_periksa : "",
                        nama_fktp_pj: row.nama_fktp_pj ? row.nama_fktp_pj : "",
                        pemeriksa_nik: row.pemeriksa && row.pemeriksa.nik ? row.pemeriksa.nik : "",
                        pemeriksa_nama: row.pemeriksa && row.pemeriksa.nama ? row.pemeriksa.nama : "",
                        pasien_nik: row.pasien && row.pasien.nik ? row.pasien.nik : "",
                        pasien_nama: row.pasien && row.pasien.nama ? row.pasien.nama : "",
                        pasien_jenis_kelamin: row.pasien && row.pasien.jenis_kelamin ? row.pasien.jenis_kelamin : "",
                        pasien_tgl_lahir: row.pasien && row.pasien.tgl_lahir ? row.pasien.tgl_lahir : "",
                        
                        // pasien_provinsi_ktp: row.pasien && row.pasien.provinsi_ktp ? row.pasien.provinsi_ktp : "",
                        // pasien_provinsi_ktp_nama: row.pasien && row.pasien.provinsi_ktp && row.pasien.ref_provinsi_ktp.nama ? row.pasien.ref_provinsi_ktp.nama : "",
                        // pasien_kota_kab_ktp: row.pasien && row.pasien.kota_kab_ktp ? row.pasien.kota_kab_ktp : "",
                        // pasien_kota_kab_ktp_nama: row.pasien && row.pasien.kota_kab_ktp && row.pasien.ref_kota_kab_ktp.nama ? row.pasien.ref_kota_kab_ktp.nama : "",
                        // pasien_kecamatan_ktp: row.pasien && row.pasien.kecamatan_ktp ? row.pasien.kecamatan_ktp : "",
                        // pasien_kecamatan_ktp_nama: row.pasien && row.pasien.kecamatan_ktp && row.pasien.ref_kecamatan_ktp.nama ? row.pasien.ref_kecamatan_ktp.nama : "",
                        // pasien_kelurahan_ktp: row.pasien && row.pasien.kelurahan_ktp ? row.pasien.kelurahan_ktp : "",
                        // pasien_kelurahan_ktp_nama: row.pasien && row.pasien.kelurahan_ktp && row.pasien.ref_kelurahan_ktp.nama ? row.pasien.ref_kelurahan_ktp.nama : "",
                        // pasien_alamat_ktp: row.pasien && row.pasien.alamat_ktp ? row.pasien.alamat_ktp : "",
                        
                        pasien_provinsi_ktp: row.pasien?.provinsi_ktp || "",
                        pasien_provinsi_ktp_nama: row.pasien?.ref_provinsi_ktp?.nama || "",
                        pasien_kota_kab_ktp: row.pasien?.kota_kab_ktp || "",
                        pasien_kota_kab_ktp_nama: row.pasien?.ref_kota_kab_ktp?.nama || "",
                        pasien_kecamatan_ktp: row.pasien?.kecamatan_ktp || "",
                        pasien_kecamatan_ktp_nama: row.pasien?.ref_kecamatan_ktp?.nama || "",
                        pasien_kelurahan_ktp: row.pasien?.kelurahan_ktp || "",
                        pasien_kelurahan_ktp_nama: row.pasien?.ref_kelurahan_ktp?.nama || "",
                        pasien_alamat_ktp: row.pasien && row.pasien.alamat_ktp ? row.pasien.alamat_ktp : "",
                        
                        
                        pasien_provinsi_dom: row.pasien && row.pasien.provinsi_dom ? row.pasien.provinsi_dom : "",
                        pasien_provinsi_dom_nama: row.pasien && row.pasien.provinsi_dom && row.pasien.ref_provinsi_dom.nama ? row.pasien.ref_provinsi_dom.nama : "",
                        pasien_kota_kab_dom: row.pasien && row.pasien.kota_kab_dom ? row.pasien.kota_kab_dom : "",
                        pasien_kota_kab_dom_nama: row.pasien && row.pasien.kota_kab_dom && row.pasien.ref_kota_kab_dom.nama ? row.pasien.ref_kota_kab_dom.nama : "",
                        pasien_kecamatan_dom: row.pasien && row.pasien.kecamatan_dom ? row.pasien.kecamatan_dom : "",
                        pasien_kecamatan_dom_nama: row.pasien && row.pasien.kecamatan_dom && row.pasien.ref_kecamatan_dom.nama ? row.pasien.ref_kecamatan_dom.nama : "",
                        pasien_kelurahan_dom: row.pasien && row.pasien.kelurahan_dom ? row.pasien.kelurahan_dom : "",
                        pasien_kelurahan_dom_nama: row.pasien && row.pasien.kelurahan_dom && row.pasien.ref_kelurahan_dom.nama ? row.pasien.ref_kelurahan_dom.nama : "",
                        pasien_alamat_dom: row.pasien && row.pasien.alamat_dom ? row.pasien.alamat_dom : "",

                        pasien_no_hp: row.pasien && row.pasien.no_hp ? row.pasien.no_hp : "",
                        hasil_pemeriksaan: hasil_pemeriksaan,
                        hasil_pemeriksaan_lainnya: row.hasil_pemeriksaan_lainnya?row.hasil_pemeriksaan_lainnya:"",
                        kesimpulan_hasil_pemeriksaan: row.kesimpulan_hasil_pemeriksaan ? row.kesimpulan_hasil_pemeriksaan : "",
                        program_tindak_lanjut: program_tindak_lanjut,
                    };
                } else {
                    semua_riwayat.push({
                        id: row.id,
                        tanggal_pemeriksaan: row.tanggal_pemeriksaan,
                        tempat_periksa: row.tempat_periksa ? row.tempat_periksa : "",
                        nama_fktp_pj: row.nama_fktp_pj ? row.nama_fktp_pj : "",
                        pemeriksa_nik: row.pemeriksa && row.pemeriksa.nik ? row.pemeriksa.nik : "",
                        pemeriksa_nama: row.pemeriksa && row.pemeriksa.nama ? row.pemeriksa.nama : "",
                        
                        pasien_nik: row.pasien && row.pasien.nik ? row.pasien.nik : "",
                        pasien_nama: row.pasien && row.pasien.nama ? row.pasien.nama : "",
                        pasien_jenis_kelamin: row.pasien && row.pasien.jenis_kelamin ? row.pasien.jenis_kelamin : "",
                        pasien_tgl_lahir: row.pasien && row.pasien.tgl_lahir ? row.pasien.tgl_lahir : "",
                        
                        pasien_provinsi_ktp: row.pasien?.provinsi_ktp || "",
                        pasien_provinsi_ktp_nama: row.pasien?.ref_provinsi_ktp?.nama || "",
                        pasien_kota_kab_ktp: row.pasien?.kota_kab_ktp || "",
                        pasien_kota_kab_ktp_nama: row.pasien?.ref_kota_kab_ktp?.nama || "",
                        pasien_kecamatan_ktp: row.pasien?.kecamatan_ktp || "",
                        pasien_kecamatan_ktp_nama: row.pasien?.ref_kecamatan_ktp?.nama || "",
                        pasien_kelurahan_ktp: row.pasien?.kelurahan_ktp || "",
                        pasien_kelurahan_ktp_nama: row.pasien?.ref_kelurahan_ktp?.nama || "",
                        pasien_alamat_ktp: row.pasien && row.pasien.alamat_ktp ? row.pasien.alamat_ktp : "",
                        
                        pasien_provinsi_dom: row.pasien && row.pasien.provinsi_dom ? row.pasien.provinsi_dom : "",
                        pasien_provinsi_dom_nama: row.pasien && row.pasien.provinsi_dom && row.pasien.ref_provinsi_dom.nama ? row.pasien.ref_provinsi_dom.nama : "",
                        pasien_kota_kab_dom: row.pasien && row.pasien.kota_kab_dom ? row.pasien.kota_kab_dom : "",
                        pasien_kota_kab_dom_nama: row.pasien && row.pasien.kota_kab_dom && row.pasien.ref_kota_kab_dom.nama ? row.pasien.ref_kota_kab_dom.nama : "",
                        pasien_kecamatan_dom: row.pasien && row.pasien.kecamatan_dom ? row.pasien.kecamatan_dom : "",
                        pasien_kecamatan_dom_nama: row.pasien && row.pasien.kecamatan_dom && row.pasien.ref_kecamatan_dom.nama ? row.pasien.ref_kecamatan_dom.nama : "",
                        pasien_kelurahan_dom: row.pasien && row.pasien.kelurahan_dom ? row.pasien.kelurahan_dom : "",
                        pasien_kelurahan_dom_nama: row.pasien && row.pasien.kelurahan_dom && row.pasien.ref_kelurahan_dom.nama ? row.pasien.ref_kelurahan_dom.nama : "",
                        pasien_alamat_dom: row.pasien && row.pasien.alamat_dom ? row.pasien.alamat_dom : "",

                        pasien_no_hp: row.pasien && row.pasien.no_hp ? row.pasien.no_hp : "",
                        hasil_pemeriksaan: hasil_pemeriksaan,
                        hasil_pemeriksaan_lainnya: row.hasil_pemeriksaan_lainnya?row.hasil_pemeriksaan_lainnya:"",
                        kesimpulan_hasil_pemeriksaan: row.kesimpulan_hasil_pemeriksaan ? row.kesimpulan_hasil_pemeriksaan : "",
                        program_tindak_lanjut: program_tindak_lanjut,
                    });
                }
                // var baseurl = "{{url('pasien/riwayat_skrining/')}}"
                var actionsHtml = ''
                
                // if(role_auth=="Admin"||role_auth=="Puskesmas"||role_auth=="Petugas"||role_auth=="Kader"){
                    
                    actionsHtml += '<button class="btn btn-sm btn-primary" onclick="oc_modal(\'Detail\', \''+row.id+'\')" style="width:100%"><i class="fa fa-eye"></i> Detail</button>'
                    
                    // }
                
                return actionsHtml;
                }
            },
            {
                render: function(data, type, row, meta) {
                    let tgl = row.tanggal_pemeriksaan
                    if (tgl) {
                        let dateParts = tgl.split("-");
                        let formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0]; // Rearrange to "DD-MM-YYYY"
                        return formattedDate;
                    }
                    return "";
                },
            },
            { 'data': 'tempat_periksa' },
            { 'data': 'nama_fktp_pj' },
            // { 'data': 'pemeriksa.nama' },
            // { 'render': function (data, type, row, meta) {
            //     let pasien = (row.pasien && row.pasien.nik ? row.pasien.nik : "");

            //     return pasien
            //     }
            // },
            { 'render': function (data, type, row, meta) {
                let pasien = (row.pasien && row.pasien.nama ? row.pasien.nama : "");

                return pasien
                }
            },
            { 'render': function (data, type, row, meta) {
                let pasien = (row.pasien && row.pasien.jenis_kelamin ? row.pasien.jenis_kelamin : "");

                return pasien
                }
            },
            // { 'render': function (data, type, row, meta) {
            //     let tgl = (row.pasien && row.pasien.tgl_lahir ? row.pasien.tgl_lahir : "");

            //     if (tgl != "") {
            //         let dateParts = tgl.split("-");
            //         let formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
            //         return formattedDate;
            //     }
            //     return "";
            //     }
            // },
            {
            'render': function (data, type, row, meta) {
                let tglLahir = row.pasien?.tgl_lahir;
                let tglPeriksa = row.tanggal_pemeriksaan;
                if (!tglLahir || !tglPeriksa) return "";
                // console.log(tglLahir)
                // console.log(tglPeriksa)

                const tanggalLahir = new Date(tglLahir);
                const tanggalPeriksa = new Date(tglPeriksa);

                let tahun = tanggalPeriksa.getFullYear() - tanggalLahir.getFullYear();
                let bulan = tanggalPeriksa.getMonth() - tanggalLahir.getMonth();
                let hari = tanggalPeriksa.getDate() - tanggalLahir.getDate();

                if (hari < 0) {
                bulan--;
                const prevMonth = new Date(tanggalPeriksa.getFullYear(), tanggalPeriksa.getMonth(), 0);
                hari += prevMonth.getDate();
                }

                if (bulan < 0) {
                tahun--;
                bulan += 12;
                }

                return `${tahun} tahun ${bulan} bulan ${hari} hari`;
                }
            },
            // { 'data': 'hasil_pemeriksaan' },
            { 'data': 'kesimpulan_hasil_pemeriksaan' },
            // { 'data': 'program_tindak_lanjut' },
        ]

        $('#idtabel').dataTable( {
            destroy : true,
            scrollX : true,
            ajax: {
                url: "{{url('laporan/data')}}",
                data: function(d) {
                    d.periode_dari = $('#periode_dari').val(); // Ambil nilai dari input
                    d.periode_sampai = $('#periode_sampai').val();
                    d.instrumen = $('#instrumen option:selected').text();
                },
                dataSrc: ''
            },
            columns: col
        });
    }

    var ar_hasil_pemeriksaan = []
    var dt

    function oc_modal(fitur, id_riwayat){
        console.log(semua_riwayat)
        ar_hasil_pemeriksaan = []
        ar_program_tindak_lanjut = []

        console.log(semua_riwayat)

        dt = semua_riwayat.find(function(entry) {
            return entry.id == id_riwayat;
        });
        console.log(dt)
        
        if(dt==null){
            // console.log("null")
            dt = {
                id: '',
                tanggal_pemeriksaan: '',
                tempat_periksa: '',
                nama_fktp_pj: '',
                pemeriksa_nik: '',
                pemeriksa_nama: '',
                pasien_nik: '',
                pasien_nama: '',
                pasien_jenis_kelamin: '',
                pasien_tgl_lahir: '',

                pasien_provinsi_ktp_kode: '',
                pasien_provinsi_ktp_nama: '',
                pasien_kota_kab_ktp_kode: '',
                pasien_kota_kab_ktp_nama: '',
                pasien_kecamatan_ktp_kode: '',
                pasien_kecamatan_ktp_nama: '',
                pasien_kelurahan_ktp_kode: '',
                pasien_kelurahan_ktp_nama: '',
                pasien_alamat_ktp: '',
                
                pasien_provinsi_dom_kode: '',
                pasien_provinsi_dom_nama: '',
                pasien_kota_kab_dom_kode: '',
                pasien_kota_kab_dom_nama: '',
                pasien_kecamatan_dom_kode: '',
                pasien_kecamatan_dom_nama: '',
                pasien_kelurahan_dom_kode: '',
                pasien_kelurahan_dom_nama: '',
                pasien_alamat_dom: '',

                pasien_no_hp: '',
                hasil_pemeriksaan: '',
                hasil_pemeriksaan_lainnya: '',
                kesimpulan_hasil: '',
                program_tindak_lanjut: '',
            }
        }
        
        // console.log(id_riwayat)
        // console.log(fitur)
        // console.log(dt.id_pasien)
        // console.log(id_pasien)
        // console.log("id_petugas"+id_petugas)
        // var role_auth = "{{ Auth::user()->role }}";
        // console.log(role_auth)
        $('#exampleModal .modal-title').text(fitur+' Pasien');
        
            // let hasil_pemeriksaan_lainnya = JSON.parse(JSON.stringify(dt.hasil_pemeriksaan_lainnya));
            console.log(dt.hasil_pemeriksaan_lainnya)

            var html='\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Identitas Pasien</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">NIK</div>\
                <div class="col-8"><input id="nik_pasien" type="text" value="'+((dt.pasien_nik != "")?dt.pasien_nik:"")+'" oninput="oi_nik()" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Nama</div>\
                <div class="col-8"><input id="nama_pasien" type="text" value="'+((dt.pasien_nama != "")?dt.pasien_nama:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Jenis Kelamin</div>\
                <div class="col-8"><select id="jenis_kelamin" style="width:100%">\
                    <option value="Laki-laki" '+(((dt.pasien_jenis_kelamin != "" && dt.pasien_jenis_kelamin === "Laki-laki") ? "selected" : ""))+'>Laki-laki</option>\
                    <option value="Perempuan" '+(((dt.pasien_jenis_kelamin != "" && dt.pasien_jenis_kelamin === "Perempuan") ? "selected" : ""))+'>Perempuan</option></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Tanggal Lahir</div>\
                <div class="col-8"><input id="tgl_lahir" type="date" value="'+((dt.pasien_tgl_lahir != "")?dt.pasien_tgl_lahir:"")+'" style="width:100%" onchange="oc_tgl_pemeriksaan_dan_lahir()"></input></div>\
            </div>\
            <div class="row mb-3">\
                <div class="col-12"><b>KTP</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Provinsi</div>\
                <div class="col-8"><select class="form-control" id="provinsi_ktp" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kota/Kab</div>\
                <div class="col-8"><select class="form-control" id="kota_kab_ktp" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kecamatan</div>\
                <div class="col-8"><select class="form-control" id="kecamatan_ktp" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kelurahan</div>\
                <div class="col-8"><select class="form-control" id="kelurahan_ktp" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Alamat</div>\
                <div class="col-8"><input id="alamat_ktp" type="text" value="'+((dt.pasien_alamat_ktp != "")?dt.pasien_alamat_ktp:"")+'" style="width: 100%;"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><input type="checkbox" id="alamat_sama" name="alamat_sama" value="alamat_sama" onchange="oc_alamat_ktp_sama_domisili()"><label for="l_alamat_sama" style="margin-left:5px"> Alamat domisili sama dengan alamat ktp</label></div>\
            </div>\
            <div class="row mb-3">\
                <div class="col-12"><b>Domisili</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Provinsi</div>\
                <div class="col-8"><select class="form-control" id="provinsi_dom" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kota/Kab</div>\
                <div class="col-8"><select class="form-control" id="kota_kab_dom" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kecamatan</div>\
                <div class="col-8"><select class="form-control" id="kecamatan_dom" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Kelurahan</div>\
                <div class="col-8"><select class="form-control" id="kelurahan_dom" style="width: 100%;"></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Alamat</div>\
                <div class="col-8"><input id="alamat_dom" type="text" value="'+((dt.pasien_alamat_dom != "")?dt.pasien_alamat_dom:"")+'" style="width: 100%;"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Usia</div>\
                <div class="col-8"><input id="usia" type="text" style="width: 100%;" readonly></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">No HP</div>\
                <div class="col-8"><input id="no_hp" type="text" value="'+((dt.pasien_no_hp != "")?dt.pasien_no_hp:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Tanggal Pemeriksaan</div>\
                <div class="col-8"><input id="tanggal_pemeriksaan" type="date" value="'+((dt.tanggal_pemeriksaan != "") != ""?dt.tanggal_pemeriksaan:"")+'" onchange="oc_tgl_pemeriksaan_dan_lahir()" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Tempat Periksa</div>\
                <div class="col-8">\
                    <select id="tempat_periksa" style="width:100%">\
                        <option value="Puskesmas" '+(((dt.tempat_periksa != "" && dt.tempat_periksa === "Puskesmas") ? "selected" : ""))+'>Puskesmas</option>\
                        <option value="Klinik" '+(((dt.tempat_periksa != "" && dt.tempat_periksa === "Klinik") ? "selected" : ""))+'>Klinik</option>\
                        <option value="Praktek Dokter Mandiri" '+(((dt.tempat_periksa != "" && dt.tempat_periksa === "Praktek Dokter Mandiri") ? "selected" : ""))+'>Praktek Dokter Mandiri</option>\
                        <option value="Pustu" '+(((dt.tempat_periksa != "" && dt.tempat_periksa === "Pustu") ? "selected" : ""))+'>Pustu</option>\
                        <option value="Lainnya" '+(((dt.tempat_periksa != "" && dt.tempat_periksa === "Lainnya") ? "selected" : ""))+'>Lainnya</option>\
                    </select>\
                </div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Nama FKTP PJ</div>\
                <div class="col-8"><input id="nama_fktp_pj" type="text" value="'+((dt.nama_fktp_pj != "") != ""?dt.nama_fktp_pj:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Identitas Pemeriksa</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">NIK</div>\
                <div class="col-8"><input id="nik_pemeriksa" type="text" value="'+((dt.pemeriksa_nik != "")?dt.pemeriksa_nik:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Nama</div>\
                <div class="col-8"><input id="nama_pemeriksa" type="text" value="'+((dt.pemeriksa_nama != "")?dt.pemeriksa_nama:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Hasil Pemeriksaan Kesehatan</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12" id="id_hasil_pemeriksaan" style="width:100%"></div>\
            </div>'
            if(fitur=="Edit"){
                html+=
                '<div class="row mb-3" style="display:flex">\
                    <div class="col-12"><b>Hasil Pemeriksaan Kesehatan Lainnya (ASIK)</b></div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-12" style="width:100%"><textarea style="width:100%; height:100px" id="hasil_pemeriksaan_lainnya" readonly>'+dt.hasil_pemeriksaan_lainnya+'</textarea></div>\
                </div>'
            }
        html+='<div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Kesimpulan Hasil</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Hasil Pemeriksaan</div>\
                <div class="col-8">\
                    <select id="kesimpulan_hasil_pemeriksaan" style="width:100%">\
                        <option value="">Pilih</option>\
                        <option value="Normal dan faktor resiko tidak terdeteksi" '+(((dt.kesimpulan_hasil_pemeriksaan != "" && dt.kesimpulan_hasil_pemeriksaan === "Normal dan faktor resiko tidak terdeteksi") ? "selected" : ""))+'>Normal dan faktor resiko tidak terdeteksi</option>\
                        <option value="Normal dengan faktor resiko" '+(((dt.kesimpulan_hasil_pemeriksaan != "" && dt.kesimpulan_hasil_pemeriksaan === "Normal dengan faktor resiko") ? "selected" : ""))+'>Normal dengan faktor resiko</option>\
                        <option value="Menunjukkan kondisi pra penyakit" '+(((dt.kesimpulan_hasil_pemeriksaan != "" && dt.kesimpulan_hasil_pemeriksaan === "Menunjukkan kondisi pra penyakit") ? "selected" : ""))+'>Menunjukkan kondisi pra penyakit</option>\
                        <option value="Menunjukkan kondisi penyakit" '+(((dt.kesimpulan_hasil_pemeriksaan != "" && dt.kesimpulan_hasil_pemeriksaan === "Menunjukkan kondisi penyakit") ? "selected" : ""))+'>Menunjukkan kondisi penyakit</option>\
                    </select>\
                </div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Program Tindak Lanjut</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Edukasi yang diberikan</div>\
                <div class="col-8"><input id="edukasi" type="text" value="" oninput="oc_program_tindak_lanjut(\'edukasi\')" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Rujuk FKTRL (disertai dengan keterangan)</div>\
                <div class="col-8"><input id="rujuk_fktrl" type="text" value="" oninput="oc_program_tindak_lanjut(\'rujuk_fktrl\')" style="width:100%"></input></div>\
            </div>'

        $('#exampleModal .modal-body').html(html);
        // $('#exampleModal .modal-footer').html('<button type="button" class="btn btn-success" onclick="oc_fitur(\''+fitur+'\', \''+id_riwayat+'\')">'+fitur+'</button>');
        
        oc_tgl_pemeriksaan_dan_lahir()
        get_program_tindak_lanjut()
        get_provinsi_ktp(dt.pasien_provinsi_ktp, dt.pasien_provinsi_ktp_nama)
        get_kota_kab_ktp(dt.pasien_kota_kab_ktp, dt.pasien_kota_kab_ktp_nama)
        get_kecamatan_ktp(dt.pasien_kecamatan_ktp, dt.pasien_kecamatan_ktp_nama)
        get_kelurahan_ktp(dt.pasien_kelurahan_ktp, dt.pasien_kelurahan_ktp_nama)
        
        get_provinsi_dom(dt.pasien_provinsi_dom, dt.pasien_provinsi_dom_nama)
        get_kota_kab_dom(dt.pasien_kota_kab_dom, dt.pasien_kota_kab_dom_nama)
        get_kecamatan_dom(dt.pasien_kecamatan_dom, dt.pasien_kecamatan_dom_nama)
        get_kelurahan_dom(dt.pasien_kelurahan_dom, dt.pasien_kelurahan_dom_nama)
        
        if(dt.nik!=""){
            oi_nik()
        }

        $('#exampleModal').modal('show');
    }

    function oi_nik(){
        //     let nik = $('#nik_pasien').val()
            
        //     get_provinsi(nik)
        //     get_kota_kab(nik)
        //     get_kecamatan(nik)
        //     // get_kelurahan(nik, kode_kelurahan)
    }

    function get_provinsi_ktp(kode, nama) {
        // if(nik.length >= 6){
            // let kode_prov = nik.slice(-2);
            // let kode_prov = nik.slice(0, 2);
            
            // $.ajax({
            //     url: "{{ url('master_provinsi') }}",
            //     dataType: 'json',
            //     data: { search: kode_prov },
            //     success: function(data) {
            //         if (data.length == 1) {
            //             $('#provinsi').html(data[0].nama)
            //         }
            //         else{
            //             $('#provinsi').html("")
            //         }
            //     },
            //     error: function(xhr, status, error) {
            //         console.error("Error fetching province:", error);
            //     }
            // });
            // console.log("provinsi ktp"+kode+nama)
            $('#provinsi_ktp')
            .empty()
            .append($("<option/>")
                .val(kode)
                .text(nama))
            .val(kode)
            // .append($("<option/>")
            //     .val("")
            //     .text(""))
            // .val("")
            .trigger("change");

            $('#provinsi_ktp').select2({
                placeholder: 'Cari...',
                allowClear: true,
                width: 'resolve',
                dropdownParent: $(".modal-body"),
                theme: 'bootstrap4',
                ajax: {
                    url: "{{ url('master_provinsi') }}",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        console.log(params.term)
                        return {
                            search: params.term,
                            kode_provinsi: kode,
                        };
                    },
                    processResults: function(data) {
                        console.log(data)
                        return {
                            results: data
                                .map(function(item) {
                                    return {
                                        id: item.kode,
                                        text: item.nama,
                                    };
                                })
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                    },
                    // cache: true
                },
                // minimumInputLength: 2,
            });
        // }
    }

    function get_kota_kab_ktp(kode, nama) {
        $('#kota_kab_ktp')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kota_kab_ktp').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kota_kab') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    // if(kode==""){
                    let kode_provinsi = $('#provinsi_ktp').val();
                        // console.log("kode"+kode_provinsi)
                    // }
                    // console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode_provinsi,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function get_kecamatan_ktp(kode, nama) {
        $('#kecamatan_ktp')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kecamatan_ktp').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kecamatan') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    let kode = $('#kota_kab_ktp').val();
                    // console.log(kode_provinsi)
                    
                    console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function get_kelurahan_ktp(kode, nama) {
        $('#kelurahan_ktp')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kelurahan_ktp').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kelurahan') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    let kode = $('#kecamatan_ktp').val();
                    // console.log(kode_provinsi)
                    
                    console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function get_provinsi_dom(kode, nama) {
        // console.log("provinsi dom"+kode+nama)
            $('#provinsi_dom')
            .empty()
            .append($("<option/>")
                .val(kode)
                .text(nama))
            .val(kode)
            // .append($("<option/>")
            //     .val("")
            //     .text(""))
            // .val("")
            .trigger("change");

            $('#provinsi_dom').select2({
                placeholder: 'Cari...',
                allowClear: true,
                width: 'resolve',
                theme: 'bootstrap4',
                dropdownParent: $(".modal-body"),
                ajax: {
                    url: "{{ url('master_provinsi') }}",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        console.log(params.term)
                        return {
                            search: params.term,
                            kode_provinsi: kode,
                        };
                    },
                    processResults: function(data) {
                        console.log(data)
                        return {
                            results: data
                                .map(function(item) {
                                    return {
                                        id: item.kode,
                                        text: item.nama,
                                    };
                                })
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                    },
                    // cache: true
                },
                // minimumInputLength: 2,
            });
        // }
    }

    function get_kota_kab_dom(kode, nama) {
        $('#kota_kab_dom')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kota_kab_dom').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kota_kab') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    // if(kode==""){
                    let kode_provinsi = $('#provinsi_dom').val();
                        // console.log("kode"+kode_provinsi)
                    // }
                    // console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode_provinsi,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function get_kecamatan_dom(kode, nama) {
        $('#kecamatan_dom')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kecamatan_dom').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kecamatan') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    let kode = $('#kota_kab_dom').val();
                    // console.log(kode_provinsi)
                    
                    console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function get_kelurahan_dom(kode, nama) {
        $('#kelurahan_dom')
        .empty()
        .append($("<option/>")
            .val(kode)
            .text(nama))
        .val(kode)
        .trigger("change");

        $('#kelurahan_dom').select2({
            placeholder: 'Cari...',
            allowClear: true,
            width: 'resolve',
            theme: 'bootstrap4',
            dropdownParent: $(".modal-body"),
            ajax: {
                url: "{{ url('master_kelurahan') }}",
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    let kode = $('#kecamatan_dom').val();
                    // console.log(kode_provinsi)
                    
                    console.log(params.term)
                    return {
                        search: params.term,
                        kode_parent: kode,
                        kode: kode

                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                            .map(function(item) {
                                return {
                                    id: item.kode,
                                    text: item.nama,
                                };
                            })
                    };
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                },
                // cache: true
            },
            // minimumInputLength: 2,
        });
    }

    function oc_alamat_ktp_sama_domisili(){
        console.log("oc alamat domisisli")
        let kode_provinsi = $('#provinsi_ktp').val();
        let nama_provinsi = $('#provinsi_ktp').find(':selected').text();

        get_provinsi_dom(kode_provinsi, nama_provinsi)

        let kode_kota_kab = $('#kota_kab_ktp').val();
        let nama_kota_kab = $('#kota_kab_ktp').find(':selected').text();

        get_kota_kab_dom(kode_kota_kab, nama_kota_kab)

        let kode_kecamatan = $('#kecamatan_ktp').val();
        let nama_kecamatan = $('#kecamatan_ktp').find(':selected').text();

        get_kecamatan_dom(kode_kecamatan, nama_kecamatan)

        let kode_kelurahan = $('#kelurahan_ktp').val();
        let nama_kelurahan = $('#kelurahan_ktp').find(':selected').text();

        get_kelurahan_dom(kode_kelurahan, nama_kelurahan)

        let alamat = $('#alamat_ktp').val();
        $('#alamat_dom').val(alamat);

    }

    function oc_fitur(fitur, id_riwayat){
        console.log(fitur)
        // console.log(id_riwayat)
        let vurl = fitur.toLowerCase()
        console.log(vurl)
        if(vurl=="hapus"){
            $.ajax({
                url: `{{url('riwayat')}}/${vurl}`,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id_riwayat,
                },
                success: function(response) {
                    console.log(response)
                    $('#exampleModal').modal('hide');
                    tabel()
                    if(response.status=="Berhasil"){
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil '+fitur+' Pasien'
                        })
                    }
                }
            })
        }
        else if(vurl=="tambah" || vurl=="edit"){
            let tanggal_pemeriksaan = $('#tanggal_pemeriksaan').val();
            let tempat_periksa = $('#tempat_periksa').val();
            let nama_fktp_pj = $('#nama_fktp_pj').val();

            let nik_pemeriksa = $('#nik_pemeriksa').val();
            let nama_pemeriksa = $('#nama_pemeriksa').val();
            
            let nik_pasien = $('#nik_pasien').val();
            let nama_pasien = $('#nama_pasien').val();
            let jenis_kelamin = $('#jenis_kelamin').val();
            let tgl_lahir = $('#tgl_lahir').val();
            let provinsi_ktp = $('#provinsi_ktp').val();
            let kota_kab_ktp = $('#kota_kab_ktp').val();
            let kecamatan_ktp = $('#kecamatan_ktp').val();
            let kelurahan_ktp = $('#kelurahan_ktp').val();
            let alamat_ktp = $('#alamat_ktp').val();

            let provinsi_dom = $('#provinsi_dom').val();
            let kota_kab_dom = $('#kota_kab_dom').val();
            let kecamatan_dom = $('#kecamatan_dom').val();
            let kelurahan_dom = $('#kelurahan_dom').val();
            let alamat_dom = $('#alamat_dom').val();

            let no_hp = $('#no_hp').val();

            let hasil_pemeriksaan = ar_hasil_pemeriksaan
            let kesimpulan_hasil_pemeriksaan = $('#kesimpulan_hasil_pemeriksaan').val()
            let program_tindak_lanjut = ar_program_tindak_lanjut

            console.log(tanggal_pemeriksaan)
            console.log(tempat_periksa)
            console.log(nama_fktp_pj)
            console.log(nik_pemeriksa) 
            console.log(nama_pemeriksa)
            console.log(nama_pasien)
            console.log(nik_pasien)
            console.log(jenis_kelamin)
            console.log(tgl_lahir)
            console.log(kota_kab_ktp)
            console.log(alamat_ktp)
            console.log(no_hp)
            console.log(hasil_pemeriksaan)
            console.log(kesimpulan_hasil_pemeriksaan)
            console.log(program_tindak_lanjut)

            $.ajax({
                url: `{{url('riwayat')}}/${vurl}`,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id_riwayat,
                    tanggal_pemeriksaan: tanggal_pemeriksaan,
                    tempat_periksa: tempat_periksa,
                    nama_fktp_pj: nama_fktp_pj,

                    nik_pemeriksa: nik_pemeriksa,
                    nama_pemeriksa: nama_pemeriksa,
                    
                    nik_pasien: nik_pasien,
                    nama_pasien: nama_pasien,
                    jenis_kelamin: jenis_kelamin,
                    tgl_lahir: tgl_lahir,
                    provinsi_ktp: provinsi_ktp,
                    kota_kab_ktp: kota_kab_ktp,
                    kecamatan_ktp: kecamatan_ktp,
                    kelurahan_ktp: kelurahan_ktp,
                    alamat_ktp: alamat_ktp,

                    provinsi_dom: provinsi_dom,
                    kota_kab_dom: kota_kab_dom,
                    kecamatan_dom: kecamatan_dom,
                    kelurahan_dom: kelurahan_dom,
                    alamat_dom: alamat_dom,

                    no_hp: no_hp,

                    ar_hasil_pemeriksaan: ar_hasil_pemeriksaan,
                    kesimpulan_hasil_pemeriksaan: kesimpulan_hasil_pemeriksaan,
                    program_tindak_lanjut: program_tindak_lanjut
                },
                success: function(response) {
                    console.log(response)
                    $('#exampleModal').modal('hide');
                    tabel()
                    if(response.status=="Berhasil"){
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil '+fitur+' Pasien'
                        })
                    }
                    // else{
                    //     Toast.fire({
                    //         icon: 'error',
                    //         title: 'Data Pasien Sudah Ada'
                    //     })
                    // }

                }
            })
        }

    }

    function oc_tgl_pemeriksaan_dan_lahir() {
        var tgl_lahir = $('#tgl_lahir').val()
        var tanggal_pemeriksaan = $('#tanggal_pemeriksaan').val()
        

        console.log(tgl_lahir)
        console.log(tanggal_pemeriksaan)
        if (tgl_lahir !== "") {
            const tglPemeriksaanInput = document.getElementById('tanggal_pemeriksaan');

            const hari_ini = new Date();
            const tahun_ini = hari_ini.getFullYear();

            var lahir = new Date(tgl_lahir);

            // Ambil hari dan bulan dari tanggal lahir dalam format dua digit
            const tgl_lahir_hari = lahir.getDate().toString().padStart(2, '0');
            const tgl_lahir_bulan = (lahir.getMonth() + 1).toString().padStart(2, '0');

            console.log("Tanggal Lahir:", tgl_lahir_hari + "/" + tgl_lahir_bulan);

            // Konversi bulan lahir ke angka untuk pengecekan
            const bulan_lahir_num = parseInt(tgl_lahir_bulan, 10);

            let tgl_pemeriksaan_min_format;
            let tgl_pemeriksaan_max_format;

            if (bulan_lahir_num >= 1 && bulan_lahir_num <= 2) {
                // Jika lahir antara Januari - Februari
                const tgl_ulang_tahun_2025 = new Date(`2025-${tgl_lahir_bulan}-${tgl_lahir_hari}`);
                const tgl_max_pemeriksaan = new Date(`2025-04-30`);  // 30 April 2025

                tgl_pemeriksaan_min_format = tgl_ulang_tahun_2025.toISOString().split('T')[0];
                tgl_pemeriksaan_max_format = tgl_max_pemeriksaan.toISOString().split('T')[0];

                console.log("Lahir Jan-Feb: Pemeriksaan dari", tgl_pemeriksaan_min_format, "hingga", tgl_pemeriksaan_max_format);
            } else {
                // Jika lahir antara Maret - Desember
                const tgl_ulang_tahun_ini = new Date(`${tahun_ini}-${tgl_lahir_bulan}-${tgl_lahir_hari}`);

                // Tanggal pemeriksaan minimum = tanggal ulang tahun tahun ini
                tgl_pemeriksaan_min_format = tgl_ulang_tahun_ini.toISOString().split('T')[0];

                // Tanggal pemeriksaan maksimum = 30 hari setelah ulang tahun
                tgl_ulang_tahun_ini.setDate(tgl_ulang_tahun_ini.getDate() + 30);
                tgl_pemeriksaan_max_format = tgl_ulang_tahun_ini.toISOString().split('T')[0];

                console.log("Lahir Mar-Des: Pemeriksaan dari ulang tahun hingga +30 hari");
            }

            // Set atribut min dan max pada input tanggal pemeriksaan
            console.log("Tanggal Pemeriksaan Min:", tgl_pemeriksaan_min_format);
            console.log("Tanggal Pemeriksaan Max:", tgl_pemeriksaan_max_format);
            tglPemeriksaanInput.min = tgl_pemeriksaan_min_format;
            tglPemeriksaanInput.max = tgl_pemeriksaan_max_format;
        }

        if(tgl_lahir!="" && tanggal_pemeriksaan!=""){
            // var lahir = new Date(tgl_lahir);
            var periksa = new Date(tanggal_pemeriksaan);

            var tahun = periksa.getFullYear() - lahir.getFullYear();
            var bulan = periksa.getMonth() - lahir.getMonth();
            var hari = periksa.getDate() - lahir.getDate();

            if (bulan < 0) {
                tahun--;
                bulan += 12;
            }

            if (hari < 0) {
                bulan--;
                var lastMonth = new Date(periksa.getFullYear(), periksa.getMonth(), 0);
                hari += lastMonth.getDate();
            }

            $('#usia').val(tahun + " Tahun " + bulan + " Bulan " + hari + " Hari");

            if(tahun == 0 && bulan == 0 && hari >= 0 && hari <= 28){
                bbl()
            }
            if(tahun >= 1 && tahun <= 6){
                balita_dan_pra_sekolah(tahun)
            }
            if(tahun >= 18 && tahun <= 29){
                dewasa_18_29_tahun()
            }
            if(tahun >= 30 && tahun <= 39){
                dewasa_30_39_tahun()
            }
            if(tahun >= 40 && tahun <= 59){
                dewasa_40_59_tahun()
            }
            if(tahun >= 60){
                lansia()
            }
        }
    }

    function formatDate(date) {
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return day + '/' + month + '/' + year;
    }

    function bbl(){
        console.log(dt)

        let variabel = ['pertumbuhan_bb', 'penyakit_jantung_bawaan', 'kekurangan_hormon_tiroid', 'kekurangan_enzim_d6pd', 'kekurangan_hormon_adrenal', 'kelainan_saluran_empedu']

        let html = ''

        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Pertumbuhan (BB)</div>\
                    <div class="col-8">\
                        <select id="pertumbuhan_bb" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'pertumbuhan_bb\')">\
                            <option value="">Pilih</option>\
                            <option value="BB Lahir ≥ 2500 gr">BB Lahir ≥ 2500 gr</option>\
                            <option value="BBLR (2000 - < 2500 gr) dan sehat">BBLR (2000 - < 2500 gr) dan sehat</option>\
                            <option value="BBLR (2000 - <2500 gr) dan sakit">BBLR (2000 - <2500 gr) dan sakit</option>\
                            <option value="BBLR < 2000 gr">BBLR < 2000 gr</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Penyakit Jantung Bawaan Kritis</div>\
                    <div class="col-8">\
                        <select id="penyakit_jantung_bawaan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'penyakit_jantung_bawaan\')">\
                            <option value="">Pilih</option>\
                            <option value=">95%, Perbedaan <3% di tangan kanan dan kaki">>95%, Perbedaan <3% di tangan kanan dan kaki</option>\
                            <option value="90-95% atau perbedaan >3% di tangan dan kaki">90-95% atau perbedaan >3% di tangan dan kaki</option>\
                            <option value="<90%"> <90%</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kekurangan Hormon Tiroid Sejak Lahir (TSHS)</div>\
                    <div class="col-8">\
                        <select id="kekurangan_hormon_tiroid" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kekurangan_hormon_tiroid\')">\
                            <option value="">Pilih</option>\
                            <option value="TSH Normal">TSH Normal</option>\
                            <option value="TSH Tinggi">TSH Tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kekurangan Enzim Pelindung Sel Darah Merah (D6PD)</div>\
                    <div class="col-8">\
                        <select id="kekurangan_enzim_d6pd" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kekurangan_enzim_d6pd\')">\
                            <option value="">Pilih</option>\
                            <option value="Negatif">Negatif</option>\
                            <option value="Positif">Positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kekurangan Hormon Adrenal Sejak Lahir</div>\
                    <div class="col-8">\
                        <select id="kekurangan_hormon_adrenal" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kekurangan_hormon_adrenal\')">\
                            <option value="">Pilih</option>\
                            <option value="Negatif">Negatif</option>\
                            <option value="Positif">Positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kelainan Saluran Empedu</div>\
                    <div class="col-8">\
                        <select id="kelainan_saluran_empedu" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kelainan_saluran_empedu\')">\
                            <option value="">Pilih</option>\
                            <option value="Warna tinja Normal">Warna tinja Normal</option>\
                            <option value="Warna tinja Pucat">Warna tinja Pucat</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function balita_dan_pra_sekolah(tahun){
        console.log(dt)
        let variabel = ['indeks_pbu_tbu', 'indeks_bbpb_bbtb', 'indeks_bbu', 'indeks_imtu', 'lingkar_kepala', 'perkembangan', 'tuberkulosis', 'telinga', 'pupil_putih', 'tes_e_tumbling', 'gigi', 'talasemia', 'gula_darah']

        let html = ''

        if(tahun < 6){
        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Indeks PB/U atau TB/U</div>\
                    <div class="col-8">\
                        <select id="indeks_pbu_tbu" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'indeks_pbu_tbu\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Pendek atau sangat pendek">Pendek atau sangat pendek</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Indeks BB/PB atau BB/TB</div>\
                    <div class="col-8">\
                        <select id="indeks_bbpb_bbtb" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'indeks_bbpb_bbtb\')">\
                            <option value="">Pilih</option>\
                            <option value="Gizi Baik (Normal)">Gizi Baik (Normal)</option>\
                            <option value="Gizi kurang (Tanpa Stunting)">Gizi kurang (Tanpa Stunting)</option>\
                            <option value="Beresiko gizi lebih">Beresiko gizi lebih</option>\
                            <option value="Gizi lebih (Overweight)">Gizi lebih (Overweight)</option>\
                            <option value="Obesitas">Obesitas</option>\
                            <option value="Gizi buruk (tanpa stunting)">Gizi buruk (tanpa stunting)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Indeks BB/U</div>\
                    <div class="col-8">\
                        <select id="indeks_bbu" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'indeks_bbu\')">\
                            <option value="">Pilih</option>\
                            <option value="Berat badan normal">Berat badan normal</option>\
                            <option value="Berat badan kurang (tanpa stunting)">Berat badan kurang (tanpa stunting)</option>\
                            <option value="Berat badan sangat kurang (tanpa stunting)">Berat badan sangat kurang (tanpa stunting)</option>\
                            <option value="Risiko berat badan lebih">Risiko berat badan lebih</option>\
                        </select>\
                    </div>\
                </div>'
        }
        if(tahun >= 6){
        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Indeks (IMT/U)</div>\
                    <div class="col-8">\
                        <select id="indeks_imtu" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'indeks_imtu\')">\
                            <option value="">Pilih</option>\
                            <option value="Gizi baik (normal)">Gizi baik (normal)</option>\
                            <option value="Gizi kurang (Wasted)">Gizi kurang (Wasted)</option>\
                            <option value="Gizi lebih (Overweight)">Gizi lebih (Overweight)</option>\
                            <option value="Obesitas">Obesitas</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Lingkar Kepala Menurut Umur</div>\
                    <div class="col-8">\
                        <select id="lingkar_kepala" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'lingkar_kepala\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Mikrosefali atau Makrosefali">Mikrosefali atau Makrosefali</option>\
                        </select>\
                    </div>\
                </div>'
        }
        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Perkembangan</div>\
                    <div class="col-8">\
                        <select id="perkembangan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'perkembangan\')">\
                            <option value="">Pilih</option>\
                            <option value="Sesuai umur">Sesuai umur</option>\
                            <option value="Meragukan">Meragukan</option>\
                            <option value="Ada kemungkinan penyimpangan">Ada kemungkinan penyimpangan</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tuberkulosis</div>\
                    <div class="col-8">\
                        <select id="tuberkulosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tuberkulosis\')">\
                            <option value="">Pilih</option>\
                            <option value="Bukan Terduga TB (Tidak terdapat tanda, gejala dan kontak erat TB)">Bukan Terduga TB (Tidak terdapat tanda, gejala dan kontak erat TB)</option>\
                            <option value="Terduga TB (Ada gejala & tanda TB)">Terduga TB (Ada gejala & tanda TB)</option>\
                            <option value="Tidak ada gejala namun terdapat kontak erat/serumah atau faktor risiko lainnya">Tidak ada gejala namun terdapat kontak erat/serumah atau faktor risiko lainnya</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Telinga</div>\
                    <div class="col-8">\
                        <select id="telinga" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'telinga\')">\
                            <option value="">Pilih</option>\
                            <option value="Semua jawaban YA - perkembangan sesuai umur">Semua jawaban YA - perkembangan sesuai umur</option>\
                            <option value="Ada jawaban TIDAK - ada kemungkinan penyimpangan">Ada jawaban TIDAK - ada kemungkinan penyimpangan</option>\
                        </select>\
                    </div>\
                </div>'
        if(tahun >= 1 && tahun < 3){
            html+='<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Pemeriksaan pupil putih</div>\
                    <div class="col-8">\
                        <select id="pupil_putih" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'pupil_putih\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Curiga kelainan pupil putih pada anak">Curiga kelainan pupil putih pada anak</option>\
                        </select>\
                    </div>\
                </div>'
        }
        if(tahun >= 3 && tahun <=6){
        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tes “E” tumbling</div>\
                    <div class="col-8">\
                        <select id="tes_e_tumbling" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_e_tumbling\')">\
                            <option value="">Pilih</option>\
                            <option value="3x benar Berturut-turut atau 4x benar atau lebih dalam 5x kesempatan serta Daya Lihat Anak Baik (Visus >6/12 atau >6/60)">3x benar Berturut-turut atau 4x benar atau lebih dalam 5x kesempatan serta Daya Lihat Anak Baik (Visus >6/12 atau >6/60)</option>\
                            <option value="3x Salah Berturut-turut atau <4x benar dalam 5x kesempatan & Daya Lihat Anak Kurang (Visus <6/12 atau <6/60)">3x Salah Berturut-turut atau <4x benar dalam 5x kesempatan & Daya Lihat Anak Kurang (Visus <6/12 atau <6/60)</option>\
                        </select>\
                    </div>\
                </div>'
        }
        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gigi</div>\
                    <div class="col-8">\
                        <select id="gigi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gigi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada karies">Tidak ada karies</option>\
                            <option value="Ada karies">Ada karies</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Talasemia</div>\
                    <div class="col-8">\
                        <select id="talasemia" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'talasemia\')">\
                            <option value="">Pilih</option>\
                            <option value="Hemoglobin normal (≥11 g/dL)">Hemoglobin normal (≥11 g/dL)</option>\
                            <option value="Hemoglobin di bawah normal (< 11 g/dL)">Hemoglobin di bawah normal (< 11 g/dL)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gula Darah</div>\
                    <div class="col-8">\
                        <select id="gula_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gula_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Anamnesis tanda dan gejala negatif">Anamnesis tanda dan gejala negatif</option>\
                            <option value="Anamnesis tanda dan gejala positif (GDS Normal)">Anamnesis tanda dan gejala positif (GDS Normal)</option>\
                            <option value="GDP < 100 mgdl">GDP < 100 mgdl</option>\
                            <option value="GDP ≥100 mg/dl">GDP ≥100 mg/dl</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function dewasa_18_29_tahun(){
        console.log("18")
        console.log(dt)
        let variabel = ['status_gizi', 'tuberkulosis', 'tekanan_darah', 'gula_darah', 'tes_pendengaran', 'tes_penglihatan', 'gigi', 'kesehatan_jiwa', 'merokok', 'aktivitas_fisik', 'faktor_resiko', 'hepatitis_b', 'hepatitis_c', 'fibrosis_sirosis', 'anemia', 'hiv', 'sifilis', 'napza', 'status_imunisasi_tt']

        let html = ''

        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Gizi</div>\
                    <div class="col-8">\
                        <select id="status_gizi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_gizi\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Overweight">Overweight</option>\
                            <option value="Underweight">Underweight</option>\
                            <option value="Obesitas">Obesitas</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tuberkulosis</div>\
                    <div class="col-8">\
                        <select id="tuberkulosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tuberkulosis\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdapat tanda, gejala dan Kontak erat TB">Tidak terdapat tanda, gejala dan Kontak erat TB</option>\
                            <option value="Terdapat kontak erat TB Positif tanpa gejala">Terdapat kontak erat TB Positif tanpa gejala</option>\
                            <option value="Terdapat kontak erat TB positif dengan gejala">Terdapat kontak erat TB positif dengan gejala</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tekanan Darah</div>\
                    <div class="col-8">\
                        <select id="tekanan_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tekanan_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdiagnosis Hipertensi atau prehipertensi">Tidak terdiagnosis Hipertensi atau prehipertensi</option>\
                            <option value="Terdiagnosis hipertensi tanpa tanda bahaya">Terdiagnosis hipertensi tanpa tanda bahaya</option>\
                            <option value="Terdiagnosis hipertensi dengan tanda bahaya">Terdiagnosis hipertensi dengan tanda bahaya</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gula Darah</div>\
                    <div class="col-8">\
                        <select id="gula_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gula_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal (GDS<100)">Normal (GDS<100)</option>\
                            <option value="Prediabetes (GDS 140 - 199)">Prediabetes (GDS 140 - 199)</option>\
                            <option value="Hiperglikemia (GDS > 200)">Hiperglikemia (GDS > 200)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Telinga (Tes Pendengaran)</div>\
                    <div class="col-8">\
                        <select id="tes_pendengaran" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_pendengaran\')">\
                            <option value="">Pilih</option>\
                            <option value="Lulus">Lulus</option>\
                            <option value="Tidak lulus (Hasil normal)">Tidak lulus (Hasil normal)</option>\
                            <option value="Tidak lulus (ditemukan gangguan atau kelainan)">Tidak lulus (ditemukan gangguan atau kelainan)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Mata (Tes Tajam Penglihatan)</div>\
                    <div class="col-8">\
                        <select id="tes_penglihatan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_penglihatan\')">\
                            <option value="">Pilih</option>\
                            <option value="Visus (6/6 - 6/12)">Visus (6/6 - 6/12)</option>\
                            <option value="Abnormal (Visus <6/12)">Abnormal (Visus <6/12)</option>\
                            <option value="Visus membaik">Visus membaik</option>\
                            <option value="Visus tidak membaik">Visus tidak membaik</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gigi</div>\
                    <div class="col-8">\
                        <select id="gigi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gigi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada karies (normal)">Tidak ada karies (normal)</option>\
                            <option value="Ada karies, gigi goyang">Ada karies, gigi goyang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kesehatan Jiwa</div>\
                    <div class="col-8">\
                        <select id="kesehatan_jiwa" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kesehatan_jiwa\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak ada gangguan jiwa">Tidak ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa">Ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa dengan penyulit">Ada gangguan jiwa dengan penyulit</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Merokok</div>\
                    <div class="col-8">\
                        <select id="merokok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'merokok\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak merokok">Tidak merokok</option>\
                            <option value="Merokok">Merokok</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tingkat Aktivitas Fisik</div>\
                    <div class="col-8">\
                        <select id="aktivitas_fisik" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'aktivitas_fisik\')">\
                            <option value="">Pilih</option>\
                            <option value="Cukup">Cukup</option>\
                            <option value="Kurang">Kurang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Faktor Resiko</div>\
                    <div class="col-8">\
                        <select id="faktor_resiko" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'faktor_resiko\')">\
                            <option value="">Pilih</option>\
                            <option value="Faktor resiko hati negatif">Faktor resiko hati negatif</option>\
                            <option value="Faktor resiko hati positif">Faktor resiko hati positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis B</div>\
                    <div class="col-8">\
                        <select id="hepatitis_b" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_b\')">\
                            <option value="">Pilih</option>\
                            <option value="HBsAg Non Reaktif">HBsAg Non Reaktif</option>\
                            <option value="HBsAg Reaktif">HBsAg Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis C</div>\
                    <div class="col-8">\
                        <select id="hepatitis_c" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_c\')">\
                            <option value="">Pilih</option>\
                            <option value="Anti HCV Non Reaktif">Anti HCV Non Reaktif</option>\
                            <option value="Anti HCV Reaktif">Anti HCV Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fibrosis/Sirosis</div>\
                    <div class="col-8">\
                        <select id="fibrosis_sirosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fibrosis_sirosis\')">\
                            <option value="">Pilih</option>\
                            <option value="APRI Score ≤ 0.5">APRI Score ≤ 0.5</option>\
                            <option value="APRI Score >0.5">APRI Score >0.5</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Anemia (Hb Test)</div>\
                    <div class="col-8">\
                        <select id="anemia" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'anemia\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak Normal (Hb <12 gr/dL)">Tidak Normal (Hb <12 gr/dL)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">HIV</div>\
                    <div class="col-8">\
                        <select id="hiv" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hiv\')">\
                            <option value="">Pilih</option>\
                            <option value="Non Reaktif">Non Reaktif</option>\
                            <option value="Reaktif">Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Sifilis</div>\
                    <div class="col-8">\
                        <select id="sifilis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'sifilis\')">\
                            <option value="">Pilih</option>\
                            <option value="RDT HIV R1 Non Reaktif">RDT HIV R1 Non Reaktif</option>\
                            <option value="R2 dan R3 Reaktif">R2 dan R3 Reaktif</option>\
                            <option value="R2 dan R3 Non Reaktif">R2 dan R3 Non Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">NAPZA</div>\
                    <div class="col-8">\
                        <select id="napza" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'napza\')">\
                            <option value="">Pilih</option>\
                            <option value="Menggunakan salah satu zat atau minum alkohol">Menggunakan salah satu zat atau minum alkohol</option>\
                            <option value="Tidak pernah">Tidak pernah</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Imunisasi TT</div>\
                    <div class="col-8">\
                        <select id="status_imunisasi_tt" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_imunisasi_tt\')">\
                            <option value="">Pilih</option>\
                            <option value="Status imunisasi TT Lengkap">Status imunisasi TT Lengkap</option>\
                            <option value="Status imunisasi TT belum lengkap">Status imunisasi TT belum lengkap</option>\
                            <option value="Bukan Calon pengantin">Bukan Calon pengantin</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function dewasa_30_39_tahun(){
        console.log(dt)
        let variabel = ['status_gizi', 'tuberkulosis', 'tekanan_darah', 'gula_darah', 'tes_pendengaran', 'tes_penglihatan', 'gigi', 'kesehatan_jiwa', 'merokok', 'aktivitas_fisik', 'faktor_resiko', 'hepatitis_b', 'hepatitis_c', 'fibrosis_sirosis', 'kanker_payudara', 'kanker_leher_rahim', 'anemia', 'hiv', 'sifilis', 'napza', 'status_imunisasi_tt']

        let html = ''

        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Gizi</div>\
                    <div class="col-8">\
                        <select id="status_gizi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_gizi\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Overweight">Overweight</option>\
                            <option value="Underweight">Underweight</option>\
                            <option value="Obesitas">Obesitas</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tuberkulosis</div>\
                    <div class="col-8">\
                        <select id="tuberkulosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tuberkulosis\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdapat tanda, gejala dan Kontak erat TB">Tidak terdapat tanda, gejala dan Kontak erat TB</option>\
                            <option value="Terdapat kontak erat TB Positif tanpa gejala">Terdapat kontak erat TB Positif tanpa gejala</option>\
                            <option value="Terdapat kontak erat TB positif dengan gejala">Terdapat kontak erat TB positif dengan gejala</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tekanan Darah</div>\
                    <div class="col-8">\
                        <select id="tekanan_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tekanan_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdiagnosis Hipertensi atau prehipertensi">Tidak terdiagnosis Hipertensi atau prehipertensi</option>\
                            <option value="Terdiagnosis hipertensi tanpa tanda bahaya">Terdiagnosis hipertensi tanpa tanda bahaya</option>\
                            <option value="Terdiagnosis hipertensi dengan tanda bahaya">Terdiagnosis hipertensi dengan tanda bahaya</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gula Darah</div>\
                    <div class="col-8">\
                        <select id="gula_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gula_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal (GDS<100)">Normal (GDS<100)</option>\
                            <option value="Prediabetes (GDS 140 - 199)">Prediabetes (GDS 140 - 199)</option>\
                            <option value="Hiperglikemia (GDS > 200)">Hiperglikemia (GDS > 200)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Telinga (Tes Pendengaran)</div>\
                    <div class="col-8">\
                        <select id="tes_pendengaran" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_pendengaran\')">\
                            <option value="">Pilih</option>\
                            <option value="Lulus">Lulus</option>\
                            <option value="Tidak lulus (Hasil normal)">Tidak lulus (Hasil normal)</option>\
                            <option value="Tidak lulus (ditemukan gangguan atau kelainan)">Tidak lulus (ditemukan gangguan atau kelainan)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Mata (Tes Tajam Penglihatan)</div>\
                    <div class="col-8">\
                        <select id="tes_penglihatan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_penglihatan\')">\
                            <option value="">Pilih</option>\
                            <option value="Visus (6/6 - 6/12)">Visus (6/6 - 6/12)</option>\
                            <option value="Abnormal (Visus <6/12)">Abnormal (Visus <6/12)</option>\
                            <option value="Visus membaik">Visus membaik</option>\
                            <option value="Visus tidak membaik">Visus tidak membaik</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gigi</div>\
                    <div class="col-8">\
                        <select id="gigi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gigi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada karies (normal)">Tidak ada karies (normal)</option>\
                            <option value="Ada karies, gigi goyang">Ada karies, gigi goyang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kesehatan Jiwa</div>\
                    <div class="col-8">\
                        <select id="kesehatan_jiwa" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kesehatan_jiwa\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak ada gangguan jiwa">Tidak ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa">Ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa dengan penyulit">Ada gangguan jiwa dengan penyulit</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Merokok</div>\
                    <div class="col-8">\
                        <select id="merokok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'merokok\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak merokok">Tidak merokok</option>\
                            <option value="Merokok">Merokok</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tingkat Aktivitas Fisik</div>\
                    <div class="col-8">\
                        <select id="aktivitas_fisik" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'aktivitas_fisik\')">\
                            <option value="">Pilih</option>\
                            <option value="Cukup">Cukup</option>\
                            <option value="Kurang">Kurang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Faktor Resiko</div>\
                    <div class="col-8">\
                        <select id="faktor_resiko" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'faktor_resiko\')">\
                            <option value="">Pilih</option>\
                            <option value="Faktor resiko hati negatif">Faktor resiko hati negatif</option>\
                            <option value="Faktor resiko hati positif">Faktor resiko hati positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis B</div>\
                    <div class="col-8">\
                        <select id="hepatitis_b" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_b\')">\
                            <option value="">Pilih</option>\
                            <option value="HBsAg Non Reaktif">HBsAg Non Reaktif</option>\
                            <option value="HBsAg Reaktif">HBsAg Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis C</div>\
                    <div class="col-8">\
                        <select id="hepatitis_c" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_c\')">\
                            <option value="">Pilih</option>\
                            <option value="Anti HCV Non Reaktif">Anti HCV Non Reaktif</option>\
                            <option value="Anti HCV Reaktif">Anti HCV Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fibrosis/Sirosis</div>\
                    <div class="col-8">\
                        <select id="fibrosis_sirosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fibrosis_sirosis\')">\
                            <option value="">Pilih</option>\
                            <option value="APRI Score ≤ 0.5">APRI Score ≤ 0.5</option>\
                            <option value="APRI Score >0.5">APRI Score >0.5</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Payudara</div>\
                    <div class="col-8">\
                        <select id="kanker_payudara" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_payudara\')">\
                            <option value="">Pilih</option>\
                            <option value="Sadanis Negatif">Sadanis Negatif</option>\
                            <option value="Sadanis Positif pemeriksaan USG Normal">Sadanis Positif pemeriksaan USG Normal</option>\
                            <option value="Sadanis Positif pemeriksaan USG Simple Cyst">Sadanis Positif pemeriksaan USG Simple Cyst</option>\
                            <option value="Sadanis Positif pemeriksaan USG Non Simple cyst">Sadanis Positif pemeriksaan USG Non Simple cyst</option>\
                            <option value="Sadanis Positif resiko sangat tinggi">Sadanis Positif resiko sangat tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Leher Rahim</div>\
                    <div class="col-8">\
                        <select id="kanker_leher_rahim" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_leher_rahim\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada faktor resiko">Tidak ada faktor resiko</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif">Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif">Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif</option>\
                            <option value="Curiga kanker">Curiga kanker</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Anemia (Hb Test)</div>\
                    <div class="col-8">\
                        <select id="anemia" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'anemia\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak Normal (Hb <12 gr/dL)">Tidak Normal (Hb <12 gr/dL)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">HIV</div>\
                    <div class="col-8">\
                        <select id="hiv" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hiv\')">\
                            <option value="">Pilih</option>\
                            <option value="Non Reaktif">Non Reaktif</option>\
                            <option value="Reaktif">Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Sifilis</div>\
                    <div class="col-8">\
                        <select id="sifilis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'sifilis\')">\
                            <option value="">Pilih</option>\
                            <option value="RDT HIV R1 Non Reaktif">RDT HIV R1 Non Reaktif</option>\
                            <option value="R2 dan R3 Reaktif">R2 dan R3 Reaktif</option>\
                            <option value="R2 dan R3 Non Reaktif">R2 dan R3 Non Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">NAPZA</div>\
                    <div class="col-8">\
                        <select id="napza" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'napza\')">\
                            <option value="">Pilih</option>\
                            <option value="Menggunakan salah satu zat atau minum alkohol">Menggunakan salah satu zat atau minum alkohol</option>\
                            <option value="Tidak pernah">Tidak pernah</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Imunisasi TT</div>\
                    <div class="col-8">\
                        <select id="status_imunisasi_tt" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_imunisasi_tt\')">\
                            <option value="">Pilih</option>\
                            <option value="Status imunisasi TT Lengkap">Status imunisasi TT Lengkap</option>\
                            <option value="Status imunisasi TT belum lengkap">Status imunisasi TT belum lengkap</option>\
                            <option value="Bukan Calon pengantin">Bukan Calon pengantin</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function dewasa_40_59_tahun(){
        console.log(dt)
        let variabel = ['status_gizi', 'tuberkulosis', 'tekanan_darah', 'gula_darah', 'tes_pendengaran', 'tes_penglihatan', 'gigi', 'kesehatan_jiwa', 'merokok', 'aktivitas_fisik', 'faktor_resiko', 'hepatitis_b', 'hepatitis_c', 'fibrosis_sirosis', 'kanker_payudara', 'kanker_leher_rahim', 'risiko_jantung', 'risiko_stroke', 'fungsi_ginjal', 'kanker_paru', 'kanker_usus', 'ppok', 'anemia', 'hiv', 'sifilis', 'napza', 'status_imunisasi_tt']

        let html = ''

        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Gizi</div>\
                    <div class="col-8">\
                        <select id="status_gizi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_gizi\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Overweight">Overweight</option>\
                            <option value="Underweight">Underweight</option>\
                            <option value="Obesitas">Obesitas</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tuberkulosis</div>\
                    <div class="col-8">\
                        <select id="tuberkulosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tuberkulosis\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdapat tanda, gejala dan Kontak erat TB">Tidak terdapat tanda, gejala dan Kontak erat TB</option>\
                            <option value="Terdapat kontak erat TB Positif tanpa gejala">Terdapat kontak erat TB Positif tanpa gejala</option>\
                            <option value="Terdapat kontak erat TB positif dengan gejala">Terdapat kontak erat TB positif dengan gejala</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tekanan Darah</div>\
                    <div class="col-8">\
                        <select id="tekanan_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tekanan_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdiagnosis Hipertensi atau prehipertensi">Tidak terdiagnosis Hipertensi atau prehipertensi</option>\
                            <option value="Terdiagnosis hipertensi tanpa tanda bahaya">Terdiagnosis hipertensi tanpa tanda bahaya</option>\
                            <option value="Terdiagnosis hipertensi dengan tanda bahaya">Terdiagnosis hipertensi dengan tanda bahaya</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gula Darah</div>\
                    <div class="col-8">\
                        <select id="gula_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gula_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal (GDS<100)">Normal (GDS<100)</option>\
                            <option value="Prediabetes (GDS 140 - 199)">Prediabetes (GDS 140 - 199)</option>\
                            <option value="Hiperglikemia (GDS > 200)">Hiperglikemia (GDS > 200)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Telinga (Tes Pendengaran)</div>\
                    <div class="col-8">\
                        <select id="tes_pendengaran" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_pendengaran\')">\
                            <option value="">Pilih</option>\
                            <option value="Lulus">Lulus</option>\
                            <option value="Tidak lulus (Hasil normal)">Tidak lulus (Hasil normal)</option>\
                            <option value="Tidak lulus (ditemukan gangguan atau kelainan)">Tidak lulus (ditemukan gangguan atau kelainan)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Mata (Tes Tajam Penglihatan)</div>\
                    <div class="col-8">\
                        <select id="tes_penglihatan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_penglihatan\')">\
                            <option value="">Pilih</option>\
                            <option value="Visus (6/6 - 6/12)">Visus (6/6 - 6/12)</option>\
                            <option value="Abnormal (Visus <6/12)">Abnormal (Visus <6/12)</option>\
                            <option value="Visus membaik">Visus membaik</option>\
                            <option value="Visus tidak membaik">Visus tidak membaik</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gigi</div>\
                    <div class="col-8">\
                        <select id="gigi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gigi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada karies (normal)">Tidak ada karies (normal)</option>\
                            <option value="Ada karies, gigi goyang">Ada karies, gigi goyang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kesehatan Jiwa</div>\
                    <div class="col-8">\
                        <select id="kesehatan_jiwa" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kesehatan_jiwa\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak ada gangguan jiwa">Tidak ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa">Ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa dengan penyulit">Ada gangguan jiwa dengan penyulit</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Merokok</div>\
                    <div class="col-8">\
                        <select id="merokok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'merokok\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak merokok">Tidak merokok</option>\
                            <option value="Merokok">Merokok</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tingkat Aktivitas Fisik</div>\
                    <div class="col-8">\
                        <select id="aktivitas_fisik" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'aktivitas_fisik\')">\
                            <option value="">Pilih</option>\
                            <option value="Cukup">Cukup</option>\
                            <option value="Kurang">Kurang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Faktor Resiko</div>\
                    <div class="col-8">\
                        <select id="faktor_resiko" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'faktor_resiko\')">\
                            <option value="">Pilih</option>\
                            <option value="Faktor resiko hati negatif">Faktor resiko hati negatif</option>\
                            <option value="Faktor resiko hati positif">Faktor resiko hati positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis B</div>\
                    <div class="col-8">\
                        <select id="hepatitis_b" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_b\')">\
                            <option value="">Pilih</option>\
                            <option value="HBsAg Non Reaktif">HBsAg Non Reaktif</option>\
                            <option value="HBsAg Reaktif">HBsAg Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis C</div>\
                    <div class="col-8">\
                        <select id="hepatitis_c" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_c\')">\
                            <option value="">Pilih</option>\
                            <option value="Anti HCV Non Reaktif">Anti HCV Non Reaktif</option>\
                            <option value="Anti HCV Reaktif">Anti HCV Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fibrosis/Sirosis</div>\
                    <div class="col-8">\
                        <select id="fibrosis_sirosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fibrosis_sirosis\')">\
                            <option value="">Pilih</option>\
                            <option value="APRI Score ≤ 0.5">APRI Score ≤ 0.5</option>\
                            <option value="APRI Score >0.5">APRI Score >0.5</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Payudara</div>\
                    <div class="col-8">\
                        <select id="kanker_payudara" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_payudara\')">\
                            <option value="">Pilih</option>\
                            <option value="Sadanis Negatif">Sadanis Negatif</option>\
                            <option value="Sadanis Positif pemeriksaan USG Normal">Sadanis Positif pemeriksaan USG Normal</option>\
                            <option value="Sadanis Positif pemeriksaan USG Simple Cyst">Sadanis Positif pemeriksaan USG Simple Cyst</option>\
                            <option value="Sadanis Positif pemeriksaan USG Non Simple cyst">Sadanis Positif pemeriksaan USG Non Simple cyst</option>\
                            <option value="Sadanis Positif resiko sangat tinggi">Sadanis Positif resiko sangat tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Leher Rahim</div>\
                    <div class="col-8">\
                        <select id="kanker_leher_rahim" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_leher_rahim\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada faktor resiko">Tidak ada faktor resiko</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif">Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif">Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif</option>\
                            <option value="Curiga kanker">Curiga kanker</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Risiko Jantung</div>\
                    <div class="col-8">\
                        <select id="risiko_jantung" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'risiko_jantung\')">\
                            <option value="">Pilih</option>\
                            <option value="EKG Normal">EKG Normal</option>\
                            <option value="EKG Tidak normal">EKG Tidak normal</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Risiko Stroke</div>\
                    <div class="col-8">\
                        <select id="risiko_stroke" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'risiko_stroke\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tinggi">Tinggi</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fungsi Ginjal</div>\
                    <div class="col-8">\
                        <select id="fungsi_ginjal" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fungsi_ginjal\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak normal">Tidak normal</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Paru</div>\
                    <div class="col-8">\
                        <select id="kanker_paru" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_paru\')">\
                            <option value="">Pilih</option>\
                            <option value="Risiko ringan">Risiko ringan</option>\
                            <option value="Risiko sedang">Risiko sedang</option>\
                            <option value="Risiko tinggi">Risiko tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Usus</div>\
                    <div class="col-8">\
                        <select id="kanker_usus" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_usus\')">\
                            <option value="">Pilih</option>\
                            <option value="APCS 0-1 Risiko rendah">APCS 0-1 Risiko rendah</option>\
                            <option value="APCS 2-3 Risiko sedang">APCS 2-3 Risiko sedang</option>\
                            <option value="APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua">APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua</option>\
                            <option value="APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif">APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">PPOK</div>\
                    <div class="col-8">\
                        <select id="ppok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'ppok\')">\
                            <option value="">Pilih</option>\
                            <option value="Resiko rendah (PUMA < 6)">Resiko rendah (PUMA < 6)</option>\
                            <option value="Resiko tinggi (PUMA ≥ 6)">Resiko tinggi (PUMA ≥ 6)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Anemia (Hb Test)</div>\
                    <div class="col-8">\
                        <select id="anemia" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'anemia\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak Normal (Hb <12 gr/dL)">Tidak Normal (Hb <12 gr/dL)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">HIV</div>\
                    <div class="col-8">\
                        <select id="hiv" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hiv\')">\
                            <option value="">Pilih</option>\
                            <option value="Non Reaktif">Non Reaktif</option>\
                            <option value="Reaktif">Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Sifilis</div>\
                    <div class="col-8">\
                        <select id="sifilis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'sifilis\')">\
                            <option value="">Pilih</option>\
                            <option value="RDT HIV R1 Non Reaktif">RDT HIV R1 Non Reaktif</option>\
                            <option value="R2 dan R3 Reaktif">R2 dan R3 Reaktif</option>\
                            <option value="R2 dan R3 Non Reaktif">R2 dan R3 Non Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">NAPZA</div>\
                    <div class="col-8">\
                        <select id="napza" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'napza\')">\
                            <option value="">Pilih</option>\
                            <option value="Menggunakan salah satu zat atau minum alkohol">Menggunakan salah satu zat atau minum alkohol</option>\
                            <option value="Tidak pernah">Tidak pernah</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Imunisasi TT</div>\
                    <div class="col-8">\
                        <select id="status_imunisasi_tt" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_imunisasi_tt\')">\
                            <option value="">Pilih</option>\
                            <option value="Status imunisasi TT Lengkap">Status imunisasi TT Lengkap</option>\
                            <option value="Status imunisasi TT belum lengkap">Status imunisasi TT belum lengkap</option>\
                            <option value="Bukan Calon pengantin">Bukan Calon pengantin</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function lansia(){
        console.log(dt)
        let variabel = ['status_gizi', 'tuberkulosis', 'tekanan_darah', 'gula_darah', 'tes_pendengaran', 'tes_penglihatan', 'gigi', 'kesehatan_jiwa', 'merokok', 'aktivitas_fisik', 'faktor_resiko', 'hepatitis_b', 'hepatitis_c', 'fibrosis_sirosis', 'kanker_payudara', 'kanker_leher_rahim', 'risiko_jantung', 'risiko_stroke', 'fungsi_ginjal', 'kanker_paru', 'kanker_usus', 'ppok', 'ppok', 'gangguan_penglihatan', 'gangguan_pendengaran', 'gejala_depresi', 'activity_daily_living', 'frailty_syndrome', 'sarc_caif']

        let html = ''

        html+= '<div class="row mb-3" style="display:flex">\
                    <div class="col-4">Status Gizi</div>\
                    <div class="col-8">\
                        <select id="status_gizi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'status_gizi\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Overweight">Overweight</option>\
                            <option value="Underweight">Underweight</option>\
                            <option value="Obesitas">Obesitas</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tuberkulosis</div>\
                    <div class="col-8">\
                        <select id="tuberkulosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tuberkulosis\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdapat tanda, gejala dan Kontak erat TB">Tidak terdapat tanda, gejala dan Kontak erat TB</option>\
                            <option value="Terdapat kontak erat TB Positif tanpa gejala">Terdapat kontak erat TB Positif tanpa gejala</option>\
                            <option value="Terdapat kontak erat TB positif dengan gejala">Terdapat kontak erat TB positif dengan gejala</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tekanan Darah</div>\
                    <div class="col-8">\
                        <select id="tekanan_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tekanan_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdiagnosis Hipertensi atau prehipertensi">Tidak terdiagnosis Hipertensi atau prehipertensi</option>\
                            <option value="Terdiagnosis hipertensi tanpa tanda bahaya">Terdiagnosis hipertensi tanpa tanda bahaya</option>\
                            <option value="Terdiagnosis hipertensi dengan tanda bahaya">Terdiagnosis hipertensi dengan tanda bahaya</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gula Darah</div>\
                    <div class="col-8">\
                        <select id="gula_darah" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gula_darah\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal (GDS<100)">Normal (GDS<100)</option>\
                            <option value="Prediabetes (GDS 140 - 199)">Prediabetes (GDS 140 - 199)</option>\
                            <option value="Hiperglikemia (GDS > 200)">Hiperglikemia (GDS > 200)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Telinga (Tes Pendengaran)</div>\
                    <div class="col-8">\
                        <select id="tes_pendengaran" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_pendengaran\')">\
                            <option value="">Pilih</option>\
                            <option value="Lulus">Lulus</option>\
                            <option value="Tidak lulus (Hasil normal)">Tidak lulus (Hasil normal)</option>\
                            <option value="Tidak lulus (ditemukan gangguan atau kelainan)">Tidak lulus (ditemukan gangguan atau kelainan)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Mata (Tes Tajam Penglihatan)</div>\
                    <div class="col-8">\
                        <select id="tes_penglihatan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'tes_penglihatan\')">\
                            <option value="">Pilih</option>\
                            <option value="Visus (6/6 - 6/12)">Visus (6/6 - 6/12)</option>\
                            <option value="Abnormal (Visus <6/12)">Abnormal (Visus <6/12)</option>\
                            <option value="Visus membaik">Visus membaik</option>\
                            <option value="Visus tidak membaik">Visus tidak membaik</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gigi</div>\
                    <div class="col-8">\
                        <select id="gigi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gigi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada karies (normal)">Tidak ada karies (normal)</option>\
                            <option value="Ada karies, gigi goyang">Ada karies, gigi goyang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kesehatan Jiwa</div>\
                    <div class="col-8">\
                        <select id="kesehatan_jiwa" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kesehatan_jiwa\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak ada gangguan jiwa">Tidak ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa">Ada gangguan jiwa</option>\
                            <option value="Ada gangguan jiwa dengan penyulit">Ada gangguan jiwa dengan penyulit</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Merokok</div>\
                    <div class="col-8">\
                        <select id="merokok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'merokok\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak merokok">Tidak merokok</option>\
                            <option value="Merokok">Merokok</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Tingkat Aktivitas Fisik</div>\
                    <div class="col-8">\
                        <select id="aktivitas_fisik" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'aktivitas_fisik\')">\
                            <option value="">Pilih</option>\
                            <option value="Cukup">Cukup</option>\
                            <option value="Kurang">Kurang</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Faktor Resiko</div>\
                    <div class="col-8">\
                        <select id="faktor_resiko" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'faktor_resiko\')">\
                            <option value="">Pilih</option>\
                            <option value="Faktor resiko hati negatif">Faktor resiko hati negatif</option>\
                            <option value="Faktor resiko hati positif">Faktor resiko hati positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis B</div>\
                    <div class="col-8">\
                        <select id="hepatitis_b" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_b\')">\
                            <option value="">Pilih</option>\
                            <option value="HBsAg Non Reaktif">HBsAg Non Reaktif</option>\
                            <option value="HBsAg Reaktif">HBsAg Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Hepatitis C</div>\
                    <div class="col-8">\
                        <select id="hepatitis_c" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'hepatitis_c\')">\
                            <option value="">Pilih</option>\
                            <option value="Anti HCV Non Reaktif">Anti HCV Non Reaktif</option>\
                            <option value="Anti HCV Reaktif">Anti HCV Reaktif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fibrosis/Sirosis</div>\
                    <div class="col-8">\
                        <select id="fibrosis_sirosis" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fibrosis_sirosis\')">\
                            <option value="">Pilih</option>\
                            <option value="APRI Score ≤ 0.5">APRI Score ≤ 0.5</option>\
                            <option value="APRI Score >0.5">APRI Score >0.5</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Payudara</div>\
                    <div class="col-8">\
                        <select id="kanker_payudara" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_payudara\')">\
                            <option value="">Pilih</option>\
                            <option value="Sadanis Negatif">Sadanis Negatif</option>\
                            <option value="Sadanis Positif pemeriksaan USG Normal">Sadanis Positif pemeriksaan USG Normal</option>\
                            <option value="Sadanis Positif pemeriksaan USG Simple Cyst">Sadanis Positif pemeriksaan USG Simple Cyst</option>\
                            <option value="Sadanis Positif pemeriksaan USG Non Simple cyst">Sadanis Positif pemeriksaan USG Non Simple cyst</option>\
                            <option value="Sadanis Positif resiko sangat tinggi">Sadanis Positif resiko sangat tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Leher Rahim</div>\
                    <div class="col-8">\
                        <select id="kanker_leher_rahim" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_leher_rahim\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada faktor resiko">Tidak ada faktor resiko</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif">Ada faktor resiko, normal, tes IVA & HPV DNA semua negatif</option>\
                            <option value="Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif">Ada faktor resiko, normal, tes IVA & HPV DNA salah satu positif</option>\
                            <option value="Curiga kanker">Curiga kanker</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Risiko Jantung</div>\
                    <div class="col-8">\
                        <select id="risiko_jantung" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'risiko_jantung\')">\
                            <option value="">Pilih</option>\
                            <option value="EKG Normal">EKG Normal</option>\
                            <option value="EKG Tidak normal">EKG Tidak normal</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Risiko Stroke</div>\
                    <div class="col-8">\
                        <select id="risiko_stroke" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'risiko_stroke\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tinggi">Tinggi</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko rendah</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko sedang</option>\
                            <option value="Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi">Prediksi risiko stroke dengan tabel prediksi PTM menunjukan resiko tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Fungsi Ginjal</div>\
                    <div class="col-8">\
                        <select id="fungsi_ginjal" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'fungsi_ginjal\')">\
                            <option value="">Pilih</option>\
                            <option value="Normal">Normal</option>\
                            <option value="Tidak normal">Tidak normal</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Paru</div>\
                    <div class="col-8">\
                        <select id="kanker_paru" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_paru\')">\
                            <option value="">Pilih</option>\
                            <option value="Risiko ringan">Risiko ringan</option>\
                            <option value="Risiko sedang atau tinggi">Risiko sedang atau tinggi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Kanker Usus</div>\
                    <div class="col-8">\
                        <select id="kanker_usus" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'kanker_usus\')">\
                            <option value="">Pilih</option>\
                            <option value="APCS 0-1 Risiko rendah">APCS 0-1 Risiko rendah</option>\
                            <option value="APCS 2-3 Risiko sedang">APCS 2-3 Risiko sedang</option>\
                            <option value="APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua">APCS 4-7 Risiko tinggi, colok dubur darah samar feses negatif semua</option>\
                            <option value="APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif">APCS 4-7 Risiko tinggi, colok dubur darah samar feses salah satu positif</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">PPOK</div>\
                    <div class="col-8">\
                        <select id="ppok" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'ppok\')">\
                            <option value="">Pilih</option>\
                            <option value="Resiko rendah (PUMA < 6)">Resiko rendah (PUMA < 6)</option>\
                            <option value="Resiko tinggi (PUMA ≥ 6)">Resiko tinggi (PUMA ≥ 6)</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gangguan Penglihatan</div>\
                    <div class="col-8">\
                        <select id="gangguan_penglihatan" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gangguan_penglihatan\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada gangguan">Tidak ada gangguan</option>\
                            <option value="Ditemukan ≥1 gangguan">Ditemukan ≥1 gangguan</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gangguan Pendengaran</div>\
                    <div class="col-8">\
                        <select id="gangguan_pendengaran" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gangguan_pendengaran\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada gangguan">Tidak ada gangguan</option>\
                            <option value="Ditemukan ≥1 gangguan">Ditemukan ≥1 gangguan</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Gejala Depresi</div>\
                    <div class="col-8">\
                        <select id="gejala_depresi" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'gejala_depresi\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada gangguan">Tidak ada gangguan</option>\
                            <option value="Tidak depresi">Tidak depresi</option>\
                            <option value="Kemungkinan depresi">Kemungkinan depresi</option>\
                            <option value="Depresi">Depresi</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Activity Daily Living</div>\
                    <div class="col-8">\
                        <select id="activity_daily_living" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'activity_daily_living\')">\
                            <option value="">Pilih</option>\
                            <option value="Mandiri">Mandiri</option>\
                            <option value="Ketergantungan ringan">Ketergantungan ringan</option>\
                            <option value="Ketergantungan Sedang">Ketergantungan Sedang</option>\
                            <option value="Ketergantungan Berat">Ketergantungan Berat</option>\
                            <option value="Ketergantungan total">Ketergantungan total</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">Frailty Syndrome / Kerapuhan</div>\
                    <div class="col-8">\
                        <select id="frailty_syndrome" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'frailty_syndrome\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak ada sindrom kerapuhan">Tidak ada sindrom kerapuhan</option>\
                            <option value="Sindrom pra-kerapuhan">Sindrom pra-kerapuhan</option>\
                            <option value="Sindroma kerapuhan">Sindroma kerapuhan</option>\
                        </select>\
                    </div>\
                </div>\
                <div class="row mb-3" style="display:flex">\
                    <div class="col-4">SARC-CaIF</div>\
                    <div class="col-8">\
                        <select id="sarc_caif" style="width:100%" onchange="oc_hasil_pemeriksaan_kesehatan(\'sarc_caif\')">\
                            <option value="">Pilih</option>\
                            <option value="Tidak terdapat kemungkinan Sarkopenia">Tidak terdapat kemungkinan Sarkopenia</option>\
                            <option value="Terdapat kemungkinan Sarkopenia">Terdapat kemungkinan Sarkopenia</option>\
                        </select>\
                    </div>\
                </div>'
        
        $('#id_hasil_pemeriksaan').html(html);

        if(dt.id!="" && dt.hasil_pemeriksaan!=null){
            ar_hasil_pemeriksaan = dt.hasil_pemeriksaan
            variabel.map(var_nama => {
                let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_hasil_pemeriksaan[index][var_nama];
                    $('#'+var_nama).val(value);
                }
                // else{
                //     $('#'+var_nama).val("");
                // }
            })
        }
    }

    function oc_hasil_pemeriksaan_kesehatan(value){
        let val = $('#'+value).val()
        console.log(val)
        console.log(value)

        let index = ar_hasil_pemeriksaan.findIndex(item => Object.keys(item)[0] == value);

        if (index !== -1) {
            ar_hasil_pemeriksaan[index][value] = val;
        } else {
            let newObj = {};
            newObj[value] = val;
            ar_hasil_pemeriksaan.push(newObj);
        }
        // let cari_hasil_pemeriksaan = ar_hasil_pemeriksaan.find(item => Object.keys(item)[0] == value);

        // if(cari_hasil_pemeriksaan){
        //     // console.log(cari_hasil_pemeriksaan)
        //     ar_hasil_pemeriksaan[value] = val;
        // }
        // else{
        //     let newObj = {};
        //     newObj[value] = val;
        //     ar_hasil_pemeriksaan.push(newObj);
        //     // console.log("null")
        // }

        console.log(ar_hasil_pemeriksaan)
    }

    var ar_program_tindak_lanjut = []

    function oc_program_tindak_lanjut(value){
        let val = $('#'+value).val()
        let index = ar_program_tindak_lanjut.findIndex(item => Object.keys(item)[0] == value);

        if (index !== -1) {
            ar_program_tindak_lanjut[index][value] = val;
        } else {
            let newObj = {};
            newObj[value] = val;
            ar_program_tindak_lanjut.push(newObj);
        }
    }

    function get_program_tindak_lanjut(){
        if(dt.id!="" && dt.program_tindak_lanjut!=null){
            let variabel = ['edukasi', 'rujuk_fktrl']
            ar_program_tindak_lanjut = dt.program_tindak_lanjut

            variabel.map(var_nama => {
                let index = ar_program_tindak_lanjut.findIndex(item => Object.keys(item)[0] == var_nama);

                if (index !== -1) {
                    let value = ar_program_tindak_lanjut[index][var_nama];
                    $('#'+var_nama).val(value);
                }
            })
        }
    }

    function oc_cari_nik(){
        let nik = $('#nik_pasien').val()
        
        console.log(nik)
        $.ajax({
            url: "{{url('riwayat/cari_nik_pasien')}}",
            type: 'GET',
            data: {
                'nik':nik,
            },
            dataType: 'json',
            async: true,
            success: function(data) {
                console.log(data)
                $('#nik_pasien').val(data.nik)
                $('#nama_pasien').val(data.nama)
                $('#jenis_kelamin').val(data.jenis_kelamin)
                $('#tgl_lahir').val(data.tgl_lahir)
                if(data.ref_provinsi_ktp){
                    get_provinsi_ktp(data.ref_provinsi_ktp.kode_provinsi, data.ref_provinsi_ktp.nama)
                }
                if (data.ref_kota_kab_ktp) {
                    get_kota_kab_ktp(data.ref_kota_kab_ktp.kode_kota_kab, data.ref_kota_kab_ktp.nama);
                }
                if (data.ref_kecamatan_ktp) {
                    get_kecamatan_ktp(data.ref_kecamatan_ktp.kode_kecamatan, data.ref_kecamatan_ktp.nama);
                }
                if (data.ref_kelurahan_ktp) {
                    get_kelurahan_ktp(data.ref_kelurahan_ktp.kode_kelurahan, data.ref_kelurahan_ktp.nama);
                }

                // Cek dan set data Domisili
                if (data.ref_provinsi_dom) {
                    get_provinsi_dom(data.ref_provinsi_dom.kode_provinsi, data.ref_provinsi_dom.nama);
                }
                if (data.ref_kota_kab_dom) {
                    get_kota_kab_dom(data.ref_kota_kab_dom.kode_kota_kab, data.ref_kota_kab_dom.nama);
                }
                if (data.ref_kecamatan_dom) {
                    get_kecamatan_dom(data.ref_kecamatan_dom.kode_kecamatan, data.ref_kecamatan_dom.nama);
                }
                if (data.ref_kelurahan_dom) {
                    get_kelurahan_dom(data.ref_kelurahan_dom.kode_kelurahan, data.ref_kelurahan_dom.nama);
                }
                
                $('#alamat_ktp').val(data.alamat_ktp)
                $('#alamat_dom').val(data.alamat_dom)
                $('#no_hp').val(data.no_hp)
                
        

            }
        })
    }

    function oc_export(){
        // window.location.href = "{{url('laporan/export')}}";
        let periodeDari = document.getElementById("periode_dari").value;
        let periodeSampai = document.getElementById("periode_sampai").value;
        let instrumen = $('#instrumen option:selected').text()
        let jenis = "semua";

        let url = "{{url('laporan/export')}}" + 
                "?periode_dari=" + encodeURIComponent(periodeDari) + 
                "&periode_sampai=" + encodeURIComponent(periodeSampai) + 
                "&instrumen=" + encodeURIComponent(instrumen)+
                "&jenis=" + encodeURIComponent(jenis);

        window.location.href = url;
    }

</script>