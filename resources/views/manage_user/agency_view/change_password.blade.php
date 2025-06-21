<!DOCTYPE html>
<html>
<head>
    <title>Change Password - Agency</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .password-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }
        .password-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .password-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .password-header p {
            color: #666;
            font-size: 14px;
        }
        .alert {
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40,167,69,0.3);
        }
        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        .password-requirements {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-size: 14px;
        }
        .password-requirements h4 {
            margin: 0 0 10px 0;
            color: #495057;
        }
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        .password-requirements li {
            margin-bottom: 5px;
            color: #6c757d;
        }
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .security-notice {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .security-notice .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <h2>🔐 Change Your Password</h2>
            <p>For security reasons, you must change your temporary password before accessing the system.</p>
        </div>

        <!-- Security Notice -->
        <div class="security-notice">
            <div class="icon">🛡️</div>
            <strong>Security Notice:</strong> You are currently using a temporary password. Please create a new secure password to continue.
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                <strong>✅ {{ session('success') }}</strong>
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

        <!-- Password Requirements -->
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

        <!-- Password Change Form -->
        <form action="{{ route('agency.change.password.submit') }}" method="POST">
            @csrf

            <!-- New Password -->
            <div class="form-group">
                <label for="password">New Password *</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Enter your new secure password">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       placeholder="Re-enter your new password">
                @error('password_confirmation')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">
                🔒 Update Password & Continue
            </button>
        </form>
    </div>

    <script>
        // Add real-time password validation feedback
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const requirements = document.querySelectorAll('.password-requirements li');
            
            // Check each requirement
            const checks = [
                password.length >= 8,
                /[A-Z]/.test(password),
                /[a-z]/.test(password),
                /[0-9]/.test(password),
                /[@$!%*?&#]/.test(password)
            ];
            
            requirements.forEach((req, index) => {
                if (checks[index]) {
                    req.style.color = '#28a745';
                    req.style.fontWeight = 'bold';
                } else {
                    req.style.color = '#6c757d';
                    req.style.fontWeight = 'normal';
                }
            });
        });
    </script>
</body>
</html>