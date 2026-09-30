@extends('layouts.public')

@section('title', 'Daftar Tugas Akhir')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-5 mb-5 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="text-center">
                <span class="badge bg-warning text-dark px-3 py-2 fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">Bank Data Tugas Akhir</span>
                <h1 class="text-white fw-bold" style="font-family: 'Poppins', sans-serif;">Daftar Tugas Akhir Mahasiswa</h1>
                <p class="lead mb-0 text-white-50">Koleksi arsip naskah skripsi dan tugas akhir S1 Teknik Informatika Universitas Halu Oleo</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header bg-white py-3 d-flex align-items-center fw-bold text-dark border-bottom">
                <i class="fas fa-filter text-primary me-2"></i>
                Filter & Pencarian Koleksi
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('public.thesis.index') }}">
                    <div class="row gx-3">
                        {{-- Kolom Pencarian --}}
                        <div class="col-md-6 mb-3">
                            <label for="search" class="form-label fw-semibold text-dark small">Kata Kunci Pencarian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Cari judul, penulis, NIM, kata kunci, atau dosen pembimbing..."
                                    class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Kolom Angkatan --}}
                        <div class="col-md-4 mb-3">
                            <label for="angkatan" class="form-label fw-semibold text-dark small">Angkatan Mahasiswa</label>
                            <select name="angkatan" id="angkatan" class="form-select">
                                <option value="">Semua Angkatan</option>
                                @foreach ($angkatans ?? $years as $ang)
                                    <option value="{{ $ang }}" {{ (request('angkatan', request('year')) == $ang) ? 'selected' : '' }}>
                                        Angkatan {{ $ang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="col-md-2 d-flex align-items-end mb-3">
                            <div class="d-flex w-100 gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                @if (request()->hasAny(['search', 'angkatan', 'year']))
                                    <a href="{{ route('public.thesis.index') }}" class="btn btn-outline-secondary"
                                        title="Reset Filter">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0 small">
                Menampilkan <strong>{{ $theses->firstItem() ?? 0 }} - {{ $theses->lastItem() ?? 0 }}</strong> dari <strong>{{ $theses->total() }}</strong> naskah tugas akhir terarsip
            </p>
            @if(request('angkatan') || request('year'))
                <span class="badge bg-primary px-3 py-2">
                    <i class="fas fa-filter me-1"></i> Angkatan: {{ request('angkatan', request('year')) }}
                </span>
            @endif
        </div>

        <div class="row gx-4">
            @forelse($theses as $thesis)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px; transition: transform 0.2s, box-shadow 0.2s;">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 small">
                                    <i class="fas fa-graduation-cap me-1"></i>Angkatan {{ $thesis->angkatan }}
                                </span>
                                @if ($thesis->nim)
                                    <span class="badge bg-light text-dark border small">{{ $thesis->nim }}</span>
                                @endif
                            </div>

                            <h5 class="card-title mb-3" style="font-family: 'Lora', Georgia, serif; font-size: 1.05rem; font-weight: 700; line-height: 1.45; color: #0f2c59;">
                                <a href="{{ route('public.thesis.show', $thesis) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $thesis->title }}
                                </a>
                            </h5>

                            <div class="small text-muted mb-2">
                                <i class="fas fa-user-graduate me-1 text-primary"></i>
                                <strong>{{ $thesis->author }}</strong>
                            </div>

                            @if ($thesis->pembimbing_1)
                                <div class="small text-muted mb-2">
                                    <i class="fas fa-chalkboard-teacher me-1 text-secondary"></i>
                                    <span><strong>Pembimbing:</strong> {{ $thesis->pembimbing_1 }}</span>
                                    @if ($thesis->pembimbing_2)
                                        <div class="ms-3 text-truncate">&bull; {{ $thesis->pembimbing_2 }}</div>
                                    @endif
                                </div>
                            @endif

                            @if(!empty($thesis->keyword_array))
                                <div class="mb-3 mt-1">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($thesis->keyword_array as $kw)
                                            @if ($kw !== '')
                                                <a href="{{ route('public.thesis.index', ['search' => $kw]) }}"
                                                    class="badge bg-light text-dark border px-2 py-1 small text-decoration-none">
                                                    #{{ $kw }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <p class="card-text small text-muted mt-auto" style="text-align: justify;">
                                {{ Str::limit($thesis->abstract, 130) }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 p-4 pt-0">
                            <a href="{{ route('public.thesis.show', $thesis) }}" class="btn btn-outline-primary w-100 fw-semibold">
                                <i class="fas fa-book-open me-1"></i> Buka Detail Naskah
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card card-body text-center py-5 border-0 shadow-sm">
                        <i class="fas fa-search mx-auto text-muted mb-3" style="font-size: 48px;"></i>
                        <h4 class="fw-bold">Tidak Ada Tugas Akhir Ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau pilih angkatan yang berbeda.</p>
                        <div class="mt-2">
                            <a href="{{ route('public.thesis.index') }}" class="btn btn-primary">Reset Filter Pencarian</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($theses->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $theses->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
