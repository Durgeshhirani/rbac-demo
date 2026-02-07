<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC Demo</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{route('dashboard')}}">
                RBAC Demo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                {{-- LEFT SIDE NAV --}}
                <ul class=" navbar-nav me-auto mb-2 mb-lg-0">

                    @auth
                    {{-- Employee Module --}}
                    @if(in_array(auth()->user()->role, ['org_hr','org_admin','super_admin']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.index') }}">
                            Employees
                        </a>
                    </li>
                    @endif

                    {{-- Leads / CRM Module --}}
                    @if(in_array(auth()->user()->role, ['org_sales','org_admin','super_admin']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leads.index') }}">
                            Leads
                        </a>
                    </li>
                    @endif
                    @endauth

                </ul>

                {{-- RIGHT SIDE NAV --}}
                <ul class="navbar-nav ms-auto">

                    @auth
                    <li class="nav-item me-3">
                        <span class="navbar-text text-white">
                            {{ auth()->user()->name }}
                            <small class=" text-white">
                                ({{ auth()->user()->organization?->name}})
                            </small>
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Logout?')">
                                Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>

    <div class="container mt-4">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        {{-- Page Content --}}
        @yield('content')

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>