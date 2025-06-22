<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Jurisdiction</title>
    @vite(['resources/js/app.js'])

    <script>
        function toggleRejectionField() {
            const status = document.getElementById('Jurisdiction_Status').value;
            const reasonField = document.getElementById('rejection_reason_wrapper');
            reasonField.style.display = (status === 'Out of Jurisdiction') ? 'block' : 'none';
        }

        window.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const jurisdictionSelect = document.getElementById('Jurisdiction_Status');
            const rejectionWrapper = document.getElementById('rejection_reason_wrapper');
            const successMsg = document.getElementById('success-message');

            // Reset form and hide rejection reason if success
            @if (session('success'))
                if (form) {
                    form.reset();
                    rejectionWrapper.style.display = 'none';
                }
                // Auto-hide success message
                setTimeout(() => {
                    if (successMsg) successMsg.style.display = 'none';
                }, 3000);
            @endif
        });
    </script>
</head>
<body class="login-body">

    <!-- Top Navbar -->
    <nav class="navbar agency-header">
        <div class="navbar-brand">
            <strong>MYSEBENARNYA</strong><br><small>Agency User</small>
        </div>
        <ul class="navbar-menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="#">News Updates</a></li>
            <li><a href="{{ route('agency.assigned.list') }}">Assigned Inquiry</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Search Bar -->
    <div class="search-section">
        <div class="search-bar">
            <input type="text" placeholder="Search News">
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <!-- Main Form Content -->
    <div class="login-container">
        <div class="Agencylogin-header">Review Inquiry Jurisdiction</div>

        <div class="login-form">
            <!-- ✅ Success Message -->
            @if (session('success'))
                <div id="success-message" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ❌ Validation Errors -->
            @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ✅ Inquiry Info -->
            <div class="form-group">
                <label><strong>Inquiry Title:</strong></label>
                <p>{{ $assignment->inquiry->Inquiry_Title }}</p>
            </div>

            <div class="form-group">
                <label><strong>Description:</strong></label>
                <p>{{ $assignment->inquiry->Inquiry_Desc }}</p>
            </div>

            <!-- ✅ Review Form -->
            <form method="POST" action="{{ route('jurisdiction.submit') }}">
                @csrf

                <input type="hidden" name="Assignment_ID" value="{{ $assignment->Assignment_ID }}">
                <input type="hidden" name="Inquiry_ID" value="{{ $assignment->Inquiry_ID }}">
                <input type="hidden" name="Response_Date" value="{{ date('Y-m-d') }}">

                <div class="form-group">
                    <label for="Jurisdiction_Status">Jurisdiction Status:</label>
                    <select name="Jurisdiction_Status" id="Jurisdiction_Status" onchange="toggleRejectionField()" required>
                        <option value="">-- Select --</option>
                        <option value="Within">Within</option>
                        <option value="Out of Jurisdiction">Out of Jurisdiction</option>
                    </select>
                </div>

                <div class="form-group" id="rejection_reason_wrapper" style="display: none;">
                    <label for="Rejection_Reason">Rejection Reason:</label>
                    <input type="text" name="Rejection_Reason" id="Rejection_Reason">
                </div>

                <div class="form-group">
                    <label for="Agency_Comments">Agency Comments:</label>
                    <textarea name="Agency_Comments" id="Agency_Comments" rows="4"></textarea>
                </div>

                <button type="submit" class="edit-btn">Submit Review</button>
            </form>
        </div>
    </div>
    
@if (session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.reload();
</script>
@endif

</body>
</html>
