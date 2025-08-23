@extends('layouts.app')

@section('styles')
<style>
    .preview-container {
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

    .preview-badge {
        background-color: #17a2b8;
        color: white;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        margin-left: 0.5rem;
    }

    .course-info {
        margin-bottom: 2rem;
    }

    .course-title {
        color: var(--primary-blue);
        font-weight: 600;
    }

    .enrollment-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .enrollment-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        padding: 1.5rem;
    }

    .enrollment-price {
        font-size: 2rem;
        font-weight: 700;
    }

    .enrollment-body {
        padding: 1.5rem;
    }

    .feature-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 2rem;
    }

    .feature-list li {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
    }

    .feature-list li::before {
        content: '✓';
        color: #28a745;
        font-weight: bold;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="preview-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="video-player">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtube-player"
                            src="https://www.youtube.com/embed/{{ $video->youtube_video_id }}?rel=0&modestbranding=1&controls=1&disablekb=1&showinfo=0&iv_load_policy=3&fs=1&cc_load_policy=0&origin={{ url('') }}&playsinline=1&color=white"
                            title="{{ $video->title }}" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                    <!-- Overlay elements to hide YouTube branding -->
                    <div class="youtube-overlay-top"></div>
                    <div class="youtube-overlay-bottom-right"></div>
                    <div class="youtube-overlay-top-right"></div>
                </div>

                <h1 class="video-title">
                    {{ $video->title }}
                    <span class="preview-badge">Free Preview</span>
                </h1>

                <div class="video-description">
                    {{ $video->description }}
                </div>

                <div class="course-info">
                    <h4 class="course-title">{{ $discourse->title }}</h4>
                    <p>{{ count($discourse->videos) }} videos in this course</p>
                    <a href="{{ route('discourses.show', $discourse->slug) }}" class="btn btn-outline-primary">
                        View Full Course
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="enrollment-card">
                    <div class="enrollment-header text-center">
                        @if($discourse->price > 0)
                        <div class="enrollment-price">₹{{ number_format($discourse->price, 2) }}</div>
                        @else
                        <div class="enrollment-price">Free</div>
                        @endif
                    </div>
                    <div class="enrollment-body">
                        <ul class="feature-list">
                            <li>{{ count($discourse->videos) }} video lessons</li>
                            <li>Lifetime access</li>
                            <li>Access on mobile and Computer</li>
                            <li>Certificate of completion</li>
                        </ul>

                        @if(Auth::check())
                        <form action="{{ route('discourses.enroll', $discourse->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                @if($discourse->price > 0)
                                Enroll Now
                                @else
                                Enroll for Free
                                @endif
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn btn-primary w-100">
                            Login to Enroll
                        </a>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <h5>This is a preview</h5>
                    <p class="text-muted">Enroll in this course to get access to all videos and course materials.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
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
        const player = new YT.Player('youtube-player', {
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