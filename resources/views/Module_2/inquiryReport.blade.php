
@include('layouts.app', ['mcmc' => true])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiry Report</title>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-4 rounded shadow p-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Inquiry Report</h2>
            <a href="{{ route('inquiries.report.download') }}" class="btn btn-sm btn-outline-primary">Download PDF</a>
        </div>
<div class="table-responsive">
       <div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Inquiries</h5>
                    <p class="card-text fs-4">{{ $totalInquiries }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Accepted</h5>
                    <p class="card-text fs-4">{{ $accepted }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rejected</h5>
                    <p class="card-text fs-4">{{ $rejected }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="card">
            <div class="card-body">
                <canvas id="inquiryChart" height="100"></canvas>
            </div>
        </div>
    </div>
    </div>
    <script>
        const ctx = document.getElementById('inquiryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'accepted', 'Rejected'],
                datasets: [{
                    label: 'Number of Inquiries',
                    data: [{{ $totalInquiries }}, {{ $accepted }}, {{ $rejected }}],
                    backgroundColor: [
                        'rgba(0, 123, 255, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
</body>
</html>

