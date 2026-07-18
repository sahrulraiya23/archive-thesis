<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistem Arsip Tugas Akhir S1 Teknik Informatika Universitas Halu Oleo" />
    <meta name="author" content="Teknik Informatika UHO" />

    <title>@yield('title', 'Sistem Arsip TA') - S1 Teknik Informatika UHO</title>

    <!-- Google Fonts: Inter & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Assets (SB Admin styles or Bootstrap 5) -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />

    <!-- Script Icons -->
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        h1, h2, h3, h4, h5, h6, .navbar-brand, .brand-title {
            font-family: 'Poppins', sans-serif;
        }

        /* Top White Header */
        .top-header {
            background-color: #ffffff;
            padding: 12px 0;
            border-bottom: 2px solid #eaeaea;
        }
        .top-header .brand-logo {
            height: 52px;
            margin-right: 15px;
            object-fit: contain;
        }
        .top-header .brand-title {
            color: #0b3c5d;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }
        .top-header .brand-subtitle {
            color: #777;
            font-size: 0.85rem;
            margin: 0;
            font-weight: 500;
        }
        .top-header .contact-box {
            font-size: 0.85rem;
            color: #444;
        }
        .top-header .contact-box i {
            color: #0b3c5d;
            font-size: 1.1rem;
        }
        .top-header .btn-contact {
            background-color: #ffc107;
            color: #1a1a1a;
            font-weight: 600;
            border-radius: 4px;
            padding: 8px 18px;
            font-size: 0.85rem;
            border: none;
            transition: all 0.25s ease-in-out;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);
        }
        .top-header .btn-contact:hover {
            background-color: #e0a800;
            color: #000;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(255, 193, 7, 0.3);
        }

        /* Main Blue Navbar */
        .main-navbar {
            background-color: #0f2c59 !important; /* Biru UHO dari screenshot */
            padding: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .main-navbar .navbar-nav {
            width: 100%;
            justify-content: center;
        }
        .main-navbar .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 15px 16px !important;
            text-transform: capitalize;
            transition: all 0.2s ease;
            position: relative;
        }
        .main-navbar .nav-link:hover,
        .main-navbar .nav-item.active .nav-link,
        .main-navbar .nav-item.show .nav-link {
            color: #ffc107 !important;
            background-color: rgba(255, 255, 255, 0.08);
        }
        .main-navbar .dropdown-menu {
            background-color: #ffffff;
            border-radius: 0 0 4px 4px;
            border: none;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            margin-top: 0;
            padding: 5px 0;
        }
        .main-navbar .dropdown-item {
            color: #333;
            font-size: 0.85rem;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .main-navbar .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #0f2c59;
            padding-left: 24px;
        }
        .main-navbar .dropdown-toggle::after {
            vertical-align: middle;
            margin-left: 5px;
        }

        /* Footer Styling */
        .public-footer {
            background-color: #0f2c59;
            color: rgba(255, 255, 255, 0.85);
            padding: 40px 0 20px;
            border-top: 4px solid #ffc107;
            font-size: 0.9rem;
        }
        .public-footer a {
            color: #ffc107;
            text-decoration: none;
            transition: color 0.2s;
        }
        .public-footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .public-footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            padding-top: 20px;
            font-size: 0.8rem;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top White Header Section -->
    <header class="top-header">
        <div class="container px-4">
            <div class="row align-items-center">
                <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start text-center text-lg-start mb-3 mb-lg-0">
                    <img src="{{ asset('assets/img/logo-uho.png') }}" class="brand-logo" alt="Logo UHO" />
                    <div>
                        <h1 class="brand-title">S1 - TEKNIK INFORMATIKA</h1>
                        <p class="brand-subtitle">Fakultas Teknik - Universitas Halu Oleo</p>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-center justify-content-center justify-content-lg-end">
                    <div class="contact-box me-4 d-none d-sm-flex align-items-center">
                        <div class="icon-circle bg-light me-2 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 50%;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div class="text-xs text-muted">Hubungi Kontak</div>
                            <div class="fw-bold text-dark">(0401) 3196237</div>
                        </div>
                    </div>
                    <a href="https://ti.eng.uho.ac.id" target="_blank" class="btn btn-contact">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Blue Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark main-navbar sticky-top">
        <div class="container px-4">
            <button class="navbar-toggler py-2 my-2 border-0 bg-white bg-opacity-10 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item {{ Route::is('public.home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('public.home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}#tentang-sistem">Tentang Sistem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}#panduan">Panduan Pengecekan</a>
                    </li>
                    <li class="nav-item {{ Route::is('public.thesis.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('public.thesis.index') }}">Daftar Tugas Akhir</a>
                    </li>
                    <li class="nav-item {{ Route::is('plagiarism.check') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('plagiarism.check') }}">Cek Plagiarisme Judul</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-desktop me-1"></i> Dashboard Admin</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login Admin</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="public-footer">
        <div class="container px-4">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white mb-3 fw-bold">Teknik Informatika UHO</h5>
                    <p class="text-white-50 small">Program Studi S1 Teknik Informatika, Jurusan Teknik Informatika, Fakultas Teknik, Universitas Halu Oleo.</p>
                    <p class="text-white-50 small"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Kampus Hijau Bumi Tridharma Anduonohu, Kendari, Sulawesi Tenggara.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0 text-lg-center">
                    <h5 class="text-white mb-3 fw-bold">Layanan Tugas Akhir</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('public.thesis.index') }}">Daftar Tugas Akhir</a></li>
                        <li class="mb-2"><a href="{{ route('plagiarism.check') }}">Cek Plagiarisme Judul</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}">Masuk Ke Sistem (Admin/Dosen)</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3 fw-bold">Kontak Kami</h5>
                    <p class="text-white-50 small"><i class="fas fa-phone me-2 text-primary"></i> (0401) 3196237</p>
                    <p class="text-white-50 small"><i class="fas fa-envelope me-2 text-primary"></i> informatika@uho.ac.id</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="btn btn-outline-light btn-sm me-2 btn-icon" style="width: 32px; height: 32px; padding:0; display:flex; align-items:center; justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm me-2 btn-icon" style="width: 32px; height: 32px; padding:0; display:flex; align-items:center; justify-content:center;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm me-2 btn-icon" style="width: 32px; height: 32px; padding:0; display:flex; align-items:center; justify-content:center;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="public-footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Sistem Arsip TA. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-white-50 mb-0 small mt-1">S1 Teknik Informatika - Universitas Halu Oleo</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        // Trigger feather replace if feather is loaded
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>
    @yield('scripts')
</body>
</html>
