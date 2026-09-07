@extends('layouts.admin')

@section('title', 'Detail Tugas Akhir (Admin)')

@section('content')
    {{-- Header Halaman --}}
    <header class.="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white">Detail Tugas Akhir</h1>
                    <p class="lead mb-0 text-white-50">Tinjau detail data tugas akhir</p>
                </div>
                <div>
                    <a href="{{ route('admin.thesis.edit', $thesis) }}" class="btn btn-warning">
                        <i class="me-2" data-feather="edit-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.thesis.index') }}" class="btn btn-light">
                        <i class="me-2" data-feather="arrow-left"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span
                                    class="badge bg-primary bg-opacity-25 text-primary">{{ $thesis->type_code_upper }}</span>
                                <span class="text-muted ms-2"><i class="me-1"
                                        data-feather="calendar"></i>{{ $thesis->year }}</span>
                            </div>
                            <span class="text-muted small">Dibuat: {{ $thesis->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <h1 class="card-title">{{ $thesis->title }}</h1>
                        <div class="row gx-4 mt-4">
                            <div class="col-md-12">
                                <p class="small text-muted mb-0">Penulis</p>
                                <p class="fw-bold mb-0">{{ $thesis->author }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="mb-3"><i class="me-2" data-feather="file-text"></i>Abstrak</h4>
                        <div class="bg-light p-3 rounded" style="text-align: justify;">
                            <p>{!! nl2br(e($thesis->abstract)) !!}</p>
                        </div>
                    </div>
                    <div class="card-footer p-4 bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus tugas akhir ini? Aksi ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="me-2" data-feather="trash-2"></i>Hapus Tugas Akhir
                                </button>
                            </form>
                            <a href="{{ route('public.thesis.show', $thesis) }}" target="_blank"
                                class="btn btn-outline-primary">
                                <i class="me-2" data-feather="external-link"></i>Lihat di Halaman Publik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
