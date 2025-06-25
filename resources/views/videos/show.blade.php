@extends('layouts.app')

@section('styles')
<style>
    .video-container {
        padding: 3rem 0;
        background-color: #f8f9fa;
    }

    .video-player {
        background-color: #000;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-bottom: 2rem;
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

    .progress-container {
        height: 5px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-blue), var(--dark-blue));
        border-radius: 5px;
        transition: width 0.3s ease;
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
                <div class="video-player">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtube-player"
                            src="https://www.youtube.com/embed/{{ $video->youtube_video_id }}?enablejsapi=1&rel=0&modestbranding=1"
                            title="{{ $video->title }}" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                </div>

                <h1 class="video-title">{{ $video->title }}</h1>

                <div class="video-meta">
                    <span>Duration: {{ $video->formatted_duration }}</span>
                    <span>Last watched: {{ $progress->last_watched_at->diffForHumans() }}</span>
                </div>

                <div class="progress-container">
                    <div class="progress-bar" style="width: {{ $progress->progress_percentage }}%"></div>
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
                    <a href="{{ route('discourses.my') }}" class="btn btn-success">
                        Complete Course <i class="fas fa-check ms-2"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="course-info">
                    <h4 class="course-title">{{ $discourse->title }}</h4>
                    <p>{{ count($discourse->videos) }} videos</p>
                    <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-outline-primary btn-sm">
                        Back to Course
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
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;
    let videoId = '{{ $video->youtube_video_id }}';
    let currentPosition = {{ $progress->current_position_seconds ?? 0 }};
    let videoDuration = {{ $video->duration_seconds ?? 0 }};
    let videoCompleted = {{ $progress->completed ? 'true' : 'false' }};
    let updateInterval;
    let lastUpdateTime = 0;
    
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }
    
    function onPlayerReady(event) {
        // Seek to the last saved position if available
        if (currentPosition > 0) {
            player.seekTo(currentPosition, true);
        }
        
        // Start tracking progress
        updateInterval = setInterval(updateProgress, 5000); // Update every 5 seconds
    }
    
    function onPlayerStateChange(event) {
        // Update progress when video is paused
        if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED) {
            updateProgress(true);
        }
        
        // Mark video as completed when it ends
        if (event.data == YT.PlayerState.ENDED) {
            videoCompleted = true;
            updateProgress(true);
        }
    }
    
    function updateProgress(force = false) {
        if (!player || typeof player.getCurrentTime !== 'function') {
            return;
        }
        
        const currentTime = Math.floor(player.getCurrentTime());
        
        // Only update if position changed by at least 5 seconds or forced
        if (force || Math.abs(currentTime - lastUpdateTime) >= 5) {
            lastUpdateTime = currentTime;
            
            // Calculate progress percentage
            const percentage = videoDuration > 0 ? (currentTime / videoDuration) * 100 : 0;
            
            // Update progress bar
            document.querySelector('.progress-bar').style.width = percentage + '%';
            
            // Save progress to server
            fetch('{{ route("videos.progress", $video->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    current_position: currentTime,
                    completed: videoCompleted
                })
            })
            .catch(error => console.error('Error updating progress:', error));
        }
    }
    
    // Clean up when leaving the page
    window.addEventListener('beforeunload', function() {
        clearInterval(updateInterval);
        updateProgress(true);
    });
</script>
@endsection