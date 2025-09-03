@extends('layouts.app')

@section('styles')
@include('admin.layouts.video-js-includes')
<style>
    .video-container {
        padding: 3rem 0;
        background-color: #f8f9fa;
    }

    .video-player-container {
        position: relative;
        padding-top: 56.25%;
        /* 16:9 aspect ratio */
    }

    .video-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .video-title {
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .video-description {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .nav-buttons {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .course-info {
        margin-bottom: 2rem;
    }

    .course-title {
        color: var(--primary-blue);
        font-weight: 600;
    }

    .video-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="video-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="video-player-container mb-4">
                    <video id="my-video" class="video-js vjs-theme-forest" controls preload="auto"
                        poster="{{ $discourse->getThumbnailUrl() }}" data-setup="{}">
                        <source src="{{ route('video.stream', $video->id) }}" type="{{ $video->mime_type }}">
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>

                <h1 class="video-title">{{ $video->title }}</h1>

                <div class="video-meta">
                    <span>Duration: {{ $video->formatted_duration }}</span>
                </div>

                <div class="video-description">
                    {{ $video->description }}
                </div>

                <div class="nav-buttons">
                    @if($prevVideo)
                    <a href="{{ route('videos.show', ['discourse_slug' => $discourse->slug, 'video_id' => $prevVideo->id]) }}"
                        class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Previous Video
                    </a>
                    @else
                    <div></div>
                    @endif

                    @if($nextVideo)
                    <a href="{{ route('videos.show', ['discourse_slug' => $discourse->slug, 'video_id' => $nextVideo->id]) }}"
                        class="btn btn-primary">
                        Next Video <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    @else
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="course-info">
                    <h4 class="course-title">{{ $discourse->title }}</h4>
                    <p>{{ count($discourse->videos) }} videos</p>
                    <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-outline-primary btn-sm">
                        Back to Discourse
                    </a>
                </div>

                <div class="list-group">
                    @foreach($discourse->videos as $courseVideo)
                    <a href="{{ route('videos.show', ['discourse_slug' => $discourse->slug, 'video_id' => $courseVideo->id]) }}"
                        class="list-group-item list-group-item-action {{ $courseVideo->id == $video->id ? 'active' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $courseVideo->title }}</h6>
                            <small>{{ $courseVideo->formatted_duration }}</small>
                        </div>
                        <small class="text-muted">{{ \Illuminate\Support\Str::limit($courseVideo->description, 60)
                            }}</small>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var player = videojs('my-video');
        player.on('contextmenu', function(e) {
            e.preventDefault();
        });
    });
</script>
@endsection