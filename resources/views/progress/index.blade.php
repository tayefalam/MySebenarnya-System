<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiry Progress Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ NAVIGATION BAR -->
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

<div class="container mt-5">
    <h2 class="mb-4 text-center">📌 Inquiry Progress Tracking</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Add New Progress</div>
        <div class="card-body">
            <form method="POST" action="/progress">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Inquiry ID</label>
                        <input type="number" name="inquiry_id" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Agency ID</label>
                        <input type="text" name="agency_id" class="form-control">
                    </div>
                    <div class="col">
                        <label class="form-label">MCMC ID</label>
                        <input type="text" name="mcmc_id" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" name="status" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Progress</button>
            </form>
        </div>
    </div>

    <!-- 🔍 Search Form -->
    <form method="GET" action="{{ url('/progress') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Inquiry ID or Status" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
            <a href="{{ url('/progress') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <h4 class="mb-3">📄 Inquiry Progress Records</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Inquiry ID</th>
                <th>Status</th>
                <th>Updated At</th>
                <th>Remarks</th>
                <th>Updated By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($progress as $item)
            <tr>
                <td>{{ $item->inquiry_id }}</td>
                <td>
                    <span class="badge 
                        @if($item->status == 'Pending') bg-warning 
                        @elseif($item->status == 'In Progress') bg-primary 
                        @elseif($item->status == 'Resolved') bg-success 
                        @else bg-secondary 
                        @endif">
                        {{ $item->status }}
                    </span>
                </td>
                <td>{{ $item->update_timestamp }}</td>
                <td>{{ $item->remarks ?? '—' }}</td>
                <td>
                    @if($item->mcmc_id)
                        MCMC ({{ $item->mcmc_id }})
                    @elseif($item->agency_id)
                        Agency ({{ $item->agency_id }})
                    @else
                        Unknown
                    @endif
                </td>
                <td>
                    <a href="{{ url('/progress/history/' . $item->inquiry_id) }}" class="btn btn-sm btn-outline-info">
                        View History
                    </a>
                    <a href="{{ url('/progress/' . $item->id . '/edit') }}" class="btn btn-sm btn-outline-warning">
                        Edit
                    </a>
                    <!-- ❌ Delete function removed as per SDD -->
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
