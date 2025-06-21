<!DOCTYPE html>
<html>
<head>
    <title>MCMC Profile</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .profile-header {
            text-align: center;
            padding: 30px 0;
            color: rgb(39, 38, 38);
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(73, 71, 71, 0.171);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .stat-item {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #0e630e;
        }
        
    </style>
</head>
<body class="login-body">
    <!-- Top Navbar -->
    <nav class="navbar mcmc-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>MCMC</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="{{ route('mcmc.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('mcmc.register.agency') }}">Register Agency</a></li>
            <li><a href="{{ route('mcmc.view.registered.users') }}">Registered Users</a></li>
            <li><a href="{{ route('mcmc.reports') }}">Reports</a></li>
            <li><a href="{{ route('mcmc.profile') }}" class="active">Profile</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>


    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <h2 style="margin: 0 0 10px 0;">{{ $user->Name }}</h2>
            <p style="margin: 0; opacity: 0.9; font-size: 16px;">
                <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                MCMC Administrator
            </p>
            <p style="margin: 10px 0 0 0; opacity: 0.8; font-size: 14px;">
                <i class="fas fa-envelope" style="margin-right: 8px;"></i>
                {{ $user->Email }}
            </p>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-item">
                <i class="fas fa-users" style="font-size: 24px; color: #0e630e; margin-bottom: 10px;"></i>
                <h3 style="margin: 0; color: #0e630e;">{{ $totalUsersManaged }}</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Total Users Managed</p>
            </div>
            
            <div class="stat-item">
                <i class="fas fa-building" style="font-size: 24px; color: #007bff; margin-bottom: 10px;"></i>
                <h3 style="margin: 0; color: #007bff;">{{ $totalAgenciesManaged }}</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Agencies Registered</p>
            </div>
            
            <div class="stat-item">
                <i class="fas fa-calendar-alt" style="font-size: 24px; color: #ffc107; margin-bottom: 10px;"></i>
                <h3 style="margin: 0; color: #ffc107; font-size: 16px;">{{ $lastLoginDate->format('M d, Y') }}</h3>
                <p style="margin: 5px 0 0 0; color: #666;">Last Login</p>
            </div>
        </div>

    </div>

</body>
</html>