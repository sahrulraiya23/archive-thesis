@extends('layouts.public')

@section('title', $thesis->title)

@section('content')
    {{-- Header Halaman --}}
    <header class="py-5 mb-5 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white fw-bold">{{ ucfirst($thesis->type) }} - {{ $thesis->year }}</h1>
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
                                <span
                                    class="badge bg-primary bg-opacity-25 text-primary">{{ ucfirst($thesis->type) }}</span>
                                <span class="text-muted ms-2"><i class="me-1"
                                        data-feather="calendar"></i>{{ $thesis->year }}</span>
                            </div>
                            <span class="text-muted small"><i class="me-1" data-feather="clock"></i>Dibuat pada
                                {{ $thesis->created_at->format('d M Y') }}</span>
                        </div>
                        <h1 class="card-title">{{ $thesis->title }}</h1>

                        <div class="row gx-4 mt-4">
                            <div class="col-md-6">
                                <p class="small text-muted mb-0">Penulis</p>
                                <p class="fw-bold">{{ $thesis->author }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-0">Program Studi</p>
                                <p class="fw-bold">{{ $thesis->program_study }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <h4 class="mb-3"><i class="me-2" data-feather="file-text"></i>Abstrak</h4>
                        <div class="bg-light p-3 rounded" style="text-align: justify;">
                            <p>{!! nl2br(e($thesis->abstract)) !!}</p>
                        </div>
                    </div>

                    <div class="card-footer p-4 bg-transparent border-top-0">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('plagiarism.check') }}?title={{ urlencode($thesis->title) }}"
                                class="btn btn-primary">
                                <i class="me-2" data-feather="shield"></i>Cek Plagiarisme Judul
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="me-2" data-feather="printer"></i>Print Detail
                            </button>
                            <button onclick="sharePage()" class="btn btn-outline-secondary">
                                <i class="me-2" data-feather="share-2"></i>Share
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="me-2" data-feather="book"></i>Tugas Akhir Sejenis</div>
                    <div class="card-body">
                        @php
                            $similarTheses = App\Models\Thesis::where('type', $thesis->type)
                                ->where('id', '!=', $thesis->id)
                                ->latest()
                                ->limit(3)
                                ->get();
                        @endphp

                        @if ($similarTheses->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($similarTheses as $similar)
                                    <a href="{{ route('public.thesis.show', $similar) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $similar->title }}</h6>
                                            <small>{{ $similar->year }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted">{{ $similar->author }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted">Tidak ada tugas akhir sejenis lainnya.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $thesis->title }}',
                    text: 'Lihat tugas akhir: {{ $thesis->title }} oleh {{ $thesis->author }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Link telah disalin ke clipboard!');
                });
            }
        }
    </script>
@endsection
