@extends('admin.layouts.app')

@section('title', 'Gallery Images')
@section('page_title', 'Gallery Images')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Manage Gallery Images</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Add New Images
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if($albums->count() > 0)
            <ul class="nav nav-tabs mb-4" id="albumTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-pane"
                        type="button" role="tab" aria-controls="all-pane" aria-selected="true">
                        All Images
                    </button>
                </li>
                @foreach($albums as $album)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="album-{{ $album->id }}-tab" data-bs-toggle="tab"
                        data-bs-target="#album-{{ $album->id }}-pane" type="button" role="tab"
                        aria-controls="album-{{ $album->id }}-pane" aria-selected="false">
                        {{ $album->name }} ({{ $album->galleryImages->count() }})
                    </button>
                </li>
                @endforeach
            </ul>

            <div class="tab-content" id="albumTabsContent">
                <div class="tab-pane fade show active" id="all-pane" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row g-3">
                        @php $totalImages = 0; @endphp
                        @foreach($albums as $album)
                        @foreach($album->galleryImages as $image)
                        @php $totalImages++; @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top"
                                    alt="Gallery image">
                                <div class="card-body">
                                    <span class="badge bg-primary">{{ $album->name }}</span>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="btn-group btn-group-sm w-100">
                                        <a href="{{ route('admin.gallery-images.edit', $image->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.gallery-images.destroy', $image->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this image?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach

                        @if($totalImages == 0)
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <p class="h5 text-muted">No images found</p>
                                <p class="text-muted">Add some images to your gallery albums.</p>
                                <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-1"></i> Add Images
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @foreach($albums as $album)
                <div class="tab-pane fade" id="album-{{ $album->id }}-pane" role="tabpanel"
                    aria-labelledby="album-{{ $album->id }}-tab">
                    <div class="row g-3">
                        @if($album->galleryImages->count() > 0)
                        @foreach($album->galleryImages as $image)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top"
                                    alt="Gallery image">
                                <div class="card-body">
                                    <span class="badge bg-primary">{{ $album->name }}</span>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="btn-group btn-group-sm w-100">
                                        <a href="{{ route('admin.gallery-images.edit', $image->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.gallery-images.destroy', $image->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this image?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <p class="h5 text-muted">No images in this album</p>
                                <p class="text-muted">Add some images to display in this album.</p>
                                <a href="{{ route('admin.gallery-images.create') }}?album_id={{ $album->id }}"
                                    class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-1"></i> Add Images
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-photo-album fa-3x text-muted mb-3"></i>
                <p class="h5 text-muted">No albums found</p>
                <p class="text-muted">Create an album first before adding images to your gallery.</p>
                <a href="{{ route('admin.albums.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Create Album
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection