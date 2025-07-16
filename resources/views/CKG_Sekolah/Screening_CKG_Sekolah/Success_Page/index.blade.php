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
                    <h3 class="text-2xl font-bold">Terima Kasih!</h3>
                    <p class="text-gray-600">NIK Anda: {{ $nik }}</p>
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

    <script>
        document.getElementById('data-peserta').innerHTML = `
                        <div class="animate-pulse space-y-3">
                            <div class="h-4 bg-gray-300 rounded w-1/2"></div>
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    `;

        document.getElementById('data-persetujuan').innerHTML = `
                        <div class="animate-pulse space-y-3">
                            <div class="h-4 bg-gray-300 rounded w-1/3"></div>
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                        </div>
                    `;

        document.getElementById('data-screening').innerHTML = `
                        <div class="animate-pulse space-y-3">
                            <div class="h-4 bg-gray-300 rounded w-1/2"></div>
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        </div>
                    `;

        fetch("{{ url('/get_data_peserta') }}?nik=" + "{{ $nik }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('data-peserta').innerHTML = '';
                document.getElementById('data-persetujuan').innerHTML = '';
                document.getElementById('data-screening').innerHTML = '';
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
                    row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');

                    const left = document.createElement('div');
                    left.innerHTML = `<div class="text-lg font-semibold">${labelize(kiri)}</div>
                                  <div class="text-gray-900 text-[14px]">${formatValue(data[kiri])}</div>`;

                    const right = document.createElement('div');
                    right.innerHTML = `<div class="font-semibold text-lg">${labelize(kanan)}</div>
                                   <div class="text-gray-900 text-[14px]">${formatValue(data[kanan])}</div>`;

                    row.appendChild(left);
                    row.appendChild(right);
                    container.appendChild(row);

                });

                // 🔽 Tampilkan Surat Persetujuan
                const persetujuanContainer = document.getElementById('data-persetujuan');

                if (data.persetujuan) {
                    const persetujuan = data.persetujuan;

                    // Dummy nama/alamat sekolah & puskesmas
                    const namaSekolah = data.nama_sekolah || '-';
                    const alamatSekolah = data.alamat_sekolah || '-';
                    const namaPuskesmas = data.puskesmas; // Ganti jika tersedia dari data

                    const status = persetujuan.persetujuan === 1 ? "Setuju" : "Tidak setuju";
                    const isChecked = (val) => persetujuan.persetujuan === val ? 'checked' : '';

                    persetujuanContainer.innerHTML = `
                                        <div class="bg-white rounded-lg shadow px-6 py-4 border">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <h3 class="text-[14px] font-semibold uppercase">Formulir Skrining Kesehatan Anak Usia Sekolah dan Remaja</h3>
                                            </div>

                                            <h4 class="text-[14px] font-semibold uppercase mb-4">PUSKESMAS ${namaPuskesmas}</h4>

                                            <h5 class="text-[14px] font-semibold mb-2">Pernyataan Persetujuan Orang Tua/Wali</h5>

                                            <p class="text-[14px] text-gray-700 mb-3">
                                                Dengan ini, saya menyetujui anak saya mengikuti kegiatan Cek Kesehatan Anak Sekolah (CKG) yang
                                                diselenggarakan oleh pihak sekolah bekerja sama dengan Puskesmas/Fasilitas Kesehatan Tingkat Pertama.
                                            </p>
                                            <p class="text-[14px] text-gray-700 mb-3">
                                                Demikian pernyataan ini saya buat dengan sebenarnya untuk digunakan sebagaimana mestinya.
                                            </p>

                                            <div class="text-[14px] text-gray-800 space-y-1 mb-4">
                                                <div><span class="font-semibold">Nama Sekolah</span> : ${namaSekolah}</div>
                                                <div><span class="font-semibold">Alamat</span> : ${alamatSekolah}</div>
                                            </div>

                                            <div class="mt-4 mb-2">
                                                <p class="font-semibold text-[14px] mb-1">Tanda Tangan</p>
                                                <div class="border border-gray-500 h-32 w-full"></div>
                                            </div>

                                            <div class="mt-4">
                                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                                        ${persetujuan.persetujuan == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                                    ${persetujuan.persetujuan == 1 ? 'Setuju' : 'Tidak setuju'}
                                                </span>
                                            </div>
                                        </div>
                                    `;
                }

                const screeningContainer = document.getElementById('data-screening');

                if (Array.isArray(data.screening) && data.screening.length > 0) {
                    const box = document.createElement('div');
                    box.classList.add('bg-white', 'rounded-lg', 'shadow', 'px-6', 'py-4', 'border');

                    function beautifyLabel(str) {
                        return str.replace(/_/g, ' ')
                            .replace(/\b\w/g, c => c.toUpperCase());
                    }

                    data.screening.forEach(item => {
                        const key = Object.keys(item)[0];
                        const value = item[key];

                        const row = document.createElement('div');
                        row.classList.add('mb-2');

                        const bgColorClass = (value) => {
                            if (value === 'Ya') return 'bg-green-100 text-green-800';
                            if (value === 'Tidak') return 'bg-blue-100 text-blue-800';
                            return 'bg-gray-100 text-gray-800';
                        };

                        row.innerHTML = `
                                        <div class="space-y-1 border p-1 rounded-lg">
                                            <div class="font-medium text-gray-700 text-[16px] md:text-lg">
                                                ${beautifyLabel(key)}
                                            </div>
                                            <p class="font-semibold">Jawaban:</p>
                                            <div class="inline-block px-3 py-1 rounded ${bgColorClass(value)} text-xs sm:text-sm md:text-base">
                                                ${formatValue(value)}
                                            </div>
                                        </div>
                                    `;

                        box.appendChild(row);
                    });

                    screeningContainer.appendChild(box);
                } else {
                    screeningContainer.innerHTML = `<p class="text-sm text-gray-500">Tidak ada data screening.</p>`;
                }


                function labelize(str) {
                    return str.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                }

                function formatValue(val) {
                    try {
                        // Jika val string array JSON (contoh: '["Fisik"]'), ubah ke array
                        if (typeof val === 'string' && val.startsWith('[') && val.endsWith(']')) {
                            const parsed = JSON.parse(val);
                            if (Array.isArray(parsed)) {
                                return parsed.join(', ');
                            }
                        }
                    } catch (e) {
                        document.getElementById('data-peserta').innerHTML =
                            '<p class="text-red-600 text-sm">Gagal memuat data peserta.</p>';
                        document.getElementById('data-persetujuan').innerHTML =
                            '<p class="text-red-600 text-sm">Gagal memuat data persetujuan.</p>';
                        document.getElementById('data-screening').innerHTML =
                            '<p class="text-red-600 text-sm">Gagal memuat data screening.</p>';
                    }
                    if (Array.isArray(val)) return val.join(', ');
                    if (val === null || val === undefined || val === '') return '-';
                    return val;
                }
            })
            .catch(error => console.error('Error:', error));
    </script>
</body>

</html>
