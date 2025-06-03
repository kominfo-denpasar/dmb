<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Konseling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 5px;
            font-weight: bold;
        }
        .info-table, .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .content-table th, .content-table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .sign-section {
            margin-top: 50px;
            text-align: right;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        .signature {
            height: 100px;
            margin-top: 5px;
        }
        .text-muted {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>Laporan Detail Konseling</h2>
    <hr>
    <h4>Tanggal Konseling: {{ \Carbon\Carbon::parse($data->tanggalnya)->format('d/m/Y') }}</h4>

    <table class="info-table">
        <tr>
            <td><strong>Nama Pemeriksa:</strong></td>
            <td>{{$data->psikolog_nama}}</td>
        </tr>
        <tr>
            <td><strong>Nama Klien:</strong></td>
            <td>{{$data->nama}}</td>
        </tr>
        <tr>
            <td><strong>Jenis Kelamin:</strong></td>
            <td>{{$data->jk}}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Lahir / Usia:</strong></td>
            <td>{{\Carbon\Carbon::parse($data->tgl_lahir)->format('d M Y')}} / ({{\Carbon\Carbon::parse($data->tgl_lahir)->age}} Tahun)</td>
        </tr>
        <tr>
            <td><strong>Pendidikan Terakhir:</strong></td>
            <td>{{$data->pendidikan}}</td>
        </tr>
        <tr>
            <td><strong>Pekerjaan:</strong></td>
            <td>{{$data->pekerjaan}}</td>
        </tr>
        <tr>
            <td><strong>Alamat:</strong></td>
            <td>{{App\Http\Controllers\PsikologController::kec($data->kec_id)}}</td>
        </tr>
    </table>

    <div class="section-title">A. Keluhan</div>
    <p>{{ $data->keluhan }}</p>

    <div class="section-title">B. Masalah yang Dialami</div>
    <ul>
        @foreach($masalah as $m)
            <li style="list-style: none;">
                {!! in_array($m->id, $konseling_masalah) ? '<strong>v</strong>' : '-' !!} {{ $m->nama }}
            </li>
        @endforeach
    </ul>

    <div class="section-title">C. Data Anamnesis</div>
    <p>[data anamnesis]</p>

    <div class="section-title">D. Asesmen dan Hasil Pemeriksaan</div>
    <p>{{ $konseling->hasil }}</p>

    <div class="section-title">E. Kesimpulan</div>
    <p>{{ $konseling->kesimpulan }}</p>

    <div class="section-title">F. Saran</div>
    <p>{{ $konseling->saran }}</p>

    @if($konseling && $konseling->berkas_pendukung)
        @php
            $path = storage_path('app/public/uploads/berkas_pendukung/'.$konseling->berkas_pendukung);
        @endphp
        @if(file_exists($path))
            <div class="section-title">G. Dokumentasi</div>
            <img class="img-fluid" src="{{ asset('storage/uploads/berkas_pendukung/'.$konseling->berkas_pendukung) }}">
        @endif
    @endif

    <div class="sign-section">
        <p>Denpasar, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        @if(file_exists(storage_path('app/public/uploads/psikolog/'.$data->ttd)))
            <img class="signature" src="{{ asset('storage/uploads/psikolog/'.$data->ttd) }}">
        @else
            <img class="signature" src="{{ asset('img/pp_user.jpg') }}">
        @endif
        <p><strong><u>({{ $data->psikolog_nama }})</u></strong><br>
        <span class="text-muted">{{ $data->sipp }}</span></p>
    </div>
</body>
</html>
