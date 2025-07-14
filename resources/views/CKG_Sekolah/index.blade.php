<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semar PKG79</title>
    <link rel="icon" href="{{ asset('logo_semarpkg79.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    {{-- @include('layouts.header') --}}
</head>

<style>
    body {
        font-family: "Geist", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        color: #323232;
    }

    .signature-container {
        border: 1px solid #000;
        border-radius: 4px;
        overflow: hidden;
        display: inline-block;
        max-width: 100%;
    }

    canvas {
        display: block;
    }

    .button-group {
        margin-top: 10px;
        text-align: right;
    }

    button {
        padding: 8px 16px;
        margin-left: 5px;
        border: none;
        border-radius: 4px;
        background-color: #eee;
        cursor: pointer;
    }

    button:hover {
        background-color: #ccc;
    }

    .ui-autocomplete {
        max-height: 40vh;
        /* Batas tinggi agar tidak keluar layar */
        overflow-y: auto;
        overflow-x: hidden;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        z-index: 9999 !important;
        /* pastikan muncul di atas elemen lain */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Buat lebih kecil untuk layar mobile */
    @media (max-width: 600px) {
        .ui-autocomplete {
            font-size: 13px;
            max-height: 50vh;
        }
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        {{-- @include('layouts.navbar') --}}
        {{-- @include('layouts.sidebar') --}}

        <!-- <div class="content-wrapper">
            <div class="container-fluid"> -->

        <!-- <div class="w-[800px] mx-auto border">
                <h1 class="text-3xl font-semibold underline">
                    Cek Kesehatan Gratis
                </h1>
                <div>

                </div>
            </div> -->

        <div id="loadingScreen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
            <!-- <div id="lottie-loader" style="width: 200px; height: 200px;"></div> -->
            <style>
                @keyframes wiggle {

                    0%,
                    100% {
                        transform: rotate(-2deg);
                    }

                    50% {
                        transform: rotate(2deg);
                    }
                }

                #image-loader {
                    width: 200px;
                    height: 200px;
                    background-image: url('/logo_semarpkg79.png');
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    animation: wiggle 1s ease-in-out infinite;
                }
            </style>

            <div id="image-loader"></div>
            <!-- <div id="image-loader" class="animate-spin" style="width: 200px; height: 200px; background-image: url('{{ asset('logo_semarpkg79.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;"> -->
            <!-- </div> -->
        </div>

        <div id="mainContent" class="hidden">

            <section class="py-1 bg-blueGray-50">
                <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                        <div class="rounded-t bg-white mb-0 px-6 py-2">
                            <div class="text-center items-center flex justify-between">
                                <h6 class="text-blueGray-700 text-xl font-bold">
                                    Pemeriksaan Kesehatan Gratis
                                </h6>
                                <img class="nav-icon" src="{{ asset('logo_semarpkg79.png') }}" style="width:60px; height:auto;"></img>
                                {{-- <button
                                class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                type="button">
                                Settings
                            </button> --}}
                            </div>
                        </div>
                        <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                            <form>
                                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                                    Identitas Peserta Didik
                                </h6>
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nama Lengkap
                                            </label>
                                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nomor Induk Kependudukan (NIK)
                                            </label>
                                            <input type="text" id="nik" name="nik" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nomor Induk Siswa Nasional (NISN)
                                            </label>
                                            <input type="text" id="nisn" name="nisn" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Tempat / Tanggal Lahir
                                            </label>
                                            <div class="grid grid-cols-12 gap-2 mt-2">
                                                <input type="text" maxlength="20" placeholder="Tempat Lahir" id="tempat_lahir" class="col-span-12 md:col-span-5 border-0 px-3 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150" />

                                                <select id="tanggal_lahir" name="tanggal_lahir" class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
                                                    <option value="">Tgl</option>
                                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                                                </select>

                                                <select id="bulan_lahir" name="bulan_lahir" class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
                                                    <option value="">Bulan</option>
                                                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $idx => $bulan)
                                                    <option value="{{ $idx + 1 }}">{{ $bulan }}</option>
                                                    @endforeach
                                                </select>

                                                <select id="tahun_lahir" name="tahun_lahir" class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
                                                    <option value="">Tahun</option>
                                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nama Orangtua / Wali
                                            </label>
                                            <input type="text" id="nama_ortu_wali" name="nama_ortu_wali" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nomor HP/WA
                                            </label>
                                            <input type="text" id="no_hp" name="no_hp" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Umur
                                            </label>
                                            <input type="text" id="umur" name="umur" readonly class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <span class="text-sm italic text-[#94a3b8]">Otomatis berdasarkan TTL</span>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            function hitungUmur() {
                                                const tgl = document.getElementById('tanggal_lahir').value;
                                                const bln = document.getElementById('bulan_lahir').value;
                                                const thn = document.getElementById('tahun_lahir').value;
                                                const umurInput = document.getElementById('umur');
                                                if (tgl && bln && thn) {
                                                    const today = new Date();
                                                    const birthDate = new Date(thn, bln - 1, tgl);
                                                    let umur = today.getFullYear() - birthDate.getFullYear();
                                                    const m = today.getMonth() - birthDate.getMonth();
                                                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                                                        umur--;
                                                    }
                                                    umurInput.value = umur + ' tahun';
                                                } else {
                                                    umurInput.value = '';
                                                }
                                            }

                                            document.getElementById('tanggal_lahir').addEventListener('change', hitungUmur);
                                            document.getElementById('bulan_lahir').addEventListener('change', hitungUmur);
                                            document.getElementById('tahun_lahir').addEventListener('change', hitungUmur);
                                        });
                                    </script>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Nama Sekolah
                                            </label>
                                            <input type="text" id="nama_sekolah" name="nama_sekolah" placeholder="Cari nama sekolah..." class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <p class="text-sm italic text-[#94a3b8]">Ketik dan pilih nama sekolah</p>
                                            <input type="hidden" id="id_sekolah" name="id_sekolah">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Alamat Sekolah
                                            </label>
                                            <input type="text" id="alamat_sekolah" name="alamat_sekolah" readonly class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <p class="text-sm italic text-[#94a3b8]">Otomatis bedasrakan Nama Sekolah</p>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Kelas
                                            </label>
                                            <input type="number" id="kelas" name="kelas" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="puskesmas" class="block uppercase text-gray-600 text-xs font-bold mb-2">
                                                Puskesmas
                                            </label>
                                            <select id="puskesmas" disabled class="border-0 px-3 py-3 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                <option value="">-- Pilih Puskesmas --</option>
                                            </select>
                                            <p class="text-sm italic text-[#94a3b8]">Otomatis berdasarkan Nama Sekolah</p>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                Jenis Kelamin
                                            </label>
                                            <div class="flex space-x-4 mt-2">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="jenis_kemain" name="jenis_kelamin" value="laki-laki" class="form-radio text-pink-500">
                                                    <span class="ml-2">Laki - laki</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="jenis_kemain" name="jenis_kelamin" value="perempuan" class="form-radio text-pink-500">
                                                    <span class="ml-2">Perempuan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                Golongan Darah
                                            </label>
                                            <div class="flex space-x-4 mt-2">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="golongan_darah" name="golongan_darah" value="A" class="form-radio text-pink-500">
                                                    <span class="ml-2">A</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="golongan_darah" name="golongan_darah" value="B" class="form-radio text-pink-500">
                                                    <span class="ml-2">B</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="golongan_darah" name="golongan_darah" value="AB" class="form-radio text-pink-500">
                                                    <span class="ml-2">AB</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="golongan_darah" name="golongan_darah" value="O" class="form-radio text-pink-500">
                                                    <span class="ml-2">O</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" id="golongan_darah" name="golongan_darah" value="O" class="form-radio text-pink-500">
                                                    <span class="ml-2">Tidak Tahu</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="mt-6 border-b-1 border-blueGray-300">

                                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                                    Alamat Peserta Didik (Sesuai KK atau KTP)
                                </h6>

                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Provinsi</label>
                                            <select id="provinsi" name="provinsi" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kota / Kabupaten</label>
                                            <select id="kota" name="kota" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kecamatan</label>
                                            <select id="kecamatan" name="kecamatan" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kelurahan</label>
                                            <select id="kelurahan" id="kelurahan" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-12/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                                                Alamat
                                            </label>
                                            <input type="text" id="alamat" name="alamat" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>

                                </div>

                                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Alamat Domisili Peserta Didik</h6>

                                <div class="mb-4 px-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="alamat_sesuai_kk" id="checkbox-alamat-sesuai" class="form-checkbox text-pink-500">
                                        <span class="ml-2 text-sm font-semibold">Alamat domisili sesuai dengan alamat KK atau KTP</span>
                                    </label>
                                </div>

                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Provinsi Domisili</label>
                                            <select id="dom-provinsi" name="dom-provinsi" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kota / Kabupaten Domisili</label>
                                            <select id="dom-kota" name="dom-kota" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kecamatan Domisili</label>
                                            <select id="dom-kecamatan" name="dom-kecamatan" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Kelurahan Domisili</label>
                                            <select id="dom-kelurahan" name="dom-kelurahan" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"></select>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-12/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-gray-600 text-xs font-bold mb-2">Alamat Lengkap Domisili</label>
                                            <input type="text" id="dom-alamat" name="dom-alamat" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        </div>
                                    </div>
                                </div>


                                <hr class="mt-6 border-b-1 border-blueGray-300">

                                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                                    Jenis Disabilitas
                                </h6>
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-12/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                                Jenis Disabilitas
                                            </label>
                                            <div class="flex flex-col space-y-2 mt-2">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" id="disabilitas_tidak_ada" name="jenis_disabilitas[]" value="Tidak Ada" class="form-checkbox text-pink-500" onchange="toggleDisabilitas(this)">
                                                    <span class="ml-2">Tidak Ada</span>
                                                </label>
                                                <div id="disabilitas_lain_group">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Fisik" class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                        <span class="ml-2">Fisik</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Intelektual" class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                        <span class="ml-2">Intelektual</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Mental" class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                        <span class="ml-2">Mental</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Sensorik" class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                        <span class="ml-2">Sensorik</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <script>
                                                function toggleDisabilitas(checkbox) {
                                                    const lain = document.querySelectorAll('.disabilitas_lain');
                                                    const lainGroup = document.getElementById('disabilitas_lain_group');
                                                    if (checkbox.checked) {
                                                        lain.forEach(cb => {
                                                            cb.checked = false;
                                                            cb.disabled = true;
                                                        });
                                                        lainGroup.style.display = 'none';
                                                    } else {
                                                        lain.forEach(cb => cb.disabled = false);
                                                        lainGroup.style.display = '';
                                                    }
                                                }

                                                function toggleDisabilitasLain() {
                                                    const lain = document.querySelectorAll('.disabilitas_lain');
                                                    const tidakAda = document.getElementById('disabilitas_tidak_ada');
                                                    let anyChecked = false;
                                                    lain.forEach(cb => {
                                                        if (cb.checked) anyChecked = true;
                                                    });
                                                    if (anyChecked) {
                                                        tidakAda.checked = false;
                                                        tidakAda.disabled = true;
                                                    } else {
                                                        tidakAda.disabled = false;
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="text-right">
                                <button
                                    class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase px-12 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                    type="button">
                                    Kirim
                                </button>
                            </div> --}}
                                <button type="button" onclick="openModal()" class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase px-6 py-2 rounded shadow hover:shadow-md transition-all duration-150">
                                    Selanjutnya
                                </button>

                            </form>
                        </div>
                    </div>
                    <footer class="relative  pt-8 pb-6 mt-2">
                        <div class="container mx-auto px-4">
                            <div class="flex flex-wrap items-center md:justify-between justify-center">
                                <div class="w-full md:w-6/12 px-4 mx-auto text-center">
                                    <div class="text-sm text-blueGray-500 font-semibold py-1">
                                        <p>Powered by Dinas Kesehatan Kota Semarang</p>
                                        <!-- Made with <a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800" target="_blank">Notus JS</a> by <a href="https://www.creative-tim.com" class="text-blueGray-500 hover:text-blueGray-800" target="_blank"> Creative Tim</a>. -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </section>
        </div>


        {{-- modal --}}
        <!-- MODAL -->
        <div id="myModal" class="hidden fixed inset-0 z-10 overflow-y-auto transition-opacity duration-300 ease-out" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop -->
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500/75 transition-opacity duration-300 opacity-0" aria-hidden="true"></div>

            <!-- Modal Content Wrapper -->
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div id="modalContent" class="relative transform scale-95 opacity-0 overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-3xl">

                    <!-- Modal Inner -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M526.628571 512L190.171429 285.257143l343.771428-219.428572 336.457143 219.428572z" fill="#F4B1B2"></path>
                                        <path d="M526.628571 541.257143c-7.314286 0-7.314286 0-14.628571-7.314286L175.542857 307.2c-7.314286 0-7.314286-14.628571-7.314286-21.942857 0-7.314286 7.314286-14.628571 14.628572-21.942857L519.314286 36.571429c7.314286-7.314286 21.942857-7.314286 29.257143 0l343.771428 219.428571c7.314286 7.314286 14.628571 14.628571 14.628572 21.942857 0 7.314286-7.314286 14.628571-14.628572 21.942857L541.257143 533.942857s-7.314286 7.314286-14.628572 7.314286zM241.371429 285.257143l285.257142 190.171428 292.571429-190.171428-292.571429-190.171429-285.257142 190.171429z" fill="#D72822"></path>
                                        <path d="M526.628571 716.8L124.342857 446.171429c-14.628571-7.314286-21.942857-29.257143-7.314286-36.571429 7.314286-14.628571 21.942857-14.628571 36.571429-7.314286L533.942857 658.285714l394.971429-256c14.628571-7.314286 29.257143-7.314286 36.571428 7.314286s7.314286 29.257143-7.314285 36.571429L526.628571 716.8z" fill="#D72822"></path>
                                        <path d="M526.628571 877.714286L124.342857 607.085714c-14.628571-7.314286-21.942857-21.942857-7.314286-36.571428 7.314286-14.628571 21.942857-14.628571 36.571429-7.314286l380.342857 256 394.971429-256c14.628571-7.314286 29.257143-7.314286 36.571428 7.314286 7.314286 14.628571 7.314286 29.257143-7.314285 36.571428L526.628571 877.714286z" fill="#D72822"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900 mb-2" id="modal-title">FORMULIR SKRINING
                                    KESEHATAN ANAK USIA SEKOLAH DAN REMAJA
                                    <h3 class="text-base font-semibold text-gray-900">PUSKESMAS <span class="uppercase" id="output_puskesmas"></span> </h3>
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        PERNYATAAN PERSETUJUAN ORANG TUA/WALI
                                    </p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Dengan ini, saya menyetujui anak saya mengikuti kegiatan Cek Kesehatan Anak Sekolah
                                        (CKG) yang diselenggarakan oleh pihak sekolah bekerja sama dengan
                                        Puskesmas/Fasilitas Kesehatan Tingkat Pertama.
                                    </p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Demikian pernyataan ini saya buat dengan sebenarnya untuk digunakan sebagaimana
                                        mestinya.
                                    </p>
                                    <div class="flex justify-start text-gray-500 gap-2 item-start">
                                        <div>
                                            <p class="text-sm">Nama Sekolah</p>
                                            <p class="text-sm">Alamat</p>
                                        </div>
                                        <div>
                                            <p class="text-sm">: <span class="uppercase" id="output_nama_sekolah"></span>
                                            </p>
                                            <p class="text-sm">: <span class="uppercase" id="output_alamat_sekolah"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end items-center px-4 sm:px-6 py-4">
                                    <div class="w-full max-w-md">
                                        @include('CKG_Sekolah\signature-pad')
                                    </div>
                                </div>
                                <div class="mt-2 flex flex-col space-y-3">
                                    <label class="inline-flex items-center w-fit">
                                        <input type="radio" name="persetujuan" value="Setuju" class="form-checkbox text-pink-500">
                                        <span class="ml-2 text-sm font-semibold">Setuju</span>
                                    </label>
                                    <label class="inline-flex items-center w-fit">
                                        <input type="radio" name="persetujuan" value="Tidak" class="form-checkbox text-pink-500">
                                        <span class="ml-2 text-sm font-semibold">Tidak setuju</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="btn-kirim" type="submit" disabled class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold 
