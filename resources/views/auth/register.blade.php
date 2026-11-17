<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Peminjam - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">Daftar Sebagai Peminjam</h2>
                        <p class="text-muted mb-0">Akun akan dapat digunakan setelah dikonfirmasi admin atau petugas.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required autofocus>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pengguna</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="form-control @error('no_telp') is-invalid @enderror">
                                @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kata Sandi</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Kirim Pendaftaran</button>
                    </form>

                    <p class="text-center text-muted small mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
