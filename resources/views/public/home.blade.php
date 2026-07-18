@extends('layouts.public')

@section('title', 'Beranda')

@section('styles')
<style>
    /* Hero Banner */
    .hero-banner {
        position: relative;
        background-image: url("{{ asset('assets/img/demo/hero_students_uho.png') }}");
        background-size: cover;
        background-position: center;
        min-height: 520px;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(15, 44, 89, 0.92) 0%, rgba(15, 44, 89, 0.75) 50%, rgba(15, 44, 89, 0.4) 100%);
        z-index: 1;
    }
    .hero-banner .container {
        position: relative;
        z-index: 2;
    }
    .hero-title-main {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
    }
    .hero-title-sub {
        font-size: 1.5rem;
        font-weight: 600;
        background-color: #ffc107;
        color: #111;
        display: inline-block;
        padding: 6px 18px;
        border-radius: 4px;
        margin-bottom: 35px;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
    }
    .hero-buttons .btn {
        padding: 12px 28px;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 4px;
        transition: all 0.25s ease;
    }
    .hero-buttons .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #1a1a1a;
        margin-right: 15px;
    }
    .hero-buttons .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }
    .hero-buttons .btn-light {
        background-color: #ffffff;
        border-color: #ffffff;
        color: #0f2c59;
    }
    .hero-buttons .btn-light:hover {
        background-color: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
    }

    /* Content Cards and Layout */
    .section-welcome {
        padding: 60px 0;
        background-color: #ffffff;
    }
    .welcome-title {
        color: #0f2c59;
        font-weight: 700;
        font-size: 1.8rem;
        line-height: 1.35;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
    }
    .welcome-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background-color: #ffc107;
        border-radius: 2px;
    }
    .video-container {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: 4px solid #ffffff;
    }
    .card-info {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background-color: #ffffff;
        overflow: hidden;
    }
    .card-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    .card-info .card-header-custom {
        padding: 24px 24px 10px;
        display: flex;
        align-items: center;
    }
    .card-info .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(15, 44, 89, 0.1);
        color: #0f2c59;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-right: 15px;
        flex-shrink: 0;
    }
    .card-info .card-title {
        color: #0f2c59;
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
    }
    .card-info .card-body {
        padding: 10px 24px 24px;
        color: #555;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    /* Quick Stats Banner */
    .stats-banner {
        background-color: #f1f5f9;
        padding: 40px 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }
    .stat-item {
        text-align: center;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f2c59;
        line-height: 1;
        margin-bottom: 5px;
    }
    .stat-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section Banner -->
<section class="hero-banner">
    <div class="container px-4">
        <div class="row">
            <div class="col-lg-9 text-start">
                <h2 class="hero-title-main">Sistem Arsip & Cek Judul Tugas Akhir</h2>
                <div class="hero-title-sub">S1 Teknik Informatika UHO</div>
                <div class="hero-buttons">
                    <a href="{{ route('public.thesis.index') }}" class="btn btn-warning"><i class="fas fa-search me-2"></i> Jelajahi Tugas Akhir</a>
                    <a href="{{ route('plagiarism.check') }}" class="btn btn-light"><i class="fas fa-shield-alt me-2"></i> Cek Plagiarisme Judul</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Banner -->
<section class="stats-banner">
    <div class="container px-4">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalThesis }}</div>
                    <div class="stat-label">Total Arsip TA</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ $thisYearThesis }}</div>
                    <div class="stat-label">Arsip Baru Tahun Ini</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">Jaccard</div>
                    <div class="stat-label">Metode Cek Plagiasi</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Akses Terbuka Publik</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Welcome & Info Cards Section -->
