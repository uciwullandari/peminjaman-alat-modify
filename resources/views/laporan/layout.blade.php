<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('judul', 'Laporan')</title>
    <style>
        @page { margin: 1.5cm; }
        body {
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        .kop {
            border-bottom: 2px solid #111827;
            margin-bottom: 16px;
            padding-bottom: 10px;
            text-align: center;
        }
        .kop h1 {
            font-size: 17px;
            margin: 0 0 4px;
            text-transform: uppercase;
        }
        .kop p {
            margin: 0;
        }
        .judul-laporan {
            font-size: 15px;
            margin: 0 0 5px;
            text-align: center;
        }
        .periode {
            margin: 0 0 14px;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #9ca3af;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background: #e5e7eb;
            text-align: center;
        }
        .tengah { text-align: center; }
        .kanan { text-align: right; }
        .ringkasan { margin-top: 14px; }
    </style>
</head>
<body>
    <div class="kop">
        <h1>{{ $namaSekolah ?? 'Nama Sekolah' }}</h1>
        <p> Laporan Sistem Peminjaman Alat </p>
    </div>

    <h2 class="judul-laporan">@yield('judul')</h2>
    @if (isset($keteranganPeriode))
        <p class="periode">Periode: {{ $keteranganPeriode }}</p>
    @endif

    @yield('isi')
</body>
</html>
