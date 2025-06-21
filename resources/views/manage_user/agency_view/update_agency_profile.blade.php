<!DOCTYPE html>
<html>
<head>
    <title>Update Agency Profile</title>
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
        
        .profile-card {
            width: 800px;
            margin: 20px auto;
            background: #f5e7e7;
            border-radius: 15px;
            box-shadow: 0 8px 50px rgba(0,0,0,0.1);
            overflow: hidden
        }
        
        .form-section {
            background: #fff;
            padding: 25px;
            margin: 25px 0;
            border-radius: 12px;
            border-left: 4px solid #921b35;
            box-shadow: 0 5px 15px rgba(146,27,53,0.1);
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(146,27,53,0.15);
        }
        
        .form-section h3 {
            margin: 0 0 20px 0;
            color: #921b35;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .form-section h3 i {
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
        
        .profile-image-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 20px auto;
            object-fit: cover;
            border: 4px solid #921b35;
            box-shadow: 0 8px 25px rgba(146,27,53,0.3);
            transition: all 0.3s ease;
        }
        
        .profile-avatar:hover {
            transform: scale(1.05);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #921b35;
            box-shadow: 0 0 0 3px rgba(146,27,53,0.1);
            transform: translateY(-1px);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }
        
        .password-requirements {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            font-size: 13px;
        }
        
        .password-requirements h4 {
            margin: 0 0 15px 0;
            color: #921b35;
            font-size: 16px;
            font-weight: 600;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .password-requirements li {
            margin-bottom: 8px;
            color: #6c757d;
            font-weight: 500;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #921b35, #dc3545);
            color: white;
            box-shadow: 0 6px 20px rgba(146,27,53,0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(146,27,53,0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #545b62);
            color: white;
            box-shadow: 0 6px 20px rgba(108,117,125,0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108,117,125,0.4);
            text-decoration: none;
            color: white;
        }
        
        .btn i {
            margin-right: 8px;
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
        
        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            box-shadow: 0 4px 15px rgba(114,28,36,0.2);
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            box-shadow: 0 4px 15px rgba(133,100,4,0.2);
        }
        
        .welcome-message {
            background: linear-gradient(135deg, #fff0f0, #ffe6e6);
            color: #721c24;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: left;
            font-size: 18px;
            border-left: 4px solid #921b35;
            box-shadow: 0 4px 15px rgba(146,27,53,0.1);
        }
        
        .optional-text {
            color: #6c757d;
            font-size: 12px;
            font-style: italic;
            font-weight: 400;
        }
        
        .file-upload-area {
            border: 2px dashed #921b35;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #fff8f8;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #dc3545;
            background: #fff0f0;
        }
        
        .file-upload-area input[type="file"] {
            border: none;
            background: none;
            padding: 10px 0;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }
        
        .password-requirements {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            font-size: 13px;
        }
        
        .password-requirements h4 {
            margin: 0 0 15px 0;
            color: #921b35;
            font-size: 16px;
            font-weight: 600;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .password-requirements li {
            margin-bottom: 8px;
            color: #6c757d;
            font-weight: 500;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #921b35, #dc3545);
            color: white;
            box-shadow: 0 6px 20px rgba(146,27,53,0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(146,27,53,0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #545b62);
            color: white;
            box-shadow: 0 6px 20px rgba(108,117,125,0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108,117,125,0.4);
            text-decoration: none;
            color: white;
        }
        
        .btn i {
            margin-right: 8px;
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
        
        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            box-shadow: 0 4px 15px rgba(114,28,36,0.2);
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            box-shadow: 0 4px 15px rgba(133,100,4,0.2);
        }
        
        .optional-text {
            color: #6c757d;
            font-size: 12px;
            font-style: italic;
            font-weight: 400;
        }
        
        .file-upload-area {
            border: 2px dashed #921b35;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #fff8f8;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #dc3545;
            background: #fff0f0;
        }
        
        .file-upload-area input[type="file"] {
            border: none;
            background: none;
            padding: 10px 0;
        }
    </style>
</head>
<body class="login-body">
    <!-- Navbar -->
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
            <strong>✅ {{ session('success') }}</strong>
        </div>
    @endif

    @if(session('password_success'))
        <div class="alert alert-success">
            <strong>🔐 {{ session('password_success') }}</strong>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            <strong>⚠️ {{ session('warning') }}</strong>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-error">
            <strong>❌ Please fix the following errors:</strong>
            <ul style="margin: 10px 0 0 20px; text-align: left;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    

    <!-- Profile Container -->
        <div class="profile-header">
            <h2 class="profile-title">
                <i class="fas fa-building-user" style="margin-right: 15px; color: #921b35;"></i>
                Update Agency Profile
            </h2>
        </div>

        <div class="profile-card-agency">
            <form action="{{ route('update.agency.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Basic Information Section -->
                <div class="form-section">
                    <h3><i class="fas fa-building"></i>Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="name">Agency Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->Name) }}" required>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="agency_section">Agency Section *</label>
                        <select id="agency_section" name="agency_section" required>
                            <option value="">Select Section</option>
                            <option value="Communications" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Communications' ? 'selected' : '' }}>Communications</option>
                            <option value="Broadcasting" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Broadcasting' ? 'selected' : '' }}>Broadcasting</option>
                            <option value="Multimedia" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                            <option value="Postal Services" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Postal Services' ? 'selected' : '' }}>Postal Services</option>
                            <option value="Digital Services" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Digital Services' ? 'selected' : '' }}>Digital Services</option>
                            <option value="Regulatory Affairs" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Regulatory Affairs' ? 'selected' : '' }}>Regulatory Affairs</option>
                            <option value="Technical Services" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Technical Services' ? 'selected' : '' }}>Technical Services</option>
                            <option value="Other" {{ old('agency_section', Auth::user()->agency->Agency_Section ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('agency_section')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->Email) }}" required>
                            @error('email')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number *</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->Contact_Number) }}" required 
                                   placeholder="e.g., 03-12345678">
                            @error('phone_number')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h3><i class="fas fa-map-marker-alt"></i>Contact Information</h3>
                    
                    <div class="form-group">
                        <label for="address">Office Address</label>
                        <textarea id="address" name="address" placeholder="Enter your agency's complete address">{{ old('address', Auth::user()->agency->Address ?? '') }}</textarea>
                        @error('address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                     
                    <div class="form-group">
                        <label for="website">Website <span class="optional-text">(Optional)</span></label>
                        <input type="url" id="website" name="website" value="{{ old('website', Auth::user()->agency->Website ?? '') }}" 
                               placeholder="https://www.example.com">
                        @error('website')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="form-section">
                    <h3><i class="fas fa-lock"></i>Password Settings</h3>
                    <p style="color: #6c757d; margin-bottom: 15px;">Leave password fields empty if you don't want to change your password.</p>
                    
                    <div class="form-group">
                        <label for="current_password">Current Password <span class="optional-text">(Required only if changing password)</span></label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter your current password">
                        @error('current_password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">New Password <span class="optional-text">(Optional)</span></label>
                            <input type="password" id="password" name="password" placeholder="Enter new password">
                            @error('password')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                            @error('password_confirmation')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="password-requirements">
                        <h4>Password Requirements:</h4>
                        <ul>
                            <li>At least 8 characters long</li>
                            <li>At least one uppercase letter (A-Z)</li>
                            <li>At least one lowercase letter (a-z)</li>
                            <li>At least one number (0-9)</li>
                            <li>At least one special character (@$!%*?&#)</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                    <a href="/view-agency-profile" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
   

    <script>
        // Preview image before upload
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-avatar').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Show/hide password requirements based on password field focus
        document.getElementById('password').addEventListener('focus', function() {
            document.querySelector('.password-requirements').style.display = 'block';
        });
        
        // Enable/disable password confirmation based on new password
        document.getElementById('password').addEventListener('input', function() {
            const confirmField = document.getElementById('password_confirmation');
            const currentField = document.getElementById('current_password');
            
            if (this.value) {
                confirmField.required = true;
                currentField.required = true;
            } else {
                confirmField.required = false;
                currentField.required = false;
            }
        });
    </script>
</body>
</html>