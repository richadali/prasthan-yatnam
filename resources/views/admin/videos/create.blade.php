@extends('admin.layouts.app')

@section('title', 'Add Video')
@section('page_title', 'Add Video')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Add Video to "{{ $discourse->title }}"</h1>
            <p class="text-muted">Upload a new video to this discourse</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.videos.index', $discourse) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Videos
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.discourses.videos.store', $discourse) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sequence" class="form-label">Sequence</label>
                            <input type="number" class="form-control @error('sequence') is-invalid @enderror"
                                id="sequence" name="sequence"
                                value="{{ old('sequence', $discourse->videos()->count()) }}" min="0">
                            <div class="form-text">Order in which this video appears in the discourse</div>
                            @error('sequence')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="duration_seconds" class="form-label">Duration (seconds)</label>
                            <input type="number" class="form-control @error('duration_seconds') is-invalid @enderror"
                                id="duration_seconds" name="duration_seconds" value="{{ old('duration_seconds') }}"
                                min="0">
                            <div class="form-text">Video duration in seconds (auto-filled when you select a video)</div>
                            @error('duration_seconds')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> This video will use the discourse thumbnail for
                            display.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="video_file" class="form-label">Video File <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file"
                        name="video_file" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv" required>
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
                        <i class="fas fa-save me-1"></i> Upload Video
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
    const fileInput = document.getElementById('video_file');
    const titleInput = document.getElementById('title');
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
            
            // Auto-fill title if empty
            if (!titleInput.value.trim()) {
                titleInput.value = fileName.replace(/\.[^/.]+$/, "");
            }
            
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