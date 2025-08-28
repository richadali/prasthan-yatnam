<style>
    /* Header Banner Styles */
    .header-banner {
        position: relative;
        width: 100%;
        overflow: hidden;
    }


    .logo-container {
        position: absolute;
        top: 10px;
        right: 20px;
    }

    .header-logo {
        width: 150px;
        height: auto;
        border: 2px solid black;
    }

    /* Navigation Menu Styles */
    .navy-gradient {
        background: linear-gradient(to bottom, #0B0B45, #0000b3);
        padding: 0;
    }

    .navbar-nav {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .nav-link {
        color: white !important;
        font-weight: bold;
        padding: 15px 10px;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        position: relative;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #FA8128;
    }

    .dropdown-menu {
        background-color: #f8f9fa;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        padding: 0.5rem 1.5rem;
        color: #333;
    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    /* Make navbar sticky right below the header */
    .sticky-top {
        top: 0;
        z-index: 1020;
    }

    /* Mobile responsiveness */
    @media (max-width: 992px) {
        .navbar-collapse {
            background-color: #000080;
            padding: 10px;
        }

        .navbar-toggler {
            background-color: #FA8128;
            border: 1px solid white;
            padding: 4px 8px;
            margin: 6px 0;
            font-size: 0.8rem;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.2em;
            height: 1.2em;
        }

        .banner-text h1 {
            font-size: 2rem;
        }

        .banner-text p {
            font-size: 1rem;
        }

        .header-logo {
            width: 100px;
        }

        .nav-item {
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link {
            padding: 12px;
        }
    }
</style>

<!-- Header Banner -->
<div class="header-banner">
    <img src="{{ asset('images/HEADER2.jpg') }}" alt="Prasthan Yatnam Header" class="img-fluid w-100">

</div>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg sticky-top navy-gradient">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ url('/') }}">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('discourses') ? 'active' : '' }}"
                        href="{{ url('/discourses') }}">DISCOURSES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('poems') ? 'active' : '' }}"
                        href="{{ url('/poems') }}">POEMS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('activity') ? 'active' : '' }}"
                        href="{{ url('/activity') }}">ACTIVITY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('testimonials') ? 'active' : '' }}"
                        href="{{ url('/testimonials') }}">TESTIMONIAL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('gallery') || request()->is('gallery/*') ? 'active' : '' }}"
                        href="{{ url('/gallery') }}">GALLERY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('about') ? 'active' : '' }}"
                        href="{{ url('/about') }}">ABOUT</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('login') ? 'active' : '' }}"
                        href="{{ route('login') }}">LOGIN</a>
                </li>
                @endguest
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->full_name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('/my-discourses') }}">My Discourses</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>