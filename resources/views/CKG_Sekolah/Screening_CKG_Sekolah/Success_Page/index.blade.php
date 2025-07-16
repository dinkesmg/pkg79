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
    <div class="min-h-screen bg-success-page flex flex-col justify-center">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex items-center justify-center">
                    <svg class="w-12 h-12 text-success-page" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-2xl font-bold">Terima Kasih!</h3>
                    <p class="text-gray-600">Anda telah berhasil mendaftar ke dalam program CKG Sekolah.</p>
                </div>
                <div class="mt-6">
                    <a href="{{ url('/pkg_sekolah') }}"
                        class="block w-full px-4 py-2 text-white bg-[#dc2626] border border-transparent rounded-md shadow-sm hover:bg-[#c82020] focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
