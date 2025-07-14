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
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    {{-- @include('layouts.header') --}}
</head>

<style>
    body {
        font-family: "Geist", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        color: #323232;
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
                <div id="lottie-loader" style="width: 200px; height: 200px;"></div>
            </div>

            <div id="mainContent" class="hidden">
            
        <section class=" py-1 bg-blueGray-50">
            <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                    <div class="rounded-t bg-white mb-0 px-6 py-2">
                        <div class="text-center items-center flex justify-between">
                            <h6 class="text-blueGray-700 text-xl font-bold">
                                Cek Kesehatan Gratis
                            </h6>
                            <img class="nav-icon" src="{{asset('logo_semarpkg79.png')}}" style="width:60px; height:auto;"></img>
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
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Nama Lengkap
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Nomor Induk Kependudukan
                                        </label>
                                        <input type="email"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Tempat / Tanggal Lahir
                                        </label>
                                        <div class="grid grid-cols-12 gap-2 mt-2">
                                            <input type="text" maxlength="20" placeholder="Tempat Lahir"
                                                class="col-span-12 md:col-span-5 border-0 px-3 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150" />

                                            <select id="tanggal_lahir" name="tanggal_lahir"
                                                class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
                                                <option value="">Tgl</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>

                                            <select id="bulan_lahir" name="bulan_lahir"
                                                class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
                                                <option value="">Bulan</option>
                                                @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $bulan)
                                                    <option value="{{ $idx+1 }}">{{ $bulan }}</option>
                                                @endforeach
                                            </select>

                                            <select id="tahun_lahir" name="tahun_lahir"
                                                class="col-span-4 md:col-span-2 border-0 px-2 py-2 bg-white rounded text-sm shadow focus:outline-none focus:ring transition-all duration-150">
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
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Nama Orangtua / Wali
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Umur
                                        </label>
                                        <input type="text" id="umur" readonly
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <span class="text-sm italic text-[#94a3b8]">Otomatis berdasarkan TTL</span>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
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
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Nama Sekolah
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Alamat Sekolah
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kelas
                                        </label>
                                        <input type="number"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Puskesmas
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                                            Jenis Kelamin
                                        </label>
                                        <div class="flex space-x-4 mt-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="golongan_darah" value="A"
                                                    class="form-radio text-pink-500">
                                                <span class="ml-2">Laki - laki</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="golongan_darah" value="B"
                                                    class="form-radio text-pink-500">
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
                                                <input type="radio" name="golongan_darah" value="A"
                                                    class="form-radio text-pink-500">
                                                <span class="ml-2">A</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="golongan_darah" value="B"
                                                    class="form-radio text-pink-500">
                                                <span class="ml-2">B</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="golongan_darah" value="AB"
                                                    class="form-radio text-pink-500">
                                                <span class="ml-2">AB</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="golongan_darah" value="O"
                                                    class="form-radio text-pink-500">
                                                <span class="ml-2">O</span>
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
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Provinsi
                                        </label>
                                        <input type="email"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kota / Kabupaten
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kecamatan
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kelurahan
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Alamat
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>

                            </div>

                            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                                Alamat Domisili Peserta Didik
                            </h6>
                            <div class="mb-4 px-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="alamat_sesuai_kk"
                                        class="form-checkbox text-pink-500">
                                    <span class="ml-2 text-sm font-semibold">Alamat domisili sesuai dengan alamat KK
                                        atau KTP</span>
                                </label>
                            </div>
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Provinsi
                                        </label>
                                        <input type="email"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kota / Kabupaten
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kecamatan
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kelurahan
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Alamat
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                                                <input type="checkbox" id="disabilitas_tidak_ada" name="jenis_disabilitas[]" value="Tidak Ada"
                                                    class="form-checkbox text-pink-500" onchange="toggleDisabilitas(this)">
                                                <span class="ml-2">Tidak Ada</span>
                                            </label>
                                            <div id="disabilitas_lain_group">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Fisik"
                                                        class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                    <span class="ml-2">Fisik</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Intelektual"
                                                        class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                    <span class="ml-2">Intelektual</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Mental"
                                                        class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
                                                    <span class="ml-2">Mental</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="disabilitas_lain" name="jenis_disabilitas[]" value="Sensorik"
                                                        class="form-checkbox text-pink-500" onchange="toggleDisabilitasLain()">
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
                            <button type="button" onclick="openModal()"
                                class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase px-6 py-2 rounded shadow hover:shadow-md transition-all duration-150">
                                Kirim
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
        <div id="myModal" class="hidden fixed inset-0 z-10 overflow-y-auto transition-opacity duration-300 ease-out"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop -->
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500/75 transition-opacity duration-300 opacity-0"
                aria-hidden="true"></div>

            <!-- Modal Content Wrapper -->
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div id="modalContent"
                    class="relative transform scale-95 opacity-0 overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-3xl">

                    <!-- Modal Inner -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M526.628571 512L190.171429 285.257143l343.771428-219.428572 336.457143 219.428572z" fill="#F4B1B2"></path><path d="M526.628571 541.257143c-7.314286 0-7.314286 0-14.628571-7.314286L175.542857 307.2c-7.314286 0-7.314286-14.628571-7.314286-21.942857 0-7.314286 7.314286-14.628571 14.628572-21.942857L519.314286 36.571429c7.314286-7.314286 21.942857-7.314286 29.257143 0l343.771428 219.428571c7.314286 7.314286 14.628571 14.628571 14.628572 21.942857 0 7.314286-7.314286 14.628571-14.628572 21.942857L541.257143 533.942857s-7.314286 7.314286-14.628572 7.314286zM241.371429 285.257143l285.257142 190.171428 292.571429-190.171428-292.571429-190.171429-285.257142 190.171429z" fill="#D72822"></path><path d="M526.628571 716.8L124.342857 446.171429c-14.628571-7.314286-21.942857-29.257143-7.314286-36.571429 7.314286-14.628571 21.942857-14.628571 36.571429-7.314286L533.942857 658.285714l394.971429-256c14.628571-7.314286 29.257143-7.314286 36.571428 7.314286s7.314286 29.257143-7.314285 36.571429L526.628571 716.8z" fill="#D72822"></path><path d="M526.628571 877.714286L124.342857 607.085714c-14.628571-7.314286-21.942857-21.942857-7.314286-36.571428 7.314286-14.628571 21.942857-14.628571 36.571429-7.314286l380.342857 256 394.971429-256c14.628571-7.314286 29.257143-7.314286 36.571428 7.314286 7.314286 14.628571 7.314286 29.257143-7.314285 36.571428L526.628571 877.714286z" fill="#D72822"></path></g></svg>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900 mb-2" id="modal-title">FORMULIR SKRINING KESEHATAN ANAK USIA SEKOLAH DAN REMAJA
                                <h3 class="text-base font-semibold text-gray-900">PUSKESMAS …………………………… </h3>
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        PERNYATAAN PERSETUJUAN ORANG TUA/WALI
                                    </p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Dengan ini, saya menyetujui anak saya mengikuti kegiatan Cek Kesehatan Anak Sekolah (CKG) yang diselenggarakan oleh pihak sekolah bekerja sama dengan Puskesmas/Fasilitas Kesehatan Tingkat Pertama.
                                    </p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Demikian pernyataan ini saya buat dengan sebenarnya untuk digunakan sebagaimana mestinya.
                                    </p>
                                    <div class="flex justify-start text-gray-500 gap-2 item-start">
                                        <div>
                                            <p class="text-sm">Nama Sekolah</p>
                                            <p class="text-sm">Alamat</p>
                                        </div>
                                        <div>
                                            <p class="text-sm">: SDN 1 SUKOHARJO</p>
                                            <p class="text-sm">: Jl Veteran No. 5, 34482</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="alamat_sesuai_kk"
                                        class="form-checkbox text-pink-500">
                                        <span class="ml-2 text-sm font-semibold">Setuju</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Action Buttons -->
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Kirim Sekarang
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>

        <script>
            // Load animasi
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-loader'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'https://lottie.host/cb201212-1750-42ba-bf36-c1246e6f8494/a2wZUiTkxo.json'
            });

            // Sembunyikan loader setelah halaman selesai
            window.addEventListener('load', function () {
                setTimeout(() => {
                    document.getElementById('loadingScreen').style.display = 'none';
                    document.getElementById('mainContent').classList.remove('hidden');
                }, 2000);
            });
        </script>

        <!-- <div class="container mt-6">
                <h1 class="container">Identitas Peserta Didik</h1>
                <div class="card">
                    <div class="card-body">
                        <form class="">
                            <input type="text" class="form-control mb-3" placeholder="Masukkan Nama Sekolah" name="nama_sekolah">
                        </form>
                    </div>
                </div>
            </div> -->
        <!-- @yield('content') -->
        <!-- </div>
        </div> -->

        {{-- @include('layouts.footer') --}}
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('myModal');
            const content = document.getElementById('modalContent');
            const backdrop = document.getElementById('modalBackdrop');

            modal.classList.remove('hidden');

            // Delay untuk trigger transition
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');

                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('myModal');
            const content = document.getElementById('modalContent');
            const backdrop = document.getElementById('modalBackdrop');

            // Tambahkan kelas keluar
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');

            // Setelah animasi selesai, sembunyikan modal
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

</body>
