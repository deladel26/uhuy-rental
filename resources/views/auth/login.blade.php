<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Uhuy Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Subtle Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            z-index: 0;
            pointer-events: none;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(15, 23, 42, 0.2) 0%, transparent 50%);
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e8ecf1;
            overflow: hidden;
        }

        /* Logo Section */
        .logo-section {
            padding: 25px 20px 18px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-bottom: 1px solid #e8ecf1;
        }

        .logo-wrapper {
            display: inline-block;
            margin-bottom: 12px;
        }

        .logo-wrapper img {
            width: 100%;
            max-width: 100px;
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
        }

        .welcome-text h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .welcome-text p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0;
        }

        /* Form Section */
        .form-section {
            padding: 25px 20px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 16px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 5;
        }

        .form-control-custom {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid #e8ecf1;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #1f2937;
            background: white;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            transition: all 0.3s ease;
            z-index: 5;
        }

        .password-toggle:hover {
            color: #1f2937;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 6px;
            cursor: pointer;
            accent-color: #1f2937;
        }

        .custom-checkbox label {
            font-size: 0.85rem;
            color: #64748b;
            cursor: pointer;
            margin: 0;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #1f2937;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #0f172a;
        }

        .btn-login {
            width: 100%;
            padding: 12px 18px;
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e8ecf1;
        }

        .divider span {
            position: relative;
            background: white;
            padding: 0 12px;
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .register-link {
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
        }

        .register-link a {
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #0f172a;
        }

        .footer-text {
            text-align: center;
            margin-top: 16px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .alert-custom {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.85rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        @media (max-width: 576px) {
            .form-section {
                padding: 22px 18px;
            }

            .logo-section {
                padding: 22px 18px 16px;
            }

            .welcome-text h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>

    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <div class="login-container">
        <!-- Login Card -->
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-wrapper">
                    <img src="{{ asset('logo.png') }}" alt="Uhuy Rental Logo">
                </div>
                <div class="welcome-text font-bold">
                    <h1>MANAJEMEN RENTAL MOTOR</h1>
                    <p>Silakan masuk ke akun Anda</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert-custom alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="username" class="form-label">username</label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="username" id="username" name="username" value="{{ old('username') }}"
                                class="form-control-custom" placeholder="username" required autofocus
                                autocomplete="username">
                        </div>
                        @error('username')
                            <div class="alert-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="form-control-custom"
                                placeholder="Masukkan password" required autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="alert-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="remember_me" name="remember">
                            <label for="remember_me">Ingat saya</label>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>

                </form>
            </div>
        </div>

        <!-- Footer Text -->
        <p class="footer-text">
            Â© 2025 Uhuy Rental. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>

