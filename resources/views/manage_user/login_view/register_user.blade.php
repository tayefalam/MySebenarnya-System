<!DOCTYPE html>
<html>
<head>
    <title>Register New User</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <h1 class="main-title">MYSEBENARNYA</h1>

    <div class="login-container">
        <div class="login-header">
            <h2>Register New User</h2>
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

        <form method="POST" action="{{ route('register.submit') }}" class="login-form">
            @csrf

            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <label for="user_type">Type of User</label>
            <select id="user_type" name="user_type" required>
                <option value="">-- Select User Type --</option>
                <option value="public_user" {{ old('user_type') == 'public_user' ? 'selected' : '' }}>Public User</option>
                <option value="agency" {{ old('user_type') == 'agency' ? 'selected' : '' }}>Agency</option>
                <option value="mcmc" {{ old('user_type') == 'mcmc' ? 'selected' : '' }}>MCMC</option>
            </select>

            <button type="submit">Register</button>
        </form>

        <p class="margin-top-15">
            Already have an account? 
            <a href="{{ route('login') }}" style="color: #007bff; text-decoration: underline;">Login here</a>
        </p>
    </div>
</body>
</html>
