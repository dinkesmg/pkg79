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

    @php
        $nik = request()->query('nik');
    @endphp

    <div class="min-h-screen bg-success-page flex flex-col justify-center">
        <div class="w-[80%] mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
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
                    <p class="text-gray-600">NIK Anda: {{ $nik }}</p>
                    <p class="text-gray-600">Anda telah berhasil mendaftar ke dalam program CKG Sekolah. Berikut adalah
                        informasi pendaftaran Anda:</p>
                </div>
                <div>
                    Data Peserta Didik
                    <div id="data-peserta" class="mt-4 space-y-4"></div>
                </div>


                <script>
                    fetch("{{ url('/get_data_peserta') }}?nik=" + "{{ $nik }}")
                        .then(response => response.json())
                        .then(data => {
                            const container = document.getElementById('data-peserta');

                            const pairs = [
                                ['nik', 'nisn'],
                                ['nama', 'tempat_tanggal_lahir'],
                                ['umur', 'golongan_darah'],
                                ['jenis_kelamin', 'telp'],
                                ['alamat_ktp', 'alamat_dom'],
                                ['kelas', 'jenis_disabilitas'],
                                ['nama_orangtua_wali', 'nama_sekolah']
                            ];

                            pairs.forEach(([kiri, kanan]) => {
                                const row = document.createElement('div');
                                row.classList.add('grid', 'grid-cols-2', 'gap-4', 'text-sm');

                                const left = document.createElement('div');
                                left.innerHTML = `<div class="font-medium text-gray-500">${labelize(kiri)}</div>
                                  <div class="text-gray-900">${formatValue(data[kiri])}</div>`;

                                const right = document.createElement('div');
                                right.innerHTML = `<div class="font-medium text-gray-500">${labelize(kanan)}</div>
                                   <div class="text-gray-900">${formatValue(data[kanan])}</div>`;

                                row.appendChild(left);
                                row.appendChild(right);
                                container.appendChild(row);
                            });

                            function labelize(str) {
                                return str.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                            }

                            function formatValue(val) {
                                if (Array.isArray(val)) return val.join(', ');
                                if (val === null || val === undefined || val === '') return '-';
                                return val;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                </script>




            </div>
        </div>
    </div>
</body>

</html>
