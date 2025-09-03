@extends('admin.layouts.app')

@section('title', 'Edit Video')
@section('page_title', 'Edit Video')

@section('styles')
<!-- Include Video.js -->
@include('admin.layouts.video-js-includes')
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Edit Video</h1>
            <p class="text-muted">Update video details for "{{ $discourse->title }}"</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.videos.index', $discourse) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Videos
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.discourses.videos.update', [$discourse, $video]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $video->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sequence" class="form-label">Sequence</label>
                            <input type="number" class="form-control @error('sequence') is-invalid @enderror"
                                id="sequence" name="sequence" value="{{ old('sequence', $video->sequence) }}" min="0">
                            <div class="form-text">Order in which this video appears in the discourse</div>
                            @error('sequence')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="duration_seconds" class="form-label">Duration (seconds)</label>
                            <input type="number" class="form-control @error('duration_seconds') is-invalid @enderror"
                                id="duration_seconds" name="duration_seconds"
                                value="{{ old('duration_seconds', $video->duration_seconds) }}" min="0">
                            <div class="form-text">Video duration in seconds</div>
                            @error('duration_seconds')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> This video uses the discourse thumbnail for display.
                        </div>

                        @if($video->video_path)
                        <div class="video-preview-container mb-4" style="max-width: 400px;">
                            <video id="videoPreview" class="video-js vjs-theme-forest" controls preload="auto"
                                style="width: 100%; height: 225px;">
                                <source src="{{ asset('storage/' . $video->video_path) }}"
                                    type="{{ $video->mime_type ?? 'video/mp4' }}">
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a
                                    web browser that <a href="https://videojs.com/html5-video-support/"
                                        target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                        </div>
                        <div class="text-center mb-4">
                            <p class="mb-0"><strong>Current Video:</strong> {{ $video->video_filename }}</p>
                            @if($video->file_size)
                            <p class="text-muted">{{ number_format($video->file_size / (1024 * 1024), 2) }} MB</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label for="video_file" class="form-label">Replace Video File (Optional)</label>
                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file"
                        name="video_file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv">
                    <div class="form-text">MP4, MOV, AVI, WMV up to 1GB</div>
                    @error('video_file')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div id="file-info" class="alert alert-success" style="display: none;">
                    <div id="file-details"></div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Uploading large videos may take several minutes.
                    Please be patient after submitting.
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize video player if video exists
    if (document.getElementById('videoPreview')) {
        videojs('videoPreview');
    }
    
    const fileInput = document.getElementById('video_file');
    const durationInput = document.getElementById('duration_seconds');
    const fileInfo = document.getElementById('file-info');
    const fileDetails = document.getElementById('file-details');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const file = this.files[0];
            const fileName = file.name;
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            
            // Show file info
            fileDetails.innerHTML = `
                <strong>Selected:</strong> ${fileName}<br>
                <strong>Size:</strong> ${fileSize} MB
            `;
            fileInfo.style.display = 'block';
            
            // Extract video duration
            const video = document.createElement('video');
            video.preload = 'metadata';
            
            video.onloadedmetadata = function() {
                const duration = Math.round(video.duration);
                if (duration && duration > 0) {
                    durationInput.value = duration;
                    fileDetails.innerHTML += `<br><strong>Duration:</strong> ${duration} seconds`;
                }
                window.URL.revokeObjectURL(video.src);
            };
            
            video.src = URL.createObjectURL(file);
        }
    });
});
</script>
@endsection