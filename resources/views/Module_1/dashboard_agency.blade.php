<!DOCTYPE html>
<html>
<head>
    <title>Agency Dashboard</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>
<body class="login-body">
    <!-- Top Navbar -->
    <nav class="navbar agency-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Agency User</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">News Updates</a></li>
            <li><a href="#">Profile</a></li>
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

    <!-- Dashboard content can go here -->
</body>
</html>
