
@extends('layouts.app', ['user' => true])
@section('content')
@if(session('success'))
    <div class="alert alert-success text-center mx-auto" style="max-width: 400px;" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        
        setTimeout(function () {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.4s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 400); 
            }
        }, 4000);
    </script>
@endif
<div class="container mt-4 rounded shadow p-4 bg-light">
    <h1 class="mb-4">Submit New Inquiry</h1>
    <div class="p-4 border rounded-4 shadow-sm bg-white">
        <form method="POST" action="{{ route('inquiries.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Evidence File</label>
                <input type="file" name="evidence" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
