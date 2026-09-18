<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center bg-light min-vh-100">

    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="fw-bold text-center mb-1">🏫 Login Admin</h4>
            <p class="text-muted text-center small mb-4">Sistem Inventaris Sekolah</p>

            @if (session('lockout_seconds'))
                <div id="lockoutAlert" class="alert alert-warning small d-flex align-items-center gap-2" role="alert">
                    <span>⏳</span>
                    <span>
                        Terlalu banyak percobaan login yang gagal. Silakan tunggu
                        <strong><span id="lockoutCountdown">{{ session('lockout_seconds') }}</span> detik</strong>
                        sebelum mencoba lagi.
                    </span>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="loginEmail" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="loginPassword" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="loginSubmitBtn">Login</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="small text-muted">&larr; Kembali ke halaman publik</a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const countdownEl = document.getElementById('lockoutCountdown');
            if (!countdownEl) {
                return;
            }

            const alertEl = document.getElementById('lockoutAlert');
            const submitBtn = document.getElementById('loginSubmitBtn');
            const emailInput = document.getElementById('loginEmail');
            const passwordInput = document.getElementById('loginPassword');

            let seconds = parseInt(countdownEl.textContent, 10) || 0;

            const originalBtnText = submitBtn.textContent;

            function lockForm() {
                submitBtn.disabled = true;
                emailInput.disabled = true;
                passwordInput.disabled = true;
                submitBtn.textContent = `Tunggu ${seconds} detik...`;
            }

            function unlockForm() {
                submitBtn.disabled = false;
                emailInput.disabled = false;
                passwordInput.disabled = false;
                submitBtn.textContent = originalBtnText;
                alertEl.classList.remove('alert-warning');
                alertEl.classList.add('alert-success');
                alertEl.innerHTML = '<span>✅</span><span>Jeda selesai, silakan coba login lagi.</span>';
            }

            if (seconds > 0) {
                lockForm();

                const timer = setInterval(() => {
                    seconds -= 1;

                    if (seconds <= 0) {
                        clearInterval(timer);
                        unlockForm();
                        return;
                    }

                    countdownEl.textContent = seconds;
                    submitBtn.textContent = `Tunggu ${seconds} detik...`;
                }, 1000);
            }
        })();
    </script>

</body>
</html>