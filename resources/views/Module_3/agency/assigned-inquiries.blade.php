<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Inquiries</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
    <style>
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.report-table th, table.report-table td {
            border: 1px solid #999;
            padding: 10px;
            text-align: left;
        }

        table.report-table thead tr {
            background-color: #f2f2f2; /* Light grey header */
        }

        .btn-view {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="login-body">

    <!-- Top Navbar -->
    <nav class="navbar agency-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Agency User</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">News Updates</a></li>
            <li><a href="#">Assigned Inquiry</a></li>
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

    <!-- Assigned Inquiries Content -->
    <div class="profile-container">
        <div class="profile-card" style="width: 95%;">
            <h2 style="color: black; text-align: center;">Assigned Inquiries</h2>

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($assignments->isEmpty())
                <p>No inquiries assigned.</p>
            @else
                <table class="report-table">
                    <thead class="table-header-agency"> 
                        <tr>
                            <th>Assignment ID</th>
                            <th>Inquiry ID</th>
                            <th>Inquiry Title</th>
                            <th>Assigned Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->Assignment_ID }}</td>
                                <td>{{ $assignment->Inquiry_ID }}</td>
                                <td>{{ $assignment->inquiry->Inquiry_Title ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->Assigned_Date)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('agency.review.jurisdiction', ['assignment_id' => $assignment->Assignment_ID]) }}">
                                        <button class="btn-view">View</button>
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
