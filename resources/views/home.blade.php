@extends('layouts.app')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/1600x900/?himalaya,spirituality') no-repeat center center;
        background-size: cover;
        height: 80vh;
        display: flex;
        align-items: center;
        color: white;
        position: relative;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-quote {
        font-size: 2.5rem;
        font-weight: 300;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .hero-author {
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 2rem;
    }

    /* Featured Courses */
    .featured-courses {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .course-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .course-card:hover {
        transform: translateY(-10px);
    }

    .course-img {
        height: 200px;
        object-fit: cover;
    }

    /* About Section */
    .about-section {
        padding: 5rem 0;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 3rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: var(--primary-orange);
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
        .hero-quote {
            font-size: 1.8rem;
        }

        .hero-author {
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-quote">" The need not to journey, to sit still, is the greatest journey."</h1>
            <h2 class="hero-author">~Raina Bhattacharjee</h2>

            @guest
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/login') }}" class="btn btn-primary btn-lg px-4">LOGIN</a>
                <a href="{{ url('/register') }}" class="btn btn-orange btn-lg px-4">REGISTER</a>
            </div>
            @endguest
        </div>
    </div>
</section>

<!-- Featured Course -->
<section class="featured-courses">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Click on the image to attend the discourse</h2>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://source.unsplash.com/800x500/?divine,mother,kali" class="card-img-top"
                        alt="Divine Mother">
                </div>
            </div>
            <div class="col-lg-6 mb-4 d-flex align-items-center">
                <div>
                    <h3 class="fw-bold mb-3">Discourse On:</h3>
                    <p class="lead">'Divine Mother: Getting rid of misconceptions regarding Maa Kali and the facts and
                        the spiritual interpretation'</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Courses -->
<section class="upcoming-courses bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold blinking-header">Upcoming Discourses</h2>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card course-card border-0">
                    <img src="https://source.unsplash.com/800x500/?hinduism,temple" class="card-img-top course-img"
                        alt="Hinduism">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Hinduism: Core Concepts</h5>
                        <p class="card-text">Explore the fundamental concepts of Hinduism and their relevance in modern
                            times.</p>
                        <a href="#" class="btn btn-sm btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card course-card border-0">
                    <img src="https://source.unsplash.com/800x500/?sai,baba" class="card-img-top course-img"
                        alt="Sai Baba">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Sai Baba: Life & Teachings</h5>
                        <p class="card-text">Discover the profound teachings and life story of Sai Baba of Shirdi.</p>
                        <a href="#" class="btn btn-sm btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonial-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Students Say</h2>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="testimonial-card text-center">
                    <img src="https://source.unsplash.com/100x100/?person" class="testimonial-avatar" alt="Student">
                    <i class="fas fa-quote-left testimonial-quote"></i>
                    <p class="mb-3">"The Divine Mother course changed my perspective on spirituality. The teachings were
                        profound yet accessible."</p>
                    <h5 class="mb-1">Amit Sharma</h5>
                    <p class="text-muted small">Student</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimonial-card text-center">
                    <img src="https://source.unsplash.com/100x100/?woman" class="testimonial-avatar" alt="Student">
                    <i class="fas fa-quote-left testimonial-quote"></i>
                    <p class="mb-3">"I've been searching for authentic spiritual teachings for years. Prasthan Yatnam
                        offers exactly what I was looking for."</p>
                    <h5 class="mb-1">Priya Patel</h5>
                    <p class="text-muted small">Student</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimonial-card text-center">
                    <img src="https://source.unsplash.com/100x100/?man" class="testimonial-avatar" alt="Student">
                    <i class="fas fa-quote-left testimonial-quote"></i>
                    <p class="mb-3">"The courses are well-structured and the instructors are knowledgeable. I highly
                        recommend Prasthan Yatnam to all spiritual seekers."</p>
                    <h5 class="mb-1">Rajesh Kumar</h5>
                    <p class="text-muted small">Student</p>
                </div>
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
                <a href="{{ url('/about') }}" class="btn btn-primary px-4 py-2">KNOW MORE ABOUT US</a>
            </div>
        </div>
    </div>
</section>
@endsection