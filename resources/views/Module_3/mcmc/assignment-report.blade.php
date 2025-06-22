<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment Report</title>
    @vite(['resources/js/app.js'])
    <style>
        /* Center the search bar */
        .search-section {
            background-color: #e0e0e0;
            height: auto;
            padding: 20px 0;
            width: 100%;
            text-align: center;
        }
        
        .search-bar {
            background-color: white;
            border: 2px solid #ccc;
            border-radius: 30px;
            padding: 5px 20px;
            display: flex;
            align-items: center;
            width: 500px;
            margin: 0 auto;
        }
        
        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            padding: 5px;
            font-size: 16px;
        }
        
        .search-bar button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding-right: 5px;
        }
    </style>
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
    <div class="profile-container" style="margin: 0px; padding: 0px;">
        <div class="profile-card" style="width: 98%; overflow-x: auto; margin: 0px; padding: 20px; max-width: none;">
            <h2 style="color: black; margin-top: 0px;">Inquiry Assignment Report</h2>

            <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 20px; min-width: 800px; font-size: 14px;">
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
