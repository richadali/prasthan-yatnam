@extends('layouts.app')

@section('styles')
<style>
    .discourse-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .discourse-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .discourse-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .discourse-thumbnail {
        height: 200px;
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
</style>
@endsection

@section('content')
<section class="discourse-section">
    <div class="container">
        <h1 class="section-title">Available Discourses</h1>

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
            @forelse($discourses as $discourse)
            <div class="col-md-6 col-lg-4">
                <div class="discourse-card">
                    <img src="{{ asset('images/discourses/' . ($discourse->thumbnail ?? 'default.jpg')) }}"
                        alt="{{ $discourse->title }}" class="discourse-thumbnail">
                    <div class="card-body p-4">
                        <h3 class="discourse-title">{{ $discourse->title }}</h3>
                        <p class="discourse-description">{{ $discourse->description }}</p>

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
@endsection