<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MCMC Agency Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-message {
            background: #f8f9fa;
            border-left: 4px solid #0e630e;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .credentials-box {
            background: linear-gradient(135deg, #f8fff8, #fff);
            border: 2px solid #0e630e;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .credential-item {
            margin: 15px 0;
            padding: 12px;
            background: white;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .credential-label {
            font-weight: bold;
            color: #0e630e;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
            background: #f8f8f8;
            padding: 8px;
            border-radius: 4px;
            display: inline-block;
            min-width: 200px;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 20px;
            margin: 25px 0;
        }
        .security-notice h4 {
            color: #856404;
            margin-top: 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 25px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .agency-info {
            background: #e7f3ff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .agency-info h4 {
            color: #0066cc;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🏢 MCMC Agency Registration</h1>
            <p>Malaysian Communications and Multimedia Commission</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <h3>🎉 Registration Successful!</h3>
                <p>Congratulations! Your agency <strong>{{ $agencyName }}</strong> has been successfully registered with MCMC.</p>
            </div>

            <!-- Agency Information -->
            <div class="agency-info">
                <h4>📋 Agency Details</h4>
                <p><strong>Agency Name:</strong> {{ $agencyName }}</p>
                <p><strong>Agency ID:</strong> {{ $agencyId }}</p>
                <p><strong>Registration Date:</strong> {{ date('F d, Y') }}</p>
            </div>

            <!-- Login Credentials -->
            <div class="credentials-box">
                <h3>🔐 Your Login Credentials</h3>
                <p>Please use the following credentials to access your agency dashboard:</p>
                
                <div class="credential-item">
                    <div class="credential-label">Email (Login)</div>
                    <div class="credential-value">{{ $email }}</div>
                </div>
                
                <div class="credential-item">
                    <div class="credential-label">Password</div>
                    <div class="credential-value">{{ $password }}</div>
                </div>

                <a href="{{ url('/login') }}" class="login-button">
                    🚀 Login to Dashboard
                </a>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <h4>🛡️ Important Security Information</h4>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li><strong>Change Your Password:</strong> Please log in and change your password immediately for security purposes.</li>
                    <li><strong>Keep Credentials Safe:</strong> Do not share your login credentials with unauthorized personnel.</li>
                    <li><strong>Secure Login:</strong> Always log out after using the system, especially on shared computers.</li>
                    <li><strong>Contact Support:</strong> If you experience any issues, contact MCMC support immediately.</li>
                </ul>
            </div>

            <!-- Next Steps -->
            <div style="background: #e8f5e8; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h4>📋 Next Steps</h4>
                <ol>
                    <li>Click the "Login to Dashboard" button above</li>
                    <li>Enter your username and password</li>
                    <li>Complete your agency profile setup</li>
                    <li>Upload required documents</li>
                    <li>Await approval from MCMC administrators</li>
                </ol>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Malaysian Communications and Multimedia Commission (MCMC)</strong></p>
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>If you need assistance, please contact our support team.</p>
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} MCMC. All rights reserved.<br>
                Email sent on {{ date('F d, Y \a\t g:i A') }}
            </p>
        </div>
    </div>
</body>
</html>