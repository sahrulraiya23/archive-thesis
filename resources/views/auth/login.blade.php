<x-guest-layout>
    <div class="login-body">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark mb-1">Login Admin / Dosen</h4>
            <p class="text-muted small mb-0">Masukan akun resmi untuk mengelola arsip tugas akhir</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3 alert alert-info py-2 px-3 small" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label-academic">
                    <i class="fas fa-envelope me-1 text-primary"></i> Alamat Email Akademik
                </label>
                <div class="input-group-academic">
                    <i class="fas fa-user-shield input-icon-left"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="form-control @error('email') is-invalid @enderror" placeholder="email@uho.ac.id">
                </div>
                @error('email')
                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label-academic mb-0">
                        <i class="fas fa-key me-1 text-primary"></i> Kata Sandi / Password
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">Lupa kata sandi?</a>
                    @endif
                </div>
                <div class="input-group-academic">
                    <i class="fas fa-lock input-icon-left"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                </div>
                @error('password')
                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-4 d-flex align-items-center">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label small text-muted">
                        Ingat saya di perangkat ini
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-academic-login">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk Ke Sistem Admin
            </button>
        </form>
    </div>
</x-guest-layout>
