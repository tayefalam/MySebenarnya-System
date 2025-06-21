<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Analytics</title>
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            margin: 0px auto;
            max-width: 1200px;
        }

        .chart-box {
            flex: 1 1 45%;
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .chart-box h3 {
            color: #0e630e;
            margin-bottom: 20px;
        }

        canvas {
            margin-top: 20px;
        }
        
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

<!-- Dashboard Analytics -->
<div class="profile-container" style="margin-top: 0px; padding-top: 0; margin-bottom: 0px; padding-bottom: 0px;">
    <div class="profile-card" style="width: 95%; margin-bottom: 0px; padding-bottom: 10px;">
        <h2 style="color: black;">Dashboard Analytics</h2>
        <p style="font-size: 18px; margin-top: 10px; margin-bottom: 0px;">
            <strong>Total Assignments:</strong> {{ $totalAssignments }}
        </p>
    </div>
</div>

<!-- Graphs Section Side by Side -->
<div class="chart-section" style="margin-top: 0px;">
    <div class="chart-box">
        <h3>Assignments Per Agency</h3>
        <canvas id="agencyChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Assignments Per Month</h3>
        <canvas id="monthlyChart"></canvas>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
    // Bar Chart for Assignments Per Agency
    const agencyChart = new Chart(document.getElementById('agencyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($assignmentsPerAgency->keys()) !!},
            datasets: [{
                label: 'Assignments',
                data: {!! json_encode($assignmentsPerAgency->values()) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                borderRadius: 10,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            }
        }
    });

    // Pie Chart for Assignments Per Month
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($assignmentsPerMonth->keys()) !!},
            datasets: [{
                label: 'Monthly Assignments',
                data: {!! json_encode($assignmentsPerMonth->values()) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56',
                    '#4BC0C0', '#9966FF', '#FF9F40',
                    '#F7464A', '#46BFBD', '#FDB45C',
                    '#949FB1', '#4D5360', '#E7E9ED'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ": " + context.raw;
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
