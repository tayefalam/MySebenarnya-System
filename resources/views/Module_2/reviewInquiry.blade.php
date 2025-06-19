@extends('layouts.app', ['mcmc' => true])
@section('content')
@if(session('success'))
    <div class="alert alert-success text-center mx-auto" style="max-width: 400px;" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        
        setTimeout(function () {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.2s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 200); 
            }
        }, 2000);
    </script>
@endif
<div class="container mt-4 rounded shadow p-4 bg-light">
    <h2>Review Inquiries</h2>
        <div class="d-flex justify-content-end mb-3">
        <form method="GET" action="{{ route('inquiries.review') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search by title or description" value="{{ request('search') }}">
            
            <select name="status" class="form-select">
                <option value="">Display All</option>
                <option value="approved" {{ request('status') == 'true' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'false' ? 'selected' : '' }}>Rejected</option>
                <option value="pending" {{ request('status') == 'null' ? 'selected' : '' }}>Pending</option>
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date Time</th>
                <th>Evidence</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
    @if($inquiries->count() > 0)
        @foreach($inquiries as $inquiry)
        <tr>
            <td style="max-width: 200px; white-space: normal; word-break: break-word;">
            {{ $inquiry->title }}</td>
            <td style="max-width: 250px; white-space: normal; word-break: break-word;">
            {{ $inquiry->description }}</td>
            <td>{{ $inquiry->created_at }}</td>
            <td>
                @if($inquiry->evidence)
                    <a href="{{ route('inquiries.download', $inquiry->id) }}" class="btn btn-sm btn-info">Download</a>
                @else
                    No Evidence
                @endif
            </td>
            <td>
                @if (is_null($inquiry->status))
                    Pending
                @elseif ($inquiry->status)
                    Approved
                @else
                    Rejected
                @endif
            </td>
            <td>
                <form action="{{ route('inquiries.updateStatus', $inquiry->id) }}" method="POST">
                    @csrf
                    <select name="status" class="form-select form-select-sm" required>
                        <option value="approved" {{ $inquiry->status === true ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $inquiry->status === false ? 'selected' : '' }}>Rejected</option>
                        <option value="pending" {{ is_null($inquiry->status) ? 'selected' : '' }}>Pending</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm mt-1">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center text-muted">No inquiries found.</td>
        </tr>
    @endif
</tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $inquiries->appends(request()->query())->links() }}
    </div>
</div>
@endsection