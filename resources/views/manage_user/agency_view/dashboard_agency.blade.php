<!DOCTYPE html>
<html>
<head>
    <title>Agency Dashboard</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
.welcome-message {
            background: linear-gradient(135deg, #fcfcfc, #ffe6e6);
            color: #721c24;
            padding: 15px;
            margin: 20px;
            border-radius: 10px;
            text-align: left;
            font-size: 20px;
            border-left: 4px solid #921b35;
            box-shadow: 0 4px 15px rgba(146,27,53,0.1);
}

    </style>
</head>
<body class="login-body">
    <!-- Top Navbar -->
    <nav class="navbar agency-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Agency</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="/agency-dashboard">Dashboard</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">News Updates</a></li>
            <li><a href="/view-agency-profile">Profile</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Welcome Message -->
    <div class="welcome-message">
        <strong>Welcome to Dashboard, {{ $user->Name }}!</strong>
    </div>


    {{-- Success Message (for other actions) --}}
    @if(session('success'))
        <div class="dashboard-success">
            <strong>✅ {{ session('success') }}</strong>
        </div>
    @endif

    
        </div>
    </div>

</body>
</html>
