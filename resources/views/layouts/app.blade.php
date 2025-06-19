<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MYSEBENARNYA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #dedede;
        }

        .navbar-custom {
            background-color: #0b6094;
            padding-top: 1.2rem;
            padding-bottom: 1.2rem;
        }

        .navbar-custom .navbar-brand {
            font-size: 32px;
            font-weight: bold;
            color: white !important;
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: bold;
            text-decoration: none;
            font-size: 20px;
            padding: 10px 18px;
        }

        .navbar-custom .nav-link:hover {
            text-decoration: underline;
        }
    </style>

    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MYSEBENARNYA</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCentered"
                aria-controls="navbarCentered" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarCentered">
                <ul class="navbar-nav">
                    @if(isset($mcmc) && $mcmc)
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.review') }}">Inquiry Review</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.report') }}">Inquiry Report</a>
                        </li>
                    @elseif(isset($agency) && $agency)
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.agency') }}">Public Inquiries -Agency-</a>
                        </li>
                    @elseif(isset($user) && $user)
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.create') }}">Add Inquiry</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.public') }}">View Public Inquiries</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{{ route('inquiries.status') }}">Status of Submitted Inquiries</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

