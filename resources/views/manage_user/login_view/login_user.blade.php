<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <h1 class="main-title">MYSEBENARNYA</h1>
    
    <div class="login-container">
        <div class="login-header">
            <h2>Login</h2>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
           <div class="success-message">
                {{ session('success') }}
           </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="login-form">

            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="user_type">Type of User</label>
            <select id="user_type" name="user_type" required>
                <option value="">-- Select User Type --</option>
                <option value="public_user" {{ old('user_type') == 'public_user' ? 'selected' : '' }}>Public User</option>
                <option value="agency" {{ old('user_type') == 'agency' ? 'selected' : '' }}>Agency</option>
                <option value="mcmc" {{ old('user_type') == 'mcmc' ? 'selected' : '' }}>MCMC</option>
            </select>

            <button type="submit">Login</button>
            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password</a>
        </form>
    </div>
</body>
</html>
