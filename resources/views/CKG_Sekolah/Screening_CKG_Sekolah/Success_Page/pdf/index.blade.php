<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PDF Pendaftaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 6px;
            vertical-align: top;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            font-size: 14px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center">Terima Kasih!</h2>
    <p style="text-align:center">NIK Anda: {{ $data['nik'] }}</p>
    <p style="text-align:center">Anda telah berhasil mendaftar ke dalam program CKJ Sekolah. Berikut adalah informasi
        Anda:</p>

    <div class="section-title">Data Peserta Didik</div>
    <table>
        <tr>
            <td>Nama</td>
            <td>{{ $data['nama'] }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>{{ $data['nik'] }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>{{ $data['tempat_tanggal_lahir'] }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>{{ $data['jenis_kelamin'] }}</td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>{{ $data['umur'] }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td>{{ $data['alamat_sekolah'] }}</td>
        </tr>
        <!-- Lanjutkan data lainnya -->
    </table>

    @if ($data['persetujuan'])
        <div class="section-title">Surat Persetujuan</div>
        <div class="box">
            <p>Saya menyetujui anak saya mengikuti kegiatan Cek Kesehatan.</p>
            <p>Nama Sekolah: {{ $data['nama_sekolah'] }}</p>
            <p>Alamat: {{ $data['alamat_sekolah'] }}</p>
            <p>Tanda Tangan:</p>
            @if ($tanda_tangan)
                <img src="{{ $tanda_tangan }}" width="150" />
            @endif
        </div>
    @endif

    <div class="section-title">Hasil Screening</div>

    @if (!empty($data['screening']))
        @foreach ($data['screening'] as $item)
            <div class="box">
                <strong>{{ $item['pertanyaan'] }}</strong><br>
                Jawaban:
                <strong>{{ is_array($item['jawaban']) ? implode(', ', $item['jawaban']) : $item['jawaban'] }}</strong>
            </div>
        @endforeach
    @else
        <div class="box">
            <em>Tidak ada data screening.</em>
        </div>
    @endif

</body>

</html>
