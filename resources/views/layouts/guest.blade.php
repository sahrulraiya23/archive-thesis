<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Archive Thesis') }} - Autentikasi Sistem Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #07162c 0%, #0f2c59 50%, #163e78 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 30px 15px;
            color: #333;
        }

        h1, h2, h3, h4, h5, h6, .brand-title {
            font-family: 'Poppins', sans-serif;
        }

        .academic-login-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top: 5px solid #ffc107;
            max-width: 440px;
            width: 100%;
        }

        .login-header-banner {
            background-color: #0f2c59;
            padding: 26px 20px 20px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        .logo-uho-wrapper {
            width: 82px;
            height: 82px;
            margin: 0 auto 12px;
            background: #ffffff;
            border-radius: 50%;
            padding: 7px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-uho-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .brand-title-main {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            color: #ffffff;
        }

        .brand-subtitle-main {
            font-size: 0.8rem;
            color: #ffc107;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-body {
            padding: 28px 26px;
        }

        .form-label-academic {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f2c59;
            margin-bottom: 6px;
        }

        .input-group-academic {
            position: relative;
        }

        .input-group-academic .form-control {
            border-radius: 6px;
            padding: 10px 14px 10px 42px;
            font-size: 0.9rem;
            border: 1.5px solid #cbd5e1;
            transition: all 0.2s ease;
        }

        .input-group-academic .form-control:focus {
            border-color: #0f2c59;
            box-shadow: 0 0 0 3px rgba(15, 44, 89, 0.15);
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1rem;
            z-index: 10;
        }

        .btn-academic-login {
            background-color: #0f2c59;
            border-color: #0f2c59;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 11px 20px;
            border-radius: 6px;
            width: 100%;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(15, 44, 89, 0.3);
        }

        .btn-academic-login:hover {
            background-color: #0b1f3a;
            border-color: #0b1f3a;
            color: #ffc107;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 44, 89, 0.4);
        }

        .academic-badge-footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 14px 20px;
            text-align: center;
            font-size: 0.78rem;
            color: #64748b;
        }

        .academic-badge-footer a {
            color: #0f2c59;
            text-decoration: none;
            font-weight: 600;
        }

        .academic-badge-footer a:hover {
            text-decoration: underline;
            color: #d97706;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="academic-login-card">
            <div class="login-header-banner">
                <div class="logo-uho-wrapper">
                    <x-application-logo class="logo-uho-img" />
                </div>
                <h2 class="brand-title-main">SISTEM ARSIP TUGAS AKHIR</h2>
                <div class="brand-subtitle-main">S1 Teknik Informatika UHO</div>
            </div>

            {{ $slot }}

            <div class="academic-badge-footer">
                <div><i class="fas fa-shield-alt text-warning me-1"></i> Area Terbatas Khusus Administrator</div>
                <div class="mt-1">&copy; {{ date('Y') }} Jurusan Teknik Informatika — FT UHO • <a href="{{ route('public.home') }}"><i class="fas fa-arrow-left me-1"></i>Ke Beranda Publik</a></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
