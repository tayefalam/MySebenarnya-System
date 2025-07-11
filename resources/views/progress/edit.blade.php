<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Inquiry Progress</title>
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
    <h2 class="mb-4 text-center">✏️ Edit Progress Entry</h2>

    <!-- ✅ Make sure you use progress_id here -->
    <form method="POST" action="{{ url('/progress/' . $progress->progress_id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" name="status" class="form-control" value="{{ $progress->status }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="4">{{ $progress->remarks }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ url('/progress') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
