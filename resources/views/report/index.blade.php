<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Report Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ Navigation Bar Start -->
<nav class="navbar navbar-expand-lg" style="background-color: #0C356A;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">MySebenarnya</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon bg-light"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/progress">📌 Inquiry Progress</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/report">📊 Report Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/">🏠 Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ✅ Navigation Bar End -->

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Inquiry Progress Report Summary</h2>

    <div class="row text-center mb-4">
        <div class="col">
            <div class="card bg-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Records</h5>
                    <p class="display-6">{{ $total }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="display-6">{{ $pending }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <p class="display-6">{{ $inProgress }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Resolved</h5>
                    <p class="display-6">{{ $resolved }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="/progress" class="btn btn-secondary">← Back to Progress</a>
    </div>
</div>

<!-- Bootstrap JS (for responsive navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
