<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />

    <meta name="mobile-web-app-capable" content="yes" />

    <meta name="apple-apple-web-app-capable" content="yes" />

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

            background: var(--bark); color: #fff; font-size: 0.88rem; font-weight: 500;

            padding: 12px 20px; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.18);

            transition: opacity 0.4s ease, transform 0.4s ease; max-width: calc(100vw - 40px);

        }

    </style>

    @stack('styles')

</head>

<body>



    @yield('content')



    @if(session('success'))

        <div class="flash-toast" data-flash>🐾 {{ session('success') }}</div>

    @endif



    <div id="loginModal" class="modal-overlay {{ session('show_login') ? 'active' : '' }}" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="modal-box">

            <button class="modal-close" id="closeModal" aria-label="Close login modal">&times;</button>

            <div class="modal-header">

                <span class="modal-paw">🐾</span>

                <h2 id="modalTitle">Welcome Back</h2>

                <p>Sign in to your PawHaven account</p>

            </div>



            @if ($errors->any())

                <div class="modal-error">{{ $errors->first() }}</div>

            @endif



            <form method="POST" action="{{ route('login') }}" class="modal-form">

                @csrf

                <div class="form-group">

                    <label for="email">Email Address</label>

                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />

                </div>

                <div class="form-group">

                    <label for="password">Password</label>

                    <div class="password-wrap">

                        <input type="password" id="password" name="password" placeholder="••••••••" required />

                        <button type="button" class="toggle-pw" id="togglePw">👁</button>

                    </div>

                </div>

                <div class="form-row">

                    <label class="checkbox-label"><input type="checkbox" name="remember" /> <span>Remember me</span></label>

                    <a href="#" class="forgot-link">Forgot password?</a>

                </div>

                <button type="submit" class="btn-login">Sign In</button>

            </form>

            <p class="modal-register">New to PawHaven? <a href="#" id="openSignupBtn">Create an account</a></p>

        </div>

    </div>



    <div id="signupModal" class="modal-overlay {{ session('show_signup') ? 'active' : '' }}" role="dialog" aria-modal="true" aria-labelledby="signupTitle">

        <div class="modal-box">

            <button class="modal-close" id="closeSignupModal" aria-label="Close signup modal">&times;</button>

            <div class="modal-header">

                <span class="modal-paw">🐾</span>

                <h2 id="signupTitle">Join the Pack</h2>

                <p>Create your PawHaven account</p>

            </div>

            <form method="POST" action="#" class="modal-form">

                @csrf

                <div class="form-group">

                    <label for="reg_name">Full Name</label>

                    <input type="text" id="reg_name" name="name" placeholder="Your Name" required />

                </div>

                <div class="form-group">

                    <label for="reg_email">Email Address</label>

                    <input type="email" id="reg_email" name="email" placeholder="you@example.com" required />

                </div>

                <div class="form-group">

                    <label for="reg_password">Password</label>

                    <input type="password" id="reg_password" name="password" placeholder="••••••••" required />

                </div>

                <div class="form-group">

                    <label for="password_confirmation">Confirm Password</label>

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required />

                </div>

                <button type="submit" class="btn-login">Create Account</button>

            </form>

            <p class="modal-register">Already have an account? <a href="#" id="switchToLogin">Sign In</a></p>

        </div>

    </div>



    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>

</html>