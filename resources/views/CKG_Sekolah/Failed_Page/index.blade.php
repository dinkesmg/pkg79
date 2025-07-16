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

    <style>
        body {
            font-family: "Geist", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            color: #323232;
        }

        .bg-success-page {
            background-color: #f8fafc;
        }

        .text-success-page {
            color: #34C759;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    {{-- @php
        $nik = request()->query('nik');
    @endphp --}}

    <div class="min-h-screen bg-success-page flex flex-col justify-center">
        <div class="w-[96%] md:w-[80%] mx-auto bg-white rounded-lg shadow-lg overflow-hidden mt-4 mb-10">
            <div class="px-5 py-4">
                <div class="flex items-center justify-center">
                    <svg class="w-12 h-12 text-success-page" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <div class="mt-4 text-center">
                    <h3 class="text-2xl font-bold">You fail madafaka</h3>
                    {{-- <p class="text-gray-600">NIK Anda: {{ $nik }}</p> --}}
                    <p class="text-gray-600">Anda telah berhasil mendaftar ke dalam program CKG Sekolah. Berikut adalah
                        informasi pendaftaran Anda:</p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold mt-4">
                        Data Peserta Didik
                    </h2>
                    <div id="data-peserta" class="my-4 space-y-2 border rounded-lg px-6 py-4"></div>
                    <hr>

                    <h2 class="text-2xl font-semibold mt-4">Surat Persetujuan</h2>
                    <div id="data-persetujuan" class="my-4 space-y-4"></div>

                    <h2 class="text-2xl font-semibold">Hasil Screening</h2>
                    <div id="data-screening" class="my-4 space-y-4"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
