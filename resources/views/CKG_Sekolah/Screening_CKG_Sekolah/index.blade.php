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
                {{-- <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
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
                <!-- <button onclick="kirimData()" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">
                    Kirim Data
                </button> -->
                <div class="flex justify-center mt-6 mb-7">
                    <button onclick="kirimData()" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">
                        Kirim Data
                    </button>
                </div> --}}

                <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                    <div>
                        <div id="steps-container" class="space-y-6 h-[500px]"></div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button id="prev-btn" onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded text-gray-700 hidden">Sebelumnya</button>
                        <button id="next-btn" onclick="nextStep()" class="inline-flex justify-center rounded-md px-3 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 sm:ml-3 sm:w-auto transition">Selanjutnya</button>
                    </div>
                </div>
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

            {{-- get screening --}}
            <script>
                document.addEventListener('DOMContentLoaded', async () => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const kelas = urlParams.get('kelas');
                    const jkText = urlParams.get('jk');
                    const jenisKelamin = jkText === 'laki-laki' ? 'L' : 'P';
                    const hasilList = document.getElementById('hasil-instrumen');

                    if (!kelas || !jenisKelamin) {
                        hasilList.innerHTML = '<li class="text-red-600">Parameter tidak lengkap.</li>';
                        return;
                    }

                    try {
                        const res = await fetch(`/instrumen_sekolah?kelas=${kelas}&jenis_kelamin=${jenisKelamin}`);
                        if (!res.ok) throw new Error('Gagal mengambil data');

                        const data = await res.json();

                        if (data.length === 0 || data.data.length === 0) {
                            hasilList.innerHTML = '<li class="text-gray-600">Tidak ada instrumen ditemukan.</li>';
                            return;
                        }

                        data.data.forEach(item => {
                            const li = document.createElement('li');
                            li.classList.add('mb-4'); // Jarak antar instrumen

                            const inputName = `${item.objek}`;

                            const label = document.createElement('label');
                            label.textContent = item.pertanyaan ?? '[Tanpa Nama]';
                            label.classList.add('block', 'font-medium', 'mb-1');
                            li.appendChild(label);

                            const savedValue = localStorage.getItem(inputName);

                            if (item.tipe_input === 'radio') {
                                ['YA', 'TIDAK'].forEach(value => {
                                    const wrapper = document.createElement('label');
                                    wrapper.classList.add('inline-flex', 'items-center', 'gap-2',
                                        'mr-4'); // spacing radio + label

                                    const radio = document.createElement('input');
                                    radio.type = 'radio';
                                    radio.className = 'form-radio text-pink-500';
                                    radio.name = inputName;
                                    radio.value = value;

                                    if (savedValue === value) {
                                        radio.checked = true;
                                    }

                                    radio.addEventListener('change', () => {
                                        localStorage.setItem(inputName, radio.value);
                                    });

                                    const text = document.createTextNode(value);
                                    wrapper.appendChild(radio);
                                    wrapper.appendChild(text);

                                    li.appendChild(wrapper);
                                });

                            } else if (item.tipe_input === 'number') {
                                const input = document.createElement('input');
                                input.type = 'number';
                                input.name = inputName;
                                input.classList.add('border', 'rounded', 'px-2', 'py-1', 'mt-1', 'w-32');

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
                        hasilList.innerHTML = `<li class="text-red-500">Error: ${err.message}</li>`;
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

                    fetch('/pkg_sekolah/simpan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
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

            {{-- stepper --}}
            <script>
                let currentStepIndex = 0;
                let groupedData = [];

                function renderSteps() {
                    const container = document.getElementById('steps-container');
                    container.innerHTML = '';

                    groupedData.forEach((group, index) => {
                        const stepDiv = document.createElement('div');
                        stepDiv.classList.add('step');
                        if (index !== currentStepIndex) stepDiv.classList.add('hidden');

                        const title = document.createElement('h3');
                        title.classList.add('text-xl', 'font-bold', 'mb-4');
                        title.textContent = group.judul;
                        stepDiv.appendChild(title);

                        group.items.forEach(item => {
                            const li = document.createElement('div');
                            li.classList.add('mb-4');

                            const inputName = item.objek;
                            const label = document.createElement('label');
                            label.textContent = item.pertanyaan ?? '[Tanpa Nama]';
                            label.classList.add('block', 'font-medium', 'mb-1');
                            li.appendChild(label);

                            const savedValue = localStorage.getItem(inputName);

                            if (item.tipe_input === 'radio') {
                                JSON.parse(item.value_tipe_input).forEach((value, i) => {
                                    const wrapper = document.createElement('label');
                                    wrapper.classList.add('inline-flex', 'items-center', 'gap-2', 'mr-4');

                                    const radio = document.createElement('input');
                                    radio.type = 'radio';
                                    radio.name = inputName;
                                    radio.value = value;
                                    radio.className = 'form-radio text-pink-500';
                                    if (savedValue === value) radio.checked = true;

                                    radio.addEventListener('change', () => {
                                        localStorage.setItem(inputName, value);
                                    });

                                    const text = document.createTextNode(value);
                                    wrapper.appendChild(radio);
                                    wrapper.appendChild(text);

                                    li.appendChild(wrapper);
                                });
                            }

                            if (item.tipe_input === 'number') {
                                const input = document.createElement('input');
                                input.type = 'number';
                                input.name = inputName;
                                input.classList.add('border', 'rounded', 'px-2', 'py-1', 'mt-1', 'w-32');
                                if (savedValue !== null) input.value = savedValue;

                                input.addEventListener('input', () => {
                                    localStorage.setItem(inputName, input.value);
                                });

                                li.appendChild(input);
                            }

                            stepDiv.appendChild(li);
                        });

                        container.appendChild(stepDiv);
                    });

                    updateNavigationButtons();
                }

                function updateNavigationButtons() {
                    document.getElementById('prev-btn').classList.toggle('hidden', currentStepIndex === 0);
                    document.getElementById('next-btn').textContent = currentStepIndex === groupedData.length - 1 ? 'Kirim Data' :
                        'Selanjutnya';
                }

                function nextStep() {
                    if (currentStepIndex < groupedData.length - 1) {
                        currentStepIndex++;
                        renderSteps();
                    } else {
                        kirimData();
                    }
                }

                function prevStep() {
                    if (currentStepIndex > 0) {
                        currentStepIndex--;
                        renderSteps();
                    }
                }

                document.addEventListener('DOMContentLoaded', async () => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const kelas = urlParams.get('kelas');
                    const jkText = urlParams.get('jk');
                    const jenisKelamin = jkText === 'laki-laki' ? 'L' : 'P';

                    if (!kelas || !jenisKelamin) {
                        document.getElementById('steps-container').innerHTML =
                            '<div class="text-red-600">Parameter tidak lengkap.</div>';
                        return;
                    }

                    try {
                        const res = await fetch(`/instrumen_sekolah?kelas=${kelas}&jenis_kelamin=${jenisKelamin}`);
                        if (!res.ok) throw new Error('Gagal mengambil data');

                        const response = await res.json();
                        const items = response.data;

                        // Grouping berdasarkan judul
                        const grouped = {};
                        items.forEach(item => {
                            if (!grouped[item.judul]) {
                                grouped[item.judul] = [];
                            }
                            grouped[item.judul].push(item);
                        });

                        groupedData = Object.entries(grouped).map(([judul, items]) => ({
                            judul,
                            items
                        }));
                        renderSteps();

                    } catch (err) {
                        document.getElementById('steps-container').innerHTML =
                            `<div class="text-red-600">Error: ${err.message}</div>`;
                    }
                });
            </script>


        </div>
</body>