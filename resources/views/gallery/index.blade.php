@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-navy mb-3">Gallery</h1>
            <p class="lead text-muted">Explore our collection of albums and images</p>
        </div>
    </div>

    <div class="row g-4">
        @if($albums->count() > 0)
        @foreach($albums as $album)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm hover-card">
                <a href="{{ route('gallery.show', $album->id) }}" class="text-decoration-none">
                    <div class="position-relative album-cover">
                        @if($album->cover_image)
                        <img src="{{ asset('storage/' . $album->cover_image) }}" class="card-img-top"
                            alt="{{ $album->name }}">
                        @else
                        <div class="bg-light text-center p-5">
                            <i class="fas fa-images fa-4x text-muted"></i>
                        </div>
                        @endif
                        <div class="album-overlay">
                            <div class="album-count">
                                <i class="fas fa-image me-1"></i> {{ $album->galleryImages->count() }} images
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-navy">{{ $album->name }}</h5>
                        @if($album->description)
                        <p class="card-text text-muted">{{ Str::limit($album->description, 100) }}</p>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('gallery.show', $album->id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-eye me-1"></i> View Album
                        </a>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="fas fa-photo-album fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No albums available</h3>
                <p class="text-muted">Please check back later for our gallery content.</p>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .album-cover {
        height: 220px;
        overflow: hidden;
    }

    .album-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .hover-card:hover .album-cover img {
        transform: scale(1.05);
    }

    .album-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        padding: 15px;
        color: white;
        transition: all 0.3s ease;
    }

    .album-count {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .text-navy {
        color: #000080;
    }
</style>
@endsection