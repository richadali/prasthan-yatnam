@extends('layouts.app')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        padding: 150px 0;
        width: 100%;
        min-height: 500px;
        position: relative;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        position: relative;
    }

    .hero-tag {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 8px 0;
        font-size: 1rem;
        font-weight: 500;
        z-index: 10;
        overflow: hidden;
        white-space: nowrap;
    }

    .hero-tag-content {
        display: inline-block;
        padding-left: 35%;
        animation: marquee-left-to-right 25s linear infinite;
    }

    .hero-tag-content p {
        margin-bottom: 0;
    }

    @keyframes marquee-left-to-right {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 127, 39, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(255, 127, 39, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 127, 39, 0);
        }
    }

    .hero-quote {
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.4;
        font-size: 1.4rem;
        color: rgba(112, 111, 111, 0.9);
        text-align: center;
        font-style: italic;
        font-family: 'Palatino', 'Georgia', serif;
    }

    .hero-author {
        font-size: 1.2rem;
        color: rgba(72, 71, 70, 0.9);
        margin-bottom: 2rem;
        font-style: italic;
        font-family: 'Palatino', 'Georgia', serif;
        font-weight: 400;
    }

    /* Custom Button Styles with Gradients */
    .navy-btn {
        background: linear-gradient(to bottom, #000080, #0000b3);
        border: 2px solid white;
        color: white;
        s box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 170px;
    }

    .navy-btn:hover {
        background: linear-gradient(to bottom, #0000b3, #000080);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    .orange-btn {
        background: linear-gradient(to bottom, #FA8128, #e86b00);
        border: 2px solid white;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 170px;
    }

    .orange-btn:hover {
        background: linear-gradient(to bottom, #e86b00, #FA8128);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    /* Featured Courses */
    .featured-courses {
        padding: 5rem 0;
        background: url('{{ asset("images/himalaya.jpg") }}') no-repeat;
        background-size: cover;
        background-position: center;
        color: white;
    }

    .discourse-carousel-item {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .discourse-img-container {
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .discourse-img {
        width: 100%;
        transition: transform 0.3s ease;
    }

    .discourse-img:hover {
        transform: scale(1.05);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        opacity: 0.8;
    }

    .carousel-indicators {
        bottom: -50px;
    }

    /* About Section */
    .about-section {
        background: url('{{ asset("images/background2.png") }}') no-repeat;
        background-size: cover;
        background-position: center bottom;
        height: 510px;
        padding: 2rem;
        margin-top: 50px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 3rem;
        color: white;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #FA8128;
    }

    .about-section .section-title {
        color: inherit;
    }

    /* Upcoming Courses */
    .upcoming-courses {
        padding: 5rem 0;
    }

    .blinking-header {
        animation: blink 2s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    /* Testimonials */
    .testimonial-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .testimonial-card {
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        background-color: white;
        position: relative;
        margin-top: 3rem;
    }

    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .testimonial-quote {
        font-size: 3rem;
        color: var(--primary-blue);
        opacity: 0.2;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    @media (max-width: 768px) {
        .hero-tag {
            top: 0;
            font-size: 0.5rem;
        }

        .about-section {
            background-size: 100% auto;
            height: auto;
            min-height: 500px;
            padding: 2rem 0;
            margin-top: 0;
        }

        .about-section .container {
            padding: 15px;
            margin-top: 20px;
        }

        .about-section .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero-section {
            padding: 30px 0;
            min-height: auto;
            background-size: 100% auto;
            background-position: top center;
            margin-bottom: 0;
            padding-bottom: 10px;
        }

        .hero-quote {
            font-size: 1.1rem;
            color: rgba(112, 111, 111, 0.9);
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }

        .hero-author {
            font-size: 0.9rem;
            color: rgba(72, 71, 70, 0.9);
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .hero-content {
            max-width: 90%;
        }

        .featured-courses {
            padding: 2rem 0 4rem 0;
        }

        .hero-buttons {
            top: 60% !important;
        }

        .discourse-carousel-item {
            padding: 15px;
        }

        .carousel-indicators {
            bottom: -35px;
        }

        .featured-courses .text-center {
            margin-bottom: 1rem !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="padding: 0; min-height: 0; position: relative;">
    <div class="container-fluid px-0">
        <div class="hero-content" style="max-width: 100%;">
            @if($heroImage->tag)
            <div class="hero-tag">
                <div class="hero-tag-content">
                    {!! $heroImage->tag !!}
                </div>
            </div>
            @endif

            @if(Str::startsWith($heroImage->image_path, 'images/'))
            <img src="{{ asset($heroImage->image_path) }}" class="img-fluid w-100"
                alt="{{ $heroImage->tag ?? 'Hero Image' }}">
            @else
            <img src="{{ asset('storage/' . $heroImage->image_path) }}" class="img-fluid w-100"
                alt="{{ $heroImage->tag ?? 'Hero Image' }}">
            @endif

            @guest
            <div class="d-flex justify-content-center gap-3 hero-buttons"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <a href="{{ url('/login') }}" class="btn navy-btn px-4 py-2">LOGIN</a>
                <a href="{{ url('/register') }}" class="btn orange-btn px-4 py-2">REGISTER</a>
            </div>
            @endguest
        </div>
    </div>
</section>

<!-- Featured Course with Carousel -->
<section class="featured-courses">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title">DISCOURSES</h2>
        </div>

        <div id="discourseCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @forelse($featuredDiscourses as $index => $discourse)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="discourse-carousel-item">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="discourse-img-container">
                                    <img src="{{ $discourse->thumbnail ? asset('storage/' . $discourse->thumbnail) : asset('images/discourses/default.jpg') }}"
                                        class="img-fluid w-100" alt="{{ $discourse->title }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 d-flex align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-3">Discourse On:</h3>
                                    <p class="lead">{{ $discourse->title }}</p>
                                    <p><i>{{ Str::limit(strip_tags($discourse->description), 150) }}</i></p>

                                    @if($discourse->is_upcoming)
                                    <span class="btn orange-btn mt-3" style="cursor: default;">Upcoming</span>
                                    @if($discourse->expected_release_date)
                                    <small class="d-block mt-2 text-light">Expected: {{
                                        $discourse->expected_release_date->format('M d, Y') }}</small>
                                    @endif
                                    @else
                                    <a href="{{ route('discourses.show', $discourse->slug) }}"
                                        class="btn orange-btn mt-3">Watch Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Default carousel item if no discourses are available -->
                <div class="carousel-item active">
                    <div class="discourse-carousel-item">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="discourse-img-container">
                                    <img src="{{ asset('images/discourses/divine-mother.jpg') }}"
                                        class="img-fluid w-100" alt="Divine Mother">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 d-flex align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-3">No Discourses Available</h3>
                                    <p class="lead">Check back soon for upcoming spiritual discourses</p>
                                    <a href="{{ url('/discourses') }}" class="btn orange-btn mt-3">Browse Discourses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Carousel Controls (only if there are discourses) -->
            @if(count($featuredDiscourses) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#discourseCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#discourseCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                @foreach($featuredDiscourses as $index => $discourse)
                <button type="button" data-bs-target="#discourseCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold section-title">FOUNDER DIRECTOR’S MESSAGE</h2>
                <p class="mb-4" style="font-size: 1.2rem;">Peace, Love and Healing..Sarve Bhavantu Sukhinaha..</p>
                <p class="mb-4">
                    We are joyous to launch Prasthan Yatnam's webportal to the World.
                    We hope and pray that it serves the purpose of unifying the world in this conflict ridden times and
                    most importantly keep the youngsters close to their roots.
                </p>
                <p class="mb-5">
                    Our endeavour is to 'Live and Let Live', to embrace One and all, to pick up the gems from all
                    quarters, to remain forever open minded.
                    We at Prasthan Yatnam, understand spirituality to be universality. Thus we are making a humble
                    attempt to provide a soothing healthy atmosphere, free from any kind of
                    dogma/prejudice/fanatism/cultism for a balanced holistic overall growth of a being.
                </p>
                <a href="{{ url('/about') }}" class="btn navy-btn px-4 py-2">KNOW MORE ABOUT US</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize the carousel with auto-sliding
    document.addEventListener('DOMContentLoaded', function() {
        // Get the carousel element
        var discourseCarousel = document.getElementById('discourseCarousel');
        
        // Initialize the Bootstrap carousel with options
        var carousel = new bootstrap.Carousel(discourseCarousel, {
            interval: 3000,    // Show each slide for 5 seconds
            wrap: true,        // Cycle continuously
            pause: 'hover',    // Pause when mouse hovers over carousel
            ride: 'carousel'   // Start cycling automatically after user manually cycles
        });
    });
</script>
@endsection