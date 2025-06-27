@extends('layouts.app')

@section('styles')
<style>
    .my-discourses-section {
        padding: 2rem 0;
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
        max-width: 320px;
        margin: 0 auto;
    }

    .discourse-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .discourse-thumbnail {
        height: 240px;
        object-fit: cover;
        width: 100%;
        object-position: center;
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

    .enrolled-date {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<section class="my-discourses-section">
    <div class="container">
        <h2 class="section-title">My Discourses</h2>

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
                    <img src="{{ $discourse->thumbnail ? asset('storage/' . $discourse->thumbnail) : asset('images/discourses/default.jpg') }}"
                        alt="{{ $discourse->title }}" class="discourse-thumbnail">
                    <div class="card-body p-4">
                        <h3 class="discourse-title">{{ $discourse->title }}</h3>

                        <p class="enrolled-date">Enrolled: {{
                            \Carbon\Carbon::parse($discourse->pivot->enrolled_at)->format('M d, Y') }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('discourses.show', $discourse->slug) }}"
                                class="btn btn-primary w-100">View Discourse</a>
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