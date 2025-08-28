@extends('admin.layouts.app')

@section('title', 'Gallery Image Details')
@section('page_title', 'Gallery Image Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Gallery Image</h1>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Gallery
                </a>
                <a href="{{ route('admin.gallery-images.edit', $image->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Image
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded"
                        alt="Gallery image">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Image Details</h5>
                </div>
                <div class="card-body">


                    <div class="mb-3">
                        <p class="mb-1"><strong>Album:</strong></p>
                        <a href="{{ route('admin.albums.show', $image->album_id) }}">
                            {{ $image->album->name }}
                        </a>
                    </div>



                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Created:</strong></p>
                            <span>{{ $image->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Last Updated:</strong></p>
                            <span>{{ $image->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <hr>

                    <form action="{{ route('admin.gallery-images.destroy', $image->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-1"></i> Delete Image
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection