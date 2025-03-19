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
<body>
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
                                    <h5 class="m-0"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($props))
                <p>Jenis Pemeriksaan: {{ $props }}</p>
            @else
                <p>Tidak ada data pemeriksaan</p>
            @endif
            <h1>I'am The Thunderr!!!</h1>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil props dari elemen HTML (jika ada)
            let props = "{{ $props ?? '' }}"; // Ambil props dari Blade PHP

            // Pastikan props tidak kosong sebelum mengirim request
            if (props) {
                fetch(`/dashboard/data_pasien_hasil_pemeriksaan?props=${encodeURIComponent(props)}`)
                    .then(response => response.json()) // Ubah response ke JSON
                    .then(data => {
                        console.log("Data dari API:", data); // Tampilkan di console
                    })
                    .catch(error => console.error("Terjadi kesalahan:", error));
            } else {
                console.warn("Props tidak ditemukan, tidak mengirim request.");
            }
        });
    </script>

</body>
</html>