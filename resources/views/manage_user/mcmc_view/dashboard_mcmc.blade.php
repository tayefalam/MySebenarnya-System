<!DOCTYPE html>
<html>
<head>
    <title>MCMC Dashboard</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .action-card {
            transition: all 0.3s ease !important;
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        
        .action-card .btn-action {
            transition: all 0.3s ease;
        }
        
        .action-card .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        
        .dashboard-title {
            background: linear-gradient(135deg, #0e630e, #28a745);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .card-icon {
            background: linear-gradient(135deg, #0e630e, #28a745);
            padding: 12px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 4px 15px rgba(14, 99, 14, 0.2);
        }
        
        /* Statistics Cards Hover Effects */
        .stats-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .stats-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15) !important;
        }
        
        /* Search section improvements */
        .search-section {
            background-color: #e0e0e0 !important;
            display: flex;
            justify-content: center;
            align-items: center;
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
            <li><a href="{{ route('mcmc.profile') }}">Profile</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    {{-- Welcome Message with User Name --}}
    <div style="background: #f0f0f0; color: #000; padding: 15px 20px; margin: 20px; width: auto; border-radius: 5px; text-align: left; font-size: 18px; border-left: 4px solid #0e630e;">
        <strong>Welcome to Dashboard, {{ $adminName }}!</strong> 
    </div>

    <!-- Dashboard Statistics - Positioned right under search bar -->
    <div style="padding: 0px 20px 20px 20px; margin: 0px; background-color: #e0e0e0;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h3 style="color: #0e630e; margin: 0px 0px 5px 0px; font-size: 24px; font-weight: 700;">
                <i class="fas fa-chart-line" style="margin-right: 12px;"></i>
                System Overview
            </h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; max-width: 1200px; margin: 0 auto;">
            
            <!-- Total Users Stat -->
            <div class="stats-card" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 8px 25px rgba(40,167,69,0.25);">
                <i class="fas fa-users" style="font-size: 32px; margin-bottom: 12px; opacity: 0.9;"></i>
                <h4 style="margin: 0; font-size: 28px; font-weight: 700; line-height: 1.2;">{{ $totalUsers }}</h4>
                <p style="margin: 8px 0 0 0; opacity: 0.95; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Registered Users</p>
            </div>

            <!-- Total Agencies Stat -->
            <div class="stats-card" style="background: linear-gradient(135deg, #007bff, #6f42c1); color: white; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 8px 25px rgba(0,123,255,0.25);">
                <i class="fas fa-building" style="font-size: 32px; margin-bottom: 12px; opacity: 0.9;"></i>
                <h4 style="margin: 0; font-size: 28px; font-weight: 700; line-height: 1.2;">{{ $totalAgencies }}</h4>
                <p style="margin: 8px 0 0 0; opacity: 0.95; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Registered Agencies</p>
            </div>

            <!-- Active Sessions Stat -->
            <div class="stats-card" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 8px 25px rgba(255,193,7,0.25);">
                <i class="fas fa-clock" style="font-size: 32px; margin-bottom: 12px; opacity: 0.9;"></i>
                <h4 style="margin: 0; font-size: 28px; font-weight: 700; line-height: 1.2;">{{ $activeSessions }}</h4>
                <p style="margin: 8px 0 0 0; opacity: 0.95; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Active Sessions</p>
            </div>

        </div>
    </div>
    <!-- Quick Actions -->
        <div style="padding: 20px; margin: 20px 0px 0px 0px; background-color: #f8f9fa; border-top: 3px solid #0e630e;">
        <h3 class="dashboard-title" style="margin: 0px 0px 25px 0px; font-size: 26px; text-align: center;">     
        <i class="fas fa-tachometer-alt" style="margin-right: 12px;"></i>
            Quick Actions
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
            
            <!-- Register Agency Card -->
            <div class="action-card" style="background: linear-gradient(135deg, #f8fff8, #fff); border-radius: 12px; padding: 30px; box-shadow: 0 8px 25px rgba(14, 99, 14, 0.1); border-left: 5px solid #0e630e; border: 1px solid rgba(14, 99, 14, 0.1);">
                <div style="display: flex; align-items: center; margin-bottom: 18px;">
                    <div class="card-icon">
                        <i class="fas fa-building" style="font-size: 18px; color: white;"></i>
                    </div>
                    <h4 style="margin: 0; color: #333; font-size: 19px; font-weight: 600;">Register New Agency</h4>
                </div>
                <a href="{{ route('mcmc.register.agency') }}" class="btn-action" style="background: linear-gradient(135deg, #0e630e, #28a745); color: white; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(14, 99, 14, 0.3);">
                    <i class="fas fa-plus-circle" style="margin-right: 10px; font-size: 16px;"></i>
                    Register Agency
                </a>
            </div>

            <!-- View Registered Users Card -->
            <div class="action-card" style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 8px 25px rgba(0,123,255,0.1); border-left: 5px solid #007bff; border: 1px solid rgba(0,123,255,0.1);">
                <div style="display: flex; align-items: center; margin-bottom: 18px;">
                    <div style="background: linear-gradient(135deg, #007bff, #0056b3); padding: 12px; border-radius: 50%; margin-right: 15px; box-shadow: 0 4px 15px rgba(0,123,255,0.2);">
                        <i class="fas fa-users" style="font-size: 18px; color: white;"></i>
                    </div>
                    <h4 style="margin: 0; color: #333; font-size: 19px; font-weight: 600;">View Registered Users</h4>
                </div>
                <a href="{{ route('mcmc.view.registered.users') }}" class="btn-action" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(0,123,255,0.3);">
                    <i class="fas fa-eye" style="margin-right: 10px; font-size: 16px;"></i>
                    View Users
                </a>
            </div>

            <!-- Generate Report Card -->
            <div class="action-card" style="background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 8px 25px rgba(255,193,7,0.1); border-left: 5px solid #ffc107; border: 1px solid rgba(255,193,7,0.1);">
                <div style="display: flex; align-items: center; margin-bottom: 18px;">
                    <div style="background: linear-gradient(135deg, #ffc107, #e0a800); padding: 12px; border-radius: 50%; margin-right: 15px; box-shadow: 0 4px 15px rgba(255,193,7,0.2);">
                        <i class="fas fa-chart-bar" style="font-size: 18px; color: white;"></i>
                    </div>
                    <h4 style="margin: 0; color: #333; font-size: 19px; font-weight: 600;">Generate Reports</h4>
                </div>
                <a href="{{ route('mcmc.reports') }}" class="btn-action" style="background: linear-gradient(135deg, #ffc107, #e0a800); color: #333; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(255,193,7,0.3);">
                    <i class="fas fa-chart-bar" style="margin-right: 10px; font-size: 16px;"></i>
                    Generate Reports
                </a>
            </div>

        </div>
    </div>


</body>
</html>