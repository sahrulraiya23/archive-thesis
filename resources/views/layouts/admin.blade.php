<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    {{-- Judul Halaman Dinamis --}}
    <title>@yield('title', 'Dashboard') - Sistem Arsip TA</title>

    <!-- Google Fonts: Inter, Poppins, Lora & Merriweather (Academic Serifs) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- (PERBAIKAN 1) Menggunakan asset() untuk memuat CSS --}}
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />

    {{-- (PERBAIKAN 2) Menggunakan asset() untuk memuat Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />

    <!-- Script untuk Ikon (FontAwesome & Feather) dari CDN -->
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

</head>

<body class="nav-fixed">

    {{-- Memanggil Header --}}
    @include('layouts.partials.header')

    <div id="layoutSidenav">
        {{-- Memanggil Sidebar --}}
        @include('layouts.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                {{-- Konten Utama Halaman --}}
                @yield('content')
            </main>

            {{-- Memanggil Footer --}}
            @include('layouts.partials.footer')
        </div>
    </div>

    {{-- Script JavaScript Utama --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    {{-- (PERBAIKAN 3) Inisialisasi Feather Icons --}}
    <script>
        feather.replace();
    </script>

</body>

</html>
