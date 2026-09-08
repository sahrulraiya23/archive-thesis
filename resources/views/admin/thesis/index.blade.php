@extends('layouts.admin')

@section('title', 'Kelola Tugas Akhir - Admin')

@section('content')
    {{-- Header Halaman --}}
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-white">Kelola Tugas Akhir</h1>
                    <p class="lead mb-0 text-white-50">Panel administrasi untuk mengelola data tugas akhir</p>
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
                                    <div class="text-white-75 small">Total Data</div>
                                    <div class="text-lg fw-bold">{{ $totalThesis }}</div>
                                </div>
                                <i class="feather-xl" data-feather="database"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="me-2" data-feather="list"></i>Data Tugas Akhir</div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.thesis.index') }}" class="mb-4">
                    <div class="row gx-3">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Cari judul atau penulis..." class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="year" id="year" class="form-select">
                                <option value="">Semua Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary flex-grow-1"><i class="me-2"
                                        data-feather="filter"></i>Filter</button>
                                <a href="{{ route('admin.thesis.export', request()->query()) }}"
                                    class="btn btn-success text-white" title="Ekspor Data Terfilter"><i
                                        data-feather="download"></i></a>
                                <a href="{{ route('admin.thesis.index') }}" class="btn btn-secondary"
                                    title="Reset Filter"><i data-feather="refresh-cw"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul & Penulis</th>
                                <th>Kata Kunci</th>
                                <th>Tahun</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($theses as $thesis)
                                <tr>
                                     <td>
                                        <div class="fw-bold">{{ $thesis->title }}</div>
                                        <div class="small text-muted">
                                            <strong>{{ $thesis->author }}</strong>
                                            @if ($thesis->nim)
                                                <span class="badge bg-light text-dark border ms-1">NIM: {{ $thesis->nim }}</span>
                                            @endif
                                        </div>
                                     </td>
                                    <td>{{ $thesis->keywords ?: '-' }}</td>
                                    <td>{{ $thesis->year }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.thesis.show', $thesis) }}"
                                            class="btn btn-sm btn-outline-primary" title="Lihat"><i
                                                data-feather="eye"></i></a>
                                        <a href="{{ route('admin.thesis.edit', $thesis) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit"><i
                                                data-feather="edit-2"></i></a>
                                        <form action="{{ route('admin.thesis.destroy', $thesis) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete('{{ $thesis->title }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i
                                                    data-feather="trash-2"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="mx-auto mb-3" data-feather="database"
                                            style="width: 48px; height: 48px;"></i>
                                        <h5>Tidak ada data ditemukan</h5>
                                        <p class="text-muted">Data tidak ditemukan sesuai filter atau belum ada data sama
                                            sekali.</p>
                                        <a href="{{ route('admin.thesis.create') }}" class="btn btn-primary mt-2">Tambah
                                            Data Pertama</a>
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
