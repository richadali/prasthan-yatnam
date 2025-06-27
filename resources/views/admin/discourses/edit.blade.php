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

    .youtube-preview {
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

    .youtube-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .youtube-preview .yt-play {
        position: absolute;
        color: rgba(255, 0, 0, 0.8);
        font-size: 3rem;
        filter: drop-shadow(0 0 3px rgba(255, 255, 255, 0.7));
    }

    .youtube-modal .modal-content {
        background-color: #000;
        border-radius: 8px;
    }

    .youtube-modal .modal-header {
        border-bottom: 1px solid #333;
        padding: 0.5rem 1rem;
    }

    .youtube-modal .modal-header .btn-close {
        background-color: #fff;
        opacity: 0.8;
    }

    .youtube-modal .modal-title {
        color: #fff;
        font-size: 1.1rem;
    }

    .youtube-modal .modal-body {
        padding: 0;
    }

    .youtube-embed-container {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }

    .youtube-embed-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>
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
                                    <img src="{{ asset('storage/' . $discourse->thumbnail) }}"
                                        alt="{{ $discourse->title }}">
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

                <h4 class="mb-4">Manage Videos</h4>
                <p class="text-muted mb-3">Add, edit or remove videos for this discourse.</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Simply paste any YouTube URL and click "Fetch Details" to
                    automatically get the video title and duration.
                </div>

                <div id="videoContainer">
                    <!-- Existing videos will be loaded here -->
                    @foreach($discourse->videos->sortBy('sequence') as $index => $video)
                    <div class="video-item" data-index="{{ $index }}" data-id="{{ $video->id }}">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Video Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control video-title"
                                        name="videos[{{ $index }}][title]" value="{{ $video->title }}" required>
                                    <input type="hidden" name="videos[{{ $index }}][id]" value="{{ $video->id }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">YouTube URL <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control youtube-url"
                                            name="videos[{{ $index }}][youtube_url]"
                                            value="https://www.youtube.com/watch?v={{ $video->youtube_video_id }}"
                                            required>
                                        <button class="btn btn-outline-secondary fetch-yt-details" type="button">
                                            <i class="fas fa-search me-1"></i> Fetch Details
                                        </button>
                                    </div>
                                    <div class="form-text">Enter complete YouTube URL (youtu.be/abc or
                                        youtube.com/watch?v=abc)</div>
                                </div>
                                <input type="hidden" class="youtube-id" name="videos[{{ $index }}][youtube_video_id]"
                                    value="{{ $video->youtube_video_id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Sequence</label>
                                            <input type="number" class="form-control video-sequence"
                                                name="videos[{{ $index }}][sequence]" min="0"
                                                value="{{ $video->sequence }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Duration (seconds)</label>
                                            <input type="number" class="form-control duration-seconds"
                                                name="videos[{{ $index }}][duration_seconds]" min="0"
                                                value="{{ $video->duration_seconds }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="youtube-preview" data-video-id="{{ $video->youtube_video_id }}"
                                        data-video-title="{{ $video->title }}">
                                        <img src="https://img.youtube.com/vi/{{ $video->youtube_video_id }}/maxresdefault.jpg"
                                            alt="YouTube Thumbnail"
                                            onerror="this.src='https://img.youtube.com/vi/{{ $video->youtube_video_id }}/0.jpg';">
                                        <i class="fas fa-play yt-play"></i>
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

<!-- Video template -->
<template id="videoTemplate">
    <div class="video-item" data-index="__INDEX__">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label">Video Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control video-title" name="videos[__INDEX__][title]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">YouTube URL <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control youtube-url" name="videos[__INDEX__][youtube_url]"
                            required>
                        <button class="btn btn-outline-secondary fetch-yt-details" type="button">
                            <i class="fas fa-search me-1"></i> Fetch Details
                        </button>
                    </div>
                    <div class="form-text">Enter complete YouTube URL (youtu.be/abc or youtube.com/watch?v=abc)</div>
                </div>
                <input type="hidden" class="youtube-id" name="videos[__INDEX__][youtube_video_id]">
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
                    <div class="youtube-preview">
                        <i class="fas fa-play yt-play"></i>
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

<!-- YouTube Video Modal -->
<div class="modal fade youtube-modal" id="youtubeModal" tabindex="-1" aria-labelledby="youtubeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="youtubeModalLabel">Video Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="youtube-embed-container">
                    <iframe id="youtubeIframe" src="" title="YouTube video player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize rich text editor
        let editor;
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(newEditor => {
                editor = newEditor;
                
                // Listen for changes in the editor and update the hidden textarea
                editor.model.document.on('change:data', () => {
                    document.querySelector('#description').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
        
        // Auto-generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        
        titleInput.addEventListener('blur', function() {
            if (titleInput.value !== '' && slugInput.value === '') {
                slugInput.value = createSlug(titleInput.value);
            }
        });
        
        // Toggle expected release date field based on is_upcoming checkbox
        const isUpcomingCheckbox = document.getElementById('is_upcoming');
        const expectedReleaseDateContainer = document.getElementById('expected-release-date-container');
        
        isUpcomingCheckbox.addEventListener('change', function() {
            expectedReleaseDateContainer.style.display = this.checked ? 'block' : 'none';
        });
        
        function createSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')     // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-')   // Replace multiple - with single -
                .replace(/^-+/, '')       // Trim - from start
                .replace(/-+$/, '');      // Trim - from end
        }
        
        // Image preview functionality
        const thumbnailInput = document.getElementById('thumbnail');
        const previewContainer = document.querySelector('.image-preview');
        
        thumbnailInput.addEventListener('change', function() {
            while (previewContainer.firstChild) {
                previewContainer.removeChild(previewContainer.firstChild);
            }
            
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            } else {
                // If no new file is selected, show the existing thumbnail if available
                @if($discourse->thumbnail)
                    previewContainer.innerHTML = '<img src="{{ asset('storage/' . $discourse->thumbnail) }}" alt="{{ $discourse->title }}">';
                @else
                    previewContainer.innerHTML = '<div class="preview-placeholder"><i class="fas fa-image fa-3x"></i></div>';
                @endif
            }
        });
        
        // Videos management
        let videoCount = {{ $discourse->videos->count() }};
        const videoContainer = document.getElementById('videoContainer');
        const videoTemplate = document.getElementById('videoTemplate').innerHTML;
        const addVideoBtn = document.getElementById('addVideoBtn');
        
        // YouTube modal functionality
        const youtubeModal = new bootstrap.Modal(document.getElementById('youtubeModal'));
        const youtubeIframe = document.getElementById('youtubeIframe');
        const youtubeModalTitle = document.getElementById('youtubeModalLabel');
        
        // Add click handler for YouTube previews
        document.addEventListener('click', function(e) {
            const preview = e.target.closest('.youtube-preview');
            if (preview) {
                const videoId = preview.dataset.videoId;
                const videoTitle = preview.dataset.videoTitle || 'Video Preview';
                
                if (videoId) {
                    // Set the iframe src and modal title
                    youtubeIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                    youtubeModalTitle.textContent = videoTitle;
                    youtubeModal.show();
                }
            }
        });
        
        // Reset iframe when modal is closed
        document.getElementById('youtubeModal').addEventListener('hidden.bs.modal', function () {
            youtubeIframe.src = '';
        });
        
        // Add video button click handler
        addVideoBtn.addEventListener('click', function() {
            addNewVideo();
        });
        
        // Remove video button click handler
        videoContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video') || e.target.parentElement.classList.contains('remove-video')) {
                const videoItem = e.target.closest('.video-item');
                if (videoItem) {
                    // If it's an existing video, add a hidden field to mark it for deletion
                    const videoId = videoItem.dataset.id;
                    if (videoId) {
                        const deleteField = document.createElement('input');
                        deleteField.type = 'hidden';
                        deleteField.name = 'delete_videos[]';
                        deleteField.value = videoId;
                        document.getElementById('discourseForm').appendChild(deleteField);
                    }
                    
                    videoItem.remove();
                    updateSequenceNumbers();
                }
            }
        });
        
        // Fetch YouTube video details
        videoContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('fetch-yt-details') || e.target.parentElement.classList.contains('fetch-yt-details')) {
                const videoItem = e.target.closest('.video-item');
                const youtubeUrlInput = videoItem.querySelector('.youtube-url');
                const youtubeIdInput = videoItem.querySelector('.youtube-id');
                const youtubeUrl = youtubeUrlInput.value.trim();
                
                if (!youtubeUrl) {
                    alert('Please enter a YouTube URL');
                    return;
                }
                
                // Extract video ID from URL
                const videoId = extractYouTubeId(youtubeUrl);
                if (!videoId) {
                    alert('Invalid YouTube URL. Please enter a valid YouTube URL.');
                    return;
                }
                
                // Store the extracted ID in the hidden field
                youtubeIdInput.value = videoId;
                
                fetchVideoDetails(videoId, videoItem);
            }
        });
        
        // Function to extract YouTube video ID from URL
        function extractYouTubeId(url) {
            // Handle youtu.be format
            let match = url.match(/youtu\.be\/([^?&]+)/);
            if (match) return match[1];
            
            // Handle youtube.com/watch?v= format
            match = url.match(/youtube\.com\/watch\?v=([^&]+)/);
            if (match) return match[1];
            
            // Handle youtube.com/embed/ format
            match = url.match(/youtube\.com\/embed\/([^?&]+)/);
            if (match) return match[1];
            
            // If it's just the ID itself, return it
            if (/^[A-Za-z0-9_-]{11}$/.test(url)) return url;
            
            return null;
        }
        
        function addNewVideo() {
            let newVideoHtml = videoTemplate.replace(/__INDEX__/g, videoCount);
            
            // Create a temporary div to hold the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newVideoHtml;
            
            // Append the new video to the container
            videoContainer.appendChild(tempDiv.firstElementChild);
            
            videoCount++;
        }
        
        function updateSequenceNumbers() {
            const videoItems = document.querySelectorAll('.video-item');
            videoItems.forEach((item, index) => {
                const sequenceInput = item.querySelector('.video-sequence');
                if (sequenceInput.value === '' || parseInt(sequenceInput.value) === parseInt(item.dataset.index)) {
                    sequenceInput.value = index;
                }
                item.dataset.index = index;
            });
        }
        
        function fetchVideoDetails(youtubeId, videoItem) {
            const titleInput = videoItem.querySelector('.video-title');
            const durationInput = videoItem.querySelector('.duration-seconds');
            const previewContainer = videoItem.querySelector('.youtube-preview');
            const youtubeUrlInput = videoItem.querySelector('.youtube-url');
            
            // Clear any previous error messages
            const previousErrors = videoItem.querySelectorAll('.api-error-message');
            previousErrors.forEach(el => el.remove());
            
            // Set loading state
            previewContainer.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            // Fetch from API
            fetch(`{{ route('admin.youtube.fetch-details') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ youtube_video_id: youtubeId })
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        // API returned an error
                        throw new Error(data.error || 'API request failed');
                    }
                    return data;
                });
            })
            .then(data => {
                console.log('YouTube data:', data);
                
                // Fill in the data
                if (!titleInput.value && data.title) {
                    titleInput.value = data.title;
                }
                
                if (data.duration_seconds) {
                    durationInput.value = data.duration_seconds;
                }
                
                // Update preview
                previewContainer.innerHTML = `
                    <img src="https://img.youtube.com/vi/${youtubeId}/maxresdefault.jpg" alt="YouTube Thumbnail" onerror="this.src='https://img.youtube.com/vi/${youtubeId}/0.jpg';">
                    <i class="fas fa-play yt-play"></i>
                `;
                
                // Add video ID and title as data attributes for the player
                previewContainer.dataset.videoId = youtubeId;
                previewContainer.dataset.videoTitle = titleInput.value || 'Video Preview';
            })
            .catch(error => {
                console.error('Error fetching video details:', error);
                
                // Show thumbnail if available
                previewContainer.innerHTML = `
                    <img src="https://img.youtube.com/vi/${youtubeId}/maxresdefault.jpg" alt="YouTube Thumbnail" onerror="this.src='https://img.youtube.com/vi/${youtubeId}/0.jpg';">
                    <i class="fas fa-play yt-play"></i>
                `;
                
                // Add video ID for the player
                previewContainer.dataset.videoId = youtubeId;
                
                // Show error message
                const inputGroup = youtubeUrlInput.closest('.mb-3');
                if (inputGroup) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-2 api-error-message';
                    errorDiv.innerHTML = `
                        <strong>API Error:</strong> ${error.message}
                        <div class="mt-1 small">
                            <a href="https://console.cloud.google.com/apis/credentials" target="_blank">
                                Get a YouTube API key
                            </a>
                            and add it to your .env file as YOUTUBE_API_KEY
                        </div>
                    `;
                    inputGroup.appendChild(errorDiv);
                }
            });
        }
        
        // Form submission
        const discourseForm = document.getElementById('discourseForm');
        discourseForm.addEventListener('submit', function(e) {
            // Create slug if empty
            if (!slugInput.value && titleInput.value) {
                slugInput.value = createSlug(titleInput.value);
            }
            
            // Validate CKEditor content
            let isValid = true;
            
            // Check if editor exists and get its content
            if (typeof editor !== 'undefined') {
                const editorContent = editor.getData().trim();
                const descriptionField = document.querySelector('#description');
                const descriptionError = document.querySelector('#description-error');
                
                // Update the textarea with the editor content
                descriptionField.value = editorContent;
                
                // Check if content is empty
                if (!editorContent) {
                    isValid = false;
                    descriptionField.classList.add('is-invalid');
                    descriptionError.style.display = 'block';
                } else {
                    descriptionField.classList.remove('is-invalid');
                    descriptionError.style.display = 'none';
                }
            }
            
            // Process all videos - make sure IDs are extracted before submission
            const videoItems = document.querySelectorAll('.video-item');
            let hasInvalidUrls = false;
            
            videoItems.forEach(item => {
                const urlInput = item.querySelector('.youtube-url');
                const idInput = item.querySelector('.youtube-id');
                const url = urlInput.value.trim();
                
                if (url && !idInput.value) {
                    // Attempt to extract ID
                    const id = extractYouTubeId(url);
                    if (id) {
                        idInput.value = id;
                    } else {
                        hasInvalidUrls = true;
                        urlInput.classList.add('is-invalid');
                    }
                }
            });
            
            // Stop submission if invalid
            if (hasInvalidUrls || !isValid) {
                e.preventDefault();
                
                if (hasInvalidUrls) {
                    alert('One or more YouTube URLs are invalid. Please fix them before submitting.');
                }
                
                return false;
            }
        });
    });
</script>
@endsection