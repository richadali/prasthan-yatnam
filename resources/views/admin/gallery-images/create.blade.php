@extends('admin.layouts.app')

@section('title', 'Add Gallery Images')
@section('page_title', 'Add Gallery Images')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Add New Images</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Gallery
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.gallery-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="album_id" class="form-label">Album <span class="text-danger">*</span></label>
                            <select class="form-select @error('album_id') is-invalid @enderror" id="album_id"
                                name="album_id" required>
                                <option value="">Select Album</option>
                                @foreach($albums as $id => $name)
                                <option value="{{ $id }}" {{ old('album_id', request('album_id'))==$id ? 'selected' : ''
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
                            <label for="image" class="form-label">Image File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*" required>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum file size: 2MB</div>
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
                    <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Image
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