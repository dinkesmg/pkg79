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
                                    <h5 class="m-0">Sasaran Sekolah</h5>
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
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <div class="col-md-2">Periode dari</div>
                                        <div class="col-md-2"><input id="periode_dari" type="date"></input></div>
                                        <div class="col-md-2 text-center">sampai</div>
                                        <div class="col-md-2"><input id="periode_sampai" type="date"></input></div>
                                    </div>
                                    <div class="mt-3 col-md-12 d-flex justify-content-center">
                                        <div class=" col-md-2 text-center">nama sekolah</div>
                                        <div class="col-md-2"><select class="form-control" id="nama_sekolah" style="width: 100%;"></select></div>
                                        <div class="col-md-2 text-center">kelas</div>
                                        <div class="col-md-2"><input class="form-control" type="number" id="kelas" style="width: 100%;"></input></div>
                                    </div>
                                    <!-- </div> -->
                                    <div class="mt-3 col-md-12 d-flex justify-content-center">
                                        <button onclick="tabel()" class="btn btn-primary">Cari</button>
                                        <button class="btn btn-sm btn-success ml-2" onclick="oc_export()">Export</button>
                                    </div>
                                    <!-- <div style="display:flex; justify-content:center; margin-bottom:10px; margin-top:10px"><button class="btn btn-sm btn-success" onclick="oc_modal('Tambah', '')"><i class="fa fa-plus"></i> Tambah Pasien</button></a></div> -->
                                    <table id="idtabel" class="table table-bordered table-striped example" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pemeriksaan</th>
                                                <th>Nama FKTP Pemeriksa</th>
                                                <th>Persetujuan</th>
                                                <th>Nama Sekolah</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Umur</th>
                                                <th>Kelas</th>
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
    <div class="modal fade" id="exampleModal" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    var id_auth = "{{Auth::user()->id}}"

    $(document).ready(function() {
        let hari_ini = new Date().toISOString().split('T')[0];

        $('#periode_dari').val(hari_ini);
        $('#periode_sampai').val(hari_ini);

        tabel()
        Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    })

    var semua_riwayat = []

    function tabel() {
        semua_riwayat = []

        let col = [{
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                'data': 'form_persetujuan_tanggal'
            },
            {
                'data': 'puskesmas.nama'
            },
            {
                'render': function(data, type, row, meta) {
                    let persetujuan = (row.persetujuan == "1" ? "setuju" : "tidak");

                    return persetujuan
                }
            },
            {
                'data': 'pasien_sekolah.ref_master_sekolah.nama'
            },
            {
                'data': 'pasien_sekolah.nik'
            },
            {
                'data': 'pasien_sekolah.nama'
            },
            {
                'data': 'pasien_sekolah.jenis_kelamin'
            },
            {
                'render': function(data, type, row, meta) {
                    let tgl = (row.pasien_sekolah && row.pasien_sekolah.tanggal_lahir ? row.pasien_sekolah.tanggal_lahir : "");

                    if (tgl != "") {
                        let dateParts = tgl.split("-");
                        let formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
                        return formattedDate;
                    }
                    return "";
                }
            },
            {
                'render': function(data, type, row, meta) {
                    let tglLahir = row.pasien_sekolah.tanggal_lahir;
                    let tglPeriksa = row.form_persetujuan_tanggal;
                    // console.log(tglLahir)
                    // console.log(tglPeriksa)

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
            {
                'data': 'pasien_sekolah.kelas'
            },
        ]

        $('#idtabel').dataTable({
            destroy: true,
            scrollX: true,
            processing: true, // Optional: Shows a loading indicator while data is being fetched.
            serverSide: true,
            ajax: {
                url: "{{url('laporan/data_sekolah')}}",
                data: function(d) {
                    d.nama_sekolah = $('#nama_sekolah').val();
                    d.kelas = $('#kelas').val();
                    d.periode_dari = $('#periode_dari').val(); // Ambil nilai dari input
                    d.periode_sampai = $('#periode_sampai').val();
                },
                dataSrc: function(json) {
                    return json.data;
                }
            },
            columns: col,
            pageLength: 10, // Optional: Set the default page length.
            lengthChange: true, // Optional: Allow users to change the page length.
            order: [
                [0, 'desc']
            ]
        });
    }

    $('#nama_sekolah').select2({
        placeholder: 'Cari...',
        allowClear: true,
        width: 'resolve',
        theme: 'bootstrap4',
        ajax: {
            url: "{{ url('/master_sekolah/cari') }}",
            dataType: 'json',
            delay: 500,
            data: function(params) {
                let id_puskesmas = (id_auth - 1);
                return {
                    term: params.term,
                    id_puskesmas: id_puskesmas
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.nama,
                            nama: item.nama,
                            alamat: item.alamat
                        };
                    })
                };
            }
        },
        templateResult: function(item) {
            if (!item.id) {
                return item.text;
            }

            return $(
                `<div>
                    <div><strong>${item.nama}</strong></div>
                    <div style="font-size: 0.9em; color: red;"><strong>${item.alamat}</strong></div>
                </div>`
            );
        },
        templateSelection: function(item) {
            return item.nama || item.text;
        }
    });

    function oc_export() {
        // window.location.href = "{{url('laporan/export')}}";
        let periodeDari = document.getElementById("periode_dari").value;
        let periodeSampai = document.getElementById("periode_sampai").value;
        let nama_sekolah = document.getElementById("nama_sekolah").value;
        let kelas = document.getElementById("kelas").value;
        console.log(nama_sekolah)

        let url = "{{url('laporan/export_sasaran_sekolah')}}" +
            "?periode_dari=" + encodeURIComponent(periodeDari) +
            "&periode_sampai=" + encodeURIComponent(periodeSampai) +
            "&nama_sekolah=" + encodeURIComponent(nama_sekolah) +
            "&kelas=" + encodeURIComponent(kelas);

        window.location.href = url;
    }
</script>

</html>