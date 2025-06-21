<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <h1 class="main-title">MYSEBENARNYA</h1>

    <div class="login-container">
        <div class="login-header">
            <h2>Forgot Password</h2>
        </div>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="login-form">
            @csrf
            
            <label for="email">Enter Your Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            <small style="color: #666; font-size: 12px; margin-bottom: 10px; display: block;">
                We'll send you a password reset link to this email address.
            </small>

            <button type="submit">Send Reset Link</button>
        </form>

        <p class="margin-top-15">
            Remember your password? 
            <a href="{{ route('login') }}" style="color: #007bff; text-decoration: underline;">Back to Login</a>
        </p>
    </div>
</body>
</html>
