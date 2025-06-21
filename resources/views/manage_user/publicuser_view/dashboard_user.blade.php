<!DOCTYPE html>
<html>
<head>
    <title>Public User Dashboard</title>
    @vite(['resources/js/app.js'])
</head>
<body class="login-body">
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Public User</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="/user-dashboard">Dashboard</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">News Updates</a></li>
            <li><a href="/view-user-profile">Profile</a></li>
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
    
    <!-- Search bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search News">
            <button><span>&#128269;</span></button>
        </div>
    </div>
</body>
</html>
