<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#fdf8f2" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'PawHaven — Premium Pet Shop')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,800;1,9..144,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>
        .navbar { padding-left: env(safe-area-inset-left); padding-right: env(safe-area-inset-right); }
        .footer-bottom { padding-bottom: max(24px, env(safe-area-inset-bottom)); }

        .flash-toast {
            position: fixed; top: 84px; right: 20px; z-index: 9000;
            background: var(--bark, #2D241E); color: #fff; font-size: 0.88rem; font-weight: 500;
            padding: 12px 20px; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transition: opacity 0.4s ease, transform 0.4s ease; max-width: calc(100vw - 40px);
            animation: slideInToast 0.3s ease;
        }
        @keyframes slideInToast {
            from { opacity: 0; transform: translateX(100px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /*
         * ── FIX: Scope modal-overlay styles to ONLY #loginModal and #signupModal.
         *
         * Previously this used the generic `.modal-overlay` class selector, which
         * caused a CSS conflict: welcome.blade.php and shop.blade.php also use
         * `.modal-overlay` on their own modals, and the `opacity:0; visibility:hidden`
         * here would override their show logic — the scrollbar disappeared (JS ran)
         * but the modal stayed invisible (CSS kept it hidden).
         *
         * By scoping to IDs we isolate this layout's modals and leave child-view
         * modals free to define their own show/hide behaviour.
         * ────────────────────────────────────────────────────────────────────────
         */
        #loginModal,
        #signupModal {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(45, 36, 30, 0.65);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999;
            opacity: 0; visibility: hidden; pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
        }
        #loginModal.active,
        #signupModal.active {
            opacity: 1; visibility: visible; pointer-events: auto;
        }

        .modal-box {
            background: #ffffff; border-radius: 24px; padding: 32px 28px;
            max-width: 440px; width: 92%; max-height: 90vh; overflow-y: auto;
            position: relative; box-shadow: 0 24px 80px rgba(0,0,0,0.25);
            animation: modalPop 0.25s ease;
        }
        @keyframes modalPop {
            from { transform: scale(0.96) translateY(-10px); opacity: 0; }
            to   { transform: scale(1) translateY(0); opacity: 1; }
        }
        .modal-close {
            position: absolute; top: 16px; right: 16px;
            background: #f5f0e8; border: none; border-radius: 50%;
            width: 36px; height: 36px; font-size: 1.4rem;
            color: #8c7e74; cursor: pointer; display: flex;
            align-items: center; justify-content: center;
            transition: background 0.2s, color 0.2s;
        }
        .modal-close:hover { background: #e6ddd4; color: #2d241e; }
        .modal-header { text-align: center; margin-bottom: 24px; }
        .modal-paw { font-size: 2rem; display: block; margin-bottom: 8px; }
        .modal-header h2 {
            font-family: 'Fraunces', serif; font-size: 1.6rem;
            color: #2d241e; margin: 0 0 6px; font-weight: 700;
        }
        .modal-header p { color: #8c7e74; font-size: 0.95rem; margin: 0; }
        .modal-error {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #991b1b; padding: 12px 16px; border-radius: 12px;
            font-size: 0.88rem; margin-bottom: 20px;
        }
        .modal-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #166534; padding: 12px 16px; border-radius: 12px;
            font-size: 0.88rem; margin-bottom: 20px; display: none;
        }
        .modal-form .form-group { margin-bottom: 18px; }
        .modal-form label {
            display: block; font-size: 0.88rem; font-weight: 600;
            color: #2d241e; margin-bottom: 6px;
        }
        .modal-form input[type="email"],
        .modal-form input[type="password"],
        .modal-form input[type="text"] {
            width: 100%; padding: 12px 16px; border: 1.5px solid #e6ddd4;
            border-radius: 12px; font-size: 1rem; background: #faf8f5;
            color: #2d241e; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .modal-form input:focus {
            outline: none; border-color: #e68a39;
            box-shadow: 0 0 0 4px rgba(230,138,57,0.15);
        }
        .password-wrap { position: relative; }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; font-size: 1.1rem;
            cursor: pointer; color: #8c7e74; padding: 4px;
        }
        .form-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; font-size: 0.88rem;
        }
        .checkbox-label { display: flex; align-items: center; gap: 6px; color: #5c4d3c; cursor: pointer; }
        .checkbox-label input { accent-color: #e68a39; }
        .forgot-link { color: #e68a39; font-weight: 500; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }
        .btn-login {
            width: 100%; background: #e68a39; color: #fff; border: none;
            padding: 14px; border-radius: 30px; font-size: 1rem;
            font-weight: 700; cursor: pointer; transition: background 0.2s;
        }
        .btn-login:hover { background: #cf7529; }
        .btn-login:disabled { background: #e6ddd4; cursor: not-allowed; }
        .modal-register {
            text-align: center; margin-top: 20px; color: #8c7e74; font-size: 0.9rem;
        }
        .modal-register a { color: #e68a39; font-weight: 600; text-decoration: none; }
        .modal-register a:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .modal-box { padding: 24px 20px; border-radius: 20px; }
            .modal-header h2 { font-size: 1.4rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    @yield('content')

    {{-- Flash Success Toast --}}
    @if(session('success'))
        <div class="flash-toast" data-flash>🐾 {{ session('success') }}</div>
    @endif

    {{-- ── LOGIN MODAL ── --}}
    <div id="loginModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-box">
            <button class="modal-close" id="closeModal" aria-label="Close login modal">&times;</button>
            <div class="modal-header">
                <span class="modal-paw">🐾</span>
                <h2 id="modalTitle">Welcome Back</h2>
                <p>Sign in to your PawHaven account</p>
            </div>

            <div id="loginError" class="modal-error" style="display:none;"></div>
            <div id="loginSuccess" class="modal-success"></div>

            <form id="ajaxLoginForm" class="modal-form">
                @csrf
                <div class="form-group">
                    <label for="modal_email">Email Address</label>
                    <input type="email" id="modal_email" name="email"
                           placeholder="you@example.com" required />
                </div>
                <div class="form-group">
                    <label for="modal_password">Password</label>
                    <div class="password-wrap">
                        <input type="password" id="modal_password" name="password"
                               placeholder="••••••••" required />
                        <button type="button" class="toggle-pw" id="togglePw"
                                aria-label="Toggle password visibility">👁</button>
                    </div>
                </div>
                <div class="form-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" />
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>
                <button type="submit" class="btn-login" id="loginSubmitBtn">Sign In</button>
            </form>
            <p class="modal-register">
                New to PawHaven? <a href="#" id="openSignupBtn">Create an account</a>
            </p>
        </div>
    </div>

    {{-- ── SIGNUP MODAL ── --}}
    <div id="signupModal" role="dialog" aria-modal="true" aria-labelledby="signupTitle">
        <div class="modal-box">
            <button class="modal-close" id="closeSignupModal" aria-label="Close signup modal">&times;</button>
            <div class="modal-header">
                <span class="modal-paw">🐾</span>
                <h2 id="signupTitle">Join the Pack</h2>
                <p>Create your PawHaven account</p>
            </div>

            <div id="signupError" class="modal-error" style="display:none;"></div>
            <div id="signupSuccess" class="modal-success"></div>

            <form id="ajaxSignupForm" class="modal-form">
                @csrf
                <div class="form-group">
                    <label for="reg_name">Full Name</label>
                    <input type="text" id="reg_name" name="name"
                           placeholder="Your Name" required />
                </div>
                <div class="form-group">
                    <label for="reg_email">Email Address</label>
                    <input type="email" id="reg_email" name="email"
                           placeholder="you@example.com" required />
                </div>
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <input type="password" id="reg_password" name="password"
                           placeholder="••••••••" minlength="8" required />
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="••••••••" minlength="8" required />
                </div>
                <button type="submit" class="btn-login" id="signupSubmitBtn">Create Account</button>
            </form>
            <p class="modal-register">
                Already have an account? <a href="#" id="switchToLogin">Sign In</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        // ── Flash Toast Auto-Hide ──
        const flashToast = document.querySelector('[data-flash]');
        if (flashToast) {
            setTimeout(() => {
                flashToast.style.opacity   = '0';
                flashToast.style.transform = 'translateX(100px)';
                setTimeout(() => flashToast.remove(), 400);
            }, 4000);
        }

        // ── Modal Utilities ──
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            const firstInput = modal.querySelector('input');
            if (firstInput) setTimeout(() => firstInput.focus(), 100);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('active');
            document.body.style.overflow = '';
            const form = modal.querySelector('form');
            if (form) form.reset();
            const errorEl   = modal.querySelector('.modal-error');
            const successEl = modal.querySelector('.modal-success');
            if (errorEl)   errorEl.style.display   = 'none';
            if (successEl) successEl.style.display = 'none';
        }

        // ── Password Toggle ──
        const togglePw      = document.getElementById('togglePw');
        const passwordInput = document.getElementById('modal_password');
        if (togglePw && passwordInput) {
            togglePw.addEventListener('click', function () {
                const type      = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type  = type;
                this.textContent    = type === 'password' ? '👁' : '🙈';
            });
        }

        // ── Close Buttons ──
        document.getElementById('closeModal')?.addEventListener('click', () => closeModal('loginModal'));
        document.getElementById('closeSignupModal')?.addEventListener('click', () => closeModal('signupModal'));

        // ── Close on Backdrop Click ──
        document.getElementById('loginModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeModal('loginModal');
        });
        document.getElementById('signupModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeModal('signupModal');
        });

        // ── Switch Between Login / Signup ──
        document.getElementById('openSignupBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal('loginModal');
            setTimeout(() => openModal('signupModal'), 250);
        });
        document.getElementById('switchToLogin')?.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal('signupModal');
            setTimeout(() => openModal('loginModal'), 250);
        });

        // ── Open Login Modal from any #openAuthModal button ──
        // (welcome.blade.php has its own modal; this only triggers on other pages)
        document.getElementById('openAuthModal')?.addEventListener('click', function (e) {
            // If the welcome page already handles this, its listener runs too.
            // We only open the layout modal if the welcome auth modal doesn't exist.
            if (!document.getElementById('authModal')) {
                e.preventDefault();
                openModal('loginModal');
            }
        });

        // ── AJAX Login ──────────────────────────────────────────────────────
        document.getElementById('ajaxLoginForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const email     = document.getElementById('modal_email')?.value;
            const password  = document.getElementById('modal_password')?.value;
            const remember  = this.querySelector('input[name="remember"]')?.checked || false;
            const submitBtn = document.getElementById('loginSubmitBtn');
            const errorEl   = document.getElementById('loginError');
            const successEl = document.getElementById('loginSuccess');

            if (errorEl)   errorEl.style.display   = 'none';
            if (successEl) successEl.style.display = 'none';

            if (submitBtn) {
                submitBtn.disabled    = true;
                submitBtn.textContent = 'Signing in…';
            }

            fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password, remember }),
            })
            .then(async res => {
                const data = await res.json().catch(() => ({}));

                if (submitBtn) {
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Sign In';
                }

                if (res.ok && data.success) {
                    if (successEl) {
                        successEl.textContent  = '✅ Login successful! Redirecting…';
                        successEl.style.display = 'block';
                    }
                    setTimeout(() => {
                        window.location.href = data.redirect || "{{ route('shop') }}";
                    }, 800);
                } else {
                    let msg = data.message || 'Invalid credentials.';
                    if (data.errors?.email) msg = data.errors.email[0];
                    if (errorEl) {
                        errorEl.textContent  = '❌ ' + msg;
                        errorEl.style.display = 'block';
                    }
                }
            })
            .catch(() => {
                if (submitBtn) {
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Sign In';
                }
                if (errorEl) {
                    errorEl.textContent  = '❌ Connection error. Please try again.';
                    errorEl.style.display = 'block';
                }
            });
        });

        // ── AJAX Signup ─────────────────────────────────────────────────────
        document.getElementById('ajaxSignupForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const name      = document.getElementById('reg_name')?.value?.trim();
            const email     = document.getElementById('reg_email')?.value?.trim();
            const password  = document.getElementById('reg_password')?.value;
            const confirm   = document.getElementById('password_confirmation')?.value;
            const submitBtn = document.getElementById('signupSubmitBtn');
            const errorEl   = document.getElementById('signupError');
            const successEl = document.getElementById('signupSuccess');

            if (errorEl)   errorEl.style.display   = 'none';
            if (successEl) successEl.style.display = 'none';

            // Client-side validation
            if (password !== confirm) {
                if (errorEl) { errorEl.textContent = '❌ Passwords do not match.'; errorEl.style.display = 'block'; }
                return;
            }
            if (password.length < 8) {
                if (errorEl) { errorEl.textContent = '❌ Password must be at least 8 characters.'; errorEl.style.display = 'block'; }
                return;
            }
            if (!/[A-Z]/.test(password)) {
                if (errorEl) { errorEl.textContent = '❌ Password must include an uppercase letter.'; errorEl.style.display = 'block'; }
                return;
            }
            if (!/[0-9]/.test(password)) {
                if (errorEl) { errorEl.textContent = '❌ Password must include a number.'; errorEl.style.display = 'block'; }
                return;
            }

            if (submitBtn) {
                submitBtn.disabled    = true;
                submitBtn.textContent = 'Creating…';
            }

            fetch("{{ route('register') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: confirm,
                }),
            })
            .then(async res => {
                const data = await res.json().catch(() => ({}));

                if (submitBtn) {
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Create Account';
                }

                if ((res.ok || res.status === 201) && data.success) {
                    if (successEl) {
                        successEl.textContent  = '✅ Account created! Please sign in. 🎉';
                        successEl.style.display = 'block';
                    }
                    setTimeout(() => {
                        closeModal('signupModal');
                        setTimeout(() => openModal('loginModal'), 300);
                    }, 1500);
                } else {
                    let msg = 'Registration failed.';
                    if (data.errors) msg = Object.values(data.errors)[0][0];
                    else if (data.message) msg = data.message;
                    if (errorEl) {
                        errorEl.textContent  = '❌ ' + msg;
                        errorEl.style.display = 'block';
                    }
                }
            })
            .catch(() => {
                if (submitBtn) {
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Create Account';
                }
                if (errorEl) {
                    errorEl.textContent  = '❌ Connection error. Please try again.';
                    errorEl.style.display = 'block';
                }
            });
        });

        // ── Forgot Password ──
        document.querySelector('.forgot-link')?.addEventListener('click', function (e) {
            e.preventDefault();
            @if(Route::has('password.request'))
                closeModal('loginModal');
                window.location.href = "{{ route('password.request') }}";
            @else
                const errorEl = document.getElementById('loginError');
                if (errorEl) {
                    errorEl.innerHTML     = 'ℹ️ Password reset coming soon! Contact <a href="mailto:support@pawhaven.ph" style="color:#e68a39;">support@pawhaven.ph</a>.';
                    errorEl.style.display = 'block';
                }
            @endif
        });

        // ── Escape Key ──
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal('loginModal');
                closeModal('signupModal');
            }
        });
    });
    </script>

    @stack('scripts')
</body>
</html>