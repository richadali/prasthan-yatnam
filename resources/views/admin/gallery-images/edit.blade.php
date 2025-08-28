@extends('admin.layouts.app')

@section('title', 'Edit Gallery Image')
@section('page_title', 'Edit Gallery Image')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Edit Gallery Image</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Gallery
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.gallery-images.update', $image->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="album_id" class="form-label">Album <span class="text-danger">*</span></label>
                            <select class="form-select @error('album_id') is-invalid @enderror" id="album_id"
                                name="album_id" required>
                                <option value="">Select Album</option>
                                @foreach($albums as $id => $name)
                                <option value="{{ $id }}" {{ old('album_id', $image->album_id) == $id ? 'selected' : ''
                                    }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('album_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>




                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image File</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to keep current image</div>
                        </div>

                        <div class="mt-3">
                            <div class="image-preview border rounded p-2 text-center bg-light" id="imagePreview">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded"
                                    alt="{{ $image->title ?? 'Gallery image' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Image
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
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" alt="Image Preview">`;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection