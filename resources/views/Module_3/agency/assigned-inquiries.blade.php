<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Inquiries</title>
    @vite(['resources/js/app.js'])
    <style>
        /* Make the first row (table header) green */
        table thead tr {
            background-color: #0e630e;
            color: white;
        }
        
        /* Center the search bar */
        .module3-search-section {
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
    <div class="module3-search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search Inquiry">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-container" style="margin-top: 0px; padding-top: 0;">
        <div class="profile-card" style="width: 90%; overflow-x: auto;">
            <h2 style="color: black;">Assigned Inquiries</h2>

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($assignments->isEmpty())
                <p>No inquiries assigned.</p>
            @else
                <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr class="table-header-agency">
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
