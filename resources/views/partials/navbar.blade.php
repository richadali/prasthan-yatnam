<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Prasthan Yatnam Logo" class="logo-img me-2" width="50"
                height="50">
            <h1 class="h4 mb-0 fw-bold text-blue">PRASTHAN <span class="text-orange">YATNAM</span></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
                        href="{{ url('/testimonials') }}">TESTIMONIALS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('about') ? 'active' : '' }}"
                        href="{{ url('/about') }}">ABOUT</a>
                </li>
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('/my-courses') }}">My Courses</a></li>
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
                @else
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('login') ? 'active' : '' }}"
                        href="{{ url('/login') }}">LOGIN</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 15px 0;
    }

    .navbar-brand {
        font-family: 'Poppins', sans-serif;
    }

    .logo-img {
        border-radius: 50%;
        object-fit: cover;
    }

    .nav-link {
        color: #333;
        margin: 0 5px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-blue);
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-orange);
    }
</style>