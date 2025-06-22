<!DOCTYPE html>
<html>
<head>
    <title>Assigned Agency Details</title>
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
            <li><a href="#">View Inquiry</a></li>
            <li><a href="/view-user-profile">Profile</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>

    <!-- Search bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search News">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main content container -->
    <div class="login-container">
        <div class="login-header">Inquiry Assignment Details</div>
        <div class="login-form">
            @if(session('error'))
                <p style="color: red;">{{ session('error') }}</p>
            @elseif(isset($assignment))
                <div class="form-group">
                    <label>Inquiry ID:</label>
                    <p>{{ $assignment->Inquiry_ID }}</p>
                </div>

                <div class="form-group">
                    <label>Assigned Agency:</label>
                    <p>{{ $assignment->agency->Agency_Section ?? 'N/A' }}</p>
                </div>

                <div class="form-group">
                    <label>Assigned Date:</label>
                    <p>{{ $assignment->Assigned_Date }}</p>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <p>{{ $assignment->Reassigned ? 'Reassigned' : 'Assigned' }}</p>
                </div>
            @else
                <p>No agency has been assigned to this inquiry yet.</p>
            @endif
        </div>
    </div>

</body>
</html>
