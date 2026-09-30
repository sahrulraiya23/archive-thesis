@extends('layouts.public')

@section('title', $thesis->title . ' - Bank Tugas Akhir')

@section('styles')
    <style>
        /* Academic Repository Typography & Aesthetics */
        .font-serif-academic {
            font-family: 'Lora', 'Merriweather', 'Times New Roman', serif;
        }

        .academic-doc-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15, 44, 89, 0.06);
            overflow: hidden;
            position: relative;
        }

        .academic-doc-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0f2c59 0%, #1e4b85 60%, #ffc107 100%);
        }

        .academic-masthead {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 24px 32px 20px;
        }

        .academic-crest-text {
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
        }

        .academic-title {
            font-family: 'Lora', 'Merriweather', Georgia, serif;
            color: #0f2c59;
            font-weight: 700;
            font-size: 1.75rem;
            line-height: 1.45;
            letter-spacing: -0.2px;
            margin-top: 14px;
            margin-bottom: 18px;
        }

        /* Metadata & Supervisor Badges */
        .badge-angkatan {
            background: #0f2c59;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
        }

        .badge-prodi {
            background: rgba(255, 193, 7, 0.2);
            color: #855700;
            border: 1px solid rgba(255, 193, 7, 0.4);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 5px 12px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
        }

        .academic-meta-strip {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 20px;
        }

        .meta-field-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .meta-field-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Supervisors Grid */
        .supervisors-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 28px;
        }

        .supervisor-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 14px 18px;
            height: 100%;
            transition: all 0.2s ease;
        }

        .supervisor-card:hover {
            border-color: #0f2c59;
            box-shadow: 0 4px 12px rgba(15, 44, 89, 0.08);
            transform: translateY(-2px);
        }

        .supervisor-role {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            color: #0f2c59;
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .supervisor-role.pendamping {
            color: #475569;
        }

        .supervisor-name {
            font-weight: 700;
            font-size: 0.98rem;
            color: #0f2c59;
            margin-bottom: 2px;
            line-height: 1.35;
        }

        /* Abstract Section */
        .abstract-container {
            background: #ffffff;
            border-left: 4px solid #0f2c59;
            border-radius: 0 8px 8px 0;
            padding: 26px 30px;
            background: #fafbfc;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.02);
            margin-bottom: 28px;
        }

        .abstract-heading {
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #0f2c59;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .abstract-text {
            font-family: 'Lora', Georgia, serif;
            font-size: 1.05rem;
            line-height: 1.9;
            color: #1e293b;
            text-align: justify;
            text-justify: inter-word;
            margin: 0;
        }

        /* Keywords */
        .keyword-chip {
            background-color: #f1f5f9;
            color: #0f2c59;
            border: 1px solid #cbd5e1;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .keyword-chip:hover {
            background-color: #0f2c59;
            color: #ffffff;
            border-color: #0f2c59;
            transform: translateY(-1px);
        }

        /* Citation Box */
        .citation-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 22px;
            margin-bottom: 30px;
        }

        .citation-text {
            font-family: 'Lora', Georgia, serif;
            font-size: 0.92rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 14px 16px;
            color: #334155;
            line-height: 1.65;
            user-select: all;
        }

        /* Print Styles */
        @media print {
            .top-header,
            .main-navbar,
            .public-footer,
            .academic-header-banner,
            .card-footer,
            .academic-tools-bar,
            .citation-box,
            .similar-theses-card,
            .btn,
            nav {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 12pt !important;
                padding: 0 !important;
            }

            .container-xl {
                max-width: 100% !important;
                padding: 0 !important;
            }

            .academic-doc-card {
                border: none !important;
                box-shadow: none !important;
            }

            .academic-masthead {
                background: #ffffff !important;
                border-bottom: 2px solid #000000 !important;
                padding: 0 0 16px 0 !important;
            }

            .academic-title {
                color: #000000 !important;
                font-size: 18pt !important;
                margin: 16px 0 !important;
            }

            .abstract-container {
                background: #ffffff !important;
                border-left: 3px solid #000000 !important;
                padding: 12px 16px !important;
                box-shadow: none !important;
            }

            .abstract-text {
                color: #000000 !important;
                font-size: 11pt !important;
                line-height: 1.6 !important;
            }

            .print-only-letterhead {
                display: block !important;
                text-align: center;
                border-bottom: 3px double #000000;
                padding-bottom: 14px;
                margin-bottom: 20px;
            }
        }

        .print-only-letterhead {
            display: none;
        }
    </style>
