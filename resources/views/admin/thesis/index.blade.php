@extends('layouts.admin')

@section('title', 'Kelola Tugas Akhir - Admin')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white">Kelola Tugas Akhir</h1>
                    <p class="lead mb-0 text-white-50">Panel administrasi pengelolaan naskah tugas akhir & dosen pembimbing</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.thesis.export', request()->query()) }}"
                        class="btn btn-lg btn-success text-white">
                        <i class="me-2" data-feather="download"></i>
                        Ekspor CSV
                    </a>
                    <a href="{{ route('admin.thesis.create') }}" class="btn btn-lg btn-outline-light">
                        <i class="me-2" data-feather="plus"></i>
                        Tambah Data
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <div class="container-xl px-4">
        @php $totalThesis = App\Models\Thesis::count(); @endphp

        <div class="row">
            <div class="col-lg-6 mb-4">
                <a href="{{ route('admin.thesis.index') }}" class="text-decoration-none">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Total Data Tugas Akhir</div>
                                    <div class="text-lg fw-bold">{{ $totalThesis }} Data</div>
                                </div>
                                <i class="feather-xl" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-dark h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-dark-75 small fw-semibold">Data dengan Dosen Pembimbing</div>
                                <div class="text-lg fw-bold">{{ App\Models\Thesis::whereNotNull('pembimbing_1')->count() }} Terisi</div>
                            </div>
                            <i class="feather-xl" data-feather="users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3 fw-bold"><i class="me-2" data-feather="list"></i>Data Tugas Akhir Mahasiswa</div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.thesis.index') }}" class="mb-4">
                    <div class="row gx-3">
                        <div class="col-md-5 mb-3">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Cari judul, penulis, NIM, kata kunci, pembimbing..." class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="angkatan" id="angkatan" class="form-select">
                                <option value="">Semua Angkatan</option>
                                @foreach ($angkatans ?? $years as $ang)
                                    <option value="{{ $ang }}" {{ (request('angkatan', request('year')) == $ang) ? 'selected' : '' }}>
                                        Angkatan {{ $ang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary flex-grow-1"><i class="me-2"
                                        data-feather="filter"></i>Filter</button>
                                <a href="{{ route('admin.thesis.export', request()->query()) }}"
                                    class="btn btn-success text-white" title="Ekspor Data Terfilter"><i
                                        data-feather="download"></i> Ekspor</a>
                                <a href="{{ route('admin.thesis.index') }}" class="btn btn-secondary"
                                    title="Reset Filter"><i data-feather="refresh-cw"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 38%;">Judul & Penulis</th>
                                <th style="width: 25%;">Dosen Pembimbing</th>
                                <th style="width: 12%;">Angkatan</th>
                                <th style="width: 15%;">Kata Kunci</th>
                                <th class="text-end" style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($theses as $thesis)
                                <tr>
                                     <td>
                                        <div class="fw-bold text-dark" style="font-family: 'Lora', serif; font-size: 0.98rem; line-height: 1.35;">{{ $thesis->title }}</div>
                                        <div class="small text-muted mt-1">
                                            <i class="fas fa-user-graduate me-1 text-primary"></i><strong>{{ $thesis->author }}</strong>
                                            @if ($thesis->nim)
                                                <span class="badge bg-light text-dark border ms-1">{{ $thesis->nim }}</span>
                                            @endif
                                        </div>
                                     </td>
                                    <td>
                                        @if($thesis->pembimbing_1)
                                            <div class="small mb-1">
                                                <span class="badge bg-primary bg-opacity-10 text-primary py-0 px-1 me-1">P1</span>
                                                <strong>{{ $thesis->pembimbing_1 }}</strong>
                                            </div>
                                        @endif
                                        @if($thesis->pembimbing_2)
                                            <div class="small text-muted">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary py-0 px-1 me-1">P2</span>
                                                {{ $thesis->pembimbing_2 }}
                                            </div>
                                        @endif
                                        @if(!$thesis->pembimbing_1 && !$thesis->pembimbing_2)
                                            <span class="text-muted small fst-italic">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary text-white">
                                            Angkatan {{ $thesis->angkatan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="small text-muted">{{ Str::limit($thesis->keywords ?: '-', 40) }}</span>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <a href="{{ route('admin.thesis.show', $thesis) }}"
                                            class="btn btn-sm btn-outline-primary" title="Lihat Detail"><i
                                                data-feather="eye"></i></a>
                                        <a href="{{ route('admin.thesis.edit', $thesis) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit Data"><i
                                                data-feather="edit-2"></i></a>
                                        <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete('{{ addslashes($thesis->title) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i
                                                    data-feather="trash-2"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="mx-auto mb-3 text-muted" data-feather="database"
                                            style="width: 48px; height: 48px;"></i>
                                        <h5>Tidak ada data ditemukan</h5>
                                        <p class="text-muted">Data tidak ditemukan sesuai filter atau belum ada data sama sekali.</p>
                                        <a href="{{ route('admin.thesis.create') }}" class="btn btn-primary mt-2">Tambah Data Baru</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($theses->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $theses->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(title) {
            return confirm(`Apakah Anda yakin ingin menghapus tugas akhir "${title}"?\nAksi ini tidak dapat dibatalkan.`);
        }
    </script>
@endsection
