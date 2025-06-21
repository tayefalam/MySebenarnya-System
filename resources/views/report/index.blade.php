<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Report Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
</body>
</html>
