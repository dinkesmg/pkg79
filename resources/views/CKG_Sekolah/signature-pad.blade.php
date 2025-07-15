<style>
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

    /* Gaya saat canvas dinonaktifkan */
    canvas.disabled {
        pointer-events: none;
        opacity: 0.5;
        border: 2px dashed #ccc;
        background-color: #f9f9f9;
    }

    /* Gaya saat tombol dinonaktifkan */
    button:disabled {
        background-color: #ccc !important;
        color: #888;
        cursor: not-allowed;
        border: 1px solid #aaa;
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

<div style="padding: 16px;">
    <p><strong>Tanda Tangan</strong></p>
    <p class="text-sm">Tulis atau gambar tanda tangan pada kotak dibawah ini!</p>
    <div class="signature-container">
        <canvas id="signature-pad" width="360" height="100"></canvas>
    </div>
    <div class="button-group">
        <button id="save">Simpan</button>
        <button id="clear">Ulangi</button>
    </div>
    <p class="italic text-sm text-right mt-2">*Klik simpan jika tanda tangan sudah benar</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const saveBtn = document.getElementById('save');
    const clearBtn = document.getElementById('clear');
    const signaturePad = new SignaturePad(canvas);

    function resizeCanvasIfNeeded() {
        const screenWidth = window.innerWidth;
        const defaultWidth = 480;
        const defaultHeight = 200;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        let newWidth = screenWidth < 520 ? screenWidth - 40 : defaultWidth;
        let newHeight = Math.floor((newWidth / defaultWidth) * defaultHeight);

        canvas.style.width = newWidth + "px";
        canvas.style.height = newHeight + "px";
        canvas.width = newWidth * ratio;
        canvas.height = newHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    function disableCanvasInteraction() {
        canvas.classList.add('disabled');
        saveBtn.disabled = true;
    }

    function enableCanvasInteraction() {
        canvas.classList.remove('disabled');
        saveBtn.disabled = false;
    }

    function loadSignatureIfExists() {
        const savedSignature = localStorage.getItem('tanda_tangan');
        if (savedSignature) {
            const img = new Image();
            img.onload = () => {
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, canvas.width / window.devicePixelRatio, canvas.height / window
                    .devicePixelRatio);
            };
            img.src = savedSignature;
            disableCanvasInteraction();
        } else {
            enableCanvasInteraction();
        }
    }

    // Saat halaman dimuat
    window.addEventListener("load", () => {
        resizeCanvasIfNeeded();
        loadSignatureIfExists();
    });

    // Saat layar di-resize
    window.addEventListener("resize", () => {
        resizeCanvasIfNeeded();
        loadSignatureIfExists();
    });

    // Tombol simpan
    saveBtn.addEventListener('click', () => {
        if (signaturePad.isEmpty()) {
            document.getElementById('judul-modal-message').textContent = `Gagal Simpan`;

            document.getElementById('invalid-modal-message').textContent =
                `Silahkan tanda tangan terlebih dahulu dan Klik simpan`;

            // Tampilkan modal
            document.getElementById('invalid-modal').classList.remove('hidden');

            return;
        }
        const svgDataUrl = signaturePad.toDataURL('image/svg+xml');
        localStorage.setItem('tanda_tangan', svgDataUrl);
        // alert("Tanda tangan disimpan ke localStorage.");

        // document.getElementById('judul-modal-message').textContent = `Berhasil Simpan`;
        // document.getElementById('invalid-modal-message').textContent = `Tanda tangan berhasil disimpan`;
        // Tampilkan modal
        // document.getElementById('invalid-modal').classList.remove('hidden');

        disableCanvasInteraction();
    });

    // Tombol ulangi
    clearBtn.addEventListener('click', () => {
        signaturePad.clear();
        localStorage.removeItem('tanda_tangan');
        enableCanvasInteraction();
    });

    // Aktifkan tombol simpan kembali saat mulai menggambar lagi
    signaturePad.onBegin = () => {
        if (!signaturePad.isEmpty()) {
            saveBtn.disabled = false;
        }
    };
</script>
