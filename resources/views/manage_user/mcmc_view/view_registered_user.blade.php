<!DOCTYPE html>
<html>
<head>
    <title>View Registered Users - MCMC</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
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

        .users-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .table-header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 20px;
        }

        .table-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-icon {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .user-type-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .type-agency {
            background: #e3f2fd;
            color: #1976d2;
        }

        .type-public {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-resend {
            background: #007bff;
            color: white;
        }

        .btn-resend:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-card i {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .stat-card p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .stat-total {
            color: #0e630e;
        }

        .stat-today {
            color: #007bff;
        }

        .stat-week {
            color: #ffc107;
        }

        .no-users {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .no-users i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #ccc;
        }

        .email-notice {
            background: #e3f2fd;
            border: 2px solid #2196f3;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #1976d2;
        }

        .email-notice i {
            margin-right: 8px;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 10px 20px;
            border: 2px solid #0e630e;
            border-radius: 25px;
            text-decoration: none;
            color: #0e630e;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-tab.active,
        .filter-tab:hover {
            background: #0e630e;
            color: white;
        }

        .filter-tab.agency {
            border-color: #1976d2;
            color: #1976d2;
        }

        .filter-tab.agency.active,
        .filter-tab.agency:hover {
            background: #1976d2;
            color: white;
        }

        .filter-tab.public {
            border-color: #7b1fa2;
            color: #7b1fa2;
        }

        .filter-tab.public.active,
        .filter-tab.public:hover {
            background: #7b1fa2;
            color: white;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #0e630e;
            box-shadow: 0 0 0 3px rgba(14, 99, 14, 0.1);
        }

        .user-count {
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            color: #495057;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('mcmc.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-users"></i> Registered Users</h1>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <i class="fas fa-users stat-total"></i>
                <h3 class="stat-total">{{ $users->count() }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-building stat-today"></i>
                <h3 class="stat-today">{{ $users->where('User_Type', 'Agency')->count() }}</h3>
                <p>Agencies</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-user stat-week"></i>
                <h3 class="stat-week">{{ $users->where('User_Type', 'Public User')->count() }}</h3>
                <p>Public Users</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-day stat-today"></i>
                <h3 class="stat-today">{{ $users->where('created_at', '>=', today())->count() }}</h3>
                <p>Registered Today</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterUsers('all')">
                <i class="fas fa-users"></i> All Users
            </button>
            <button class="filter-tab agency" onclick="filterUsers('agency')">
                <i class="fas fa-building"></i> Agencies Only
            </button>
            <button class="filter-tab public" onclick="filterUsers('public')">
                <i class="fas fa-user"></i> Public Users Only
            </button>
        </div>

        <!-- Search Container -->
        <div class="search-container">
            <input type="text" id="userSearch" class="search-box" placeholder="Search users by name or email..." onkeyup="searchUsers()">
            <div class="user-count">
                Showing <span class="visible-count">{{ $users->count() }}</span> of {{ $users->count() }} users
            </div>
        </div>

        <!-- Users Table -->
        @if($users->count() > 0)
            <div class="users-table">
                <div class="table-header">
                    <h3><i class="fas fa-list"></i> User List</h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User Info</th>
                                <th>Contact</th>
                                <th>Type & Details</th>
                                <th>Registration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="user-row" data-user-type="{{ $user->User_Type == 'Public User' ? 'public' : strtolower($user->User_Type) }}">
                                    <td>
                                        <div class="user-info">
                                            <div class="user-icon">
                                                <i class="fas fa-{{ $user->User_Type == 'Agency' ? 'building' : 'user' }}"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $user->Name }}</strong><br>
                                                <small><strong>ID:</strong> {{ $user->User_ID }}</small><br>
                                                <span class="user-type-badge type-{{ strtolower($user->User_Type) }}">
                                                    {{ $user->User_Type }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <i class="fas fa-envelope"></i> {{ $user->Email }}<br>
                                            <i class="fas fa-phone"></i> {{ $user->Contact_Number }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->User_Type == 'Agency' && $user->agency)
                                            <div>
                                                <i class="fas fa-building"></i> <strong>Agency</strong><br>
                                                <small>Section: {{ $user->agency->Agency_Section }}</small><br>
                                                <small>Agency ID: {{ $user->agency->Agency_ID }}</small>
                                            </div>
                                        @else
                                            <div>
                                                <i class="fas fa-user-circle"></i> <strong>Public User</strong><br>
                                                <small>Individual Registration</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <i class="fas fa-calendar"></i> {{ $user->created_at->format('d/m/Y') }}<br>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($user->Status) }}">
                                            {{ $user->Status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <form method="POST" action="{{ route('mcmc.resend.credentials', $user->User_ID) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-resend" onclick="return confirm('Resend credentials to {{ $user->Email }}?')">
                                                    <i class="fas fa-paper-plane"></i> Resend Email
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('mcmc.users.destroy', $user->User_ID) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="users-table">
                <div class="no-users">
                    <i class="fas fa-users"></i>
                    <h3>No Users Registered</h3>
                    <p>No users have been registered yet.</p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('mcmc.register.agency') }}" class="btn btn-resend">
                            <i class="fas fa-building"></i> Register Agency
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-resend" style="background: #7b1fa2;">
                            <i class="fas fa-user-plus"></i> Register Public User
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Filter users function
        function filterUsers(type) {
            const userRows = document.querySelectorAll('.user-row');
            const filterTabs = document.querySelectorAll('.filter-tab');
            
            console.log('Filtering by type:', type); // Debug log
            
            // Remove active class from all tabs
            filterTabs.forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked tab
            event.target.classList.add('active');
            
            let visibleCount = 0;
            
            // Show/hide rows based on filter
            userRows.forEach(row => {
                const userType = row.getAttribute('data-user-type');
                console.log('Row user type:', userType); // Debug log
                
                if (type === 'all') {
                    row.style.display = '';
                    visibleCount++;
                } else if (type === userType) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            console.log('Visible rows:', visibleCount); // Debug log
            
            // Update visible count
            updateVisibleCount();
        }
        
        // Update visible user count
        function updateVisibleCount() {
            const visibleRows = document.querySelectorAll('.user-row:not([style*="display: none"])');
            const countElement = document.querySelector('.visible-count');
            if (countElement) {
                countElement.textContent = visibleRows.length;
            }
        }

        // Add search functionality
        function searchUsers() {
            const searchTerm = document.getElementById('userSearch').value.toLowerCase();
            const userRows = document.querySelectorAll('.user-row');
            
            userRows.forEach(row => {
                const userName = row.querySelector('strong').textContent.toLowerCase();
                const userEmail = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateVisibleCount();
        }

        // Debug function to show all user types on page load
        document.addEventListener('DOMContentLoaded', function() {
            const userRows = document.querySelectorAll('.user-row');
            console.log('All user types found:');
            userRows.forEach((row, index) => {
                const userType = row.getAttribute('data-user-type');
                const userName = row.querySelector('strong').textContent;
                console.log(`${index + 1}. ${userName}: ${userType}`);
            });
        });
    </script>
</body>
</html>