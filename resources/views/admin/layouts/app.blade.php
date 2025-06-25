<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Prasthan Yatnam Admin</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-sidebar-bg: #141727;
            --bs-sidebar-color: #fff;
            --bs-primary: #5e72e4;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }

        .sidenav {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: var(--bs-sidebar-bg);
            color: var(--bs-sidebar-color);
            z-index: 1040;
            box-shadow: 0 0 2rem 0 rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .sidenav .navbar-brand {
            padding: 1.5rem;
            display: block;
            text-align: center;
            font-weight: 600;
            font-size: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidenav .navbar-nav {
            width: 100%;
            padding-top: 0.5rem;
        }

        .sidenav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.675rem 1.5rem;
            font-weight: 500;
            margin: 0.15rem 0;
            border-radius: 0.25rem;
            transition: all 0.15s ease;
        }

        .sidenav .nav-link:hover,
        .sidenav .nav-link.active {
            background-color: rgba(199, 199, 199, 0.1);
            color: #fff;
        }

        .sidenav .nav-link i {
            color: rgba(255, 255, 255, 0.6);
            margin-right: 0.5rem;
            width: 1.125rem;
        }

        .sidenav .nav-link:hover i,
        .sidenav .nav-link.active i {
            color: var(--bs-primary);
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .navbar-top {
            position: sticky;
            top: 0;
            background-color: #fff;
            box-shadow: 0 0 2rem 0 rgba(0, 0, 0, 0.15);
            padding: 0.75rem 1.5rem;
            z-index: 1030;
        }

        .navbar-top .navbar-nav .nav-link {
            color: #525f7f;
            padding: 0.5rem 0.75rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(87deg, #11cdef 0, #1171ef 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(87deg, #fb6340 0, #fbb140 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(87deg, #f5365c 0, #f56036 100%);
        }

        .bg-gradient-secondary {
            background: linear-gradient(87deg, #8898aa 0, #888aaa 100%);
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        .avatar {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
        }

        .avatar-sm {
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
        }

        /* Custom Hamburger Menu */
        #sidebarToggle {
            display: none;
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
            }

            .sidenav {
                transform: translateX(-100%);
            }

            .sidenav.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @yield('css')
</head>

<body>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical navbar-expand-xs" id="sidenav-main">
        <div class="sidenav-header">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                Prasthan Yatnam
            </a>
        </div>

        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tv"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.discourses.*') ? 'active' : '' }}"
                            href="{{ route('admin.discourses.index') }}">
                            <i class="fas fa-book"></i>
                            <span class="nav-link-text">Discourses</span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">System</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-link-text">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <nav class="navbar navbar-top navbar-expand navbar-light bg-white">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <button id="sidebarToggle" class="navbar-toggler d-block d-md-none" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <ul class="navbar-nav align-items-center ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <div class="avatar avatar-sm bg-gradient-primary">
                                        @auth('admin')
                                        <span>{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                                        @else
                                        <span>A</span>
                                        @endauth
                                    </div>
                                    <div class="media-body ms-2">
                                        @auth('admin')
                                        <span class="mb-0 font-weight-bold">{{ Auth::guard('admin')->user()->name
                                            }}</span>
                                        @else
                                        <span class="mb-0 font-weight-bold">Admin</span>
                                        @endauth
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="#" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page content -->
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- JavaScript files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidenav').classList.toggle('show');
        });
    </script>

    @yield('scripts')
</body>

</html>