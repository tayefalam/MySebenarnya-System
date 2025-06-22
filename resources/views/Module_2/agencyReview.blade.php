@include('layouts.app', ['agency' => true])

@section('content')
<div class="container mt-4 rounded shadow p-4 bg-light">
    <h2>Public Inquiries</h2>

    <div class="d-flex justify-content-end mb-3">
        <form method="GET" action="{{ route('inquiries.agency') }}" class="d-flex gap-2">
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
            <th>Date Time</th>
            <th>Evidence</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($inquiries as $inquiry)
            <tr>
                <td>{{ $inquiry->user->Name ?? 'N/A' }}</td>
                <td>{{ $inquiry->user->Email ?? 'N/A' }}</td>
                <td style="max-width: 200px; white-space: normal; word-break: break-word;">{{ $inquiry->title }}</td>
                <td style="max-width: 250px; white-space: normal; word-break: break-word;">{{ $inquiry->description }}</td>
                <td>{{ $inquiry->created_at }}</td>
                <td>
                    @if($inquiry->evidence)
                        <a href="{{ route('inquiries.download', $inquiry->id) }}" class="btn btn-info btn-sm">Download</a>
                    @else
                        No Evidence
                    @endif
                </td>
                <td>
                    @if(is_null($inquiry->status))
                        Pending
                    @elseif($inquiry->status)
                        Accepted
                    @else
                        Rejected
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No inquiries found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
    </div>

{{ $inquiries->appends(request()->query())->links() }}