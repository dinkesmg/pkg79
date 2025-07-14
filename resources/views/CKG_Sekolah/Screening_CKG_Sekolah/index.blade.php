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
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>

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

            <section>
                <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                    <div class="p-6 space-y-2 bg-gray-100 text-gray-800">

                        <div class="flex gap-3">
                            <span class="w-12 h-2 rounded-sm bg-teal-600"></span>
                            <span class="w-12 h-2 rounded-sm bg-teal-600"></span>
                            <span class="w-12 h-2 rounded-sm bg-slate-800"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                            <span class="w-12 h-2 rounded-sm bg-gray-300"></span>
                        </div>
                        <h3 class="text-base font-semibold">Skrining Perilaku Merokok</h3>
                    </div>
                    <!-- <div>
                        <p>Apakah Anda merokok dalam setahun terakhir ini?</p>
                        <label class="inline-flex items-center">
                            <input type="radio" id="jenis_kemain" name="jenis_kelamin" value="laki-laki"
                                class="form-radio text-pink-500">
                            <span class="ml-2">Laki - laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="jenis_kemain" name="jenis_kelamin" value="perempuan"
                                class="form-radio text-pink-500">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div> -->

                    <ul id="hasil-instrumen"></ul>
                </div>
                <button onclick="kirimData()" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">
                    Kirim Data
                </button>
            </section>


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
                window.addEventListener('load', function() {
                    setTimeout(() => {
                        document.getElementById('loadingScreen').style.display = 'none';
                        document.getElementById('mainContent').classList.remove('hidden');
                    }, 1000);
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', async () => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const kelas = urlParams.get('kelas');
                    const jkText = urlParams.get('jk');
                    const jenisKelamin = jkText === 'laki-laki' ? 'L' : 'P';
                    const hasilList = document.getElementById('hasil-instrumen');

                    if (!kelas || !jenisKelamin) {
                        hasilList.innerHTML = '<li>Parameter tidak lengkap.</li>';
                        return;
                    }

                    try {
                        const res = await fetch(`/instrumen_sekolah?kelas=${kelas}&jenis_kelamin=${jenisKelamin}`);
                        if (!res.ok) throw new Error('Gagal mengambil data');

                        const data = await res.json();

                        if (data.length === 0) {
                            hasilList.innerHTML = '<li>Tidak ada instrumen ditemukan.</li>';
                            return;
                        }

                        data.data.forEach(item => {
                            const li = document.createElement('li');
                            const inputName = `${item.objek}`;

                            const label = document.createElement('label');
                            label.textContent = item.pertanyaan ?? '[Tanpa Nama]';
                            li.appendChild(label);
                            li.appendChild(document.createElement('br'));

                            // Get saved value from localStorage
                            const savedValue = localStorage.getItem(inputName);

                            if (item.tipe_input === 'radio') {
                                ['YA', 'TIDAK'].forEach(value => {
                                    const radio = document.createElement('input');
                                    radio.type = 'radio';
                                    radio.className = 'form-checkbox text-pink-500';
                                    radio.name = inputName;
                                    radio.value = value;

                                    if (savedValue === value) {
                                        radio.checked = true;
                                    }

                                    radio.addEventListener('change', () => {
                                        localStorage.setItem(inputName, radio.value);
                                    });

                                    const labelRadio = document.createElement('label');
                                    labelRadio.textContent = ` ${value} `;
                                    labelRadio.prepend(radio);

                                    li.appendChild(labelRadio);
                                });

                            } else if (item.tipe_input === 'number') {
                                const input = document.createElement('input');
                                input.type = 'number';
                                input.name = inputName;

                                if (savedValue !== null) {
                                    input.value = savedValue;
                                }

                                input.addEventListener('input', () => {
                                    localStorage.setItem(inputName, input.value);
                                });

                                li.appendChild(input);
                            }

                            hasilList.appendChild(li);
                        });


                    } catch (err) {
                        hasilList.innerHTML = `<li>Error: ${err.message}</li>`;
                    }
                });
            </script>

            <!-- kirim data -->
            <script>
            function kirimData() {
                // Ambil semua key dari localStorage
                const data = {};
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    data[key] = localStorage.getItem(key);
                }

                fetch('/ckg_sekolah/simpan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert('Data berhasil disimpan!');
                        // localStorage.clear(); // jika ingin hapus setelah submit
                    } else {
                        alert('Gagal menyimpan data.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat menyimpan data.');
                });
            }
            </script>

        </div>
</body>
