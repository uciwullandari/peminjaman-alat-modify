<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-pastel {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        }
        .nav-link {
            font-size: 13.5px;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    {{-- KONTEN DINAMIS --}}
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.bundle.min.js"></script>
</body>
</html>