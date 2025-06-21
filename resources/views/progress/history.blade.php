<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiry Progress History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ NAVBAR START -->
<nav class="navbar navbar-expand-lg" style="background-color: #1769aa;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">MYSEBENARNYA</a>
        <span class="navbar-text text-white">Module 4 - Admin</span>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/progress">View Progress</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/report">Report Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ✅ NAVBAR END -->

<div class="container mt-5">
    <h2 class="mb-4 text-center">🕒 Progress History for Inquiry ID: {{ $inquiry_id }}</h2>

    @if($history->isEmpty())
        <div class="alert alert-info">No history available for this inquiry.</div>
    @else
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Status</th>
                <th>Remarks</th>
                <th>Updated At</th>
                <th>Updated By</th>
            </tr>
        </thead>
        <tbody>
        @foreach($history as $item)
            <tr>
                <td>{{ $item->status }}</td>
                <td>{{ $item->remarks }}</td>
                <td>{{ $item->update_timestamp }}</td>
                <td>
                    @if($item->mcmc_id)
                        MCMC ({{ $item->mcmc_id }})
                    @elseif($item->agency_id)
                        Agency ({{ $item->agency_id }})
                    @else
                        Unknown
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ url('/progress') }}" class="btn btn-secondary mt-3">← Back to Progress</a>
</div>
</body>
</html>
