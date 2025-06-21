<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment Report</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
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

    <!-- Search bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search News">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main Report Section -->
    <div class="profile-container">
        <div class="profile-card" style="width: 90%; overflow-x: auto;">
            <h2 style="color: black;">Inquiry Assignment Report</h2>

            <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead class="table-header-mcmc"> 
                    <tr> 
                        <th>Assignment ID</th>
                        <th>Inquiry Title</th>
                        <th>Inquiry Description</th>
                        <th>Agency</th>
                        <th>MCMC Staff</th>
                        <th>Assigned Date</th>
                        <th>Reassigned</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->Assignment_ID }}</td>
                            <td>{{ $assignment->inquiry->Inquiry_Title ?? 'N/A' }}</td>
                            <td>{{ $assignment->inquiry->Inquiry_Desc ?? 'N/A' }}</td>
                            <td>{{ $assignment->agency->Agency_Section ?? 'N/A' }}</td>
                            <td>{{ $assignment->mcmc->MCMC_ID ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->Assigned_Date)->format('d M Y') }}</td>
                            <td>{{ $assignment->Reassigned ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
