@extends('layouts.app')

@section('styles')
<style>
    .preview-container {
        padding: 3rem 0;
        background-color: #f8f9fa;
    }

    .video-player {
        background-color: #000;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-bottom: 2rem;
    }

    .video-title {
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .video-description {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .preview-badge {
        background-color: #17a2b8;
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        margin-left: 0.5rem;
    }

    .course-info {
        margin-bottom: 2rem;
    }

    .course-title {
        color: var(--primary-blue);
        font-weight: 600;
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
</style>
@endsection

@section('content')
<div class="preview-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="video-player">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtube-player"
                            src="https://www.youtube.com/embed/{{ $video->youtube_video_id }}?rel=0&modestbranding=1"
                            title="{{ $video->title }}" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                </div>

                <h1 class="video-title">
                    {{ $video->title }}
                    <span class="preview-badge">Free Preview</span>
                </h1>

                <div class="video-description">
                    {{ $video->description }}
                </div>

                <div class="course-info">
                    <h4 class="course-title">{{ $discourse->title }}</h4>
                    <p>{{ count($discourse->videos) }} videos in this course</p>
                    <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-outline-primary">
                        View Full Course
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="enrollment-card">
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
                            <li>Certificate of completion</li>
                        </ul>

                        @if(Auth::check())
                        <form action="#" method="POST">
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

                <div class="mt-4">
                    <h5>This is a preview</h5>
                    <p class="text-muted">Enroll in this course to get access to all videos and course materials.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection