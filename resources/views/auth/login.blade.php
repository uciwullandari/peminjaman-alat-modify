<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: #f4f8fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 470px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .09);
        }
        .brand-section { padding: 32px 42px 0; }
        .brand-mark {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 12px;
            background: #e0f2fe;
            color: #0284c7;
            font-size: 22px;
            font-weight: 800;
        }
        .form-section { padding: 8px 42px 38px; }
        .form-section h4 { color: #172033; font-size: 25px; }
        .form-section .form-control {
            min-height: 48px;
            padding: .7rem .85rem;
            border-color: #dbe3ec;
            border-radius: 9px;
        }
        .form-section .form-control:focus {
            border-color: #38a3df;
            box-shadow: 0 0 0 .22rem rgba(2, 132, 199, .14);
        }
        .btn-submit {
            width: 100%;
            padding: 13px;
            border: 0;
            border-radius: 9px;
            background: #0284c7;
            color: #fff;
            font-weight: 700;
            box-shadow: 0 5px 12px rgba(2, 132, 199, .2);
            transition: all .2s ease;
        }
        .btn-submit:hover { background: #0369a1; color: #fff; transform: translateY(-1px); }
        @media (max-width: 767.98px) {
            body { padding: 12px; }
            .login-card { border-radius: 14px; }
            .brand-section { padding: 28px 24px 0; }
            .form-section { padding: 8px 24px 28px; }
            .form-section h4 { font-size: 23px; }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0">
        
        <div class="brand-section">
            <div class="brand-mark">P</div>
            <div class="text-uppercase fw-bold text-primary mb-2" style="font-size: 10px; letter-spacing: 1.5px;">Sistem Inventaris</div>
            <h3 class="fw-bold text-dark mb-0" style="font-size: 23px;">Peminjaman Alat</h3>
        </div>

        <div class="form-section">
            <div class="w-100">
                <div class="mb-4">
                    <h4 class="fw-bold mb-1">Masuk ke akun</h4>
                    <p class="text-secondary small mb-0">Gunakan kredensial Anda untuk melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <x-input name="username" label="Nama Pengguna" required autofocus />
                    </div>

                    <div class="mb-4">
                        <x-input name="password" label="Kata Sandi" type="password" required value="" />
                    </div>

                    <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Masuk</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>