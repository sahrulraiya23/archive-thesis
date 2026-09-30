@extends('layouts.admin')

@section('title', 'Detail Tugas Akhir (Admin)')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white">Detail Tugas Akhir</h1>
                    <p class="lead mb-0 text-white-50">Tinjau detail data tugas akhir mahasiswa & dosen pembimbing</p>
                </div>
                <div>
                    <a href="{{ route('admin.thesis.edit', $thesis) }}" class="btn btn-warning me-2">
                        <i class="me-1" data-feather="edit-2"></i>Edit Data
                    </a>
                    <a href="{{ route('admin.thesis.index') }}" class="btn btn-light">
                        <i class="me-1" data-feather="arrow-left"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="me-1" data-feather="calendar"></i>Angkatan {{ $thesis->angkatan }}
                                </span>
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    {{ $thesis->program_study ?: 'S1 Teknik Informatika' }}
                                </span>
                            </div>
                            <span class="text-muted small">
                                <i class="me-1" data-feather="clock"></i>Dibuat: {{ $thesis->created_at ? $thesis->created_at->format('d M Y H:i') : '-' }}
                            </span>
                        </div>
                        <h2 class="card-title fw-bold text-dark mb-3" style="font-family: 'Lora', Georgia, serif; line-height: 1.4;">
                            {{ $thesis->title }}
                        </h2>

                        <div class="row gx-4 mt-3 p-3 bg-light rounded">
                            <div class="col-md-5">
                                <p class="small text-muted mb-0">Nama Penulis / Mahasiswa</p>
                                <p class="fw-bold mb-0 text-primary">{{ $thesis->author }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="small text-muted mb-0">NIM (Nomor Induk Mahasiswa)</p>
                                <p class="fw-bold mb-0 text-dark">{{ $thesis->nim ?: '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="small text-muted mb-0">Angkatan</p>
                                <p class="fw-bold mb-0 text-dark">{{ $thesis->angkatan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        {{-- Dosen Pembimbing --}}
                        <div class="mb-4 p-3 border rounded bg-white">
                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-chalkboard-teacher text-primary me-2"></i>Dosen Pembimbing</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                                        <span class="badge bg-primary text-white mb-1">Pembimbing I (Utama)</span>
                                        <div class="fw-bold text-dark">{{ $thesis->pembimbing_1 ?: 'Belum ditentukan' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded border-start border-secondary border-3">
                                        <span class="badge bg-secondary text-white mb-1">Pembimbing II (Pendamping)</span>
                                        <div class="fw-bold text-dark">{{ $thesis->pembimbing_2 ?: 'Belum ditentukan' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Abstrak --}}
                        <h5 class="mb-3 fw-bold text-dark"><i class="me-2" data-feather="file-text"></i>Abstrak</h5>
                        <div class="p-4 rounded mb-4" style="background-color: #fafbfc; border-left: 4px solid #0f2c59; text-align: justify; font-family: 'Lora', Georgia, serif; line-height: 1.8;">
                            <p class="mb-0">{!! nl2br(e($thesis->abstract)) !!}</p>
                        </div>

                        {{-- Kata Kunci --}}
                        @if (!empty($thesis->keyword_array))
                            <div class="p-3 bg-light rounded border mb-4">
                                <h6 class="fw-bold text-dark mb-2">
                                    <i class="fas fa-tags text-primary me-2"></i>Kata Kunci / Keywords:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($thesis->keyword_array as $kw)
                                        @if ($kw !== '')
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                                                #{{ $kw }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer p-4 bg-light d-flex justify-content-between align-items-center">
                        <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus tugas akhir ini? Aksi ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="me-1" data-feather="trash-2"></i>Hapus Tugas Akhir
                            </button>
                        </form>
                        <a href="{{ route('public.thesis.show', $thesis) }}" target="_blank"
                            class="btn btn-primary">
                            <i class="me-1" data-feather="external-link"></i>Lihat di Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
