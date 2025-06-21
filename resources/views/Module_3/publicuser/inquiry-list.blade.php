<!DOCTYPE html>
<html>
<head>
    <title>My Submitted Inquiries</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
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
            <li><a href="#">View Inquiry</a></li>
            <li><a href="/view-user-profile">Profile</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>

    <!-- Inquiry Table Section -->
    <div class="table-container">
        <h2 style="text-align:center; margin-bottom: 20px;">My Submitted Inquiries</h2>

        @if($inquiries->isEmpty())
            <p style="text-align:center;">You have not submitted any inquiries yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Inquiry ID</th>
                        <th>Title</th>
                        <th>Submitted Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->Inquiry_ID }}</td>
                            <td>{{ $inquiry->Inquiry_Title }}</td>
                            <td>{{ $inquiry->Inquiry_SubDate }}</td>
                            <td>{{ $inquiry->Inquiry_Status }}</td>
                            <td>
                                <a href="{{ url('/inquiry/assigned-agency/' . $inquiry->Inquiry_ID) }}">
                                    <button>View Assigned Agency</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>
