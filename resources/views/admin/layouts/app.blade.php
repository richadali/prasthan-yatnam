<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Prasthan Yatnam</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --primary-dark: #000080;
            --primary-light: #3a52c9;
            --accent-color: #FA8128;
            --text-light: #f8f9fa;
            --text-dark: #212529;
            --bg-light: #f8f9fa;
            --sidebar-transition: all 0.3s ease;
        }

        body {
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        #wrapper {
            display: flex;
        }

        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            transition: var(--sidebar-transition);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            z-index: 1000;
        }

        #sidebar-wrapper.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-heading {
            padding: 1.5rem 1rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text-light);
            display: flex;
            align-items: center;
        }

        .sidebar-heading .sidebar-logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
            background-color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-heading .sidebar-logo i {
            color: var(--primary-dark);
            font-size: 20px;
        }

        .list-group {
            width: 100%;
        }

        .list-group-item {
            background: transparent;
            color: var(--text-light);
            border: none;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: var(--sidebar-transition);
            border-left: 3px solid transparent;
        }

        .list-group-item-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            margin-right: 12px;
            transition: var(--sidebar-transition);
        }

        .list-group-item-text {
            white-space: nowrap;
            overflow: hidden;
            transition: var(--sidebar-transition);
        }

        .list-group-item.active,
        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--accent-color);
            border-left: 3px solid var(--accent-color);
            font-weight: 500;
        }

        /* Submenu styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            background-color: #1a237e;
        }

        .submenu.show {
            max-height: 200px;
            /* Adjust as needed */
        }

        .submenu .list-group-item {
            padding: 0.5rem 3rem;
            background-color: #1a237e;
        }

        .sidebar-dropdown-icon {
            transition: transform 0.3s;
            margin-left: auto;
            font-size: 0.8rem;
        }


        .fa-chevron-right.sidebar-dropdown-icon.rotate {
            transform: rotate(90deg);
        }

        .nav-item.dropdown .dropdown-menu {
            right: 0;
            left: auto;
        }

        #content-wrapper {
            min-width: 0;
            width: 100%;
            transition: var(--sidebar-transition);
        }

        /* Header styles */
        .admin-navbar {
            background-color: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .admin-navbar .navbar-brand {
            display: flex;
            align-items: center;
        }

        .sidebar-toggler {
            background-color: transparent;
            border: none;
            color: var(--text-dark);
            font-size: 1.5rem;
            padding: 0 0.5rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            font-weight: bold;
            margin-right: 0.5rem;
        }

        /* Main content area */
        .admin-content {
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                position: fixed;
                left: -250px;
                height: 100%;
            }

            #sidebar-wrapper.collapsed {
                left: 0;
                width: var(--sidebar-width);
            }

            #content-wrapper {
                margin-left: 0;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 999;
                display: none;
            }

            .overlay.show {
                display: block;
            }
        }

        /* Collapsed sidebar styles */
        #sidebar-wrapper.collapsed .list-group-item-text,
        #sidebar-wrapper.collapsed .sidebar-dropdown-icon,
        #sidebar-wrapper.collapsed .sidebar-heading span {
            display: none;
        }

        #sidebar-wrapper.collapsed .list-group-item {
            text-align: center;
            padding: 0.75rem 0;
            justify-content: center;
        }

        #sidebar-wrapper.collapsed .list-group-item-icon {
            margin-right: 0;
        }

        #sidebar-wrapper.collapsed .submenu {
            padding-left: 0;
        }
    </style>

    @yield('styles')
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <span>Prasthan Yatnam</span>
            </div>
            <div class="list-group list-group-flush">
                <!-- Dashboard Link -->
                <a href="{{ route('admin.dashboard') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="list-group-item-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="list-group-item-text">Dashboard</div>
                </a>

                <!-- Discourses Dropdown -->
                <div class="sidebar-menu-item">
                    <a href="#"
                        class="list-group-item list-group-item-action {{ request()->is('admin/discourses*') ? 'active' : '' }}"
                        data-toggle="collapse" data-target="#discoursesSubmenu">
                        <div class="list-group-item-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="list-group-item-text">Discourses</div>
                        <i
                            class="fas fa-chevron-right sidebar-dropdown-icon ms-auto {{ request()->is('admin/discourses*') ? 'rotate' : '' }}"></i>
                    </a>
                    <div class="submenu collapse {{ request()->is('admin/discourses*') ? 'show' : '' }}"
                        id="discoursesSubmenu">
                        <a href="{{ route('admin.discourses.index') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.discourses.index') ? 'active' : '' }}">
                            <div class="list-group-item-text">View All</div>
                        </a>
                        <a href="{{ route('admin.discourses.create') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.discourses.create') ? 'active' : '' }}">
                            <div class="list-group-item-text">Create New</div>
                        </a>
                    </div>
                </div>

                <!-- Enrollments Link -->
                <a href="{{ route('admin.enrollments.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/enrollments*') ? 'active' : '' }}">
                    <div class="list-group-item-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="list-group-item-text">Enrollments</div>
                </a>

                <!-- Testimonials Link -->
                <a href="{{ route('admin.testimonials.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                    <div class="list-group-item-icon">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="list-group-item-text">Testimonials</div>
                </a>

                <!-- Hero Images Link -->
                <a href="{{ route('admin.hero-images.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/hero-images*') ? 'active' : '' }}">
                    <div class="list-group-item-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="list-group-item-text">Banner Image</div>
                </a>

                <!-- Poems Link -->
                <a href="{{ route('admin.poems.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/poems*') ? 'active' : '' }}">
                    <div class="list-group-item-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="list-group-item-text">Poems</div>
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="content-wrapper">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg admin-navbar mb-4">
                <div class="container-fluid">
                    <button class="sidebar-toggler" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="navbar-brand ms-2">
                        @yield('page_title', 'Dashboard')
                    </span>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <span class="me-2">Welcome {{ Auth::guard('admin')->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>
                                            Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="admin-content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Overlay for mobile sidebar -->
        <div class="overlay" id="sidebarOverlay"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Admin Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar-wrapper');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    overlay.classList.toggle('show');
                });
            }
            
            // Close sidebar when clicking on overlay (mobile)
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('collapsed');
                    overlay.classList.remove('show');
                });
            }
            
            // Dropdown functionality in sidebar
            const submenuToggles = document.querySelectorAll('[data-toggle="collapse"]');
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const target = document.querySelector(targetId);
                    if (target) {
                        target.classList.toggle('show');
                        this.querySelector('.sidebar-dropdown-icon').classList.toggle('rotate');
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>