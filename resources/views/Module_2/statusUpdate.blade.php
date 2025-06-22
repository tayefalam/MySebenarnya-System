@extends('layouts.app', ['user' => true])
@section('content')
<div class="container mt-4 rounded shadow p-4 bg-light">
    <h1 class="mb-4">Your Inquiry Status</h1>
    <div class="d-flex justify-content-end mb-3">
        <form method="GET" action="{{ route('inquiries.status') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search by title or description" value="{{ request('search') }}">
            
            <select name="status" class="form-select">
                <option value="">Display All</option>
                <option value="accepted" {{ request('status') == 'true' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ request('status') == 'false' ? 'selected' : '' }}>Rejected</option>
                <option value="pending" {{ request('status') == 'null' ? 'selected' : '' }}>Pending</option>
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Date Time</th>
                <th>Submitted Evidence</th>
            </tr>
        </thead>
        <tbody>
    @if($inquiries->count() > 0)
        @foreach($inquiries as $inquiry)
            <tr>
                <td>{{ $inquiry->user->Name ?? 'N/A' }}</td>
                <td>{{ $inquiry->user->Email ?? 'N/A' }}</td>
                <td style="max-width: 200px; white-space: normal; word-break: break-word;">
                {{ $inquiry->title }}</td>
                <td style="max-width: 250px; white-space: normal; word-break: break-word;">
                {{ $inquiry->description }}</td>
                <td>
                    @if (is_null($inquiry->status))
                        Pending
                    @elseif ($inquiry->status)
                        Accepted
                    @else
                        Rejected
                    @endif
                </td>
                <td>{{ $inquiry->created_at }}</td>
                <td>
                    @if ($inquiry->evidence)
                        <a href="{{ route('inquiries.download', $inquiry->id) }}" class="btn btn-sm btn-info">Download</a>
                    @else
                        No Evidence
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10" class="text-center text-muted">No inquiries found.</td>
        </tr>
    @endif
</tbody>

    </table>
    <div class="d-flex justify-content-center">
    {{ $inquiries->appends(request()->query())->links() }}
    </div>
</div>
</div>
@endsection