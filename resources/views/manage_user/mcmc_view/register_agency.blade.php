<!DOCTYPE html>
<html>
<head>
    <title>Register Agency - MCMC Dashboard</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .agency-register-container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .agency-register-header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .agency-register-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .agency-register-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .agency-register-form {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.single {
            grid-template-columns: 1fr;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        label i {
            margin-right: 8px;
            color: #0e630e;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #0e630e;
            box-shadow: 0 0 0 3px rgba(14, 99, 14, 0.1);
        }

        input::placeholder {
            color: #999;
        }

        .required {
            color: #dc3545;
        }

        .form-help {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .form-help i {
            color: #666;
            font-size: 12px;
        }

        .auto-credentials-info {
            background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
            border: 2px solid #0e630e;
            border-radius: 10px;
            padding: 20px;
            margin-top: 10px;
        }

        .auto-credentials-info h4 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #0e630e;
            font-weight: 600;
        }

        .info-box {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item i {
            color: #0e630e;
            font-size: 18px;
            margin-right: 15px;
            margin-top: 2px;
        }

        .info-item strong {
            color: #333;
            font-size: 14px;
            display: block;
            margin-bottom: 3px;
        }

        .info-item p {
            margin: 0;
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }

        .security-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 12px;
            font-size: 13px;
            color: #856404;
        }

        .security-note i {
            color: #856404;
            margin-right: 8px;
        }

        .register-btn {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .register-btn:hover {
            background: linear-gradient(135deg, #0a4d0a, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 99, 14, 0.3);
        }

         .back-btn {
            display: inline-flex;
            align-items: center;
            color: #0e630e;
            text-decoration: none;
            padding: 12px 20px;
            border: 2px solid #0e630e;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-btn:hover {
            background: #0e630e;
            color: white;
        }

        .back-btn i {
            margin-right: 8px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
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
            <li><a href="{{ route('mcmc.register.agency') }}" class="active">Register Agency</a></li>
            <li><a href="{{ route('mcmc.view.registered.users') }}">Registered Users</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="{{ route('mcmc.profile') }}">Profile</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div class="agency-register-container">
        <!-- Header -->
        <div class="agency-register-header">
            <h2><i class="fas fa-building"></i> Register New Agency</h2>
        </div>

        <!-- Form Content -->
        <div class="agency-register-form">
           
            <!-- Back Button -->
            <a href="{{ route('mcmc.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('mcmc.register.agency.submit') }}" id="agencyRegisterForm">
                @csrf

                <!-- Agency Information Section -->
                <div style="border-bottom: 2px solid #e9ecef; padding-bottom: 30px; margin-bottom: 30px;">
                    <h3 style="color: #0e630e; margin-bottom: 20px; font-size: 18px;">
                        <i class="fas fa-info-circle"></i> Agency Information
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="agency_name">
                                <i class="fas fa-building"></i>
                                Agency Name <span class="required">*</span>
                            </label>
                            <input type="text" id="agency_name" name="agency_name" value="{{ old('agency_name') }}" required>
                            <div class="form-help">
                                <i class="fas fa-info-circle"></i> Enter the full official name of your agency
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="agency_section">
                                <i class="fas fa-sitemap"></i>
                                Agency Section <span class="required">*</span>
                            </label>
                            <select id="agency_section" name="agency_section" required>
                                <option value="">Select Section</option>
                                <option value="Communications" {{ old('agency_section') == 'Communications' ? 'selected' : '' }}>Communications</option>
                                <option value="Broadcasting" {{ old('agency_section') == 'Broadcasting' ? 'selected' : '' }}>Broadcasting</option>
                                <option value="Multimedia" {{ old('agency_section') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                                <option value="Postal Services" {{ old('agency_section') == 'Postal Services' ? 'selected' : '' }}>Postal Services</option>
                                <option value="Digital Services" {{ old('agency_section') == 'Digital Services' ? 'selected' : '' }}>Digital Services</option>
                                <option value="Regulatory Affairs" {{ old('agency_section') == 'Regulatory Affairs' ? 'selected' : '' }}>Regulatory Affairs</option>
                                <option value="Technical Services" {{ old('agency_section') == 'Technical Services' ? 'selected' : '' }}>Technical Services</option>
                                <option value="Other" {{ old('agency_section') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row single">
                        <div class="form-group">
                            <label for="agency_address">
                                <i class="fas fa-map-marker-alt"></i>
                                Agency Address <span class="required">*</span>
                            </label>
                            <input type="text" id="agency_address" name="agency_address" value="{{ old('agency_address') }}" required>
                            <div class="form-help">
                                <i class="fas fa-info-circle"></i> Full physical address of your agency
                            </div>
                        </div>
                    </div>

                    <div class="form-row single">
                        <div class="form-group">
                            <label for="agency_website">
                                <i class="fas fa-globe"></i>
                                Agency Website (Optional)
                            </label>
                            <input type="url" id="agency_website" name="agency_website" value="{{ old('agency_website') }}" placeholder="https://example.com">
                            <div class="form-help">
                                <i class="fas fa-info-circle"></i> Official website URL (if available)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div style="border-bottom: 2px solid #e9ecef; padding-bottom: 30px; margin-bottom: 30px;">
                    <h3 style="color: #0e630e; margin-bottom: 20px; font-size: 18px;">
                        <i class="fas fa-phone"></i> Contact Information
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="agency_email">
                                <i class="fas fa-envelope"></i>
                                Agency Email <span class="required">*</span>
                            </label>
                            <input type="email" id="agency_email" name="agency_email" value="{{ old('agency_email') }}" required>
                            <div class="form-help">
                                <i class="fas fa-info-circle"></i> Official email address for communication
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="agency_phone">
                                <i class="fas fa-phone"></i>
                                Phone Number <span class="required">*</span>
                            </label>
                            <input type="tel" id="agency_phone" name="agency_phone" value="{{ old('agency_phone') }}" required>
                            <div class="form-help">
                                <i class="fas fa-info-circle"></i> Primary contact phone number
                            </div>
                        </div>
                    </div>
                </div>


                <button type="submit" class="register-btn">
                    <i class="fas fa-plus-circle"></i>
                    Register Agency
                </button>
            </form>
        </div>
    </div>

    <script>
        // Form validation and enhancement
        document.getElementById('agencyRegisterForm').addEventListener('submit', function(e) {
            // Show loading state
            const submitBtn = e.target.querySelector('.register-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering Agency...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>