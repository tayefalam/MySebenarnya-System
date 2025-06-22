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
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
        }

        .navbar-mcmc {
            background-color: #0e630e;
        }

        .navbar-agency {
            background-color: #921b35;
        }

        .navbar-default {
            background-color: #0b6094;
        }

        .navbar-custom .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
            padding: 6px 12px;
        }

        .navbar-custom .nav-link:hover {
            text-decoration: underline;
        }

        .user-name {
            font-size: 14px;
            color: white;
            margin-top: -10px;
        }
    </style>

    @yield('styles')
</head>
<body>
    @php
        $navbarClass = 'navbar-default';
        if (isset($mcmc) && $mcmc) $navbarClass = 'navbar-mcmc';
        elseif (isset($agency) && $agency) $navbarClass = 'navbar-agency';
    @endphp

    <nav class="navbar navbar-expand-lg navbar-custom {{ $navbarClass }}">
        <div class="container-fluid">

            <div class="d-flex flex-column align-items-start text-white">
                <span class="navbar-brand mb-0">MYSEBENARNYA</span>
                @auth
                    <span class="user-name ms-">Hello {{ Auth::user()->Name }} !</span>
                @endauth
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

             <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">

                    @if(isset($mcmc) && $mcmc)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.review') }}">Inquiry Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.report') }}">Inquiry Report</a>
                        </li>
                    @elseif(isset($agency) && $agency)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.agency') }}">Public Inquiries</a>
                        </li>
                    @elseif(isset($user) && $user)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.create') }}">Add Inquiry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.public') }}">View Public Inquiries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inquiries.status') }}">Status of Submitted Inquiries</a>
                        </li>
                    @endif

                    @auth
                        @php
                            $profileRoute = match (Auth::user()->User_Type ?? null) {
                                'Public User' => route('user.profile.view'),
                                'Agency' => route('view.agency.profile'),
                                'MCMC' => route('mcmc.profile'),
                            };
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $profileRoute }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
