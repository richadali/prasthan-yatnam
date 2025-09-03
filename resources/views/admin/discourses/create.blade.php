@extends('admin.layouts.app')

@section('title', 'Create Discourse')

@section('page_title', 'Create Discourse')

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
            <h1 class="h3 mb-0">Create New Discourse</h1>
            <p class="text-muted">Add a new discourse</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Discourses
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <h4 class="alert-heading">Validation Errors</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.discourses.store') }}" method="POST" enctype="multipart/form-data"
                id="discourseForm">
                @csrf
                <div class="row g-4">
                    <!-- Left column -->
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="8">{{ old('description') }}</textarea>
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
                                    <div class="preview-placeholder">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
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
                                value="{{ old('price', '0.00') }}">
                            <div class="form-text">Leave 0.00 to make this discourse free for all registered users</div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1" {{ old('is_active', '1' ) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <div class="form-text">Make this discourse visible and accessible to users</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_upcoming"
                                    name="is_upcoming" value="1" {{ old('is_upcoming') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_upcoming">Mark as Upcoming</label>
                            </div>
                            <div class="form-text">Mark this discourse as upcoming (videos can be added later)</div>
                        </div>

                        <div class="mb-4" id="expected-release-date-container"
                            style="{{ old('is_upcoming') ? '' : 'display: none;' }}">
                            <label for="expected_release_date" class="form-label">Expected Release Date</label>
                            <input type="date" class="form-control" id="expected_release_date"
                                name="expected_release_date" value="{{ old('expected_release_date') }}">
                            <div class="form-text">When this discourse is expected to be available</div>
                        </div>
                    </div>
                </div>

                <!-- Hidden field for slug -->
                <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">
                <input type="hidden" name="discourse_id" id="discourse_id" value="">

                <hr class="my-4">

                <h4 class="mb-4">Add Videos</h4>
                <p class="text-muted mb-3">You can add initial videos now or add them later from the discourse
                    management page.</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Upload your video files directly.
                    Videos will be stored and streamed as-is for optimal quality.
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            The form may take a few minutes to process when uploading large videos. Please be patient.
                        </small>
                    </div>
                </div>

                <div id="videoContainer">
                    <!-- Videos will be added here dynamically -->
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-primary" id="addVideoBtn">
                        <i class="fas fa-plus-circle me-1"></i> Add Video
                    </button>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Discourse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Video template -->
<template id="videoTemplate">
    <div class="video-item" data-index="__INDEX__">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label">Video Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control video-title" name="videos[__INDEX__][title]" required>
                </div>

                <!-- Video upload -->
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
                    <div class="upload-progress">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted upload-status">Preparing upload...</small>
                    </div>
                </div>
                <input type="hidden" class="video-path" name="videos[__INDEX__][video_path]">
                <input type="hidden" class="video-filename" name="videos[__INDEX__][video_filename]">
                <input type="hidden" class="mime-type" name="videos[__INDEX__][mime_type]">
                <input type="hidden" class="file-size" name="videos[__INDEX__][file_size]">
                <input type="hidden" class="is-processed" name="videos[__INDEX__][is_processed]" value="0">

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
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="video-preview" data-video-id="" data-video-type="">
                        <i class="fas fa-play play-icon"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-danger btn-sm remove-video">
                        <i class="fas fa-trash me-1"></i> Remove Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Video Preview Modal -->
<div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="video-embed-container">
                    <!-- Video.js player for videos -->
                    <video id="localVideoPlayer" class="video-js vjs-theme-forest" controls preload="auto">
                        <source src="" type="video/mp4">
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports
                                HTML5 video</a>
                        </p>
                    </video>
                </div>
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
        console.log('Initializing CKEditor...');
        
        // Initialize CKEditor for description
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                console.log('CKEditor initialized successfully');
                window.editor = editor; // Store for debugging
            })
            .catch(error => {
                console.error('CKEditor initialization failed:', error);
            });

        // Thumbnail preview
        const thumbnailInput = document.getElementById('thumbnail');
        const previewContent = document.querySelector('.preview-content');

        thumbnailInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContent.innerHTML = `<img src="${e.target.result}" alt="Thumbnail Preview">`;
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                previewContent.innerHTML = `
                    <div class="preview-placeholder">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                `;
            }
        });

        // Toggle expected release date based on is_upcoming
        const isUpcomingCheckbox = document.getElementById('is_upcoming');
        const releaseDateContainer = document.getElementById('expected-release-date-container');

        isUpcomingCheckbox.addEventListener('change', function() {
            releaseDateContainer.style.display = this.checked ? 'block' : 'none';
        });

        // Generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('blur', function() {
            if (!slugInput.value) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                slugInput.value = slug;
            }
        });

        // Video handling
        let videoIndex = 0;
        const videoContainer = document.getElementById('videoContainer');
        const videoTemplate = document.getElementById('videoTemplate').innerHTML;
        const addVideoBtn = document.getElementById('addVideoBtn');
        const videoFiles = [];

        // Add video
        addVideoBtn.addEventListener('click', function() {
            const newVideo = videoTemplate.replace(/__INDEX__/g, videoIndex);
            const videoDiv = document.createElement('div');
            videoDiv.innerHTML = newVideo;
            videoContainer.appendChild(videoDiv.firstElementChild);

            // Initialize the video upload functionality
            const uploadWrapper = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .video-upload-wrapper`);
            const fileInput = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .video-file`);
            const titleInput = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .video-title`);
            const durationInput = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .duration-seconds`);
            
            uploadWrapper.addEventListener('click', function() {
                fileInput.click();
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2);
                    
                    // Store the file in the array
                    videoFiles[videoIndex - 1] = file;

                    // Update upload wrapper display
                    uploadWrapper.innerHTML = `
                        <div class="video-upload-text">
                            <strong>${fileName}</strong> (${fileSize} MB)
                        </div>
                        <div class="video-upload-hint">
                            Click to change file
                        </div>
                    `;
                    
                    // Auto-fill title if empty
                    if (!titleInput.value.trim()) {
                        titleInput.value = fileName.replace(/\.[^/.]+$/, "");
                    }
                    
                    // Extract video duration
                    if (durationInput) {
                        const video = document.createElement('video');
                        video.preload = 'metadata';
                        
                        video.onloadedmetadata = function() {
                            const duration = Math.round(video.duration);
                            if (duration && duration > 0) {
                                durationInput.value = duration;
                            }
                            window.URL.revokeObjectURL(video.src);
                        };
                        
                        video.src = URL.createObjectURL(file);
                    }
                }
            });

            // Remove video
            const removeBtn = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .remove-video`);
            removeBtn.addEventListener('click', function() {
                this.closest('.video-item').remove();
            });

            videoIndex++;
        });

        // Test form submission with detailed debugging
        const form = document.getElementById('discourseForm');
        if (form) {
            console.log('Form found:', form);
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            
            // Check if form has any existing event listeners
            console.log('Form HTML:', form.outerHTML.substring(0, 200) + '...');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('=== FORM SUBMIT EVENT FIRED ===');


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
                        const discourseId = data.discourse_id;
                        document.getElementById('discourse_id').value = discourseId;

                        // Start chunked uploads for each video
                        let uploadsRemaining = videoFiles.filter(file => file).length;
                        if (uploadsRemaining === 0) {
                            window.location.href = "{{ route('admin.discourses.index') }}";
                            return;
                        }

                        videoFiles.forEach((file, index) => {
                            if (file) {
                                const uploader = new ChunkedUploader(file, {
                                    endpoint: "{{ route('admin.video.upload.chunk') }}",
                                    finalize_endpoint: "{{ route('admin.video.upload.finalize') }}",
                                    discourseId: discourseId,
                                    title: form.querySelector(`input[name="videos[${index}][title]"]`).value,
                                    sequence: form.querySelector(`input[name="videos[${index}][sequence]"]`).value,
                                    duration_seconds: form.querySelector(`input[name="videos[${index}][duration_seconds]"]`).value,
                                    onProgress: (progress) => {
                                        console.log(`Upload progress for video ${index}: ${progress}%`);
                                        const progressWrapper = document.querySelector(`.video-item[data-index="${index}"] .upload-progress`);
                                        const progressBar = progressWrapper.querySelector('.progress-bar');
                                        const uploadStatus = progressWrapper.querySelector('.upload-status');

                                        if (progressWrapper) {
                                            progressWrapper.style.display = 'block';
                                        }
                                        if (progressBar) {
                                            progressBar.style.width = `${progress}%`;
                                            progressBar.setAttribute('aria-valuenow', progress);
                                        }
                                        if (uploadStatus) {
                                            uploadStatus.textContent = `Uploading... ${progress}%`;
                                        }
                                    },
                                    onComplete: (response) => {
                                        console.log(`Upload complete for video ${index}:`, response);
                                        uploadsRemaining--;
                                        if (uploadsRemaining === 0) {
                                            window.location.href = "{{ route('admin.discourses.index') }}";
                                        }
                                    },
                                    onError: (error) => {
                                        console.error(`Upload error for video ${index}:`, error);
                                        uploadsRemaining--;
                                        if (uploadsRemaining === 0) {
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
                });
            });
            
            // Test submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            console.log('Submit button found:', submitBtn);
            
            if (submitBtn) {
                console.log('Submit button HTML:', submitBtn.outerHTML);
                
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default button behavior
                    console.log('=== SUBMIT BUTTON CLICKED ===');

                    // Manually trigger form submission
                    form.dispatchEvent(new Event('submit', { cancelable: true }));
                });
            }
            
            // Also check for any other submit buttons or inputs
            const allSubmits = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            console.log('All submit elements found:', allSubmits.length);
            allSubmits.forEach((btn, index) => {
                console.log(`Submit element ${index}:`, btn);
            });
            
        } else {
            console.error('Form not found!');
        }
        
        console.log('DOM loaded for discourse creation form');
    });
</script>
@endsection