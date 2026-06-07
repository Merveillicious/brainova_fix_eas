<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - Brainova</title>
    @vite('resources/css/app.css')
</head>
<body class="auth-page">
    <div class="auth-topbar">
        <a href="{{ url('/') }}" class="brand">
            Brainova
        </a>
        <a href="{{ route('register') }}" class="btn-topbar">Sign up</a>
    </div>

    <div class="auth-main">
        <div class="auth-container">
            <h1 class="auth-title">Log in</h1>
            <p class="auth-subtitle">
                <a href="{{ route('register') }}">Sign up as a student</a> or
                <a href="{{ route('register') }}?role=tutor">Sign up as a tutor</a>
            </p>

            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <a href="#" class="btn-social">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" height="20" alt="Google">
                Continue with Google
            </a>
            <a href="#" class="btn-social">
                <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" width="20" height="20" alt="Facebook">
                Continue with Facebook
            </a>
            <a href="#" class="btn-social">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="black"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.56-1.702z"/></svg>
                Continue with Apple
            </a>

            <div class="auth-divider"><span>or</span></div>

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autocomplete="email">
                    <span class="field-error" id="emailErr" style="color:#b91c1c;font-size:12px;display:none;">Email tidak valid.</span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-box">
                        <input type="password" id="password" name="password" class="input-field" placeholder="Masukkan password" required minlength="6">
                        <button type="button" class="eye-icon" id="togglePassword">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <label for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn-login">Log in</button>
            </form>
        </div>
    </div>
    
    <div class="auth-footer">
        &copy; 2026 Brainova
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passInput = document.getElementById('password');
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', () => {
                const type = passInput.type === 'password' ? 'text' : 'password';
                passInput.type = type;
                toggleBtn.style.opacity = type === 'text' ? '0.5' : '1';
            });
        }

        // Frontend validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let valid = true;
            const email = document.getElementById('email');
            const pass  = document.getElementById('password');
            const emailErr = document.getElementById('emailErr');

            // Reset
            [email, pass].forEach(el => el.style.borderColor = '');
            emailErr.style.display = 'none';

            if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.style.borderColor = '#ef4444';
                emailErr.style.display = 'block';
                valid = false;
            }
            if (!pass.value || pass.value.length < 6) {
                pass.style.borderColor = '#ef4444';
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    </script>
</body>
</html>
