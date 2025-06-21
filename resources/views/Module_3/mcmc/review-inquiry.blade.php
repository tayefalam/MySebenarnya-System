<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Inquiries</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        /* Make the first row (table header) green */
        table thead tr {
            background-color: #0e630e;
            color: white;
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
            <li><a href="#">Review Inquiry</a></li>
            <li><a href="{{ route('report.form') }}">Report</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>

    <!-- Search bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search Inquiry">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-container">
        <div class="profile-card" style="width: 90%; overflow-x: auto;">
            <h2 style="color: black;">All Inquiries</h2>

            @if ($inquiries->isEmpty())
                <p>No inquiries found.</p>
            @else
                <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr class="table-header-mcmc">
                            <th>Inquiry ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiries as $inquiry)
                            <tr>
                                <td>{{ $inquiry->Inquiry_ID }}</td>
                                <td>{{ $inquiry->Inquiry_Title }}</td>
                                <td>{{ $inquiry->Inquiry_Desc }}</td>
                                <td>{{ \Carbon\Carbon::parse($inquiry->Inquiry_SubDate)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('assign.form', ['inquiry_id' => $inquiry->Inquiry_ID]) }}">
                                        <button class="edit-btn">Assign</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</body>
</html>
