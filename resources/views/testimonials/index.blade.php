@extends('layouts.app')

@section('styles')
<style>
    .testimonial-header {
        background: linear-gradient(rgba(30, 80, 162, 0.8), rgba(10, 36, 99, 0.8)),
        url('{{ asset("images/enlightening-bg.webp") }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 5rem 0;
        margin-bottom: 3rem;
        position: relative;
    }

    .testimonial-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(to bottom right, transparent 49%, white 50%);
    }

    .testimonial-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eee;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .testimonial-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .testimonial-icon-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light, #5b92e5) 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: 5px solid white;
    }

    .testimonial-icon-placeholder i {
        font-size: 60px;
        color: white;
        opacity: 0.8;
    }

    .testimonial-content {
        padding: 2rem;
        position: relative;
    }

    .testimonial-text {
        font-style: italic;
        color: #555;
        line-height: 1.8;
        position: relative;
        padding: 0 1rem;
    }

    .testimonial-text::before,
    .testimonial-text::after {
        content: '"';
        font-size: 3rem;
        color: var(--primary-blue);
        opacity: 0.2;
        position: absolute;
        line-height: 0;
    }

    .testimonial-text::before {
        top: 0.5rem;
        left: -1rem;
    }

    .testimonial-text::after {
        bottom: -0.5rem;
        right: -1rem;
    }

    .testimonial-name {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.2rem;
        font-size: 1.2rem;
    }

    .testimonial-designation {
        font-size: 0.9rem;
        color: var(--primary-orange);
        margin-bottom: 1rem;
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
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--primary-orange);
    }
</style>
@endsection

@section('content')
<!-- Testimonial Header -->
<section class="testimonial-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="fw-bold mb-3">What People Say About Us</h1>
                <p class="lead">Discover how Prasthan Yatnam has touched the lives of our community members</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold section-title">Testimonials</h2>
            </div>
        </div>

        <div class="row">
            @foreach($testimonials as $testimonial)
            <div class="col-lg-6 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-content text-center">
                        @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                            class="testimonial-img">
                        @else
                        <div class="testimonial-icon-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                        <div class="testimonial-text mb-4">
                            {{ $testimonial->message }}
                        </div>
                        <h4 class="testimonial-name">{{ $testimonial->name }}</h4>
                        <p class="testimonial-designation">{{ $testimonial->designation }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            @if($testimonials->count() == 0)
            <div class="col-12 text-center">
                <p class="lead">No testimonials available yet.</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection