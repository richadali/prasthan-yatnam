@extends('admin.layouts.app')

@section('title', 'Edit Poem')

@section('page_title', 'Edit Poem')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Poem</h5>
                <a href="{{ route('admin.poems.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Poems
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.poems.update', $poem->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $poem->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                id="display_order" name="display_order"
                                value="{{ old('display_order', $poem->display_order) }}" min="0">
                            @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Poem Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload a new image to replace the current one (JPEG, PNG, GIF, max
                                2MB)</div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-center mt-3">
                                <div class="image-preview border rounded p-2 text-center position-relative"
                                    style="min-height: 300px; width: 100%; background-color: #f8f9fa;">
                                    @if($poem->image)
                                    <img id="preview" src="{{ asset('storage/' . $poem->image) }}"
                                        alt="{{ $poem->title }}"
                                        style="max-width: 100%; max-height: 280px; display: block; object-fit: contain;">
                                    <div id="placeholder"
                                        class="position-absolute top-50 start-50 translate-middle text-center"
                                        style="display: none;">
                                        <i class="fas fa-file-image fa-3x text-secondary mb-2"></i>
                                        <div class="text-muted">Image preview will appear here</div>
                                    </div>
                                    @else
                                    <img id="preview" src="#" alt="Image Preview"
                                        style="max-width: 100%; max-height: 280px; display: none; object-fit: contain;">
                                    <div id="placeholder"
                                        class="position-absolute top-50 start-50 translate-middle text-center">
                                        <i class="fas fa-file-image fa-3x text-secondary mb-2"></i>
                                        <div class="text-muted">No image uploaded</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Poem
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
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection