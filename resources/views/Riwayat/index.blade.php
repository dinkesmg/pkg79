<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PKG</title>

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
                                    <h5 class="m-0">Riwayat</h5>
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
                            <div style="display:flex; justify-content:center; margin-bottom:10px"><button class="btn btn-sm btn-success" onclick="oc_modal('Tambah', '')"><i class="fa fa-plus"></i> Tambah Pasien</button></a></div>
                            <table id="idtabel" class="table table-bordered table-striped example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width:150px;">Aksi</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Tempat Periksa</th>
                                    <th>Nama FKTP PJ</th>
                                    <th>Pemeriksa</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Hasil Pemeriksaan Kesehatan</th>
                                    <th>Kesimpulan Hasil</th>
                                    <th>Program Tindak Lanjut</th>
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
                    <!-- Modal content goes here -->
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <!-- Add additional buttons or actions here -->
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
        tabel()
        Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    })

    // function get_puskesmas(id_puskesmas, nama_puskesmas){
    //     console.log("puskesmas")
    //     $('#puskesmas')
    //         .empty()
    //         .append($("<option/>")
    //             .val(id_puskesmas)
    //             .text(nama_puskesmas))
    //         .val(id_puskesmas)
    //         .trigger("change");

    //     $('#puskesmas').select2({
    //         placeholder: 'Cari...',
    //         allowClear: true,
    //         width: 'resolve',
    //         theme: 'bootstrap4',
    //         ajax: {
    //             url: "{{ url('puskesmas/data') }}",
    //             dataType: 'json',
    //             delay: 500,
    //             data: function (params) {
    //                 console.log(params.term)
    //                 return {
    //                     search: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: data.map(function(item) {
    //                         return {
    //                             id: item.id,
    //                             text: item.nama,
    //                         };
    //                     })
    //                 };
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("AJAX error:", status, error);
    //             },
    //             cache: true
    //         },
    //         // minimumInputLength: 2,
    //     });
    // }

    // function get_kecamatan(id_kecamatan, nama_kecamatan){
    //     console.log("kecamat")
    //     $('#kecamatan')
    //         .empty()
    //         .append($("<option/>")
    //             .val(id_kecamatan)
    //             .text(nama_kecamatan))
    //         .val(id_kecamatan)
    //         .trigger("change");

    //     $('#kecamatan').select2({
    //         placeholder: 'Cari...',
    //         allowClear: true,
    //         width: 'resolve',
    //         theme: 'bootstrap4',
    //         ajax: {
    //             url: "{{ url('ref_kecamatan') }}",
    //             dataType: 'json',
    //             delay: 500,
    //             data: function (params) {
    //                 console.log(params.term)
    //                 return {
    //                     search: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: data
    //                     .map(function(item) {
    //                         return {
    //                             id: item.id,
    //                             text: item.nama_kecamatan,
    //                         };
    //                     })
    //                 };
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("AJAX error:", status, error);
    //             },
    //             cache: true
    //         },
    //         // minimumInputLength: 2,
    //     });
    // }

    // function get_kelurahan(id_kelurahan, nama_kelurahan){
    //     console.log("kelur")
    //     $('#kelurahan')
    //         .empty()
    //         .append($("<option/>")
    //             .val(id_kelurahan)
    //             .text(nama_kelurahan))
    //         .val(id_kelurahan)
    //         .trigger("change");

    //     $('#kelurahan').select2({
    //         placeholder: 'Cari...',
    //         allowClear: true,
    //         width: 'resolve',
    //         theme: 'bootstrap4',
    //         ajax: {
    //             url: "{{ url('ref_kelurahan') }}",
    //             dataType: 'json',
    //             delay: 500,
    //             data: function (params) {
    //                 console.log(params.term)
    //                 return {
    //                     search: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: data
    //                     // .filter(function(item){
    //                     //     return item.petugas && item.petugas.nama != null;
    //                     // })
    //                     .map(function(item) {
    //                         return {
    //                             id: item.id,
    //                             text: item.nama_kelurahan,
    //                         };
    //                     })
    //                 };
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("AJAX error:", status, error);
    //             },
    //             cache: true
    //         },
    //         // minimumInputLength: 2,
    //     });
    // }

    function tabel(){
        let col = 
        [
            {
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { 'render': function (data, type, row, meta) {
                var baseurl = "{{url('pasien/riwayat_skrining/')}}"
                var actionsHtml = '<a href="'+baseurl+"/"+row.id+'" target="_blank"><button class="btn btn-sm btn-primary" style="width:100%"><i class="fa fa-pencil-alt"></i> Riwayat Skrining</button></a>'
                
                if(role_auth=="Admin"||role_auth=="Puskesmas"||role_auth=="Petugas"||role_auth=="Kader"){
                    actionsHtml += '<button class="btn btn-sm btn-warning" onclick="oc_modal(\'Edit\', \''+row.id+'\', \''+row.nik+'\', \''+row.nama+'\', \''+row.jenis_kelamin+'\', \''+row.tgl_lahir+'\', \''+(row.id_kecamatan && row.kecamatan ? row.kecamatan.id_kecamatan:'')+'\', \''+(row.id_kecamatan && row.kecamatan ? row.kecamatan.nama_kecamatan:'')+'\', \''+(row.id_kelurahan && row.kelurahan ? row.kelurahan.id_kelurahan:'')+'\', \''+(row.id_kelurahan && row.kelurahan ? row.kelurahan.nama_kelurahan:'')+'\')" style="width:100%"><i class="fa fa-pencil-alt"></i> Edit</button>'
                }
                
                return actionsHtml;
                }
            },
            { 'data': 'tanggal_pemeriksa' },
            { 'data': 'tempat_periksa' },
            { 'data': 'nama_fktp_pj' },
            { 'data': 'id_pemeriksa' },
            { 'data': 'id_pasien' },
            { 'data': 'id_pasien' },
            { 'data': 'id_pasien' },
            { 'data': 'id_pasien' },
            { 'data': 'hasil_pemeriksaan_kesehatan' },
            { 'data': 'kesimpulan_hasil' },
            { 'data': 'program_tindak_lanjut' },
        ]

        $('#idtabel').dataTable( {
            destroy : true,
            scrollX : true,
            ajax :  {
                // url: "{{url('pasien_puskesmas')}}",
                url: "{{url('pasien/puskesmas')}}",
                dataSrc: ''
            },
            columns: col
        });
    }

    var ar_hasil_pemeriksaan = []

    function oc_modal(fitur, id_riwayat){
        // let id_riwayat
        let dt
        if(id_riwayat!=null){
            console.log("null")
            dt = {
                tanggal_pemeriksaan: '',
                tempat_periksa: '',
                nama_fktp_pj: '',
                id_pemeriksa: '',
                id_pasien: '',
                hasil_pemeriksaan: '',
                kesimpulan_hasil: '',
                program_tindak_lanjut: '',
            } 
        }
        console.log(id_riwayat)
        console.log(fitur)
        console.log(dt.id_pasien)
        if(dt.id_pasien!=""){
            console.log("pasien dt")
        }
        // console.log(id_pasien)
        // console.log("id_petugas"+id_petugas)
        var role_auth = "{{ Auth::user()->role }}";
        console.log(role_auth)
        $('#exampleModal .modal-title').text(fitur+' Pasien');
        var html='\
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
                <div class="col-8"><input id="nik_pemeriksa" type="text" value="'+((dt.id_pemeriksa != "")?dt.pemeriksa.nik:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Nama</div>\
                <div class="col-8"><input id="nama_pemeriksa" type="text" value="'+((dt.id_pemeriksa != "")?dt.pemeriksa.nama:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Identitas Pasien</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">NIK</div>\
                <div class="col-8"><input id="nik_pasien" type="text" value="'+((dt.id_pasien != "")?dt.pasien.nik:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Nama</div>\
                <div class="col-8"><input id="nama_pasien" type="text" value="'+((dt.id_pasien != "")?dt.pasien.nama:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Jenis Kelamin</div>\
                <div class="col-8"><select id="jenis_kelamin" style="width:100%">\
                    <option value="Laki-laki" '+(((dt.id_pasien != "" && dt.pasien.jenis_kelamin === "Laki-laki") ? "selected" : ""))+'>Laki-laki</option>\
                    <option value="Perempuan" '+(((dt.id_pasien != "" && dt.pasien.jenis_kelamin === "Perempuan") ? "selected" : ""))+'>Perempuan</option></select></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Tanggal Lahir</div>\
                <div class="col-8"><input id="tgl_lahir" type="date" value="'+((dt.id_pasien != "") != ""?dt.pasien.tgl_lahir:"")+'" style="width:100%" onchange="oc_tgl_pemeriksaan_dan_lahir()"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Alamat</div>\
                <div class="col-8"><input id="alamat" type="text" value="'+((dt.id_pasien != "")?dt.pasien.alamat:"")+'" style="width: 100%;"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Usia</div>\
                <div class="col-8"><input id="usia" type="text" style="width: 100%;"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">No HP</div>\
                <div class="col-8"><input id="no_hp" type="text" value="'+((dt.id_pasien != "")?dt.pasien.no_hp:"")+'" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Hasil Pemeriksaan Kesehatan</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12" id="id_hasil_pemeriksaan" style="width:100%"></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Kesimpulan Hasil</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Hasil Pemeriksaan</div>\
                <div class="col-8">\
                    <select id="kesimpulan_hasil_pemeriksaan" style="width:100%">\
                        <option value="">Pilih</option>\
                        <option value="Normal dan faktor resiko tidak terdeteksi" '+(((dt.hasil_pemeriksaan != "" && dt.hasil_pemeriksaan === "Normal dan faktor resiko tidak terdeteksi") ? "selected" : ""))+'>Normal dan faktor resiko tidak terdeteksi</option>\
                        <option value="Normal dengan faktor resiko" '+(((dt.hasil_pemeriksaan != "" && dt.hasil_pemeriksaan === "Normal dengan faktor resiko") ? "selected" : ""))+'>Normal dengan faktor resiko</option>\
                        <option value="Menunjukkan kondisi pra penyakit" '+(((dt.hasil_pemeriksaan != "" && dt.hasil_pemeriksaan === "Menunjukkan kondisi pra penyakit") ? "selected" : ""))+'>Menunjukkan kondisi pra penyakit</option>\
                        <option value="Menunjukkan kondisi penyakit" '+(((dt.hasil_pemeriksaan != "" && dt.hasil_pemeriksaan === "Menunjukkan kondisi penyakit") ? "selected" : ""))+'>Menunjukkan kondisi penyakit</option>\
                    </select>\
                </div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-12"><b>Program Tindak Lanjut</b></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Edukasi yang diberikan</div>\
                <div class="col-8"><input id="edukasi" type="text" value="'+((dt.id_pasien != "")?dt.pasien.no_hp:"")+'" oninput="oc_program_tindak_lanjut(\'edukasi\')" style="width:100%"></input></div>\
            </div>\
            <div class="row mb-3" style="display:flex">\
                <div class="col-4">Rujuk FKTRL (disertai dengan keterangan)</div>\
                <div class="col-8"><input id="rujuk_fktrl" type="text" value="'+((dt.id_pasien != "")?dt.pasien.no_hp:"")+'" oninput="oc_program_tindak_lanjut(\'rujuk_fktrl\')" style="width:100%"></input></div>\
            </div>'

        $('#exampleModal .modal-body').html(html);
        $('#exampleModal .modal-footer').html('<button type="button" class="btn btn-success" onclick="oc_fitur(\''+fitur+'\', \''+id_riwayat+'\')">'+fitur+'</button>');
        $('#exampleModal').modal('show');
    }

    function oc_fitur(fitur, id_riwayat){
        console.log(fitur)
        console.log(id_riwayat)
        var vurl = fitur.toLowerCase()
        console.log(vurl)
        if(vurl=="lihat"){
            let newUrl = `{{url('pasien/lihat_riwayat_msn')}}/${id_pasien}`;
            window.location.href = newUrl;
        }
        else if(vurl=="tambah"){
            let tanggal_pemeriksaan = $('#tanggal_pemeriksaan').val();
            let tempat_periksa = $('#tempat_periksa').val();
            let nama_fktp_pj = $('#nama_fktp_pj').val();

            let nik_pemeriksa = $('#nik_pemeriksa').val();
            let nama_pemeriksa = $('#nama_pemeriksa').val();
            
            let nik_pasien = $('#nik_pasien').val();
            let nama_pasien = $('#nama_pasien').val();
            let jenis_kelamin = $('#jenis_kelamin').val();
            let tgl_lahir = $('#tgl_lahir').val();
            let alamat = $('#alamat').val();
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
            console.log(alamat)
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
                    nik_pasien: nik_pasien,
                    nama_pasien: nama_pasien,
                    jenis_kelamin: jenis_kelamin,
                    tgl_lahir: tgl_lahir,
                    id_kecamatan: id_kecamatan,
                    id_kelurahan: id_kelurahan,
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
                    else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Data Pasien Sudah Ada'
                        })
                    }

                }
            })
        }

    }

    function oc_tgl_pemeriksaan_dan_lahir() {
        var tgl_lahir = $('#tgl_lahir').val()
        var tanggal_pemeriksaan = $('#tanggal_pemeriksaan').val()
        
        // console.log(tgl_lahir)
        // console.log(tanggal_pemeriksaan)
        if(tgl_lahir!="" && tanggal_pemeriksaan!=""){
            var lahir = new Date(tgl_lahir);
            var periksa = new Date(tanggal_pemeriksaan);

            // Hitung selisih tahun dan bulan
            var tahun = periksa.getFullYear() - lahir.getFullYear();
            var bulan = periksa.getMonth() - lahir.getMonth();

            if (bulan < 0) {
                tahun--;
                bulan += 12;
            }

            $('#usia').val(tahun + " Tahun " + bulan + " Bulan")

            if(tahun >= 18 && tahun <= 29){
                // console.log("18")
                dewasa_18_29_tahun()
            }
        }
    }

    function dewasa_18_29_tahun(){
        // console.log("18")
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
        console.log(val)
        console.log(value)

        let index = ar_program_tindak_lanjut.findIndex(item => Object.keys(item)[0] == value);

        if (index !== -1) {
            ar_program_tindak_lanjut[index][value] = val;
        } else {
            let newObj = {};
            newObj[value] = val;
            ar_program_tindak_lanjut.push(newObj);
        }

        console.log(ar_program_tindak_lanjut)
    }
</script>
</html>
