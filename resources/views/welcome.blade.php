<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to MySebenarnya System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #0C356A;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }
        .navbar-custom .nav-link:hover {
            color: #FFD93D;
        }
    </style>
</head>
<body>
    <!-- 🔷 Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MySebenarnya</a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/progress">Inquiry Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/report">Progress Report</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Welcome Section -->
    <div class="container mt-5 text-center">
        <h1 class="mb-4">👋 Welcome to MySebenarnya System</h1>
        <p class="lead">This platform helps you track and manage inquiry progress across agencies and MCMC.</p>

        <div class="mt-4">
            <a href="/progress" class="btn btn-primary me-2">Go to Inquiry Progress</a>
            <a href="/report" class="btn btn-outline-primary">View Report Summary</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
