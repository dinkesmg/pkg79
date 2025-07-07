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

        <section class=" py-1 bg-blueGray-50">
            <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                    <div class="rounded-t bg-white mb-0 px-6 py-6">
                        <div class="text-center flex justify-between">
                            <h6 class="text-blueGray-700 text-xl font-bold">
                                Cek Kesehatan Gratis
                            </h6>
                            <button
                                class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                type="button">
                                Settings
                            </button>
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
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <span class="text-sm italic text-[#94a3b8]">Otomatis berdasarkan TTL</span>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlfor="grid-password">
                                            Kelas
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
                                                <input type="checkbox" name="jenis_disabilitas[]" value="Tidak Ada"
                                                    class="form-checkbox text-pink-500">
                                                <span class="ml-2">Tidak Ada</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="jenis_disabilitas[]" value="Tuna Netra"
                                                    class="form-checkbox text-pink-500">
                                                <span class="ml-2">Fisik</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="jenis_disabilitas[]" value="Tuna Rungu"
                                                    class="form-checkbox text-pink-500">
                                                <span class="ml-2">Intelektual</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="jenis_disabilitas[]" value="Tuna Wicara"
                                                    class="form-checkbox text-pink-500">
                                                <span class="ml-2">Mental</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="jenis_disabilitas[]" value="Tuna Wicara"
                                                    class="form-checkbox text-pink-500">
                                                <span class="ml-2">Sensorik</span>
                                            </label>
                                        </div>
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
                    class="relative transform scale-95 opacity-0 overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-lg">

                    <!-- Modal Inner -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-base font-semibold text-gray-900" id="modal-title">Konfirmasi Kirim
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin mengirim data ini? Pastikan semua isian sudah benar.
                                    </p>
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
