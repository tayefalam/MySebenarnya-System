<!DOCTYPE html>
<html>
<head>
    <title>Agency Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        
        .profile-header {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 20px;
        }
        
        .profile-title {
            background: #921b35;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 30px;
            margin: 0;
        }
        
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(146,27,53,0.2);
        }
        
        .profile-image-section {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 20px auto;
            object-fit: cover;
            border: 4px solid #921b35;
            box-shadow: 0 8px 25px rgba(146,27,53,0.3);
            transition: all 0.3s ease;
        }
        
        .profile-pic:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(146,27,53,0.4);
        }
        
        .info-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(146,27,53,0.1);

            border-left: 4px solid #921b35;
            transition: all 0.3s ease;
        }
        
        .info-section:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(146,27,53,0.15);
        }
        
        .info-section h3 {
            color: #921b35;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
        }
        
        .info-section h3 i {
            margin-right: 10px;
            background: linear-gradient(135deg, #921b35, #dc3545);
            color: white;
            padding: 8px;
            border-radius: 50%;
            font-size: 14px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .info-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 140px;
            margin-right: 15px;
        }
        
        .info-value {
            color: #333;
            flex: 1;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .status-inactive {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        
        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #921b35, #dc3545);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
            box-shadow: 0 6px 20px rgba(146,27,53,0.3);
            transition: all 0.3s ease;
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(146,27,53,0.4);
            text-decoration: none;
            color: white;
        }
        
        .btn-edit i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        .alert {
            padding: 15px 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: none;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            box-shadow: 0 4px 15px rgba(21,87,36,0.2);
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

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <strong><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}</strong>
        </div>
    @endif

    <!-- Profile Container -->
        <div class="profile-header">
            <h2 class="profile-title">
                Agency Profile
            </h2>
        </div>

        <div class="profile-card-agency">
            <!-- Profile Image Section -->
            <div class="profile-image-section-agency">
                @if($user->profile_image)
                    <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" 
                         class="profile-pic" alt="Agency Profile Image">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" 
                         class="profile-pic" alt="Default Profile Image">
                @endif
                
            </div>

            <!-- Profile Information Grid -->
            <div class="profile-info-grid">
                <!-- Basic Information -->
                <div class="info-section">
                    <h3><i class="fas fa-building"></i>Basic Information</h3>
                    
                    <div class="info-item">
                        <span class="info-label">Agency Name:</span>
                        <span class="info-value">{{ $user->Name }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $user->Email }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $user->Contact_Number ?? 'Not provided' }}</span>
                    </div>
                    
                    @if($agency && $agency->Agency_Section)
                    <div class="info-item">
                        <span class="info-label">Section:</span>
                        <span class="info-value">{{ $agency->Agency_Section }}</span>
                    </div>
                    @endif
                </div>

                <!-- Contact Information -->
                <div class="info-section">
                    <h3><i class="fas fa-map-marker-alt"></i>Contact Information</h3>
                    
                    @if($agency && $agency->Address)
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $agency->Address }}</span>
                    </div>
                    @endif
                    
                    @if($agency && $agency->Website)
                    <div class="info-item">
                        <span class="info-label">Website:</span>
                        <span class="info-value">
                            <a href="{{ $agency->Website }}" target="_blank" style="color: #921b35; text-decoration: none;">
                                {{ $agency->Website }} <i class="fas fa-external-link-alt" style="font-size: 12px; margin-left: 5px;"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                    
                    @if($agency && $agency->Agency_ID)
                    <div class="info-item">
                        <span class="info-label">Agency ID:</span>
                        <span class="info-value">{{ $agency->Agency_ID }}</span>
                    </div>
                    @endif
                </div>

                <!-- Account Information -->
                <div class="info-section">
                    <h3><i class="fas fa-cog"></i>Account Information</h3>
                    
                    <div class="info-item">
                        <span class="info-label">User Type:</span>
                        <span class="info-value">{{ $user->User_Type }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value">
                            <span class="status-badge {{ $user->Status === 'Active' ? 'status-active' : 'status-inactive' }}">
                                <i class="fas {{ $user->Status === 'Active' ? 'fa-check-circle' : 'fa-times-circle' }}" style="margin-right: 5px;"></i>
                                {{ $user->Status }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Registered:</span>
                        <span class="info-value">{{ $agency && $agency->Register_Date ? \Carbon\Carbon::parse($agency->Register_Date)->format('F j, Y') : ($user->created_at ? $user->created_at->format('F j, Y') : 'N/A') }}</span>
                    </div>
                    
                </div>
                 
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('agency.profile.edit') }}" class="btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    
</body>
</html>