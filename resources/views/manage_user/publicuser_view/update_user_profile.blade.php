<!DOCTYPE html>
<html>
<head>
    <title>Update User Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
       
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-title {
            background: linear-gradient(135deg, #007bff, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 28px;
            margin: 0;
        }
        
        .profile-card {
            background: linear-gradient(135deg, #f8fdff, #fff);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,123,255,0.15);
            border-left: 5px solid #007bff;
            border: 1px solid rgba(0,123,255,0.1);
            max-width: 800px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        
        .form-section {
            background: #fff;
            padding: 25px;
            margin: 25px 0;
            border-radius: 12px;
            border-left: 4px solid #007bff;
            box-shadow: 0 5px 15px rgba(0,123,255,0.1);
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,123,255,0.15);
        }
        
        .form-section h3 {
            margin: 0 0 20px 0;
            color: #007bff;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .form-section h3 i {
            margin-right: 10px;
            background: linear-gradient(135deg, #007bff, #0056b3);
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
            border: 4px solid #007bff;
            box-shadow: 0 8px 25px rgba(0,123,255,0.3);
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
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
            transform: translateY(-1px);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        .checkbox-group label {
            margin: 0;
            font-weight: 500;
            color: #6c757d;
        }
        
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
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
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            box-shadow: 0 6px 20px rgba(0,123,255,0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,123,255,0.4);
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
        
        .welcome-message {
            background: linear-gradient(135deg, #f0f8ff, #e6f3ff);
            color: #0056b3;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: left;
            font-size: 18px;
            border-left: 4px solid #007bff;
            box-shadow: 0 4px 15px rgba(0,123,255,0.1);
        }
        
        .optional-text {
            color: #6c757d;
            font-size: 12px;
            font-style: italic;
            font-weight: 400;
        }
        
        .file-upload-area {
            border: 2px dashed #007bff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #f8fdff;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #0056b3;
            background: #f0f8ff;
        }
        
        .file-upload-area input[type="file"] {
            border: none;
            background: none;
            padding: 10px 0;
        }
    </style>
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
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-error">
            <strong><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>Please fix the following errors:</strong>
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
                <i class="fas fa-user-edit" style="margin-right: 15px; color: #007bff;"></i>
                Update Profile
            </h2>
        </div>

        <div class="profile-card">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Image Section -->
                <div class="form-section">
                    <h3><i class="fas fa-camera"></i>Profile Image</h3>
                    
                    <div class="profile-image-section">
                        @if($user->publicProfile && $user->publicProfile->profile_image_filename)
                            <img id="profile-preview" src="{{ asset('storage/profile_images/' . $user->publicProfile->profile_image_filename) }}?v={{ time() }}" 
                                 class="profile-avatar" alt="Profile Image">
                        @else
                            <img id="profile-preview" src="{{ asset('images/default-profile.png') }}" 
                                 class="profile-avatar" alt="Default Profile Image">
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_image">Upload New Profile Image <span class="optional-text">(Optional)</span></label>
                        <div class="file-upload-area">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: #007bff; margin-bottom: 10px;"></i>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*">
                            <small style="color: #6c757d; display: block; margin-top: 5px;">
                                Supported formats: JPG, PNG, JPEG. Max size: 2MB
                            </small>
                            <div id="upload-status" style="margin-top: 10px; font-size: 12px; color: #007bff;"></div>
                        </div>
                        @error('profile_image')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    @if($user->publicProfile && $user->publicProfile->profile_image_filename)
                    <div class="checkbox-group">
                        <input type="checkbox" id="remove_profile_image" name="remove_profile_image" value="1">
                        <label for="remove_profile_image">Remove current profile image</label>
                    </div>
                    @endif
                </div>

                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3><i class="fas fa-user"></i>Personal Information</h3>
                    
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->Name) }}" required>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->Email) }}" required>
                            @error('email')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number *</label>
                            <input type="text" id="phone_number" name="phone_number" 
                                   value="{{ old('phone_number', $user->Contact_Number) }}" 
                                   placeholder="e.g., 012-3456789" required>
                            @error('phone_number')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ic_number">IC Number *</label>
                        <input type="text" id="ic_number" name="ic_number" 
                               value="{{ old('ic_number', $user->publicProfile->Ic_Number ?? '') }}" 
                               placeholder="e.g., 123456-78-9012" required>
                        <small style="color: #6c757d; font-size: 12px;">
                            Format: XXXXXX-XX-XXXX (with or without dashes)
                        </small>
                        @error('ic_number')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                       Save Changes
                    </button>
                    <a href="{{ route('user.profile.view') }}" class="btn btn-secondary">
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
            const profileAvatar = document.getElementById('profile-preview');
            const uploadStatus = document.getElementById('upload-status');
            
            if (file) {
                console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
                uploadStatus.textContent = 'File selected: ' + file.name;
                uploadStatus.style.color = '#007bff';
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, JPEG, or PNG)');
                    uploadStatus.textContent = 'Error: Invalid file type';
                    uploadStatus.style.color = '#dc3545';
                    this.value = '';
                    return;
                }
                
                // Validate file size (2MB = 2048KB = 2097152 bytes)
                if (file.size > 2097152) {
                    alert('File size must be less than 2MB');
                    uploadStatus.textContent = 'Error: File too large';
                    uploadStatus.style.color = '#dc3545';
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileAvatar.src = e.target.result;
                    uploadStatus.textContent = 'Preview loaded - ready to upload';
                    uploadStatus.style.color = '#28a745';
                    
                    // Uncheck remove image checkbox if it exists
                    const removeCheckbox = document.getElementById('remove_profile_image');
                    if (removeCheckbox) {
                        removeCheckbox.checked = false;
                    }
                };
                reader.readAsDataURL(file);
            } else {
                uploadStatus.textContent = '';
            }
        });

        // Handle remove image checkbox
        document.getElementById('remove_profile_image')?.addEventListener('change', function() {
            const profileAvatar = document.getElementById('profile-preview');
            const fileInput = document.getElementById('profile_image');
            
            if (this.checked) {
                profileAvatar.src = '{{ asset("images/default-profile.png") }}';
                fileInput.value = '';
            } else {
                // Restore original image if unchecked
                @if($user->publicProfile && $user->publicProfile->profile_image_filename)
                    profileAvatar.src = '{{ asset("storage/profile_images/" . $user->publicProfile->profile_image_filename) }}?v={{ time() }}';
                @endif
            }
        });

        // Add visual feedback for file upload area
        const fileUploadArea = document.querySelector('.file-upload-area');
        const fileInput = document.getElementById('profile_image');
        
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#0056b3';
            this.style.backgroundColor = '#f0f8ff';
        });
        
        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#007bff';
            this.style.backgroundColor = '#f8fdff';
        });
        
        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#007bff';
            this.style.backgroundColor = '#f8fdff';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
        
        // Add form submission tracking
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('profile_image');
            const uploadStatus = document.getElementById('upload-status');
            
            if (fileInput.files.length > 0) {
                console.log('Form submitting with file:', fileInput.files[0].name);
                uploadStatus.textContent = 'Uploading...';
                uploadStatus.style.color = '#ffc107';
            }
        });
    </script>
</body>
</html>