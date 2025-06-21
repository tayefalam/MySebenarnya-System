<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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


    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <strong><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}</strong>
        </div>
    @endif

    <!-- Profile Container -->
    
        <div class="profile-header">
            <h2 class="profile-title">
                User Profile
            </h2>
        </div>

        <div class="profile-card.detailed">
            <!-- Profile Image Section -->
            <div class="profile-image-section">
                @if($user->publicProfile && $user->publicProfile->profile_image_filename)
                    <img src="{{ asset('storage/profile_images/' . $user->publicProfile->profile_image_filename) }}?v={{ time() }}" 
                         class="profile-pic" alt="Profile Image">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" 
                         class="profile-pic" alt="Default Profile Image">
                @endif
            </div>

            <!-- Profile Information Grid -->
            <div class="profile-info-grid">
                <!-- Personal Information -->
                <div class="info-section">
                    <h3><i class="fas fa-user"></i>Personal Information</h3>
                    
                    <div class="info-item">
                        <span class="info-label">Full Name:</span>
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
                    
                    @if($user->publicProfile && $user->publicProfile->Ic_Number)
                    <div class="info-item">
                        <span class="info-label">IC Number:</span>
                        <span class="info-value">{{ $user->publicProfile->Ic_Number }}</span>
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
                        <span class="info-label">Member Since:</span>
                        <span class="info-value">{{ $user->created_at ? $user->created_at->format('F j, Y') : 'N/A' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Last Updated:</span>
                        <span class="info-value">{{ $user->updated_at ? $user->updated_at->format('F j, Y g:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('user.profile.edit') }}" class="btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    
</body>
</html>