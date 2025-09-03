@extends('admin.layouts.app')

@section('title', 'Upload Video')

@section('page_title', 'Upload Video')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Upload Video</h1>
            <p class="text-muted">Upload a video file directly</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Discourses
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="discourse_id" class="form-label">Discourse <span class="text-danger">*</span></label>
                    <select class="form-control" id="discourse_id" name="discourse_id" required>
                        <option value="">Select a discourse</option>
                        @foreach(\App\Models\Discourse::all() as $discourse)
                        <option value="{{ $discourse->id }}">{{ $discourse->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-4">
                    <label for="video_file" class="form-label">Video File <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="video_file" name="video_file"
                        accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv" required>
                    <div class="form-text">MP4, MOV, AVI, WMV up to 1GB</div>
                </div>

                <div class="mb-4">
                    <label for="sequence" class="form-label">Sequence</label>
                    <input type="number" class="form-control" id="sequence" name="sequence" min="0" value="0">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload Video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection