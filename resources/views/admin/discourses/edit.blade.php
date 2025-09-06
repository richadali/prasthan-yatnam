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
                <input type="hidden" name="discourse_id" id="discourse_id" value="{{ $discourse->id }}">

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
                                    <input type="hidden" name="videos[{{ $loop->index }}][id]" value="{{ $video->id }}">
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

<!-- Upload Progress Modal -->
<div class="modal fade" id="uploadProgressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="uploadProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProgressModalLabel">Uploading Videos</h5>
            </div>
            <div class="modal-body">
                <div id="upload-progress-container"></div>
            </div>
        </div>
    </div>
</div>

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
        const videoFiles = [];

        addVideoBtn.addEventListener('click', function() {
            const newVideo = videoTemplate.replace(/__INDEX__/g, videoIndex);
            const videoDiv = document.createElement('div');
            videoDiv.innerHTML = newVideo;
            videoContainer.appendChild(videoDiv.firstElementChild);

            const newVideoItem = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"]`);
            const uploadWrapper = newVideoItem.querySelector('.video-upload-wrapper');
            const fileInput = newVideoItem.querySelector('.video-file');
            const titleInput = newVideoItem.querySelector('.video-title');
            const durationInput = newVideoItem.querySelector('.duration-seconds');

            uploadWrapper.addEventListener('click', function() {
                fileInput.click();
            });

            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2);

                    const video = document.createElement('video');
                    video.preload = 'metadata';
                    
                    video.onloadedmetadata = function() {
                        const duration = Math.round(video.duration);
                        videoFiles[videoIndex] = {
                            file: file,
                            title: titleInput.value || fileName.replace(/\.[^/.]+$/, ""),
                            sequence: videoIndex,
                            duration: duration || 0
                        };

                        if (duration && duration > 0) {
                            durationInput.value = duration;
                        }
                        window.URL.revokeObjectURL(video.src);
                    };
                    
                    video.src = URL.createObjectURL(file);

                    uploadWrapper.innerHTML = `
                        <div class="video-upload-text">
                            <strong>${fileName}</strong> (${fileSize} MB)
                        </div>
                        <div class="video-upload-hint">
                            Click to change file
                        </div>
                    `;

                    if (!titleInput.value.trim()) {
                        titleInput.value = fileName.replace(/\.[^/.]+$/, "");
                    }
                }
            });

            videoIndex++;
        });

        videoContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video')) {
                e.target.closest('.video-item').remove();
            }
        });

        const form = document.getElementById('discourseForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('=== FORM SUBMIT EVENT FIRED ===');

                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';

                // Update CKEditor content before submission
                if (window.editor) {
                    const descriptionTextarea = document.querySelector('#description');
                    descriptionTextarea.value = window.editor.getData();
                    console.log('Updated description with CKEditor content.');
                }

                const formData = new FormData(form);

                // Submit the main form data first
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const discourseId = {{ $discourse->id }};

                        // Start chunked uploads for each video
                        let uploadsRemaining = videoFiles.filter(file => file).length;
                        if (uploadsRemaining === 0) {
                            window.location.href = "{{ route('admin.discourses.index') }}";
                            return;
                        }

                        const uploadProgressModal = new bootstrap.Modal(document.getElementById('uploadProgressModal'));
                        uploadProgressModal.show();
                        const progressContainer = document.getElementById('upload-progress-container');
                        progressContainer.innerHTML = '';

                        videoFiles.forEach((file, index) => {
                            if (file) {
                                const progressId = `upload-progress-${index}`;
                                const progressHtml = `
                                    <div class="mb-3">
                                        <strong>${file.file.name}</strong>
                                        <div class="progress" id="${progressId}">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                    </div>
                                `;
                                progressContainer.innerHTML += progressHtml;

                                const uploader = new ChunkedUploader(file.file, {
                                    endpoint: "{{ route('admin.video.upload.chunk') }}",
                                    finalize_endpoint: "{{ route('admin.video.upload.finalize') }}",
                                    discourseId: discourseId,
                                    title: videoFiles[index].title,
                                    sequence: videoFiles[index].sequence,
                                    duration_seconds: videoFiles[index].duration,
                                    onProgress: (progress) => {
                                        const progressBar = document.querySelector(`#${progressId} .progress-bar`);
                                        if (progressBar) {
                                            progressBar.style.width = `${progress}%`;
                                            progressBar.textContent = `${progress}%`;
                                            progressBar.setAttribute('aria-valuenow', progress);
                                        }
                                    },
                                    onComplete: (response) => {
                                        console.log(`Upload complete for video ${index}:`, response);
                                        uploadsRemaining--;
                                        if (uploadsRemaining === 0) {
                                            uploadProgressModal.hide();
                                            window.location.href = "{{ route('admin.discourses.index') }}";
                                        }
                                    },
                                    onError: (error) => {
                                        console.error(`Upload error for video ${index}:`, error);
                                        uploadsRemaining--;
                                        if (uploadsRemaining === 0) {
                                            uploadProgressModal.hide();
                                            window.location.href = "{{ route('admin.discourses.index') }}";
                                        }
                                    }
                                });
                                uploader.start();
                            }
                        });
                    }
                }).catch(errorData => {
                    console.error('An error occurred during form submission:', errorData);
                    const errorContainer = document.querySelector('.alert-danger ul');
                    if (errorContainer) {
                        errorContainer.innerHTML = '';
                        for (const field in errorData.errors) {
                            const messages = errorData.errors[field];
                            messages.forEach(message => {
                                const li = document.createElement('li');
                                li.textContent = message;
                                errorContainer.appendChild(li);
                            });
                        }
                        errorContainer.closest('.alert-danger').style.display = 'block';
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-1"></i> Update Discourse';
                });
            });
        }
    });
</script>
@endsection