@endsection

@section('content')
    {{-- Official Print Letterhead (Hanya muncul saat dicetak / PDF) --}}
    <div class="print-only-letterhead">
        <h5 style="margin: 0; font-weight: 700; font-family: 'Poppins', sans-serif;">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h5>
        <h4 style="margin: 2px 0; font-weight: 800; font-family: 'Poppins', sans-serif;">UNIVERSITAS HALU OLEO</h4>
        <h5 style="margin: 0; font-weight: 600;">FAKULTAS TEKNIK - JURUSAN TEKNIK INFORMATIKA</h5>
        <p style="margin: 3px 0 0; font-size: 9pt;">Kampus Hijau Bumi Tridharma Anduonohu Kendari, Telp: (0401) 3196237 | Website: ti.eng.uho.ac.id</p>
        <p style="margin: 2px 0 0; font-size: 9pt; font-weight: 700; text-transform: uppercase;">ARSIP REPOSITORI BANK TUGAS AKHIR SARJANA (S1)</p>
    </div>

    {{-- Academic Top Breadcrumb Header --}}
    <header class="academic-header-banner py-4 mb-4 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1 text-white-50 small">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white text-decoration-none">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('public.thesis.index') }}" class="text-white text-decoration-none">Bank Tugas Akhir</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('public.thesis.index', ['angkatan' => $thesis->angkatan]) }}" class="text-warning text-decoration-none">Angkatan {{ $thesis->angkatan }}</a></li>
                            <li class="breadcrumb-item active text-white-50 text-truncate" style="max-width: 260px;" aria-current="page">{{ $thesis->nim ?: 'Dokumen TA' }}</li>
                        </ol>
                    </nav>
                    <h2 class="text-white fw-bold mb-0" style="font-family: 'Poppins', sans-serif; font-size: 1.5rem;">
                        <i class="fas fa-book-reader text-warning me-2"></i>Naskah Tugas Akhir - Angkatan {{ $thesis->angkatan }}
                    </h2>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('public.thesis.index') }}" class="btn btn-outline-light btn-sm px-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                    <button onclick="window.print()" class="btn btn-warning btn-sm px-3 fw-bold">
                        <i class="fas fa-print me-1"></i> Cetak / Simpan PDF
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Konten Utama Dokumen Akademik --}}
    <div class="container-xl px-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="academic-doc-card mb-4">
                    {{-- Academic Masthead --}}
                    <div class="academic-masthead">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge-angkatan">
                                    <i class="fas fa-graduation-cap me-1 text-warning"></i> Angkatan {{ $thesis->angkatan }}
                                </span>
                                <span class="badge-prodi">
                                    <i class="fas fa-university me-1"></i> {{ $thesis->program_study ?: 'S1 Teknik Informatika' }}
                                </span>
                                <span class="badge bg-light text-secondary border">
                                    <i class="fas fa-shield-alt me-1 text-success"></i> Naskah Terverifikasi
                                </span>
                            </div>
                            <div class="text-muted small">
                                <i class="far fa-calendar-check me-1 text-primary"></i>Diarsipkan:
                                <strong>{{ $thesis->created_at ? $thesis->created_at->format('d F Y') : '-' }}</strong>
                            </div>
                        </div>

                        {{-- Judul Skripsi / Tugas Akhir --}}
                        <h1 class="academic-title">{{ $thesis->title }}</h1>

                        {{-- Penulis & Metadata Baris --}}
                        <div class="academic-meta-strip">
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-6 col-md-5">
                                    <div class="meta-field-label"><i class="fas fa-user-graduate me-1 text-primary"></i>Penulis / Mahasiswa</div>
                                    <div class="meta-field-value text-primary">{{ $thesis->author }}</div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="meta-field-label"><i class="fas fa-id-card me-1 text-primary"></i>NIM Mahasiswa</div>
                                    <div class="meta-field-value">{{ $thesis->nim ?: '-' }}</div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="meta-field-label"><i class="fas fa-calendar-alt me-1 text-primary"></i>Angkatan</div>
                                    <div class="meta-field-value">{{ $thesis->angkatan }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Body Dokumen --}}
                    <div class="p-4 p-md-5">
                        {{-- Panel Dosen Pembimbing (Pembimbing 1 & Pembimbing 2) --}}
                        <div class="supervisors-box">
                            <h6 class="fw-bold text-dark mb-3" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-chalkboard-teacher text-primary me-2"></i>Dosen Pembimbing Tugas Akhir
                            </h6>
                            <div class="row g-3">
                                {{-- Pembimbing 1 --}}
                                <div class="col-md-6">
                                    <div class="supervisor-card">
                                        <div class="supervisor-role">
                                            <span class="badge bg-primary text-white me-2 px-2 py-1">I</span>
                                            Dosen Pembimbing Utama
                                        </div>
                                        @if ($thesis->pembimbing_1)
                                            <div class="supervisor-name">{{ $thesis->pembimbing_1 }}</div>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-user-tie me-1 text-primary"></i>Pembimbing 1
                                            </small>
                                            <div class="mt-2 pt-2 border-top">
                                                <a href="{{ route('public.thesis.index', ['search' => $thesis->pembimbing_1]) }}"
                                                    class="small text-decoration-none fw-semibold text-primary">
                                                    <i class="fas fa-search me-1"></i>Lihat tugas akhir bimbingan lainnya &rarr;
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-muted fst-italic">Data pembimbing 1 belum tercatat</div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Pembimbing 2 --}}
                                <div class="col-md-6">
                                    <div class="supervisor-card">
                                        <div class="supervisor-role pendamping">
                                            <span class="badge bg-secondary text-white me-2 px-2 py-1">II</span>
                                            Dosen Pembimbing Pendamping
                                        </div>
                                        @if ($thesis->pembimbing_2)
                                            <div class="supervisor-name">{{ $thesis->pembimbing_2 }}</div>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-user-tie me-1 text-secondary"></i>Pembimbing 2
                                            </small>
                                            <div class="mt-2 pt-2 border-top">
                                                <a href="{{ route('public.thesis.index', ['search' => $thesis->pembimbing_2]) }}"
                                                    class="small text-decoration-none fw-semibold text-secondary">
                                                    <i class="fas fa-search me-1"></i>Lihat tugas akhir bimbingan lainnya &rarr;
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-muted fst-italic">Data pembimbing 2 belum tercatat</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section Abstrak Formal --}}
                        <section class="abstract-container">
                            <div class="abstract-heading">
                                <i class="fas fa-file-alt text-primary me-2"></i>Abstrak / Abstract
                            </div>
                            <div class="abstract-text">
                                {!! nl2br(e($thesis->abstract)) !!}
                            </div>
                        </section>

                        {{-- Tampilan Kata Kunci / Keywords --}}
                        @if (!empty($thesis->keyword_array))
                            <div class="mb-4 p-3 bg-light rounded border">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="fw-bold text-dark mb-0 me-2" style="font-family: 'Poppins', sans-serif;">
                                        <i class="fas fa-tags text-primary me-2"></i>Kata Kunci / Keywords:
                                    </h6>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary small">Indeks Repositori</span>
                                </div>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($thesis->keyword_array as $kw)
                                        @if ($kw !== '')
                                            <a href="{{ route('public.thesis.index', ['search' => $kw]) }}"
                                                class="keyword-chip" title="Cari topik {{ $kw }}">
                                                <i class="fas fa-hashtag me-1 opacity-50"></i>{{ $kw }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Box Sitasi Akademik (Scholarly Citation Tool) --}}
                        <div class="citation-box mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-family: 'Poppins', sans-serif;">
                                    <i class="fas fa-quote-right text-primary me-2"></i>Kutip Tugas Akhir Ini (Sitasi Dokumen)
                                </h6>
                                <span class="badge bg-primary bg-opacity-10 text-primary">Standar Akademik</span>
                            </div>
                            <ul class="nav nav-pills mb-3" id="citationTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active py-1 px-3 small" id="apa-tab" data-bs-toggle="pill" data-bs-target="#apa-citation" type="button" role="tab">Format APA 7th</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-1 px-3 small" id="ieee-tab" data-bs-toggle="pill" data-bs-target="#ieee-citation" type="button" role="tab">Format IEEE</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-1 px-3 small" id="bibtex-tab" data-bs-toggle="pill" data-bs-target="#bibtex-citation" type="button" role="tab">BibTeX</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="citationTabsContent">
                                {{-- APA --}}
                                <div class="tab-pane fade show active" id="apa-citation" role="tabpanel">
                                    <div class="citation-text" id="citation-apa">
                                        {{ $thesis->author }} ({{ $thesis->angkatan }}). <em>{{ $thesis->title }}</em> [Tugas Akhir Sarjana, Universitas Halu Oleo]. Repositori Digital Teknik Informatika UHO.
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyCitation('citation-apa', this)">
                                        <i class="far fa-copy me-1"></i> Salin Sitasi APA
                                    </button>
                                </div>
                                {{-- IEEE --}}
                                <div class="tab-pane fade" id="ieee-citation" role="tabpanel">
                                    <div class="citation-text" id="citation-ieee">
                                        {{ $thesis->author }}, "{{ $thesis->title }}," Skripsi S1, Jurusan Teknik Informatika, Fakultas Teknik, Universitas Halu Oleo, Kendari, {{ $thesis->angkatan }}.
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyCitation('citation-ieee', this)">
                                        <i class="far fa-copy me-1"></i> Salin Sitasi IEEE
                                    </button>
                                </div>
                                {{-- BibTeX --}}
                                <div class="tab-pane fade" id="bibtex-citation" role="tabpanel">
                                    <pre class="citation-text mb-0" id="citation-bibtex" style="font-family: monospace; font-size: 0.82rem;">@thesis{uho_ta_{{ $thesis->id }},
  author  = "{{ $thesis->author }}",
  title   = "{{ $thesis->title }}",
  school  = "Universitas Halu Oleo",
  year    = "{{ $thesis->angkatan }}",
  type    = "Skripsi Sarjana"
}</pre>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyCitation('citation-bibtex', this)">
                                        <i class="far fa-copy me-1"></i> Salin BibTeX
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Academic Action Toolbar --}}
                        <div class="academic-tools-bar d-flex flex-wrap justify-content-between align-items-center gap-3 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2">
                                <button onclick="window.print()" class="btn btn-primary">
                                    <i class="fas fa-print me-2"></i> Cetak / Simpan PDF
                                </button>
                                <button onclick="shareLink(this)" class="btn btn-outline-secondary">
                                    <i class="fas fa-share-alt me-2"></i> Bagikan Tautan
                                </button>
                                <a href="{{ route('plagiarism.check', ['title' => $thesis->title]) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-2"></i> Cek Kemiripan Judul
                                </a>
                            </div>
                            <a href="{{ route('public.thesis.index') }}" class="btn btn-link text-decoration-none text-muted">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Section Tugas Akhir Terkait / Sejenis --}}
                <div class="card mb-5 border-0 shadow-sm similar-theses-card" style="border-radius: 8px;">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="fw-bold text-dark" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-book text-primary me-2"></i>Tugas Akhir Terkait & Sejenis
                        </div>
                        <span class="badge bg-light text-muted border">Rekomendasi Repositori</span>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $searchTerms = [];

                            if (!empty($thesis->keywords)) {
                                $rawList = str_contains($thesis->keywords, ',')
                                    ? explode(',', $thesis->keywords)
                                    : explode(' ', $thesis->keywords);

                                foreach ($rawList as $raw) {
                                    $cleaned = trim($raw);
                                    if (mb_strlen($cleaned) >= 3 && !in_array(mb_strtolower($cleaned), ['dan', 'atau', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'studi', 'kasus', 'berbasis', 'menggunakan', 'sistem', 'aplikasi'])) {
                                        $searchTerms[] = $cleaned;
                                    }
                                }
                            }

                            if (count($searchTerms) < 2 && !empty($thesis->title)) {
                                $titleWords = explode(' ', preg_replace('/[^\p{L}\p{N}]+/u', ' ', $thesis->title));
                                $stopWords = ['dan', 'atau', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'dalam', 'oleh', 'terhadap', 'sebagai', 'studi', 'kasus', 'berbasis', 'menggunakan', 'penerapan', 'implementasi', 'pengembangan', 'perancangan', 'rancang', 'bangun', 'analisis', 'sistem', 'aplikasi', 'metode', 'algoritma', 'model', 'data'];
                                foreach ($titleWords as $tw) {
                                    $cleanedTw = trim($tw);
                                    if (mb_strlen($cleanedTw) >= 3 && !in_array(mb_strtolower($cleanedTw), $stopWords)) {
                                        $searchTerms[] = $cleanedTw;
                                    }
                                }
                            }

                            $searchTerms = array_values(array_unique($searchTerms));

                            $similarQuery = App\Models\Thesis::where('id', '!=', $thesis->id);

                            if (!empty($searchTerms)) {
                                $similarQuery->where(function ($q) use ($searchTerms) {
                                    foreach ($searchTerms as $term) {
                                        $q->orWhere('keywords', 'like', '%' . $term . '%')
                                          ->orWhere('title', 'like', '%' . $term . '%');
                                    }
                                });
                            }

                            $similarTheses = $similarQuery->latest()->limit(4)->get();

                            if ($similarTheses->isEmpty()) {
                                $similarTheses = App\Models\Thesis::where('id', '!=', $thesis->id)->latest()->limit(4)->get();
                            }
                        @endphp

                        @if ($similarTheses->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($similarTheses as $similar)
                                    <a href="{{ route('public.thesis.show', $similar) }}"
                                        class="list-group-item list-group-item-action py-3 px-4">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold text-dark font-serif-academic" style="font-size: 1.02rem;">{{ $similar->title }}</h6>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 ms-2 flex-shrink-0">
                                                Angkatan {{ $similar->angkatan }}
                                            </span>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center gap-3 small text-muted mb-1">
                                            <span><i class="fas fa-user-graduate me-1 text-primary"></i><strong>{{ $similar->author }}</strong> @if($similar->nim) ({{ $similar->nim }}) @endif</span>
                                            @if($similar->pembimbing_1)
                                                <span><i class="fas fa-chalkboard-teacher me-1 text-secondary"></i>Pembimbing: {{ $similar->pembimbing_1 }}</span>
                                            @endif
                                        </div>
                                        @if(!empty($similar->keywords))
                                            <small class="text-muted"><i class="fas fa-tags me-1 text-primary"></i>{{ Str::limit($similar->keywords, 100) }}</small>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted py-4 mb-0">Tidak ada tugas akhir sejenis lainnya.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Toast Notification container --}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="actionToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Teks berhasil disalin ke clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showNotification(msg) {
            const toastEl = document.getElementById('actionToast');
            document.getElementById('toastMessage').innerText = msg;
            const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
            toast.show();
        }

        function copyCitation(elementId, btn) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const text = el.innerText || el.textContent;
            navigator.clipboard.writeText(text.trim()).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-success me-1"></i> Tersalin!';
                showNotification('Sitasi berhasil disalin ke clipboard!');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            }).catch(err => {
                showNotification('Gagal menyalin sitasi otomatis.');
            });
        }

        function shareLink(btn) {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-success me-1"></i> Tautan Tersalin!';
                showNotification('Tautan naskah berhasil disalin ke clipboard!');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            }).catch(err => {
                showNotification('Gagal menyalin tautan.');
            });
        }
    </script>
@endsection
