@extends('layouts.app')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: url('/images/background1.png') no-repeat;
        background-size: cover;
        background-position: center;
        padding: 150px 0;
        width: 100%;
        min-height: 500px;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
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
        border: none;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .navy-btn:hover {
        background: linear-gradient(to bottom, #0000b3, #000080);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    .orange-btn {
        background: linear-gradient(to bottom, #FA8128, #e86b00);
        border: none;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
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
        background: url('/images/himalaya.jpg') no-repeat;
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
        height: 250px;
        object-fit: cover;
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
        background: url('/images/background2.png') no-repeat;
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
        .about-section {
            background-size: 100% auto;
            height: auto;
            min-height: 500px;
            padding: 2rem 0;
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

        .discourse-carousel-item {
            padding: 15px;
        }

        .carousel-indicators {
            bottom: -35px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container-fluid px-0">
        <div class="hero-content">
            <h1 class="hero-quote">" The need not to journey, to sit still, is the greatest journey."</h1>
            <h2 class="hero-author">~Raina Bhattacharjee</h2>

            @guest
            <div class="d-flex justify-content-center gap-3 mt-5">
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
                <!-- Divine Mother Discourse -->
                <div class="carousel-item active">
                    <div class="discourse-carousel-item">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="discourse-img-container">
                                    <img src="/images/discourses/divine-mother.jpg" class="img-fluid w-100"
                                        alt="Divine Mother">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 d-flex align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-3">Discourse On:</h3>
                                    <p class="lead">'Divine Mother: Getting rid of misconceptions regarding Maa Kali and
                                        the facts and
                                        the spiritual interpretation'</p>
                                    <a href="{{ url('/discourses') }}" class="btn orange-btn mt-3">Watch Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hinduism Discourse -->
                <div class="carousel-item">
                    <div class="discourse-carousel-item">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="discourse-img-container">
                                    <img src="/images/discourses/hinduism.jpg" class="img-fluid w-100" alt="Hinduism">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 d-flex align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-3">Discourse On:</h3>
                                    <p class="lead">'Hinduism: Core Concepts - Explore the fundamental concepts of
                                        Hinduism and their relevance in modern times'</p>
                                    <a href="{{ url('/discourses') }}" class="btn orange-btn mt-3">Watch Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sai Baba Discourse -->
                <div class="carousel-item">
                    <div class="discourse-carousel-item">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="discourse-img-container">
                                    <img src="/images/discourses/saiBaba.jpg" class="img-fluid w-100" alt="Sai Baba">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 d-flex align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-3">Discourse On:</h3>
                                    <p class="lead">'Sai Baba: Life & Teachings - Discover the profound teachings and
                                        life story of Sai Baba of Shirdi'</p>
                                    <a href="{{ url('/discourses') }}" class="btn orange-btn mt-3">Watch Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
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
                <button type="button" data-bs-target="#discourseCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#discourseCarousel" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#discourseCarousel" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
</section>





<!-- About Section -->
<section class="about-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold section-title">FOUNDER CUM DIRECTOR'S MESSAGE</h2>
                <p class="mb-4">Peace, love and healing..Sarve Bhavantu Sukhinaha..</p>
                <p class="mb-4">
                    We are joyous to launch Prasthan Yatnam's webportal to the World.
                    We hope and pray that it serves the purpose of unifying the world in this conflict ridden times and
                    most importantly keep the youngsters close to their roots.
                </p>
                <p class="mb-5">
                    Our endeavour is to 'Live and Let Live', to embrace One and all, to pick up the gems from all
                    quarters, to remain forever open minded.
                    We at Prasthan Yatnam, understand spirituality to be Universility. Thus we are making a humble
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
            interval: 2000, 
            wrap: true,     // Cycle continuously
            pause: 'hover'  // Pause when mouse hovers over carousel
        });
    });
</script>
@endsection