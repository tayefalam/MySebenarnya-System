<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <h1 class="main-title">MYSEBENARNYA</h1>

    <div class="login-container">
        <div class="login-header">
            <h2>Reset Password</h2>
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

        <form method="POST" action="{{ route('password.update') }}" class="login-form">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ $email }}" readonly>

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
            <small style="color: #666; font-size: 12px; margin-bottom: 10px; display: block;">
                Password must be at least 8 characters and contain uppercase, lowercase, number, and special character (@$!%*?&#)
            </small>

            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>

        <p class="margin-top-15">
            Remember your password? 
            <a href="{{ route('login') }}" style="color: #007bff; text-decoration: underline;">Back to Login</a>
        </p>
    </div>
</body>
</html>