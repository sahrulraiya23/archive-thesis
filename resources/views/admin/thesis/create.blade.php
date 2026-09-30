@extends('layouts.admin')

@php
    $isEdit = isset($thesis);
    $formAction = $isEdit ? route('admin.thesis.update', $thesis) : route('admin.thesis.store');
@endphp

@section('title', $isEdit ? 'Edit Tugas Akhir' : 'Tambah Tugas Akhir')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white">{{ $isEdit ? 'Edit Tugas Akhir' : 'Tambah Tugas Akhir' }}</h1>
                <p class="lead mb-0 text-white-50">Lengkapi data tugas akhir dan dosen pembimbing di bawah ini</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div class="fw-bold text-primary"><i class="me-2" data-feather="book-open"></i>Formulir Data Tugas Akhir</div>
                        <a href="{{ route('admin.thesis.index') }}" class="btn btn-sm btn-light">
                            <i class="me-2" data-feather="arrow-left"></i>Kembali
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ $formAction }}">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            {{-- Judul --}}
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Judul Tugas Akhir <span class="text-danger">*</span></label>
                                <textarea name="title" id="title" rows="3" class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan judul tugas akhir lengkap..." required>{{ old('title', $thesis->title ?? '') }}</textarea>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penulis, NIM, Angkatan --}}
                            <div class="row gx-3 mb-3">
                                <div class="col-md-5 mb-3">
                                    <label for="author" class="form-label fw-bold">Nama Penulis / Mahasiswa <span class="text-danger">*</span></label>
                                    <input type="text" name="author" id="author"
                                        value="{{ old('author', $thesis->author ?? '') }}"
                                        placeholder="Nama lengkap mahasiswa"
                                        class="form-control @error('author') is-invalid @enderror" required>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nim" class="form-label fw-bold">NIM (Nomor Induk Mahasiswa)</label>
                                    <input type="text" name="nim" id="nim"
                                        value="{{ old('nim', $thesis->nim ?? '') }}"
                                        placeholder="Contoh: E1E122001"
                                        class="form-control @error('nim') is-invalid @enderror">
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="angkatan" class="form-label fw-bold">Angkatan <span class="text-danger">*</span></label>
                                    <input type="number" name="angkatan" id="angkatan"
                                        value="{{ old('angkatan', $thesis->angkatan ?? $thesis->year ?? date('Y')) }}"
                                        min="1990" max="{{ date('Y') + 5 }}"
                                        placeholder="Contoh: 2022"
                                        class="form-control @error('angkatan') is-invalid @enderror" required>
                                    @error('angkatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Dosen Pembimbing --}}
                            <div class="card bg-light border-0 mb-4 p-3">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Dosen Pembimbing</h6>
                                <div class="row gx-3">
                                    <div class="col-md-6 mb-2">
                                        <label for="pembimbing_1" class="form-label fw-semibold small">Dosen Pembimbing I (Utama)</label>
                                        <input type="text" name="pembimbing_1" id="pembimbing_1"
                                            value="{{ old('pembimbing_1', $thesis->pembimbing_1 ?? '') }}"
                                            placeholder="Contoh: Statiswaty, ST., MM.Si."
                                            class="form-control @error('pembimbing_1') is-invalid @enderror">
                                        @error('pembimbing_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="pembimbing_2" class="form-label fw-semibold small">Dosen Pembimbing II (Pendamping)</label>
                                        <input type="text" name="pembimbing_2" id="pembimbing_2"
                                            value="{{ old('pembimbing_2', $thesis->pembimbing_2 ?? '') }}"
                                            placeholder="Contoh: Asa Hari Wibowo, S.T., M.Kom."
                                            class="form-control @error('pembimbing_2') is-invalid @enderror">
                                        @error('pembimbing_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Kata Kunci --}}
                            <div class="mb-4">
                                <label for="keywords" class="form-label fw-bold">Kata Kunci (Keywords)</label>
                                <textarea name="keywords" id="keywords" rows="2" class="form-control @error('keywords') is-invalid @enderror"
                                    placeholder="Contoh: SHA-256, Autentikasi Dokumen, QR Code, PDF (atau kosongkan untuk ekstraksi otomatis dari judul)">{{ old('keywords', $thesis->keywords ?? '') }}</textarea>
                                <small class="form-text text-muted">Pisahkan dengan koma. Jika dikosongkan, sistem otomatis mengekstrak kata kunci signifikan dari judul.</small>
                                @error('keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Abstrak --}}
                            <div class="mb-4">
                                <label for="abstract" class="form-label fw-bold">Abstrak Naskah <span class="text-danger">*</span></label>
                                <textarea name="abstract" id="abstract" rows="8" class="form-control @error('abstract') is-invalid @enderror"
                                    required>{{ old('abstract', $thesis->abstract ?? '') }}</textarea>
                                @error('abstract')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('admin.thesis.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                    <i class="me-1" data-feather="check"></i> {{ $isEdit ? 'Update Tugas Akhir' : 'Simpan Tugas Akhir' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
