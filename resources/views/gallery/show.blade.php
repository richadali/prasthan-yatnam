@extends('layouts.app')

@section('title', $album->name . ' - Gallery')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('gallery') }}"
                            class="text-decoration-none">Gallery</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $album->name }}</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold text-navy">{{ $album->name }}</h1>
            @if($album->description)
            <p class="lead text-muted">{{ $album->description }}</p>
            @endif
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('gallery') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Back to Albums
            </a>
        </div>
    </div>

    <div class="row g-4 gallery-container">
        @if($album->galleryImages->count() > 0)
        @foreach($album->galleryImages as $image)
        <div class="col-lg-4 col-md-6">
            <div class="card gallery-item h-100 shadow-sm">
                <a href="{{ asset('storage/' . $image->image_path) }}" data-fancybox="gallery">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top gallery-img"
                        alt="Gallery image">
                </a>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No images in this album</h3>
                <p class="text-muted">Please check back later for content in this album.</p>
                <a href="{{ route('gallery') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to Albums
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .gallery-img {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover .gallery-img {
        transform: scale(1.03);
    }

    .gallery-item {
        cursor: pointer;
        overflow: hidden;
    }

    .text-navy {
        color: #000080;
    }
</style>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="gallery"]', {
            // Options for the lightbox gallery
            Carousel: {
                infinite: true,
            },
            Thumbs: {
                autoStart: true,
            },
        });
    });
</script>
@endsection