@extends('admin.layouts.app')

@section('title', 'Create Album')
@section('page_title', 'Create Album')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Create New Album</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Albums
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Album Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                        id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                                    @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lower numbers appear first</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', '1' )=='1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                    <div class="form-text">Inactive albums won't appear in the gallery</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="cover_image" name="cover_image" accept="image/*">
                            @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended size: 800x600 pixels</div>
                        </div>

                        <div class="mt-3">
                            <div class="image-preview border rounded p-2 text-center bg-light" id="imagePreview">
                                <i class="fas fa-image fa-5x text-muted"></i>
                                <p class="text-muted mt-2">Image preview will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Album
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
        const coverImageInput = document.getElementById('cover_image');
        const imagePreview = document.getElementById('imagePreview');
        
        coverImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" alt="Cover Preview">`;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection
