@extends('layouts.public')

@section('title', 'Daftar Tugas Akhir')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-5 mb-5 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white fw-bold">Daftar Tugas Akhir</h1>
                <p class="lead mb-0 text-white-50">Jelajahi koleksi tugas akhir mahasiswa S1 Teknik Informatika UHO</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class="me-2" data-feather="filter"></i>
                Filter & Pencarian
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('public.thesis.index') }}">
                    <div class="row gx-3">
                        {{-- Kolom Pencarian --}}
                        <div class="col-md-4 mb-3">
                            <label for="search" class="form-label">Pencarian</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Judul atau Penulis" class="form-control">
                        </div>

                        {{-- Kolom Peminatan --}}
                        <div class="col-md-3 mb-3">
                            <label for="type" class="form-label">Peminatan</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Semua Peminatan</option>
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kolom Tahun --}}
                        <div class="col-md-3 mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <select name="year" id="year" class="form-select">
                                <option value="">Semua Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="col-md-2 d-flex align-items-end mb-3">
                            <div class="d-flex w-100 gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="me-2" data-feather="filter"></i> Filter
                                </button>
                                @if (request()->hasAny(['search', 'type', 'year']))
                                    <a href="{{ route('public.thesis.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                        <i data-feather="refresh-cw"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tag Algoritma & Topik Populer --}}
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="small fw-bold text-muted me-1">
                                <i class="fas fa-tags text-primary me-1"></i> Tag Algoritma Populer:
                            </span>
                            @php
                                $popularTags = ['YOLO', 'CNN', 'LSTM', 'XGBoost', 'Random Forest', 'IoT', 'SVM', 'Fuzzy', 'Microservices', 'Blockchain', 'GIS', 'MobileNet'];
                            @endphp
                            @foreach ($popularTags as $tag)
                                <a href="{{ route('public.thesis.index', array_merge(request()->except('page'), ['search' => $tag])) }}"
                                    class="badge {{ strtolower(request('search')) === strtolower($tag) ? 'bg-primary text-white shadow-sm' : 'bg-light text-dark border' }} text-decoration-none px-2 py-1 small">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                            @if (request('search'))
                                <a href="{{ route('public.thesis.index', request()->except(['search', 'page'])) }}" class="badge bg-danger bg-opacity-10 text-danger border border-danger text-decoration-none px-2 py-1 small">
                                    <i class="fas fa-times me-1"></i> Hapus Filter Tag
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-3">
            <p>Menampilkan {{ $theses->firstItem() ?? 0 }} - {{ $theses->lastItem() ?? 0 }} dari {{ $theses->total() }}
                tugas akhir</p>
        </div>

        <div class="row gx-4">
            @forelse($theses as $thesis)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span
                                    class="badge bg-primary bg-opacity-25 text-primary">{{ $thesis->type_code_upper }}</span>
                                <span class="small text-muted d-flex align-items-center">
                                    <i class="me-1" data-feather="calendar"></i> {{ $thesis->year }}
                                </span>
                            </div>
                            <h5 class="card-title mb-2">{{ $thesis->title }}</h5>
                            <div class="small text-muted mb-3">
                                <i class="me-1" data-feather="user"></i>
                                <strong>{{ $thesis->author }}</strong>
                            </div>
                            <p class="card-text small">
                                {{ Str::limit($thesis->abstract, 150) }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 p-4 pt-0">
                            <a href="{{ route('public.thesis.show', $thesis) }}" class="btn btn-primary w-100">
                                <i class="me-2" data-feather="eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card card-body text-center py-5">
                        <i class="mx-auto" data-feather="search" style="width: 48px; height: 48px;"></i>
                        <h3 class="mt-3">Tidak Ada Tugas Akhir Ditemukan</h3>
                        <p class="text-muted">Coba ubah filter pencarian atau hapus beberapa filter.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($theses->hasPages())
            <div class="d-flex justify-content-center">
                {{ $theses->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
