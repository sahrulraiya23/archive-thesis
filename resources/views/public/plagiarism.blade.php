@extends('layouts.public')

@section('title', 'Cek Plagiarisme Judul')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-5 mb-5 text-white" style="background-color: #0f2c59; border-bottom: 4px solid #ffc107;">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white fw-bold">Cek Plagiarisme Judul</h1>
                <p class="lead mb-0 text-white-50">Periksa kemiripan judul dengan database tugas akhir S1 Teknik Informatika UHO</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header"><i class="me-2" data-feather="shield"></i>Form Pengecekan</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('plagiarism.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Masukkan Judul Tugas Akhir</label>
                                <textarea name="title" id="title" rows="4" class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Contoh: Implementasi Machine Learning untuk Prediksi Cuaca Menggunakan Algoritma Neural Network"
                                    required>{{ old('title', $inputTitle ?? request('title')) }}</textarea>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="me-2" data-feather="search"></i>Cek Plagiarisme
                            </button>
                        </form>
                    </div>
                </div>

                @if (isset($inputTitle))
                    {{-- Card Hasil Analisis --}}
                    @php
                        $colorClass = 'success';
                        $statusText = 'Kecocokan kata penting rendah - relatif aman';
                        if ($maxSimilarity > 70) {
                            $colorClass = 'danger';
                            $statusText = 'Kecocokan kata penting tinggi - perlu revisi signifikan';
                        } elseif ($maxSimilarity > 30) {
                            $colorClass = 'warning';
                            $statusText = 'Kecocokan kata penting sedang - perlu perhatian';
                        }
                    @endphp
                    <div class="card mb-4">
                        <div class="card-header"><i class="me-2" data-feather="bar-chart-2"></i>Hasil Analisis</div>
                        <div class="card-body">
                            <div class="alert alert-{{ $colorClass }} d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="alert-heading">{{ number_format($maxSimilarity, 1) }}% Kecocokan Kata Penting Tertinggi
                                    </h4>
                                    <p class="mb-0">{{ $statusText }}</p>
                                </div>
                                <div class="display-4 fw-bold">{{ number_format($maxSimilarity, 0) }}%</div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $colorClass }}" role="progressbar"
                                    style="width: {{ $maxSimilarity }}%" aria-valuenow="{{ $maxSimilarity }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Daftar Kemiripan Detail --}}
                    @if (!empty($similarities))
                        <div class="card mb-4">
                            <div class="card-header"><i class="me-2" data-feather="list"></i>Daftar Kemiripan Detail</div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">Menampilkan judul dengan kecocokan kata penting > 10%</p>
                                <div class="list-group list-group-flush">
                                    @foreach ($similarities as $similarity)
                                        @if ($similarity['percentage'] > 10)
                                            @php
                                                $itemColorClass = 'secondary';
                                                if ($similarity['percentage'] > 70) {
                                                    $itemColorClass = 'danger';
                                                } elseif ($similarity['percentage'] > 30) {
                                                    $itemColorClass = 'warning';
                                                }
                                            @endphp
                                            <div class="list-group-item">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">{{ $similarity['thesis']->title }}</h6>
                                                    <span
                                                        class="badge bg-{{ $itemColorClass }} rounded-pill">{{ number_format($similarity['percentage'], 1) }}%</span>
                                                </div>
                                                <p class="mb-1 small text-muted">
                                                    {{ $similarity['thesis']->author }}
                                                    ({{ $similarity['thesis']->year }}) -
                                                    {{ $similarity['thesis']->program_study }}
                                                </p>
                                                <a href="{{ route('public.thesis.show', $similarity['thesis']) }}"
                                                    class="small">Lihat Detail →</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Disclaimer --}}
                    <div class="alert alert-primary">
                        <h4 class="alert-heading"><i class="me-2" data-feather="info"></i>Penting untuk Diketahui</h4>
                        <p class="small mb-0">Hasil pengecekan ini hanya berdasarkan kemiripan teks judul dan bukan
                            merupakan analisis plagiarisme yang komprehensif. Untuk analisis yang lebih mendalam, disarankan
                            menggunakan tools plagiarisme profesional.</p>
                    </div>

                @endif

            </div>
        </div>
    </div>
@endsection
