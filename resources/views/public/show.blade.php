@extends('layouts.public')

@section('title', $thesis->title)

@section('styles')
    <style>
        @media print {

            .top-header,
            .main-navbar,
            .public-footer,
            header,
            .card-footer,
            .card:nth-child(2),
            nav,
            .btn {
                display: none !important;
            }

            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }

            .container-xl {
                max-width: 100% !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endsection

@section('content')
    {{-- Header Halaman --}}
    <header class="py-5 mb-5 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white fw-bold">Tugas Akhir - {{ $thesis->year }}</h1>
                    <p class="lead mb-0 text-white-50">Detail Tugas Akhir Mahasiswa S1 Teknik Informatika UHO</p>
                </div>
                <a href="{{ route('public.thesis.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 border border-primary border-opacity-25">
                                    <i class="me-1" data-feather="calendar"></i> {{ $thesis->year }}
                                </span>
                            </div>
                            <span class="text-muted small"><i class="me-1" data-feather="clock"></i>Dibuat pada
                                {{ $thesis->created_at ? $thesis->created_at->format('d M Y') : '-' }}</span>
                        </div>
                        <h1 class="card-title">{{ $thesis->title }}</h1>

                        <div class="row gx-4 mt-4">
                            <div class="col-md-12">
                                <p class="small text-muted mb-0">Penulis</p>
                                <p class="fw-bold mb-0 text-primary">{{ $thesis->author }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <h4 class="mb-3"><i class="me-2" data-feather="file-text"></i>Abstrak</h4>
                        <div class="bg-light p-3 rounded mb-4" style="text-align: justify;">
                            <p class="mb-0">{!! nl2br(e($thesis->abstract)) !!}</p>
                        </div>

                        {{-- Tampilan Kata Kunci / Keywords --}}
                        @if (!empty($thesis->keyword_array))
                            <div class="p-3 bg-light bg-opacity-75 rounded border">
                                <h6 class="fw-bold text-dark mb-2">
                                    <i class="fas fa-tags text-primary me-2"></i>Kata Kunci / Keywords:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($thesis->keyword_array as $kw)
                                        @if ($kw !== '')
                                            <a href="{{ route('public.thesis.index', ['search' => $kw]) }}"
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 text-decoration-none rounded-pill">
                                                #{{ $kw }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer p-4 bg-transparent border-top-0">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>

                {{-- Section Tugas Akhir Sejenis --}}
                <div class="card mb-5">
                    <div class="card-header"><i class="me-2" data-feather="book"></i>Tugas Akhir Sejenis</div>
                    <div class="card-body">
                        @php
                            // 1. Ekstrak frasa/kata kunci dari $thesis->keywords
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

                            // 2. Ekstrak kata penting dari judul jika kata kunci kurang
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

                            // 3. Query Tugas Akhir Sejenis
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

                            // 4. Fallback jika tidak ada hasil yang cocok: tampilkan tugas akhir terbaru lainnya
                            if ($similarTheses->isEmpty()) {
                                $similarTheses = App\Models\Thesis::where('id', '!=', $thesis->id)->latest()->limit(4)->get();
                            }
                        @endphp

                        @if ($similarTheses->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($similarTheses as $similar)
                                    <a href="{{ route('public.thesis.show', $similar) }}"
                                        class="list-group-item list-group-item-action py-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <h6 class="mb-1 fw-bold text-dark">{{ $similar->title }}</h6>
                                            <span class="badge bg-light text-muted border ms-2">{{ $similar->year }}</span>
                                        </div>
                                        <p class="mb-1 small text-muted"><i class="fas fa-user me-1"></i>{{ $similar->author }}</p>
                                        @if(!empty($similar->keywords))
                                            <small class="text-muted"><i class="fas fa-tags me-1 text-primary"></i>{{ Str::limit($similar->keywords, 90) }}</small>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted py-3">Tidak ada tugas akhir sejenis lainnya.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
