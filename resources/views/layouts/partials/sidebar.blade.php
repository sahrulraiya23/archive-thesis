<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                <div class="sidenav-menu-heading">Core</div>

                <a class="nav-link" href="{{ route('public.thesis.index') }}">
                    <div class="nav-link-icon"><i data-feather="globe"></i></div>
                    Daftar TA
                </a>
                <a class="nav-link" href="{{ route('plagiarism.check') }}">
                    <div class="nav-link-icon"><i data-feather="globe"></i></div>
                    Cek Plagiarisme Judul
                </a>

                {{-- Tampilkan menu ini hanya untuk user yang login --}}
                @auth
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        Dashboard
                    </a>


                    {{-- Tampilkan menu ini hanya untuk admin --}}
                    @if (Auth::user()->role === 'admin')
                        <div class="sidenav-menu-heading">Manajemen</div>
                        <a class="nav-link" href="{{ route('admin.thesis.index') }}">
                            <div class="nav-link-icon"><i data-feather="book-open"></i></div>
                            Tugas Akhir
                        </a>
                    @endif

                @endauth

            </div>
        </div>

        {{-- Sidenav Footer (HANYA TAMPIL JIKA USER LOGIN) --}}
        @auth
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
                </div>
            </div>
        @endauth
    </nav>
</div>
