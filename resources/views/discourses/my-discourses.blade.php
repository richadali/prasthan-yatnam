@extends('layouts.app')

@section('styles')
<style>
    .my-discourses-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
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

    .progress-container {
        height: 5px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-bottom: 0.5rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-blue), var(--dark-blue));
        border-radius: 5px;
    }

    .progress-text {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .enrolled-date {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .last-watched {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<section class="my-discourses-section">
    <div class="container">
        <h1 class="section-title">My Courses</h1>

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
            @forelse($enrolledDiscourses as $discourse)
            <div class="col-md-6 col-lg-4">
                <div class="discourse-card">
                    <img src="{{ asset('images/discourses/' . ($discourse->thumbnail ?? 'default.jpg')) }}"
                        alt="{{ $discourse->title }}" class="discourse-thumbnail">
                    <div class="card-body p-4">
                        <h3 class="discourse-title">{{ $discourse->title }}</h3>

                        <p class="enrolled-date">Enrolled: {{
                            \Carbon\Carbon::parse($discourse->pivot->enrolled_at)->format('M d, Y') }}</p>

                        @php
                        $totalVideos = count($discourse->videos);
                        $completedVideos = 0;
                        $lastWatchedVideo = null;
                        $lastWatchedTime = null;

                        foreach ($discourse->videos as $video) {
                        $progress = $video->userProgress()->where('user_id', Auth::id())->first();
                        if ($progress && $progress->completed) {
                        $completedVideos++;
                        }

                        if ($progress && (!$lastWatchedTime || $progress->last_watched_at > $lastWatchedTime)) {
                        $lastWatchedVideo = $video;
                        $lastWatchedTime = $progress->last_watched_at;
                        }
                        }

                        $progressPercentage = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;
                        @endphp

                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <p class="progress-text">{{ $completedVideos }} of {{ $totalVideos }} videos completed ({{
                            number_format($progressPercentage, 0) }}%)</p>

                        @if($lastWatchedVideo && $lastWatchedTime)
                        <p class="last-watched">Last watched: {{ $lastWatchedTime->diffForHumans() }}</p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('discourses.show', $discourse->slug) }}"
                                class="btn btn-outline-primary">View Course</a>

                            @if($lastWatchedVideo)
                            <a href="{{ route('videos.show', ['discourse_slug' => $discourse->slug, 'video_id' => $lastWatchedVideo->id]) }}"
                                class="btn btn-primary">Continue</a>
                            @else
                            <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-primary">Start</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <p class="mb-0">You haven't enrolled in any courses yet.</p>
                </div>
                <a href="{{ route('discourses.index') }}" class="btn btn-primary mt-3">Browse Courses</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection