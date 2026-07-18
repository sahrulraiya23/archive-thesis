@extends('layouts.admin')

@php
    // Menentukan apakah ini form untuk membuat data baru atau mengedit data lama
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
                <p class="lead mb-0 text-white-50">Lengkapi data tugas akhir di bawah ini</p>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div><i class="me-2" data-feather="book-open"></i>Formulir Tugas Akhir</div>
                        <a href="{{ route('admin.thesis.index') }}" class="btn btn-sm btn-light">
                            <i class="me-2" data-feather="arrow-left"></i>Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ $formAction }}">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                <textarea name="title" id="title" rows="3" class="form-control @error('title') is-invalid @enderror"
                                    required>{{ old('title', $thesis->title ?? '') }}</textarea>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" name="author" id="author"
                                    value="{{ old('author', $thesis->author ?? '') }}"
                                    class="form-control @error('author') is-invalid @enderror" required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">Jenis <span
                                            class="text-danger">*</span></label>
                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($types as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('type', $thesis->type ?? '') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label">Tahun <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="year" id="year"
                                        value="{{ old('year', $thesis->year ?? date('Y')) }}" min="1900"
                                        max="{{ date('Y') + 1 }}" class="form-control @error('year') is-invalid @enderror"
                                        required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="program_study" class="form-label">Program Studi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="program_study" id="program_study"
                                    value="{{ old('program_study', $thesis->program_study ?? '') }}"
                                    class="form-control @error('program_study') is-invalid @enderror" required>
                                @error('program_study')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="abstract" class="form-label">Abstrak <span class="text-danger">*</span></label>
                                <textarea name="abstract" id="abstract" rows="8" class="form-control @error('abstract') is-invalid @enderror"
                                    required>{{ old('abstract', $thesis->abstract ?? '') }}</textarea>
                                @error('abstract')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.thesis.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
