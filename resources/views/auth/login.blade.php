<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login - POS Bengkel</title>
    @include('layouts.style')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-wrapper {
            min-height: 100vh;
        }
        .login-side-image {
            background-image: url('{{ asset("assets/img/foto.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        .login-side-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(12, 138, 138, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: 1;
        }
        .login-side-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 3rem;
            text-align: center;
        }
        .login-form-container {
            width: 100%;
            max-width: 450px;
            padding: 3rem;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .login-right-side {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fb;
        }
        .brand-logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--bs-primary);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d9dee3;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(12, 138, 138, 0.1);
        }
        .btn-primary {
            padding: 0.75rem 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            letter-spacing: 0.5px;
        }
        .input-group-text {
            border-radius: 0 0.5rem 0.5rem 0;
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div class="row g-0 login-wrapper">
        <!-- Left Side Image -->
        <div class="col-lg-7 d-none d-lg-block login-side-image">
            <div class="login-side-content">
                <h1 class="display-4 fw-bolder mb-3 text-white">POS Bengkel</h1>
                <p class="lead fw-normal text-white-50">Kelola inventaris, layanan, dan penjualan bengkel Anda dengan lebih mudah, efisien, dan profesional.</p>
            </div>
        </div>
        
        <!-- Right Side Form -->
        <div class="col-12 col-lg-5 login-right-side p-4 p-lg-0">
            <div class="login-form-container">
                <div class="brand-logo">
                    <i class="ti ti-tool text-primary fs-2"></i> POS Bengkel
                </div>
                
                <h4 class="fw-bold mb-1">Selamat Datang 👋</h4>
                <p class="text-muted mb-4">Silakan masuk ke akun Anda untuk memulai.</p>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" autofocus required />
                        </div>
                    </div>
                    
                    <div class="mb-4 form-password-toggle">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock"></i></span>
                            <input type="password" id="password" class="form-control border-start-0 border-end-0 ps-0" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                            <span class="input-group-text cursor-pointer bg-transparent"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                    
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                            <label class="form-check-label text-muted" for="remember"> Ingat Saya </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary d-grid w-100 mb-3" type="submit">Log in</button>
                </form>
            </div>
        </div>
    </div>
    
    @include('layouts.script')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.form-password-toggle .cursor-pointer');
            const icon = toggleIcon.querySelector('i');

            toggleIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('ti-eye-off');
                    icon.classList.add('ti-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('ti-eye');
                    icon.classList.add('ti-eye-off');
                }
            });
        });
    </script>
</body>
</html>
