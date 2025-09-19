@extends('layouts.app')

@section('styles')
<style>
    .discourse-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .discourse-card {
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 320px;
        margin: 0 auto;
        position: relative;
    }

    .discourse-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .discourse-thumbnail {
        height: 240px;
        object-fit: cover;
        width: 100%;
    }

    .discourse-title {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
    }

    .discourse-description {
        color: #6c757d;
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1rem;
        height: 60px;
    }

    .discourse-price {
        font-weight: 600;
        color: #28a745;
        font-size: 1.1rem;
    }

    .discourse-price.free {
        color: #17a2b8;
    }

    .section-title {
        position: relative;
        margin-bottom: 3rem;
        text-align: center;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--primary-blue);
    }

    .upcoming-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #FA8128;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 1;
    }

    .expected-date {
        color: #6c757d;
        font-size: 0.9rem;
        font-style: italic;
    }

    .upcoming-section {
        background-color: #f0f2f5;
        padding-top: 3rem;
        margin-top: 2rem;
        border-top: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')
<!-- Active Discourses Section -->
<section class="discourse-section">
    <div class="container">
        <h2 class="section-title">Discourses Open</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">
            @forelse($activeDiscourses as $discourse)
            <div class="col-md-6 col-lg-4">
                <div class="discourse-card">
                    <img src="{{ $discourse->thumbnail ? asset('storage/' . $discourse->thumbnail) : asset('images/discourses/default.jpg') }}"
                        alt="{{ $discourse->title }}" class="discourse-thumbnail">
                    <div class="card-body p-4">
                        <h3 class="discourse-title">{{ $discourse->title }}</h3>
                        <p class="discourse-description">{{ strip_tags($discourse->description) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            @if($discourse->price > 0)
                            <span class="discourse-price">₹{{ number_format($discourse->price, 2) }}</span>
                            @else
                            <span class="discourse-price free">Free</span>
                            @endif

                            <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-primary">View
                                Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <p class="mb-0">No discourses available at the moment. Please check back later.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Upcoming Discourses Section -->
@if(count($upcomingDiscourses) > 0)
<section class="discourse-section upcoming-section" id="upcoming-discourses">
    <div class="container">
        <h2 class="section-title">Upcoming Discourses</h2>
        <div class="row g-4">
            @foreach($upcomingDiscourses as $discourse)
            <div class="col-md-6 col-lg-4">
                <div class="discourse-card">
                    {{-- <img
                        src="{{ $discourse->thumbnail ? asset('storage/' . $discourse->thumbnail) : asset('images/discourses/default.jpg') }}"
                        alt="{{ $discourse->title }}" class="discourse-thumbnail"> --}}
                    <div class="card-body p-4">
                        <h3 class="discourse-title">{{ $discourse->title }}</h3>
                        <p class="discourse-description">{{ strip_tags($discourse->description) }}</p>

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            @if($discourse->expected_release_date)
                            <span class="expected-date">Expected: {{ $discourse->expected_release_date->format('M d, Y')
                                }}</span>
                            @else
                            <span class="expected-date">Coming soon</span>
                            @endif

                            @if($discourse->price > 0)
                            <span class="discourse-price">₹{{ number_format($discourse->price, 2) }}</span>
                            @else
                            <span class="discourse-price free">Free</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="list-group">
                    <li class="list-group-item">Connect between Sufism/Vedanta/Humanism/Psychology</li>
                    <li class="list-group-item">Series on Silence</li>
                    <li class="list-group-item">Series on Solitude</li>
                    <li class="list-group-item">Rumi</li>
                    <li class="list-group-item">Myths regarding Hinduism</li>
                    <li class="list-group-item">Nectar of Ramakrishna's Kathamrita</li>
                </ul>
                <p class="text-center mt-3">And many more...</p>
            </div>
        </div>
    </div>
</section>
@endif
<div class="container text-center mt-3">
    <p style="font-size: 8pt; color: grey;">
        We acknowledge Pixabay for providing us with some license-free images for proper use.
    </p>
</div>
@endsection