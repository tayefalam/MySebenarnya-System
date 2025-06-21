<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Inquiry to Agency</title>
    @vite(['resources/js/app.js'])
</head>
<body class="login-body">

    <!-- Top Navbar -->
    <nav class="navbar mcmc-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Admin (MCMC)</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="{{ route('dashboard.analytics') }}">Dashboard</a></li>
            <li><a href="{{ route('mcmc.inquiries.list') }}">Review Inquiry</a></li>
            <li><a href="{{ route('report.form') }}">Report</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>

    <!-- Search Bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search News">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main Form Content -->
    <div class="login-container">
        <div class="MCMClogin-header">Assign Inquiry to Agency</div>

        <div class="login-form">
            <!-- ✅ Success Message -->
            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ❌ Validation Errors -->
            @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('assign.inquiry') }}" method="POST">
                @csrf

                <input type="hidden" name="Inquiry_ID" value="{{ $inquiry->Inquiry_ID }}">

                <div class="form-group">
                    <label for="Agency_ID">Select Agency:</label>
                    <select name="Agency_ID" id="Agency_ID" required>
                        <option value="">-- Choose Agency --</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->Agency_ID }}">{{ $agency->Agency_Section }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="MCMC_ID">MCMC Staff ID:</label>
                    <input type="text" name="MCMC_ID" id="MCMC_ID" value="{{ old('MCMC_ID') }}" required>
                </div>

                <div class="form-group">
                    <label for="Reassigned">Is Reassigned?</label>
                    <select name="Reassigned" id="Reassigned" required>
                        <option value="0" {{ old('Reassigned') == "0" ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('Reassigned') == "1" ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Assigned_Date">Assignment Date:</label>
                    <input type="date" name="Assigned_Date" id="Assigned_Date" value="{{ old('Assigned_Date', date('Y-m-d')) }}" required>
                </div>

                <button type="submit" class="edit-btn">Assign Inquiry</button>
            </form>
        </div>
    </div>

</body>
</html>