<section class="section-welcome" id="tentang-sistem">
    <div class="container px-4">
        <div class="row g-5">
            <!-- Left Column: Video and Welcome Text -->
            <div class="col-lg-6">
                <h3 class="welcome-title">Selamat Datang di Portal Arsip Tugas Akhir S1 Teknik Informatika UHO.</h3>
                <p class="text-muted leading-relaxed mb-4" style="text-align: justify;">
                    Portal ini didesain khusus sebagai wadah informasi, dokumentasi, dan pengecekan kemiripan judul tugas akhir/skripsi bagi mahasiswa S1 Teknik Informatika, Universitas Halu Oleo. Mahasiswa dapat mencari topik penelitian yang sudah dilakukan sebelumnya oleh para alumni sebagai referensi, serta melakukan pengecekan mandiri terhadap draf judul yang diajukan untuk menghindari duplikasi topik penelitian.
                </p>
                <div class="video-container">
                    <div class="ratio ratio-16x9">
                        <!-- Embedded YouTube Video: Profile FT UHO -->
                        <iframe src="https://www.youtube.com/embed/gL2H4Fv7aE8?si=Z6mve_3o-JgU1i8j" title="Profil Fakultas Teknik UHO" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visi & Misi, Sejarah cards -->
            <div class="col-lg-6 d-flex flex-column gap-4 justify-content-center">
                <!-- Visi & Misi Card -->
                <div class="card card-info" id="panduan">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="card-title">Alur Pengecekan Kemiripan Judul</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-2" style="text-align: justify;">
                            Mahasiswa dapat memeriksa potensi kemiripan judul usulan tugas akhir mereka dengan langkah mudah berikut:
                        </p>
                        <ol class="mb-0 ps-3 text-muted small" style="text-align: justify;">
                            <li>Masuk ke halaman <strong>Cek Plagiarisme Judul</strong> di menu atas.</li>
                            <li>Tuliskan draf judul tugas akhir lengkap Anda pada kolom yang disediakan.</li>
                            <li>Sistem akan menganalisis kecocokan kata kunci dengan membandingkannya ke seluruh judul tugas akhir alumni di database.</li>
                            <li>Hasil analisis tingkat kemiripan akan ditampilkan dalam persentase kecocokan.</li>
                        </ol>
                    </div>
                </div>

                <!-- Sejarah Card -->
                <div class="card card-info">
                    <div class="card-header-custom">
                        <div class="card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4 class="card-title">Tujuan & Manfaat Sistem</h4>
                    </div>
                    <div class="card-body" style="text-align: justify;">
                        <ul class="mb-0 ps-3 text-muted small">
                            <li class="mb-2"><strong>Mencegah Duplikasi Penelitian:</strong> Menjaga orisinalitas topik tugas akhir yang dikerjakan oleh mahasiswa baru.</li>
                            <li class="mb-2"><strong>Kemudahan Akses Referensi:</strong> Membantu mahasiswa mencari topik sejenis yang telah diuji oleh alumni terdahulu.</li>
                            <li class="mb-0"><strong>Transparansi Riset:</strong> Mendokumentasikan judul tugas akhir secara digital agar mudah diakses oleh civitas akademika kapan saja.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Services Shortcuts (Layanan TA) -->
<section class="py-5 bg-light border-top">
    <div class="container px-4">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-dark">Layanan Pengarsipan</h3>
            <p class="text-muted">Gunakan modul-modul berikut untuk mengelola atau mencari referensi tugas akhir</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-search fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Jelajahi Database TA</h5>
                    <p class="text-muted small mb-4">Cari referensi berdasarkan kata kunci judul, nama penulis, abstrak, atau tahun terbit tugas akhir.</p>
                    <a href="{{ route('public.thesis.index') }}" class="btn btn-outline-primary mt-auto">Mulai Cari TA</a>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="bg-warning bg-opacity-10 text-warning mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Cek Plagiarisme Judul</h5>
                    <p class="text-muted small mb-4">Uji usulan judul Anda sebelum diajukan ke pembimbing untuk melihat tingkat kemiripannya.</p>
                    <a href="{{ route('plagiarism.check') }}" class="btn btn-outline-warning text-dark mt-auto">Mulai Cek Judul</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
