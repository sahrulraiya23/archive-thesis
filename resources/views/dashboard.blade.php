@extends('layouts.admin')

@section('title', 'Dashboard - Sistem Pengarsipan Tugas Akhir')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white">Selamat Datang Di Sistem Pengarsipan Tugas Akhir</h1>
                <p class="lead mb-0 text-white-50">Teknik Informatika - Universitas Halu Oleo</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        @php
            $totalThesis = App\Models\Thesis::count();
            $thisYearThesis = App\Models\Thesis::whereYear('created_at', date('Y'))->count();
            $recentThesis = App\Models\Thesis::latest()->limit(5)->get();
        @endphp

        <!-- Kartu Statistik -->
        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Total Tugas Akhir</div>
                                <div class="text-lg fw-bold">{{ $totalThesis }}</div>
                            </div>
                            <i class="feather-xl" data-feather="book"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Tahun {{ date('Y') }}</div>
                                <div class="text-lg fw-bold">{{ $thisYearThesis }}</div>
                            </div>
                            <i class="feather-xl" data-feather="calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Konten Utama -->
        <div class="row">
            <!-- Kolom Kiri: Tugas Akhir Terbaru -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header"><i class="me-2" data-feather="clock"></i>Tugas Akhir Terbaru</div>
                    <div class="card-body">
                        @if ($recentThesis->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentThesis as $thesis)
                                    <a href="{{ route('public.thesis.show', $thesis) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ Str::limit($thesis->title, 80) }}</h6>
                                            <small class="text-muted">{{ $thesis->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 small">{{ $thesis->author }}</p>
                                        <small class="text-muted"><strong>Kata kunci:</strong>
                                            {{ $thesis->keywords ?: '-' }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">Belum ada tugas akhir yang tersedia.</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <a href="{{ route('public.thesis.index') }}">Lihat Semua Tugas Akhir →</a>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Quick Actions & Distribusi -->
            <div class="col-lg-4 mb-4">
                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header"><i class="me-2" data-feather="zap"></i>Aksi Cepat</div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('public.thesis.index') }}" class="list-group-item list-group-item-action"><i
                                    class="me-2" data-feather="search"></i>Jelajahi Tugas Akhir</a>
                            <a href="{{ route('plagiarism.check') }}" class="list-group-item list-group-item-action"><i
                                    class="me-2" data-feather="shield"></i>Cek Plagiarisme</a>
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.thesis.create') }}"
                                    class="list-group-item list-group-item-action"><i class="me-2"
                                        data-feather="plus"></i>Tambah Tugas Akhir</a>
                                <a href="{{ route('admin.thesis.index') }}"
                                    class="list-group-item list-group-item-action"><i class="me-2"
                                        data-feather="settings"></i>Kelola Data</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="me-2" data-feather="tag"></i>Informasi</div>
                    <div class="card-body">
                        <p class="mb-0 small text-muted">Gunakan pencarian untuk menemukan judul berdasarkan judul, penulis,
                            atau kata kunci.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
