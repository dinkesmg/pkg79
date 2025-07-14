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
    <div class="signature-container">
        <canvas id="signature-pad" width="360" height="100"></canvas>
    </div>
    <div class="button-group">
        <button id="save">Simpan</button>
        <button id="clear">Ulangi</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);

    function resizeCanvasIfNeeded() {
        const screenWidth = window.innerWidth;
        const defaultWidth = 480;
        const defaultHeight = 200;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        let newWidth = defaultWidth;

        if (screenWidth < 520) {
            newWidth = screenWidth - 40;
        }

        let newHeight = Math.floor((newWidth / defaultWidth) * defaultHeight);

        canvas.style.width = newWidth + "px";
        canvas.style.height = newHeight + "px";

        canvas.width = newWidth * ratio;
        canvas.height = newHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        signaturePad.clear();
    }

    function loadSignatureIfExists() {
        const savedSignature = localStorage.getItem('tanda_tangan');
        if (savedSignature) {
            const img = new Image();
            img.onload = () => {
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, canvas.width / window.devicePixelRatio, canvas.height / window.devicePixelRatio);
            };
            img.src = savedSignature;
        }
    }

    // Jalankan resize + load signature saat halaman selesai dimuat
    window.addEventListener("load", () => {
        resizeCanvasIfNeeded();
        loadSignatureIfExists();
    });

    // Saat ukuran layar berubah
    window.addEventListener("resize", () => {
        resizeCanvasIfNeeded();
        loadSignatureIfExists();
    });

    // Tombol hapus
    document.getElementById('clear').addEventListener('click', () => {
        signaturePad.clear();
        localStorage.removeItem('tanda_tangan');
    });

    // Tombol simpan
    document.getElementById('save').addEventListener('click', () => {
        if (signaturePad.isEmpty()) {
            alert("Silakan tanda tangani terlebih dahulu.");
            return;
        }

        const svgDataUrl = signaturePad.toDataURL('image/svg+xml');
        localStorage.setItem('tanda_tangan', svgDataUrl);
        alert("Tanda tangan disimpan ke localStorage.");
    });

</script>

