<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Sekolah')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                🏫 Inventaris Sekolah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('inventaris.*') ? 'active fw-semibold' : '' }}" href="{{ route('inventaris.index') }}">Daftar Inventaris</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link btn btn-link border-0 bg-transparent"
                                data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login Admin
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} Sistem Inventaris Sekolah. Seluruh hak cipta dilindungi.
        </div>
    </footer>

    {{-- Modal Login Admin — muncul di halaman publik manapun, tanpa pindah halaman --}}
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">🏫 Login Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Khusus administrator Sistem Inventaris Sekolah.</p>

                    @if ($errors->has('email'))
                        <div class="alert alert-danger small py-2">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="loginModalRemember">
                            <label class="form-check-label" for="loginModalRemember">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{--
        Buka otomatis modal Login jika:
        - pengunjung datang dari link/redirect yang menyertakan ?login=1
          (misalnya diarahkan oleh middleware karena mencoba akses /admin tanpa login), atau
        - percobaan login sebelumnya gagal (ada error validasi pada field 'email').
    --}}
    @if (request()->boolean('login') || $errors->has('email'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('loginModal');
                if (el) {
                    new bootstrap.Modal(el).show();
                }
            });
        </script>
    @endif

    @livewireScripts
</body>
</html>