text-white bg-red-600 hover:bg-red-500 
disabled:bg-gray-400 disabled:text-gray-200 disabled:cursor-not-allowed disabled:opacity-50 
disabled:pointer-events-none sm:ml-3 sm:w-auto transition">
                            Selanjutnya
                        </button>

                        <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="cekModal" class="hidden fixed inset-0 z-10 overflow-y-auto transition-opacity duration-300 ease-out" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop -->
            <div id="cekModalBackdrop" class="fixed inset-0 bg-gray-500/75 transition-opacity duration-300 opacity-0" aria-hidden="true"></div>

            <!-- Modal Content Wrapper -->
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div id="cekModalContent" class="relative transform scale-95 opacity-0 overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-3xl">

                    <!-- Modal Inner -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h2 class="mb-3 font-semibold text-xl">Periksa kembali data yang sudah dimasukan!</h2>
                        <h3 class="text-lg font-semibold mb-2">Identitas Peserta Didik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 space-y-3 px-2">
                            <div>
                                <p class="font-semibold">Nama Lengkap</p>
                                <p id="output_nama_lengkap"></p>
                            </div>
                            <div>
                                <p class="font-semibold">NIK</p>
                                <p id="output_nik"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Tempat / Tanggal Lahir Siswa</p>
                                <p id="output_tempat_tanggal_lahir"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Nama Orangtua / Wali</p>
                                <p id="output_nama_orangtua"></p>
                            </div>
                            <div>
                                <p class="font-semibold">No HP / WA</p>
                                <p id="output_no_hp"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Umur</p>
                                <p id="output_umur"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Nama Sekolah</p>
                                <p id="output_nama_sekolah"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Alamat Sekolah</p>
                                <p id="output_alamat_sekolah"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kelas</p>
                                <p id="output_kelas"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Puskesmas</p>
                                <p id="output_puskesmas_result"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Jenis Kelamin</p>
                                <p id="output_jenis_kelamin"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Golongan Darah</p>
                                <p id="output_gol_darah"></p>
                            </div>
                        </div>
                        <hr class="mb-3">
                        <h3 class="text-lg font-semibold mb-2">Alamat Peserta Didik (Sesuai KTP / KK)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 space-y-3 px-2">
                            <div>
                                <p class="font-semibold">Provinsi</p>
                                <p id="output_provinsi_ktp"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kota / Kabupaten</p>
                                <p id="output_kota_ktp"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kecamatan</p>
                                <p id="output_kecamatan_ktp"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kelurahan</p>
                                <p id="output_kelurahan_ktp"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Alamat</p>
                                <p id="output_alamat_ktp"></p>
                            </div>
                        </div>

                        <hr class="mb-3">
                        <h3 class="text-lg font-semibold mb-2">Alamat Peserta Didik Domisili</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 space-y-3 px-2">
                            <div>
                                <p class="font-semibold">Provinsi</p>
                                <p id="output_provinsi_dom"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kota / Kabupaten</p>
                                <p id="output_kota_dom"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kecamatan</p>
                                <p id="output_kecamatan_dom"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Kelurahan</p>
                                <p id="output_kelurahan_dom"></p>
                            </div>
                            <div>
                                <p class="font-semibold">Alamat</p>
                                <p id="output_alamat_dom"></p>
                            </div>
                        </div>
                        <hr class="mb-3">
                        <h3 class="text-lg font-semibold mb-2">Jenis Disabilitas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 space-y-3 px-2">
                            <div>
                                <p class="font-semibold">Jenis</p>
                                <p id="output_disabilitas"></p>
                            </div>
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" onclick="submitData()" class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                            Kirim Data
                        </button>

                        <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 sm:mt-0 sm:w-auto">
                            Edit Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="invalid-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full text-center">
                <h2 id="judul-modal-message" class="text-lg font-semibold mb-4 text-red-600"></h2>
                <p id="invalid-modal-message" class="mb-4 text-gray-700"></p>
                <button onclick="document.getElementById('invalid-modal').classList.add('hidden')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('input[name="persetujuan"]');
                const tombolKirim = document.getElementById('btn-kirim');

                // Cek localStorage dan atur pilihan jika ada
                const savedValue = localStorage.getItem('persetujuan');
                if (savedValue) {
                    radios.forEach(radio => {
                        if (radio.value === savedValue) {
                            radio.checked = true;
                            tombolKirim.disabled = false;
                        }
                    });
                }

                // Simpan ke localStorage saat user memilih radio
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        localStorage.setItem('persetujuan', this.value);
                        tombolKirim.disabled = false;
                    });
                });

                // Disable tombol jika belum ada yang dipilih
                const anyChecked = Array.from(radios).some(r => r.checked);
                tombolKirim.disabled = !anyChecked;

                // ✅ Validasi tanda tangan saat tombol diklik
                tombolKirim.addEventListener('click', function(e) {
                    const tandaTangan = localStorage.getItem('tanda_tangan');
                    if (!tandaTangan || tandaTangan.trim() === '') {
                        e.preventDefault();
                        // alert('Silahkan untuk memberikan tanda tangan terlebih dahulu.');
                        // Isi pesan modal
                        document.getElementById('judul-modal-message').textContent = `Gagal Selanjutnya`;

                        document.getElementById('invalid-modal-message').textContent = `Silahkan tanda tangan terlebih dahulu dan Klik simpan`;

                        // Tampilkan modal
                        document.getElementById('invalid-modal').classList.remove('hidden');

                        return;
                    }

                    cekModal();

                });
            });
        </script>



        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                const provinsi = document.getElementById('provinsi');
                const kota = document.getElementById('kota');
                const kecamatan = document.getElementById('kecamatan');
                const kelurahan = document.getElementById('kelurahan');

                // Helper isi <select>
                const fillSelect = (element, data, placeholder) => {
                    element.innerHTML = `<option value="">-- ${placeholder} --</option>`;
                    data.forEach(item => {
                        element.innerHTML += `<option value="${item.kode}">${item.nama}</option>`;
                    });
                };

                // Fetch Provinsi
                const fetchProvinsi = async () => {
                    const res = await fetch(`/master_provinsi?search=`);
                    const data = await res.json();
                    fillSelect(provinsi, data, 'Pilih Provinsi');
                };

                // Fetch Kota berdasarkan provinsi
                const fetchKota = async (kode_provinsi) => {
                    const res = await fetch(`/master_kota_kab?search=&kode_parent=${kode_provinsi}`);
                    const data = await res.json();
                    fillSelect(kota, data, 'Pilih Kota/Kabupaten');
                };

                // Fetch Kecamatan berdasarkan kota
                const fetchKecamatan = async (kode_kota) => {
                    const res = await fetch(`/master_kecamatan?search=&kode_parent=${kode_kota}`);
                    const data = await res.json();
                    fillSelect(kecamatan, data, 'Pilih Kecamatan');
                };

                // Fetch Kelurahan berdasarkan kecamatan
                const fetchKelurahan = async (kode_kecamatan) => {
                    const res = await fetch(`/master_kelurahan?search=&kode_parent=${kode_kecamatan}`);
                    const data = await res.json();
                    fillSelect(kelurahan, data, 'Pilih Kelurahan');
                };

                // Jalankan chaining
                await fetchProvinsi();

                // Setelah provinsi terload
                const savedProv = localStorage.getItem('provinsi');
                if (savedProv) {
                    provinsi.value = savedProv;
                    await fetchKota(savedProv);
                }

                // Setelah kota terload
                const savedKota = localStorage.getItem('kota');
                if (savedKota) {
                    kota.value = savedKota;
                    await fetchKecamatan(savedKota);
                }

                // Setelah kecamatan terload
                const savedKec = localStorage.getItem('kecamatan');
                if (savedKec) {
                    kecamatan.value = savedKec;
                    await fetchKelurahan(savedKec);
                }

                // Setelah kelurahan terload
                const savedKel = localStorage.getItem('kelurahan');
                if (savedKel) {
                    kelurahan.value = savedKel;
                }

                provinsi.addEventListener('change', async () => {
                    const kode = provinsi.value;
                    if (kode) {
                        localStorage.setItem('provinsi', kode);
                        await fetchKota(kode);
                        kecamatan.innerHTML = '';
                        kelurahan.innerHTML = '';
                    }
                });

                kota.addEventListener('change', async () => {
                    const kode = kota.value;
                    if (kode) {
                        localStorage.setItem('kota', kode);
                        await fetchKecamatan(kode);
                        kelurahan.innerHTML = '';
                    }
                });

                kecamatan.addEventListener('change', async () => {
                    const kode = kecamatan.value;
                    if (kode) {
                        localStorage.setItem('kecamatan', kode);
                        await fetchKelurahan(kode);
                    }
                });

                kelurahan.addEventListener('change', () => {
                    const kode = kelurahan.value;
                    if (kode) {
                        localStorage.setItem('kelurahan', kode);
                    }
                });

            });

            document.addEventListener('DOMContentLoaded', () => {
                // DOMISILI FORM ELEMENTS
                const domProvinsi = document.getElementById('dom-provinsi');
                const domKota = document.getElementById('dom-kota');
                const domKecamatan = document.getElementById('dom-kecamatan');
                const domKelurahan = document.getElementById('dom-kelurahan');
                const domAlamat = document.getElementById('dom-alamat');

                // UTAMA FORM ELEMENTS (for copy)
                const provinsi = document.getElementById('provinsi');
                const kota = document.getElementById('kota');
                const kecamatan = document.getElementById('kecamatan');
                const kelurahan = document.getElementById('kelurahan');
                const alamat = document.getElementById('alamat');

                const checkbox = document.getElementById('checkbox-alamat-sesuai');

                // Bantu isi dropdown
                // const fillSelect = (el, data, placeholder, selectedKode = '') => {
                //     el.innerHTML = `<option value="">-- ${placeholder} --</option>`;
                //     data.forEach(item => {
                //         const selected = item.kode === selectedKode ? 'selected' : '';
                //         el.innerHTML += `<option value="${item.kode}" ${selected}>${item.nama}</option>`;
                //     });
                // };

                const fillSelect = (el, data, placeholder, selectedKode = '') => {
                    return new Promise(resolve => {
                        el.innerHTML = `<option value="">-- ${placeholder} --</option>`;
                        data.forEach(item => {
                            const selected = item.kode === selectedKode ? 'selected' : '';
                            el.innerHTML +=
                                `<option value="${item.kode}" ${selected}>${item.nama}</option>`;
                        });

                        // Tunggu sampai opsi benar-benar masuk DOM
                        setTimeout(() => {
                            if (selectedKode && el.querySelector(
                                    `option[value="${selectedKode}"]`)) {
                                el.value = selectedKode;
                            }
                            resolve();
                        }, 10); // delay ringan
                    });
                };


                const fetchData = async (url) => {
                    const res = await fetch(url);
                    return await res.json();
                };

                // Simpan ke localStorage jika input manual
                const storeDomisili = () => {
                    if (!checkbox.checked) {
                        localStorage.setItem('alamat_sesuai_kk', 'false');
                        localStorage.setItem('dom-provinsi', domProvinsi.value);
                        localStorage.setItem('dom-kota', domKota.value);
                        localStorage.setItem('dom-kecamatan', domKecamatan.value);
                        localStorage.setItem('dom-kelurahan', domKelurahan.value);
                        localStorage.setItem('dom-alamat', domAlamat.value);
                    }
                };

                // Restore jika input manual
                const restoreDomisili = async () => {
                    const savedProv = localStorage.getItem('dom-provinsi');
                    const savedKota = localStorage.getItem('dom-kota');
                    const savedKec = localStorage.getItem('dom-kecamatan');
                    const savedKel = localStorage.getItem('dom-kelurahan');
                    const savedAlamat = localStorage.getItem('dom-alamat');

                    if (savedProv) {
                        const provData = await fetchData('/master_provinsi?search=');
                        await fillSelect(domProvinsi, provData, 'Pilih Provinsi', savedProv);
                    }

                    if (savedKota && savedProv) {
                        const kotaData = await fetchData(`/master_kota_kab?search=&kode_parent=${savedProv}`);
                        await fillSelect(domKota, kotaData, 'Pilih Kota/Kabupaten', savedKota);
                    }

                    if (savedKec && savedKota) {
                        const kecData = await fetchData(`/master_kecamatan?search=&kode_parent=${savedKota}`);
                        await fillSelect(domKecamatan, kecData, 'Pilih Kecamatan', savedKec);
                    }

                    if (savedKel && savedKec) {
                        const kelData = await fetchData(`/master_kelurahan?search=&kode_parent=${savedKec}`);
                        await fillSelect(domKelurahan, kelData, 'Pilih Kelurahan', savedKel);
                    }

                    if (savedAlamat) domAlamat.value = savedAlamat;
                };

                // Checkbox kontrol salin / manual
                checkbox.addEventListener('change', async function() {
                    localStorage.setItem('alamat_sesuai_kk', this.checked);

                    if (this.checked) {
                        const kodeProv = provinsi.value;
                        const kodeKota = kota.value;
                        const kodeKec = kecamatan.value;
                        const kodeKel = kelurahan.value;

                        const provinsiData = await fetchData('/master_provinsi?search=');
                        await fillSelect(domProvinsi, provinsiData, 'Pilih Provinsi', kodeProv);

                        const kotaData = await fetchData(
                            `/master_kota_kab?search=&kode_parent=${kodeProv}`);
                        await fillSelect(domKota, kotaData, 'Pilih Kota/Kabupaten', kodeKota);

                        const kecamatanData = await fetchData(
                            `/master_kecamatan?search=&kode_parent=${kodeKota}`);
                        await fillSelect(domKecamatan, kecamatanData, 'Pilih Kecamatan', kodeKec);

                        const kelurahanData = await fetchData(
                            `/master_kelurahan?search=&kode_parent=${kodeKec}`);
                        await fillSelect(domKelurahan, kelurahanData, 'Pilih Kelurahan', kodeKel);

                        if (alamat && domAlamat) domAlamat.value = alamat.value;

                        // ✅ Simpan ke localStorage meskipun dari salinan
                        localStorage.setItem('dom-provinsi', kodeProv);
                        localStorage.setItem('dom-kota', kodeKota);
                        localStorage.setItem('dom-kecamatan', kodeKec);
                        localStorage.setItem('dom-kelurahan', kodeKel);
                        localStorage.setItem('dom-alamat', alamat.value || '');

                    } else {
                        domProvinsi.selectedIndex = 0;
                        domKota.innerHTML = '';
                        domKecamatan.innerHTML = '';
                        domKelurahan.innerHTML = '';
                        domAlamat.value = '';
                    }
                });



                // Chaining manual domisili (plus simpan)
                domProvinsi.addEventListener('change', async () => {
                    const kode = domProvinsi.value;
                    if (kode) {
                        const kotaData = await fetchData(`/master_kota_kab?search=&kode_parent=${kode}`);
                        fillSelect(domKota, kotaData, 'Pilih Kota/Kabupaten');
                        domKecamatan.innerHTML = '';
                        domKelurahan.innerHTML = '';
                    }
                    storeDomisili();
                });

                domKota.addEventListener('change', async () => {
                    const kode = domKota.value;
                    if (kode) {
                        const kecData = await fetchData(`/master_kecamatan?search=&kode_parent=${kode}`);
                        fillSelect(domKecamatan, kecData, 'Pilih Kecamatan');
                        domKelurahan.innerHTML = '';
                    }
                    storeDomisili();
                });

                domKecamatan.addEventListener('change', async () => {
                    const kode = domKecamatan.value;
                    if (kode) {
                        const kelData = await fetchData(`/master_kelurahan?search=&kode_parent=${kode}`);
                        fillSelect(domKelurahan, kelData, 'Pilih Kelurahan');
                    }
                    storeDomisili();
                });

                domKelurahan.addEventListener('change', storeDomisili);
                domAlamat.addEventListener('input', storeDomisili);

                // Saat load awal
                (async () => {

                    await restoreDomisili();

                    const fromStorage = localStorage.getItem('alamat_sesuai_kk');
                    checkbox.checked = fromStorage === 'true';

                    if (checkbox.checked) {
                        // Tunggu elemen utama terisi
                        const waitUntilFilled = async (el) => {
                            let attempts = 0;
                            while (!el.value && attempts < 20) {
                                await new Promise(res => setTimeout(res, 50));
                                attempts++;
                            }
                            return el.value;
                        };

                        const kodeProv = await waitUntilFilled(provinsi);
                        const kodeKota = await waitUntilFilled(kota);
                        const kodeKec = await waitUntilFilled(kecamatan);
                        const kodeKel = await waitUntilFilled(kelurahan);

                        const provinsiData = await fetchData('/master_provinsi?search=');
                        const kotaData = await fetchData(`/master_kota_kab?search=&kode_parent=${kodeProv}`);
                        const kecamatanData = await fetchData(
                            `/master_kecamatan?search=&kode_parent=${kodeKota}`);
                        const kelurahanData = await fetchData(
                            `/master_kelurahan?search=&kode_parent=${kodeKec}`);

                        await fillSelect(domProvinsi, provinsiData, 'Pilih Provinsi', kodeProv);
                        await fillSelect(domKota, kotaData, 'Pilih Kota/Kabupaten', kodeKota);
                        await fillSelect(domKecamatan, kecamatanData, 'Pilih Kecamatan', kodeKec);
                        await fillSelect(domKelurahan, kelurahanData, 'Pilih Kelurahan', kodeKel);

                        if (alamat && domAlamat) domAlamat.value = alamat.value;
                    } else {

                    }

                })();

            });
        </script>


        <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>

        <script>
            // Load animasi
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-loader'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                // path: '/logo_semarpkg79.json'
                path: 'https://lottie.host/cb201212-1750-42ba-bf36-c1246e6f8494/a2wZUiTkxo.json'
            });

            // Sembunyikan loader setelah halaman selesai
            window.addEventListener('load', function() {
                setTimeout(() => {
                    document.getElementById('loadingScreen').style.display = 'none';
                    document.getElementById('mainContent').classList.remove('hidden');
                }, 2000);
            });
        </script>

        <!-- @yield('content') -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            $("#nama_sekolah").autocomplete({
                minLength: 2,
                source: function(request, response) {
                    // Tampilkan sementara keterangan "Mencari data..."
                    response([{
                        label: "Mencari data...",
                        value: ""
                    }]);

                    $.ajax({
                        url: "/master_sekolah/cari",
                        type: "GET",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            const result = data.map(function(item) {
                                return {
                                    label: item.nama,
                                    value: item.nama,
                                    alamat: item.alamat,
                                    id: item.id,
                                    id_puskesmas: item.id_puskesmas
                                };
                            });

                            // Hapus "Mencari data..." dan tampilkan hasil asli
                            response(result.length > 0 ? result : [{
                                label: "Tidak ditemukan",
                                value: ""
                            }]);
                        },
                        error: function() {
                            response([{
                                label: "Gagal memuat data",
                                value: ""
                            }]);
                        }
                    });
                },
                select: function(event, ui) {
                    if (!ui.item || !ui.item.id)
                        return false; // abaikan klik pada "Mencari data" atau "Tidak ditemukan"

                    const namaSekolah = ui.item.value;
                    const alamatSekolah = ui.item.alamat?.trim() !== '' ? ui.item.alamat : '-';
                    const idSekolah = ui.item.id;
                    const idPuskesmas = ui.item.id_puskesmas;

                    $("#nama_sekolah").val(namaSekolah);
                    $("#alamat_sekolah").val(alamatSekolah);
                    $("#id_sekolah").val(idSekolah);

                    localStorage.setItem('nama_sekolah', namaSekolah);
                    localStorage.setItem('alamat_sekolah', alamatSekolah);
                    localStorage.setItem('id_sekolah', idSekolah);

                    $("#output_nama_sekolah").text(namaSekolah);
                    $("#output_alamat_sekolah").text(alamatSekolah);

                    const optionExists = $(`#puskesmas option[value="${idPuskesmas}"]`).length > 0;
                    if (optionExists) {
                        $("#puskesmas").val(idPuskesmas).trigger('change');
                        localStorage.setItem('puskesmas', idPuskesmas);
                    } else {
                        localStorage.setItem('pending_puskesmas', idPuskesmas);
                    }

                    return false;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/master_puskesmas',
                type: 'GET',
                success: function(data) {
                    const select = $('#puskesmas');
                    select.empty().append(`<option value="">-- Pilih Puskesmas --</option>`);

                    data.forEach(function(item) {
                        select.append(`<option value="${item.id}">${item.nama}</option>`);
                    });

                    // Ambil nilai dari localStorage (restore puskesmas terakhir)
                    const savedValue = localStorage.getItem('puskesmas');
                    if (savedValue) {
                        select.val(savedValue);
                    }

                    // Jika ada pending puskesmas dari autocomplete
                    const pendingValue = localStorage.getItem('pending_puskesmas');
                    if (pendingValue && $(`#puskesmas option[value="${pendingValue}"]`).length > 0) {
                        select.val(pendingValue).trigger('change');
                        localStorage.setItem('puskesmas', pendingValue);
                        localStorage.removeItem('pending_puskesmas');
                    }

                    // Set output tampilan
                    const selectedText = $('#puskesmas option:selected').text();
                    $('#output_puskesmas').text(selectedText);
                    $('#output_puskesmas_result').text(selectedText);
                },
                error: function() {
                    alert('Gagal mengambil data puskesmas.');
                }
            });


            $('#puskesmas').on('change', function() {
                const selectedText = $('#puskesmas option:selected').text();
                $('#output_puskesmas').text(selectedText);
                $('#output_puskesmas_result').text(selectedText);
                localStorage.setItem('puskesmas', this.value);
            });
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputElements = document.querySelectorAll(
                'input[type="text"], input[type="number"], select, textarea');

            const namaInput = document.getElementById('nama_sekolah');
            const alamatInput = document.getElementById('alamat_sekolah');
            const outputNama = document.getElementById('output_nama_sekolah');
            const outputAlamat = document.getElementById('output_alamat_sekolah');

            // Tampilkan nilai awal dari localStorage
            const namaSekolah = localStorage.getItem('nama_sekolah') || '';
            const alamatSekolah = localStorage.getItem('alamat_sekolah') || '';
            namaInput.value = namaSekolah;
            alamatInput.value = alamatSekolah;
            outputNama.innerText = namaSekolah;
            outputAlamat.innerText = alamatSekolah;

            // Update output ketika input berubah
            namaInput.addEventListener('input', function() {
                outputNama.innerText = this.value;
            });

            alamatInput.addEventListener('input', function() {
                outputAlamat.innerText = this.value;
            });

            // Restore nilai dari localStorage
            inputElements.forEach(input => {
                const savedValue = localStorage.getItem(input.id);
                if (savedValue !== null) {
                    input.value = savedValue;
                }
            });

            // Simpan saat input berubah
            inputElements.forEach(input => {
                input.addEventListener('input', () => {
                    if (input.id) {
                        localStorage.setItem(input.id, input.value);
                    }
                });
            });

            // Restore radio button
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                const saved = localStorage.getItem(radio.name);
                if (saved === radio.value) {
                    radio.checked = true;
                }
                radio.addEventListener('change', () => {
                    localStorage.setItem(radio.name, radio.value);
                });
            });

            // Restore checkbox
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                const saved = localStorage.getItem(checkbox.id || checkbox.value);
                if (saved === 'true') {
                    checkbox.checked = true;
                }
                checkbox.addEventListener('change', () => {
                    localStorage.setItem(checkbox.id || checkbox.value, checkbox.checked);
                });
            });

            // Hitung umur berdasarkan TTL
            function hitungUmur() {
                const tgl = document.getElementById('tanggal_lahir').value;
                const bln = document.getElementById('bulan_lahir').value;
                const thn = document.getElementById('tahun_lahir').value;
                const umurInput = document.getElementById('umur');

                if (tgl && bln && thn) {
                    const today = new Date();
                    const birthDate = new Date(thn, bln - 1, tgl);
                    let umur = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();

                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        umur--;
                    }

                    umurInput.value = umur + ' tahun';
                    localStorage.setItem('umur', umurInput.value); // ✅ simpan umur
                } else {
                    umurInput.value = '';
                    localStorage.removeItem('umur');
                }
            }

            // Restore umur setelah reload
            const umurInput = document.getElementById('umur');
            const savedUmur = localStorage.getItem('umur');
            if (savedUmur !== null && umurInput) {
                umurInput.value = savedUmur;
            }

            // ✅ Tambahkan event listener agar umur dihitung saat TTL berubah
            document.getElementById('tanggal_lahir')?.addEventListener('change', hitungUmur);
            document.getElementById('bulan_lahir')?.addEventListener('change', hitungUmur);
            document.getElementById('tahun_lahir')?.addEventListener('change', hitungUmur);

            // Jalankan hitung umur jika TTL sudah terisi saat load
            hitungUmur();
        });

        // ✅ Fungsi untuk hapus semua data dari localStorage saat submit
        function clearFormStorage() {
            const all = document.querySelectorAll('input, select, textarea');
            all.forEach(el => {
                if (el.id) localStorage.removeItem(el.id);
                if (el.name && el.type === 'radio') localStorage.removeItem(el.name);
                if (el.type === 'checkbox') localStorage.removeItem(el.id || el.value);
            });
        }

        function openModal() {
            const data = {
                nama_lengkap: document.getElementById("nama_lengkap")?.value || "",
                nik: document.getElementById("nik")?.value || "",
                no_hp: document.getElementById("no_hp")?.value || "",
                tempat_lahir: document.getElementById("tempat_lahir")?.value || "",
                tanggal_lahir: document.getElementById("tanggal_lahir")?.value || "",
                bulan_lahir: document.getElementById("bulan_lahir")?.value || "",
                tahun_lahir: document.getElementById("tahun_lahir")?.value || "",
                nama_ortu_wali: document.getElementById("nama_ortu_wali")?.value || "",
                umur: document.getElementById("umur")?.value || "",
                nama_sekolah: document.getElementById("nama_sekolah")?.value || "",
                alamat_sekolah: document.getElementById("alamat_sekolah")?.value || "",
                kelas: document.getElementById("kelas")?.value || "",
                puskesmas: document.getElementById("puskesmas")?.value || "",
                jenis_kelamin: document.querySelector('input[name="jenis_kelamin"]:checked')?.value || '',
                golongan_darah: document.querySelector('input[name="golongan_darah"]:checked')?.value || "",
                provinsi: document.getElementById("provinsi")?.selectedOptions[0]?.text || "",
                kota: document.getElementById("kota")?.selectedOptions[0]?.text || "",
                kecamatan: document.getElementById("kecamatan")?.selectedOptions[0]?.text || "",
                kelurahan: document.getElementById("kelurahan")?.selectedOptions[0]?.text || "",
                alamat: document.getElementById("alamat")?.value || "",
                disabilitas: Array.from(document.querySelectorAll('input[name="jenis_disabilitas[]"]:checked')).map(
                    cb => cb.value),
                provinsi_dom: document.getElementById("dom-provinsi")?.selectedOptions[0]?.text || "",
                kota_dom: document.getElementById("dom-kota")?.selectedOptions[0]?.text || "",
                kecamatan_dom: document.getElementById("dom-kecamatan")?.selectedOptions[0]?.text || "",
                kelurahan_dom: document.getElementById("dom-kelurahan")?.selectedOptions[0]?.text || "",
                alamat_dom: document.getElementById("dom-alamat")?.value || ""

            };

            // console.log(data);

            const modal = document.getElementById('myModal');
            const content = document.getElementById('modalContent');
            const backdrop = document.getElementById('modalBackdrop');

            const isDataValid = Object.entries(data).every(([key, value]) => {
                if (key === 'disabilitas') return Array.isArray(value) && value.length > 0; // validasi khusus
                return value !== '';
            });

            if (!isDataValid) {
                const invalidFields = Object.entries(data).filter(([key, value]) => {
                    if (key === 'disabilitas') return !Array.isArray(value) || value.length === 0;
                    return value === '';
                }).map(([key]) => key);

                // const invalidFieldsFormatted = invalidFields
                //     .map(field => field.replace(/_/g, ' ').replace(/^\w/, c => c.toUpperCase()))
                //     .join(', ');

                const invalidFieldsFormatted = invalidFields
                    .map(field => field.replace(/_/g, ' ').replace(/^\w/, c => c.toUpperCase()))
                    .join(', ');


                document.getElementById('judul-modal-message').textContent = `Gagal Selanjutnya`;
                // Isi pesan modal
                document.getElementById('invalid-modal-message').textContent = `Data ${invalidFieldsFormatted} wajib diisi!`;

                // Tampilkan modal
                document.getElementById('invalid-modal').classList.remove('hidden');

                // alert(`Data ${invalidFieldsFormatted} wajib diisi!`);
                return;
            }

            modal.classList.remove('hidden');

            // Delay untuk trigger transition
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');

                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
            }, 10);
        }

        function cekModal() {
            let nama_lengkap = document.getElementById("nama_lengkap")?.value || "";
            let nik = document.getElementById("nik")?.value || "";
            let no_hp = document.getElementById("no_hp")?.value || "";
            let tempat_lahir = document.getElementById("tempat_lahir")?.value || "";
            let tanggal_lahir = document.getElementById("tanggal_lahir")?.value || "";
            let bulan_lahir = document.getElementById("bulan_lahir")?.value || "";
            let tahun_lahir = document.getElementById("tahun_lahir")?.value || "";
            let nama_ortu_wali = document.getElementById("nama_ortu_wali")?.value || "";
            let umur = document.getElementById("umur")?.value || "";
            let nama_sekolah = document.getElementById("nama_sekolah")?.value || "";
            let alamat_sekolah = document.getElementById("alamat_sekolah")?.value || "";
            let kelas = document.getElementById("kelas")?.value || "";
            let puskesmas = document.getElementById("puskesmas")?.value || "";
            let jenis_kelamin = document.querySelector('input[name="jenis_kelamin"]:checked')?.value || '';
            let golongan_darah = document.querySelector('input[name="golongan_darah"]:checked')?.value || "";
            let provinsi = document.getElementById("provinsi")?.selectedOptions[0]?.text || "";
            let kota = document.getElementById("kota")?.selectedOptions[0]?.text || "";
            let kecamatan = document.getElementById("kecamatan")?.selectedOptions[0]?.text || "";
            let kelurahan = document.getElementById("kelurahan")?.selectedOptions[0]?.text || "";
            let alamat = document.getElementById("alamat")?.value || "";

            let disabilitasCheckboxes = document.querySelectorAll('input[name="jenis_disabilitas[]"]:checked');
            let disabilitasList = Array.from(disabilitasCheckboxes).map(cb => cb.value);

            let provinsi_dom = document.getElementById("dom-provinsi")?.selectedOptions[0]?.text || "";
            let kota_dom = document.getElementById("dom-kota")?.selectedOptions[0]?.text || "";
            let kecamatan_dom = document.getElementById("dom-kecamatan")?.selectedOptions[0]?.text || "";
            let kelurahan_dom = document.getElementById("dom-kelurahan")?.selectedOptions[0]?.text || "";
            let alamat_dom = document.getElementById("dom-alamat")?.value || "";

            document.getElementById("output_nama_lengkap").innerText = nama_lengkap;
            document.getElementById("output_nik").innerText = nik;
            document.getElementById("output_no_hp").innerText = no_hp;
            document.getElementById("output_tempat_tanggal_lahir").innerText =
                `${tempat_lahir}, ${tanggal_lahir}-${bulan_lahir}-${tahun_lahir}`;
            document.getElementById("output_nama_orangtua").innerText = nama_ortu_wali;
            document.getElementById("output_umur").innerText = umur;
            document.getElementById("output_nama_sekolah").innerText = nama_sekolah;
            document.getElementById("output_alamat_sekolah").innerText = alamat_sekolah;
            document.getElementById("output_kelas").innerText = kelas;
            document.getElementById("output_puskesmas").innerText = puskesmas;
            document.getElementById("output_jenis_kelamin").innerText = jenis_kelamin;
            document.getElementById("output_gol_darah").innerText = golongan_darah;

            document.getElementById("output_provinsi_dom").innerText = provinsi_dom;
            document.getElementById("output_kota_dom").innerText = kota_dom;
            document.getElementById("output_kecamatan_dom").innerText = kecamatan_dom;
            document.getElementById("output_kelurahan_dom").innerText = kelurahan_dom;
            document.getElementById("output_alamat_dom").innerText = alamat_dom;

            // Jika alamat KTP/KK sama dengan domisili, bisa isi otomatis juga:
            document.getElementById("output_provinsi_ktp").innerText = provinsi;
            document.getElementById("output_kota_ktp").innerText = kota;
            document.getElementById("output_kecamatan_ktp").innerText = kecamatan;
            document.getElementById("output_kelurahan_ktp").innerText = kelurahan;

            // Jika ada jenis disabilitas:
            document.getElementById("output_disabilitas").innerText = disabilitasList.join(', ');


            const persetujuanModal = document.getElementById('cekModal');
            const persetujuanModalContent = document.getElementById('cekModalContent');
            const persetujuanModalBackdrop = document.getElementById('cekModalBackdrop');

            // persetujuanModalContent.classList.remove('scale-100', 'opacity-100');
            // persetujuanModalContent.classList.add('scale-95', 'opacity-0');

            // persetujuanModalBackdrop.classList.remove('opacity-100');
            // persetujuanModalBackdrop.classList.add('opacity-0');

            const modal = document.getElementById('myModal');
            // const content = document.getElementById('modalContent');
            // const backdrop = document.getElementById('modalBackdrop');

            const tandaTangan = localStorage.getItem('tanda_tangan');

            if (tandaTangan) {
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                persetujuanModal.classList.remove('hidden');

                // Delay untuk trigger transition
                setTimeout(() => {
                    persetujuanModalContent.classList.remove('scale-95', 'opacity-0');
                    persetujuanModalContent.classList.add('scale-100', 'opacity-100');

                    persetujuanModalBackdrop.classList.remove('opacity-0');
                    persetujuanModalBackdrop.classList.add('opacity-100');
                }, 10);
            } else {
                modal.classList.remove('hidden');
                alert('Silakan berikan tanda tangan terlebih dahulu.');
            }

        }

        function closeModal() {
            const modal = document.getElementById('myModal');
            const content = document.getElementById('modalContent');
            const backdrop = document.getElementById('modalBackdrop');

            const persetujuanModal = document.getElementById('cekModal');
            const persetujuanModalContent = document.getElementById('cekModalContent');
            const persetujuanModalBackdrop = document.getElementById('cekModalBackdrop');

            persetujuanModalContent.classList.remove('scale-100', 'opacity-100');
            persetujuanModalContent.classList.add('scale-95', 'opacity-0');

            persetujuanModalBackdrop.classList.remove('opacity-100');
            persetujuanModalBackdrop.classList.add('opacity-0');

            // Tambahkan kelas keluar
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');

            // Setelah animasi selesai, sembunyikan modal
            setTimeout(() => {
                persetujuanModal.classList.add('hidden');
                modal.classList.add('hidden');
            }, 300);
        }

        function submitData() {
            const kelas = localStorage.getItem('kelas') || '';
            const jenis_kelamin = localStorage.getItem('jenis_kelamin') || '';

            // clearFormStorage();

            window.location.href =
                `/pkg_sekolah/screening?kelas=${encodeURIComponent(kelas)}&jk=${encodeURIComponent(jenis_kelamin)}&jenis=mandiri`;
        }
    </script>

</body>