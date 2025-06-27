@extends('layouts.app')

@section('styles')
<style>
    .discourse-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        url('{{ $discourse->thumbnail ? asset("storage/" . $discourse->thumbnail) : asset("images/discourses/default.jpg") }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 5rem 0;
        margin-bottom: 3rem;
    }

    .discourse-title {
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .discourse-description {
        max-width: 800px;
        margin: 0 auto 2rem;
        line-height: 1.7;
    }

    .video-list {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 3rem;
    }

    .video-item {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.3s ease;
    }

    .video-item:last-child {
        border-bottom: none;
    }

    .video-item:hover {
        background-color: #e9ecef;
    }

    .video-title {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
    }

    .video-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .video-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .video-duration {
        color: #6c757d;
    }

    .preview-badge {
        background-color: #17a2b8;
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        margin-left: 0.5rem;
    }

    .enrollment-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .enrollment-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        padding: 1.5rem;
    }

    .enrollment-price {
        font-size: 2rem;
        font-weight: 700;
    }

    .enrollment-body {
        padding: 1.5rem;
    }

    .feature-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 2rem;
    }

    .feature-list li {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
    }

    .feature-list li::before {
        content: '✓';
        color: #28a745;
        font-weight: bold;
        margin-right: 0.5rem;
    }

    .locked-message {
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 1rem;
    }

    .preview-video-container {
        position: relative;
        margin-bottom: 2rem;
    }

    .upcoming-badge {
        background-color: #FA8128;
        color: white;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        margin-top: 1rem;
        display: inline-block;
    }

    .expected-date {
        font-style: italic;
        color: #e0e0e0;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="discourse-header">
    <div class="container text-center">
        <h1 class="discourse-title">{{ $discourse->title }}</h1>
        <div class="discourse-description">
            {{ strip_tags($discourse->description) }}
        </div>
        @if($isUpcoming)
        <span class="upcoming-badge">Coming Soon</span>
        @if($discourse->expected_release_date)
        <div class="expected-date">Expected Release: {{ $discourse->expected_release_date->format('F d, Y') }}</div>
        @endif
        @elseif($hasAccess)
        <span class="badge bg-success">Enrolled</span>
        @elseif($discourse->price > 0)
        <span class="badge bg-primary">₹{{ number_format($discourse->price, 2) }}</span>
        @else
        <span class="badge bg-info">Free</span>
        @endif
    </div>
</div>

<div class="container mb-5">
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

    <div class="row">
        <div class="col-lg-8">
            <div class="video-list">
                <h3 class="mb-4">Discourse Content</h3>
                @if($isUpcoming)
                <div class="alert alert-warning">
                    <i class="fas fa-clock me-2"></i> This discourse is not yet available. Content will be accessible
                    after the release date.
                </div>
                @endif

                @forelse($discourse->videos as $video)
                <div class="video-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="video-title">
                                {{ $video->title }}
                            </h5>
                            <p class="video-description">{{ $video->description }}</p>
                            <div class="video-meta">
                                <span class="video-duration">Duration: {{ $video->formatted_duration }}</span>
                            </div>
                        </div>
                        <div>
                            @if($hasAccess && !$isUpcoming)
                            <a href="{{ route('videos.show', ['discourse_slug' => $discourse->slug, 'video_id' => $video->id]) }}"
                                class="btn btn-primary btn-sm">
                                Watch Video
                            </a>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-lock me-1"></i> Locked
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <p>No videos available for this discourse yet.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4">
            <div class="enrollment-card sticky-top" style="top: 100px;">
                <div class="enrollment-header text-center">
                    @if($discourse->price > 0)
                    <div class="enrollment-price">₹{{ number_format($discourse->price, 2) }}</div>
                    @else
                    <div class="enrollment-price">Free</div>
                    @endif
                </div>
                <div class="enrollment-body">
                    <ul class="feature-list">
                        <li>{{ count($discourse->videos) }} video lessons</li>
                        <li>Lifetime access</li>
                        <li>Access on mobile and TV</li>
                    </ul>

                    @if($isUpcoming)
                    <button class="btn btn-warning w-100" disabled>
                        Coming Soon
                    </button>
                    <p class="text-center mt-2 small">This discourse is not yet available for enrollment.</p>
                    @elseif($hasAccess)
                    <a href="{{ route('discourses.my') }}" class="btn btn-success w-100">
                        Go to My Discourses
                    </a>
                    @elseif(Auth::check())
                    <form action="{{ route('discourses.enroll', $discourse->slug) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            @if($discourse->price > 0)
                            Enroll Now
                            @else
                            Enroll for Free
                            @endif
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn btn-primary w-100">
                        Login to Enroll
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection