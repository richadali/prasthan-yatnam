@extends('admin.layouts.app')

@section('title', 'Edit Discourse')

@section('page_title', 'Edit Discourse')

@section('styles')
<style>
    .image-preview {
        width: 200px;
        height: 150px;
        border-radius: 8px;
        background-color: #f8f9fa;
        border: 1px dashed #ced4da;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-placeholder {
        color: #6c757d;
    }

    .ck-editor__editable {
        min-height: 250px;
    }

    .video-item {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #eee;
    }

    .video-item .remove-video {
        cursor: pointer;
    }

    .video-preview {
        width: 240px;
        height: 150px;
        background-color: #eee;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        color: #6c757d;
        font-size: 0.8rem;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .video-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-preview .play-icon {
        position: absolute;
        color: rgba(255, 255, 255, 0.8);
        font-size: 3rem;
        filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.7));
    }

    .video-modal .modal-content {
        background-color: #000;
        border-radius: 8px;
    }

    .video-modal .modal-header {
        border-bottom: 1px solid #333;
        padding: 0.5rem 1rem;
    }

    .video-modal .modal-header .btn-close {
        background-color: #fff;
        opacity: 0.8;
    }

    .video-modal .modal-title {
        color: #fff;
        font-size: 1.1rem;
    }

    .video-modal .modal-body {
        padding: 0;
    }

    .video-embed-container {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }

    .video-embed-container .video-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .upload-progress {
        display: none;
        margin-top: 10px;
    }

    .upload-progress .progress {
        height: 10px;
        border-radius: 5px;
    }

    .video-upload-wrapper {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 25px;
        text-align: center;
        background-color: #f9f9f9;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .video-upload-wrapper:hover {
        border-color: #6c757d;
        background-color: #f1f1f1;
    }

    .video-upload-wrapper input[type="file"] {
        display: none;
    }

    .video-upload-icon {
        font-size: 2.5rem;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .video-upload-text {
        color: #495057;
    }

    .video-upload-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<!-- Include Video.js -->
@include('admin.layouts.video-js-includes')
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Edit Discourse</h1>
            <p class="text-muted">Update discourse information</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Discourses
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.discourses.update', $discourse->id) }}" method="POST"
                enctype="multipart/form-data" id="discourseForm">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Left column -->
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $discourse->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="8">{{ old('description', $discourse->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="description-error" style="display: none;">
                                Please provide a description for the discourse.
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="thumbnail" class="form-label d-block">Thumbnail</label>
                            <div class="image-preview mb-3">
                                <div class="preview-content">
                                    @if($discourse->thumbnail)
                                    <img src="{{ $discourse->getThumbnailUrl() }}" alt="{{ $discourse->title }}">
                                    @else
                                    <div class="preview-placeholder">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                id="thumbnail" name="thumbnail" accept="image/*">
                            <div class="form-text">Recommended size: 640×480 pixels</div>
                            @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label">Price (₹)</label>
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                value="{{ old('price', $discourse->price) }}">
                            <div class="form-text">Leave 0.00 to make this discourse free for all registered users</div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1" {{ old('is_active', $discourse->is_active) ? 'checked' :
                                '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <div class="form-text">Make this discourse visible and accessible to users</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_upcoming"
                                    name="is_upcoming" value="1" {{ old('is_upcoming', $discourse->is_upcoming) ?
                                'checked' :
                                '' }}>
                                <label class="form-check-label" for="is_upcoming">Mark as Upcoming</label>
                            </div>
                            <div class="form-text">Mark this discourse as upcoming (videos can be added later)</div>
                        </div>

                        <div class="mb-4" id="expected-release-date-container"
                            style="{{ old('is_upcoming', $discourse->is_upcoming) ? '' : 'display: none;' }}">
                            <label for="expected_release_date" class="form-label">Expected Release Date</label>
                            <input type="date" class="form-control" id="expected_release_date"
                                name="expected_release_date"
                                value="{{ old('expected_release_date', $discourse->expected_release_date ? $discourse->expected_release_date->format('Y-m-d') : '') }}">
                            <div class="form-text">When this discourse is expected to be available</div>
                        </div>
                    </div>
                </div>

                <!-- Hidden field for slug -->
                <input type="hidden" name="slug" id="slug" value="{{ old('slug', $discourse->slug) }}">

                <hr class="my-4">

                <h4 class="mb-4">Add Videos</h4>
                <div id="videoContainer">
                    <!-- Existing videos -->
                    @foreach($discourse->videos as $video)
                    <div class="video-item" data-index="{{ $loop->index }}">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Video Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control video-title"
                                        name="videos[{{ $loop->index }}][title]" value="{{ $video->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <div class="video-upload-wrapper">
                                        <input type="file" class="video-file" name="videos[{{ $loop->index }}][video_file]"
                                            accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv">
                                        <div class="video-upload-text">
                                            <strong>{{ $video->video_filename }}</strong>
                                            ({{ number_format($video->file_size / (1024 * 1024), 2) }} MB)
                                        </div>
                                        <div class="video-upload-hint">
                                            Click to change file
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Sequence</label>
                                            <input type="number" class="form-control video-sequence"
                                                name="videos[{{ $loop->index }}][sequence]" min="0" value="{{ $video->sequence }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Duration (seconds)</label>
                                            <input type="number" class="form-control duration-seconds"
                                                name="videos[{{ $loop->index }}][duration_seconds]" min="0"
                                                value="{{ $video->duration_seconds }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.discourses.videos.destroy', [$discourse, $video]) }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this video?')">
                                        <i class="fas fa-trash me-1"></i> Remove Video
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-primary" id="addVideoBtn">
                        <i class="fas fa-plus-circle me-1"></i> Add Video
                    </button>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Discourse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="videoTemplate">
    <div class="video-item" data-index="__INDEX__">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label">Video Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control video-title" name="videos[__INDEX__][title]" required>
                </div>
                <div class="mb-3">
                    <div class="video-upload-wrapper">
                        <input type="file" class="video-file" name="videos[__INDEX__][video_file]"
                            accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv" required>
                        <div class="video-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="video-upload-text">
                            <strong>Click to upload video</strong> or drag and drop
                        </div>
                        <div class="video-upload-hint">
                            MP4, MOV, AVI, WMV up to 1GB
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sequence</label>
                            <input type="number" class="form-control video-sequence" name="videos[__INDEX__][sequence]"
                                min="0" value="__INDEX__">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Duration (seconds)</label>
                            <input type="number" class="form-control duration-seconds"
                                name="videos[__INDEX__][duration_seconds]" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-danger btn-sm remove-video">
                        <i class="fas fa-trash me-1"></i> Remove Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('js/chunk-upload.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });

        let videoIndex = {{ $discourse->videos->count() }};
        const videoContainer = document.getElementById('videoContainer');
        const videoTemplate = document.getElementById('videoTemplate').innerHTML;
        const addVideoBtn = document.getElementById('addVideoBtn');

        addVideoBtn.addEventListener('click', function() {
            const newVideo = videoTemplate.replace(/__INDEX__/g, videoIndex);
            const videoDiv = document.createElement('div');
            videoDiv.innerHTML = newVideo;
            videoContainer.appendChild(videoDiv.firstElementChild);
            videoIndex++;
        });

        videoContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video')) {
                e.target.closest('.video-item').remove();
            }

            if (e.target.closest('.video-upload-wrapper')) {
                e.target.closest('.video-upload-wrapper').querySelector('.video-file').click();
            }
        });
    });
</script>
@endsection