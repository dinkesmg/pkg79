<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Semar PKG79</title>
    <link rel="icon" href="{{ asset('logo_semarpkg79.png')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.header')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%); font-family: 'Poppins', sans-serif;">
<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2316b3ac' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .register-box {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 500px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .register-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .register-logo {
        width: 140px;
        height: auto;
        margin-bottom: 25px;
        transition: transform 0.4s ease;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .register-logo:hover {
        transform: scale(1.05) rotate(2deg);
    }

    .register-title {
        color: rgb(22 179 172);
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 35px;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 28px;
        position: relative;
    }

    .form-label {
        color: #2d3748;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-input {
        width: 100%;
        padding: 14px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }

    .form-input:focus {
        border-color: rgb(22 179 172);
        outline: none;
        box-shadow: 0 0 0 4px rgba(22, 179, 172, 0.15);
        background: white;
    }

    .form-input::placeholder {
        color: #a0aec0;
    }

    .password-input {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #718096;
        transition: all 0.3s ease;
        padding: 5px;
    }

    .toggle-password:hover {
        color: rgb(22 179 172);
        transform: translateY(-50%) scale(1.1);
    }

    .register-button {
        background: linear-gradient(135deg, rgb(22 179 172) 0%, rgb(18, 144, 138) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 16px;
        width: 100%;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .register-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(22, 179, 172, 0.2);
    }

    .register-button:active {
        transform: translateY(0);
    }

    .register-button::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .register-button:hover::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    .error-message {
        color: #e53e3e;
        background: #fff5f5;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 25px;
        text-align: center;
        font-size: 14px;
        border: 1px solid #fed7d7;
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        color: #4a5568;
    }

    .login-link a {
        color: rgb(22 179 172);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: rgb(18, 144, 138);
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .register-box {
            padding: 30px 20px;
            margin: 15px;
        }

        .register-title {
            font-size: 28px;
        }

        .form-input {
            padding: 12px 16px;
        }

        .register-button {
            padding: 14px;
        }
    }
</style>

<div class="register-container">
    <div class="register-box">
        <div style="text-align: center;">
            <img src="{{asset('logo_semarpkg79.png')}}" alt="Logo" class="register-logo">
            <h1 class="register-title">Create Account</h1>
        </div>

        <form method="POST" action="{//{ route('auth.register') }}" id="registerForm">
            @csrf
            <div class="form-group">
                <label class="form-label" for="nama">Full Name</label>
                <input type="text" 
                       name="nama" 
                       id="nama" 
                       class="form-input" 
                       placeholder="Enter your full name"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       class="form-input" 
                       placeholder="Choose a username"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-input" 
                       placeholder="Enter your email"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                       required>
                <small class="email-error" style="color: #e53e3e; display: none; margin-top: 5px; font-size: 12px;"></small>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="password-input">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-input" 
                           placeholder="Create a password"
                           required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye-slash" id="passwordEyeIcon"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="password-input">
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="form-input" 
                           placeholder="Confirm your password"
                           required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="fas fa-eye-slash" id="confirmPasswordEyeIcon"></i>
                    </span>
                </div>
            </div>

            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="register-button">
                Create Account
            </button>

            <div class="login-link">
                Already have an account? <a href="{//{ route('auth.index') }}">Sign In</a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    // Email validation function
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    }

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const emailInput = document.getElementById('email');
        const emailError = document.querySelector('.email-error');
        const email = emailInput.value;

        if (!validateEmail(email)) {
            e.preventDefault();
            emailError.textContent = 'Please enter a valid email address';
            emailError.style.display = 'block';
            emailInput.style.borderColor = '#e53e3e';
            return false;
        }

        // If email is valid, proceed with form submission
        const button = this.querySelector('.register-button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        button.disabled = true;
    });

    // Real-time email validation
    document.getElementById('email').addEventListener('input', function() {
        const emailError = document.querySelector('.email-error');
        const email = this.value;

        if (email && !validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address';
            emailError.style.display = 'block';
            this.style.borderColor = '#e53e3e';
        } else {
            emailError.style.display = 'none';
            this.style.borderColor = '#e2e8f0';
        }
    });

    function togglePasswordVisibility(inputId) {
        var passwordInput = document.getElementById(inputId);
        var eyeIcon = document.getElementById(inputId + 'EyeIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

    // Enhanced input animations
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.querySelector('.form-label').style.color = 'rgb(22 179 172)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
            if (!this.value) {
                this.parentElement.querySelector('.form-label').style.color = '#2d3748';
            }
        });
    });
</script>
</body>
</html> 