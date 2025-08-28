@extends('admin.layouts.app')

@section('title', 'Album Details')
@section('page_title', 'Album Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">{{ $album->name }}</h1>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Albums
                </a>
                <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Album
                </a>
                <a href="{{ route('admin.gallery-images.create') }}?album_id={{ $album->id }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-1"></i> Add Images
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Album Details</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($album->cover_image)
                        <img src="{{ asset('storage/' . $album->cover_image) }}" class="img-fluid rounded"
                            alt="{{ $album->name }}">
                        @else
                        <div class="bg-light rounded p-5 text-center">
                            <i class="fas fa-image fa-4x text-muted"></i>
                            <p class="text-muted mt-2">No cover image</p>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <h5>{{ $album->name }}</h5>
                        <p class="text-muted">
                            {{ $album->description ?? 'No description provided' }}
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            @if($album->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Sort Order:</strong></p>
                            <span>{{ $album->sort_order }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Created:</strong></p>
                            <span>{{ $album->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Last Updated:</strong></p>
                            <span>{{ $album->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Gallery Images ({{ $album->galleryImages->count() }})</h5>
                    <a href="{{ route('admin.gallery-images.create') }}?album_id={{ $album->id }}"
                        class="btn btn-sm btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Add Images
                    </a>
                </div>
                <div class="card-body">
                    @if($album->galleryImages->count() > 0)
                    <div class="row g-3">
                        @foreach($album->galleryImages as $image)
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top"
                                    alt="{{ $image->title ?? 'Gallery image' }}">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $image->title ?? 'Untitled' }}</h6>
                                    <p class="card-text small text-muted">{{ Str::limit($image->description ?? '', 50)
                                        }}</p>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="btn-group btn-group-sm w-100">
                                        <a href="{{ route('admin.gallery-images.edit', $image->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.gallery-images.destroy', $image->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this image?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <p class="h5 text-muted">No images in this album</p>
                        <p class="text-muted">Add some images to display in this album.</p>
                        <a href="{{ route('admin.gallery-images.create') }}?album_id={{ $album->id }}"
                            class="btn btn-primary mt-2">
                            <i class="fas fa-plus-circle me-1"></i> Add Images
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
