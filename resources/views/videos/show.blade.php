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
        position: relative;
    }

    /* Hide YouTube logo and title */
    .video-player iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    /* Custom overlays to hide YouTube elements */
    .youtube-overlay-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background-color: #000;
        z-index: 2;
        pointer-events: none;
    }

    .youtube-overlay-bottom-right {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 120px;
        height: 60px;
        background-color: #000;
        z-index: 2;
        pointer-events: none;
    }

    .youtube-overlay-top-right {
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 60px;
        background-color: #000;
        z-index: 2;
        pointer-events: none;
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
                <div class="video-player">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtube-player"
                            src="https://www.youtube.com/embed/{{ $video->youtube_video_id }}?enablejsapi=1&rel=0&modestbranding=1&controls=1&disablekb=1&showinfo=0&iv_load_policy=3&fs=1&cc_load_policy=0&origin={{ url('') }}&playsinline=1&color=white"
                            title="{{ $video->title }}" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                    <!-- Overlay elements to hide YouTube branding -->
                    <div class="youtube-overlay-top"></div>
                    <div class="youtube-overlay-bottom-right"></div>
                    <div class="youtube-overlay-top-right"></div>
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
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;
    let videoId = '{{ $video->youtube_video_id }}';
    
    // Function to adjust overlay positions based on player dimensions
    function adjustOverlays() {
        const iframe = document.getElementById('youtube-player');
        if (!iframe) return;
        
        // Get the actual dimensions of the player
        const playerRect = iframe.getBoundingClientRect();
        const playerHeight = playerRect.height;
        
        // Calculate dimensions for overlays
        const topHeight = Math.max(60, playerHeight * 0.1); // 10% of player height or min 60px
        const bottomRightHeight = Math.max(60, playerHeight * 0.12); // 12% of player height or min 60px
        
        // Apply dimensions to overlays
        const topOverlay = document.querySelector('.youtube-overlay-top');
        if (topOverlay) {
            topOverlay.style.height = topHeight + 'px';
        }
        
        const bottomRightOverlay = document.querySelector('.youtube-overlay-bottom-right');
        if (bottomRightOverlay) {
            bottomRightOverlay.style.height = bottomRightHeight + 'px';
            bottomRightOverlay.style.width = (bottomRightHeight * 2) + 'px'; // Make it wider
        }
        
        const topRightOverlay = document.querySelector('.youtube-overlay-top-right');
        if (topRightOverlay) {
            topRightOverlay.style.height = topHeight + 'px';
            topRightOverlay.style.width = (topHeight * 2.5) + 'px'; // Make it wider
        }
    }
    
    // Try to remove YouTube branding with custom styling
    const removeYouTubeBranding = () => {
        try {
            const iframe = document.getElementById('youtube-player');
            if (!iframe) return;
            
            // Adjust overlay positions
            adjustOverlays();
            
            // Create a style element
            const style = document.createElement('style');
            
            // Add CSS to hide YouTube elements
            style.textContent = `
                .ytp-chrome-top,
                .ytp-chrome-bottom .ytp-youtube-button,
                .ytp-chrome-bottom .ytp-subtitles-button,
                .ytp-watermark,
                .ytp-show-cards-title,
                .ytp-title,
                .ytp-title-text,
                .ytp-title-link,
                .ytp-share-button,
                .ytp-watch-later-button,
                a.ytp-youtube-button.ytp-button.yt-uix-sessionlink {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                }
            `;
            
            // Try to inject style into iframe
            setTimeout(() => {
                try {
                    if (iframe.contentDocument) {
                        iframe.contentDocument.head.appendChild(style);
                    }
                } catch (e) {
                    console.log('Could not access iframe directly due to cross-origin restrictions');
                }
            }, 1000);
        } catch (e) {
            console.error('Error removing YouTube branding:', e);
        }
    };
    
    // Run this immediately and after a short delay
    removeYouTubeBranding();
    setTimeout(removeYouTubeBranding, 1000);
    
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            },
            playerVars: {
                'rel': 0,                // Don't show related videos
                'showinfo': 0,           // Hide video title and uploader info
                'modestbranding': 1,     // Hide YouTube logo
                'iv_load_policy': 3,     // Hide video annotations
                'cc_load_policy': 0,     // Hide closed captions by default
                'fs': 1,                 // Show fullscreen button
                'controls': 1,           // Show video controls
                'disablekb': 1,          // Disable keyboard controls
                'color': 'white',        // Use white progress bar
                'playsinline': 1         // Play inline on mobile
            }
        });
    }
    
    function onPlayerReady(event) {
        // Adjust overlays after player is ready
        adjustOverlays();
        setTimeout(adjustOverlays, 500);
        setTimeout(adjustOverlays, 1500);
    }
    
    function onPlayerStateChange(event) {
        // Adjust overlays when state changes
        adjustOverlays();
    }
    
    // Additional attempt to hide YouTube elements when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        removeYouTubeBranding();
        adjustOverlays();
        setTimeout(adjustOverlays, 1000);
    });
    
    // Adjust overlays when window is resized
    window.addEventListener('resize', adjustOverlays);
</script>
@endsection