<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Login | Barakah Atta</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fef9f0 0%, #fffaf5 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        :root {
            --brand-green: #2b6e3c;
            --brand-gold: #c9a03d;
        }

        /* Background Decorative Elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(43, 110, 60, 0.03) 0%, rgba(201, 160, 61, 0.02) 100%);
            border-radius: 50%;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -15%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(201, 160, 61, 0.03) 0%, rgba(43, 110, 60, 0.02) 100%);
            border-radius: 50%;
            z-index: 0;
        }

        /* Login Card - No scroll */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            border: 1px solid rgba(203, 183, 137, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 1;
            overflow: visible;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -15px rgba(43, 110, 60, 0.2);
        }

        /* Logo Styling */
        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 16px;
            margin-bottom: 0.75rem;
            transition: transform 0.3s ease;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2b6e3c 0%, #c9a03d 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
            display: block;
        }
        
        .logo-text span {
            background: linear-gradient(135deg, #c9a03d 0%, #2b6e3c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .tagline {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.3rem;
        }

        /* Form Controls - Reduced padding for compact layout */
        .form-control-custom {
            border-radius: 60px;
            padding: 10px 18px;
            border: 1.5px solid #ece3d8;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control-custom:focus {
            border-color: #2b6e3c;
            box-shadow: 0 0 0 4px rgba(43, 110, 60, 0.1);
            outline: none;
        }

        .input-group-text-custom {
            background: transparent;
            border: 1.5px solid #ece3d8;
            border-right: none;
            border-radius: 60px 0 0 60px;
            color: #2b6e3c;
            padding: 10px 15px;
        }

        .form-control-custom-with-icon {
            border-left: none;
            border-radius: 0 60px 60px 0;
        }

        /* Button Styling */
        .btn-success-custom {
            background: linear-gradient(105deg, #2b6e3c, #1f8a3e);
            border: none;
            border-radius: 40px;
            padding: 10px 24px;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(43, 110, 60, 0.25);
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            font-size: 0.95rem;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(43, 110, 60, 0.35);
        }

        /* Form Check */
        .form-check-input:checked {
            background-color: #2b6e3c;
            border-color: #2b6e3c;
        }

        /* Links */
        .forgot-link, .register-link {
            color: #2b6e3c;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.85rem;
        }

        .forgot-link:hover, .register-link:hover {
            color: #c9a03d;
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert-custom {
            border-radius: 60px;
            border: none;
            background: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 10px 15px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
            background: white;
            padding: 0 5px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        /* Animation */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: fadeSlideUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                margin: 1rem;
                padding: 1.5rem !important;
            }
            
            .logo-img {
                width: 55px;
                height: 55px;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .tagline {
                font-size: 0.75rem;
            }
            
            .form-control-custom {
                padding: 8px 15px;
                font-size: 0.85rem;
            }
            
            .input-group-text-custom {
                padding: 8px 12px;
            }
            
            .btn-success-custom {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
        }

        /* For very small screens */
        @media (max-width: 480px) {
            .login-card {
                padding: 1.2rem !important;
            }
            
            .login-logo {
                margin-bottom: 1rem;
            }
            
            .mb-3 {
                margin-bottom: 0.75rem !important;
            }
            
            .mb-4 {
                margin-bottom: 1rem !important;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-card p-4 p-md-5">
                
                <!-- Logo -->
                <div class="login-logo">
                    <img src="https://placehold.co/200x200/2b6e3c/white?text=B" 
                         alt="Barakah Atta Logo" 
                         class="logo-img"
                         onerror="this.src='https://via.placeholder.com/70x70/2b6e3c/white?text=B'">
                    <span class="logo-text">Barakah<span> Atta</span></span>
                    <p class="tagline">100% Gluten-Free Multigrain Flour</p>
                </div>

                <!-- Error Messages (if any) -->
                @if($errors->any())
                    <div class="alert alert-custom alert-danger mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold mb-1">
                            <i class="bi bi-envelope-fill text-success me-1"></i> Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input id="email" type="email" 
                                   class="form-control form-control-custom form-control-custom-with-icon @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                            <small class="text-danger mt-1 d-block">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold mb-1">
                            <i class="bi bi-lock-fill text-success me-1"></i> Password
                        </label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input id="password" 
                                       type="password" 
                                       class="form-control form-control-custom form-control-custom-with-icon @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                            </div>
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </span>
                        </div>
                        @error('password')
                            <small class="text-danger mt-1 d-block">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-link small" href="{{ route('password.request') }}">
                                <i class="bi bi-question-circle"></i> Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-success-custom">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login to Dashboard
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Password Toggle Functionality
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    }
</script>

<style>
    /* Additional styles for better UX - NO SCROLLING */
    .password-wrapper {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        z-index: 10;
        background: white;
        padding: 0 5px;
        border-radius: 50%;
    }
    
    .password-toggle:hover {
        color: #2b6e3c;
    }
    
    .form-control-custom:focus {
        border-color: #2b6e3c;
        box-shadow: 0 0 0 4px rgba(43, 110, 60, 0.1);
    }
    
    .input-group-text-custom {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    .form-control-custom-with-icon:focus {
        border-left-color: #2b6e3c;
    }
    
    /* Alert styling */
    .alert-custom {
        border-radius: 12px;
        padding: 10px 15px;
    }
    
    /* Smooth transitions */
    .btn-success-custom {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Input focus effect */
    .form-control-custom:focus {
        transform: translateY(-1px);
    }
    
    /* Custom checkbox styling */
    .form-check-input:checked {
        background-color: #2b6e3c;
        border-color: #2b6e3c;
    }
    
    .form-check-input:focus {
        border-color: #2b6e3c;
        box-shadow: 0 0 0 0.2rem rgba(43, 110, 60, 0.25);
    }
    
    /* Prevent ANY scrolling */
    body {
        overflow: hidden;
        position: fixed;
        width: 100%;
        height: 100%;
    }
    
    /* Ensure container doesn't cause scroll */
    .container {
        height: 100vh;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    
    .row {
        width: 100%;
        margin: 0;
        overflow: hidden;
    }
    
    .col-md-6, .col-lg-5 {
        overflow: hidden;
    }
    
    /* Make sure card content fits perfectly */
    .login-card {
        max-height: 95vh;
        overflow: visible;
    }
    
    /* Ensure all content fits without scroll */
    form {
        overflow: visible;
    }
    
    /* Remove any potential scroll triggers */
    * {
        -webkit-overflow-scrolling: touch;
    }
</style>

</body>
</html>