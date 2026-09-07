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
            $thesisTypes = App\Models\Thesis::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray();
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
            <div class="col-lg-6 col-xl-3 mb-4">
                <a href="{{ route('public.thesis.index', ['type' => 'kcv']) }}" class="text-decoration-none">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">KCV</div>
                                    <div class="text-lg fw-bold">{{ $thesisTypes['kcv'] ?? 0 }}</div>
                                </div>
                                <i class="feather-xl" data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <a href="{{ route('public.thesis.index', ['type' => 'kbj']) }}" class="text-decoration-none">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">KBJ</div>
                                    <div class="text-lg fw-bold">{{ $thesisTypes['kbj'] ?? 0 }}</div>
                                </div>
                                <i class="feather-xl" data-feather="wifi"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <a href="{{ route('public.thesis.index', ['type' => 'rpl']) }}" class="text-decoration-none">
                    <div class="card bg-secondary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">RPL</div>
                                    <div class="text-lg fw-bold">{{ $thesisTypes['rpl'] ?? 0 }}</div>
                                </div>
                                <i class="feather-xl" data-feather="film"></i>
                            </div>
                        </div>
                    </div>
                </a>
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
                                        <small><span
                                                class="badge bg-primary bg-opacity-25 text-primary">{{ $thesis->type_code_upper }}</span></small>
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

                <!-- Distribusi Jenis -->
                <div class="card">
                    <div class="card-header"><i class="me-2" data-feather="pie-chart"></i>Distribusi Jenis</div>
                    <div class="card-body">
                        @if (!empty($thesisTypes))
                            @foreach ($thesisTypes as $type => $count)
                                @php
                                    $percentage = $totalThesis > 0 ? round(($count / $totalThesis) * 100, 1) : 0;
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="small">{{ strtoupper($type) }}</span>
                                        <span class="small">{{ $count }} ({{ $percentage }}%)</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center small text-muted">Tidak ada data untuk ditampilkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
