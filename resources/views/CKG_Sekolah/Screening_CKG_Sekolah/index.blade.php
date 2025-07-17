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

    {{-- <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css"> --}}
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

    {{-- <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css"> --}}
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
        background: #f8fafc;
    }

    @keyframes wiggle {

        0%,
        100% {
            transform: rotate(-2deg);
        }

        50% {
            transform: rotate(2deg);
        }
    }

    input[type=radio] {
        transform: scale(1.5);
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

<body class="hold-transition sidebar-mini layout-fixed">
    <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>

    <div class="wrapper">

        <div id="loadingScreen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
            {{-- <div id="lottie-loader" style="width: 200px; height: 200px;"></div> --}}
            <div id="image-loader"></div>
        </div>
        <div id="mainContent" class="hidden">

            <section>

                <div class="w-full lg:w-8/12 p-2 lg:mx-auto mt-6">
                    <div class="flex justify-between items-center gap-4 mb-2">
                        <div>
                            <h1 class="text-lg md:text-2xl font-semibold">Skrining Pemeriksaan Kesehatan Gratis
                                Sekolah
                            </h1>
                            <p class="text-sm md:text-[20px]">Lengkapi soal skrining dibawah ini dengan jawaban yang
                                sesuai</p>
                        </div>
                        <img src="{{ asset('logo_semarpkg79.png') }}" class="w-[80px]" alt="Logo"
                            class="register-logo">
                    </div>
                    <div class="border border-gray-200 rounded-lg bg-white px-3 md:px-20 py-6">
                        <h2 class="text-xl font-bold mb-4">Data Diri Siswa</h2>
                        <div
                            class="md:flex md:justify-between items-end mb-3 border border-gray-200 rounded-lg bg-white px-4 py-6">
                            <div class="flex justify-start gap-5 items-center">
                                <div>
                                    <p>Nama Lengkap</p>
                                    <p>Nama Sekolah</p>
                                    <p>Puskesmas</p>
                                    <p>Kelas</p>
                                </div>
                                <div>
                                    <p id="nama_lengkap"></p>
                                    <p id="nama_sekolah"></p>
                                    <p id="puskesmas"></p>
                                    <p id="kelas"></p>
                                </div>
                            </div>
                            <div>
                                <button
                                    class="bg-pink-500 text-white py-2 px-4 rounded hover:bg-pink-600 transition duration-300 ease-in-out text-sm font-semibold">
                                    <a href="{{ route('ckg_sekolah.index') }}">Ubah Data Diri</a>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div id="steps-container" class="space-y-6"></div>
                            <div id="step-pagination" class="flex justify-center gap-2 mb-2"></div>
                        </div>

                        <div class="flex">
                            <button id="prev-btn" onclick="prevStep()"
                                class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400 hover:text-gray-900 hidden">Sebelumnya</button>
                            <button id="next-btn" onclick="nextStep()"
                                class="ml-auto inline-flex items-center justify-center rounded-md px-3 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 transition">
                                <span id="next-btn-text">Selanjutnya</span>
                                <svg id="spinner" class="ml-2 h-4 w-4 animate-spin hidden"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
            </section>

            <!-- Modal Alert -->
            <div id="alertModal"
                class="fixed inset-0 z-50 flex items-center justify-center inset-0 bg-black/30 transition-opacity duration-300 opacity-0 pointer-events-none">
                <div id="alertBox"
                    class="bg-white/80 backdrop-blur-md border border-white/30 rounded-lg shadow-xl max-w-sm w-full p-6 scale-95 transition-transform duration-300">
                    <h2 id="alertTitle" class="text-lg font-semibold mb-2 text-gray-800">Judul</h2>
                    <p id="alertMessage" class="text-sm text-gray-600">Pesan</p>
                    <div class="mt-4 flex justify-end">
                        <button onclick="closeAlert()"
                            class="text-sm bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded transition-all">
                            OK
                        </button>
                    </div>
                </div>
            </div>



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
                    const kelas = localStorage.getItem('kelas');
                    const jkText = localStorage.getItem('jenis_kelamin');
                    const jenisKelamin = jkText === 'laki-laki' ? 'L' : 'P';
                    const hasilList = document.getElementById('hasil-instrumen');

                    const namaLengkap = localStorage.getItem('nama_lengkap');
                    const namaSekolah = localStorage.getItem('nama_sekolah');
                    const puskesmas = localStorage.getItem('nama_puskesmas');
                    // const kelas = localStorage.getItem('kelas');

                    document.getElementById('nama_lengkap').textContent = `: ${namaLengkap}`;
                    document.getElementById('nama_sekolah').textContent = `: ${namaSekolah}`;
                    document.getElementById('puskesmas').textContent = `: Puskesmas ${puskesmas}`;
                    document.getElementById('kelas').textContent = `: ${kelas}`;

                    // console.log(kelas);
                    // console.log(jkText);
                    // console.log(jenisKelamin);

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
                    const nextBtn = document.getElementById('next-btn');
                    const nextBtnText = document.getElementById('next-btn-text');
                    const spinner = document.getElementById('spinner');

                    // Aktifkan spinner & nonaktifkan tombol
                    nextBtn.disabled = true;
                    nextBtnText.textContent = 'Mengirim...';
                    spinner.classList.remove('hidden');

                    const data = {};
                    for (let i = 0; i < localStorage.length; i++) {
                        const key = localStorage.key(i);
                        data[key] = localStorage.getItem(key);
                    }

                    // console.log(data.nik);

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
                                showAlert('Berhasil', 'Data berhasil disimpan!', false, true, data.nik);
                                // alert("Berhasil boss")
                                localStorage.clear(); // hapus setelah submit
                                // window.location.href = "{{ url('/pkg_sekolah/screening/success') }}";
                            } else {
                                // alert("Gagal boss")
                                const redirect = res.error_data_diri === true;
                                showAlert('Gagal', res.message || 'Gagal menyimpan data.', redirect, false, data.nik);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            showAlert('Kesalahan', 'Terjadi kesalahan saat menyimpan data.');
                        }).finally(() => {
                            //   Kembalikan tampilan tombol
                            nextBtn.disabled = false;
                            nextBtnText.textContent = currentStepIndex === groupedData.length - 1 ? 'Kirim Data' :
                                'Selanjutnya';
                            spinner.classList.add('hidden');
                        });
                }

                function showAlert(title, message, redirect = false, successRedirect = false, nik = null) {
                    const modal = document.getElementById('alertModal');
                    const box = document.getElementById('alertBox');
                    // const nik = localStorage.getItem('nik');

                    console.log(nik)

                    document.getElementById('alertTitle').textContent = title;
                    document.getElementById('alertMessage').textContent = message;

                    // Ganti tombol OK
                    const buttonContainer = modal.querySelector('.mt-4.flex');
                    buttonContainer.innerHTML = '';

                    const button = document.createElement('button');
                    button.textContent = 'OK';
                    button.className = 'text-sm bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded transition-all';

                    // Tambahan logika kondisi redirect
                    if (successRedirect) {
                        button.addEventListener('click', () => {
                            window.location.href = `/pkg_sekolah/screening/success?nik=${nik}`;
                        });
                    } else if (redirect) {
                        button.addEventListener('click', () => {
                            window.location.href = '/pkg_sekolah';
                        });
                    } else {
                        button.addEventListener('click', closeAlert); // hanya menutup modal
                    }

                    buttonContainer.appendChild(button);

                    // Tampilkan modal
                    modal.classList.remove('pointer-events-none', 'opacity-0');
                    modal.classList.add('opacity-100');
                    box.classList.remove('scale-95');
                    box.classList.add('scale-100');
                }



                function closeAlert() {
                    const modal = document.getElementById('alertModal');
                    const box = document.getElementById('alertBox');

                    modal.classList.remove('opacity-100');
                    modal.classList.add('opacity-0', 'pointer-events-none');

                    box.classList.remove('scale-100');
                    box.classList.add('scale-95');
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
                            li.classList.add('mb-4', 'border-2', 'p-4', 'rounded-lg', 'border-gray-200',
                                'hover:shadow-lg', 'transition-all', 'hover:border-pink-100', 'hover:border-2');

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
                    renderPagination();
                }

                function renderPagination() {
                    const paginationContainer = document.getElementById('step-pagination');
                    paginationContainer.innerHTML = '';

                    groupedData.forEach((group, index) => {
                        const circle = document.createElement('div');
                        circle.classList.add(
                            'w-8', 'h-8', 'flex', 'items-center', 'justify-center',
                            'rounded-full', 'border', 'text-sm'
                        );

                        if (index === currentStepIndex) {
                            circle.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
                        } else {
                            circle.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                        }
                        circle.textContent = index + 1;
                        paginationContainer.appendChild(circle);
                    });
                }

                function updateNavigationButtons() {
                    document.getElementById('prev-btn').classList.toggle('hidden', currentStepIndex === 0);
                    document.getElementById('next-btn-text').textContent = currentStepIndex === groupedData.length - 1 ?
                        'Kirim Data' : 'Selanjutnya';

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
                    const kelas = localStorage.getItem('kelas');
                    const jkText = localStorage.getItem('jenis_kelamin');
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
