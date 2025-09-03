@extends('admin.layouts.app')

@section('title', 'Manage Videos')

@section('page_title', 'Manage Videos')

@section('styles')
<style>
    .video-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .video-card:hover {
        transform: translateY(-5px);
    }

    .video-thumbnail {
        position: relative;
        height: 160px;
        background-color: #f8f9fa;
        overflow: hidden;
    }

    .video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 3rem;
        opacity: 0.8;
        filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
        transition: opacity 0.2s;
    }

    .video-thumbnail:hover .video-play-icon {
        opacity: 1;
    }

    .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .video-info {
        padding: 15px;
    }

    .video-title {
        font-weight: 600;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 48px;
    }

    .video-meta {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .video-actions {
        padding: 10px 15px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }

    .sortable-ghost {
        opacity: 0.5;
        background-color: #f8f9fa;
    }

    .video-handle {
        cursor: grab;
        color: #6c757d;
    }

    .video-handle:active {
        cursor: grabbing;
    }

    .sequence-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

<!-- Include Video.js -->
@include('admin.layouts.video-js-includes')
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Videos for "{{ $discourse->title }}"</h1>
            <p class="text-muted">Manage videos for this discourse</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.show', $discourse) }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Discourse
            </a>
            <a href="{{ route('admin.discourses.videos.create', $discourse) }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Add Video
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($videos->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-film fa-4x text-muted"></i>
            </div>
            <h4>No Videos Yet</h4>
            <p class="text-muted">This discourse doesn't have any videos yet.</p>
            <a href="{{ route('admin.discourses.videos.create', $discourse) }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus-circle me-1"></i> Add First Video
            </a>
        </div>
    </div>
    @else
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Videos ({{ $videos->total() }})</h5>
                <button class="btn btn-sm btn-outline-primary" id="saveOrderBtn" style="display: none;">
                    <i class="fas fa-save me-1"></i> Save Order
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i> Drag and drop videos to change their order.
            </div>

            <div class="row" id="videoSortable">
                @foreach($videos as $video)
                <div class="col-md-4 col-lg-3 mb-4" data-id="{{ $video->id }}">
                    <div class="video-card">
                        <div class="video-thumbnail">
                            <img src="{{ $video->getThumbnailUrl() }}" alt="{{ $video->title }}">
                            <div class="video-play-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="sequence-badge">{{ $video->sequence + 1 }}</div>
                            @if($video->duration_seconds)
                            <div class="video-duration">{{ $video->formatted_duration }}</div>
                            @endif
                        </div>
                        <div class="video-info">
                            <h5 class="video-title">{{ $video->title }}</h5>
                            <div class="video-meta">
                                <div><i class="far fa-file-video me-1"></i> {{ $video->video_filename ?? 'Video' }}
                                </div>
                                @if($video->file_size)
                                <div><i class="fas fa-hdd me-1"></i> {{ number_format($video->file_size / (1024 * 1024),
                                    2) }} MB</div>
                                @endif
                            </div>
                        </div>
                        <div class="video-actions">
                            <div>
                                <span class="video-handle"><i class="fas fa-grip-vertical"></i></span>
                            </div>
                            <div>
                                <a href="{{ route('admin.discourses.videos.edit', [$discourse, $video]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDelete('{{ route('admin.discourses.videos.destroy', [$discourse, $video]) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this video? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Video</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        window.confirmDelete = function(url) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = url;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        };

        // Sortable videos
        const videoContainer = document.getElementById('videoSortable');
        if (videoContainer) {
            const sortable = new Sortable(videoContainer, {
                animation: 150,
                handle: '.video-handle',
                ghostClass: 'sortable-ghost',
                onStart: function() {
                    document.getElementById('saveOrderBtn').style.display = 'block';
                },
                onEnd: function() {
                    // Update sequence badges
                    const items = videoContainer.querySelectorAll('.col-md-4');
                    items.forEach((item, index) => {
                        const badge = item.querySelector('.sequence-badge');
                        if (badge) {
                            badge.textContent = index + 1;
                        }
                    });
                }
            });

            // Save order button
            document.getElementById('saveOrderBtn').addEventListener('click', function() {
                const items = videoContainer.querySelectorAll('.col-md-4');
                const videoIds = Array.from(items).map(item => item.dataset.id);
                
                // Send order to server
                fetch('{{ route("admin.discourses.videos.reorder", $discourse) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        videos: videoIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show';
                        alert.innerHTML = `
                            Video order updated successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.querySelector('.container-fluid').prepend(alert);
                        
                        // Hide save button
                        document.getElementById('saveOrderBtn').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the order.');
                });
            });
        }
    });
</script>
@endsection
