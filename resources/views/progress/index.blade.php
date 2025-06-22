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
                <li class="nav-item"><a class="nav-link text-white" href="/">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/progress">View Progress</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/report">Report Summary</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📌 Inquiry Progress Tracking</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    <!-- ✅ Add Progress Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Progress</div>
        <div class="card-body">
            <form method="POST" action="/progress">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Inquiry Name</label>
                    <select name="inquiry_id" class="form-select" required>
                        <option value="">-- Select Inquiry --</option>
                        @foreach($inquiries as $inquiry)
                            <option value="{{ $inquiry->id }}">{{ $inquiry->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Select Status --</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Remarks</label>
                    <select name="remarks" class="form-select">
                        <option value="">-- Select Remarks --</option>
                        <option value="Acknowledged">Acknowledged</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Progress</button>
            </form>
        </div>
    </div>

    <!-- 🔍 Search Form -->
    <form method="GET" action="{{ url('/progress') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Inquiry Name or Status" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
            <a href="{{ url('/progress') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <!-- 📋 Progress Listing Table -->
    <h4 class="mb-3">📄 Inquiry Progress Records</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Inquiry Name</th>
                <th>Status</th>
                <th>Updated At</th>
                <th>Remarks</th>
                <th>Agency</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($progress as $item)
            <tr>
                <td>{{ $item->inquiry->title ?? 'Unknown' }}</td>
                <td>
                    <span class="badge 
                        @if($item->status == 'Pending') bg-warning 
                        @elseif($item->status == 'In Progress') bg-primary 
                        @elseif($item->status == 'Resolved') bg-success 
                        @elseif($item->status == 'Rejected') bg-danger 
                        @else bg-secondary 
                        @endif">
                        {{ $item->status }}
                    </span>
                </td>
                <td>{{ $item->update_timestamp }}</td>
                <td>{{ $item->remarks ?? '—' }}</td>
                <td>{{ $item->agency->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ url('/progress/history/' . $item->inquiry_id) }}" class="btn btn-sm btn-outline-info">View History</a>
                    <a href="{{ url('/progress/' . $item->progress_id . '/edit') }}" class="btn btn-sm btn-outline-warning">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
