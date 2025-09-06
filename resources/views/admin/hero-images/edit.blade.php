@extends('admin.layouts.app')

@section('title', 'Edit Hero Image')

@section('page_title', 'Edit Hero Image')

@section('styles')
<style>
    .ck-editor__editable {
        min-height: 150px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Hero Image</h5>
                <a href="{{ route('admin.hero-images.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hero-images.update', $heroImage->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Hero Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*" onchange="validateFileSize(this, 2)">
                            <div class="form-text">Recommended size: 1920x1080 pixels (16:9 ratio). Maximum file size:
                                2MB. Leave empty to keep current image.</div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag Line</label>
                            <textarea class="form-control @error('tag') is-invalid @enderror" id="tag"
                                name="tag" rows="5">{{ old('tag', $heroImage->tag) }}</textarea>
                            <div class="form-text">This tag will be displayed with animation on the hero image</div>
                            @error('tag')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="image-preview mt-3 text-center" id="imagePreview">
                                <img src="{{ asset('storage/' . $heroImage->image_path) }}"
                                    alt="{{ $heroImage->tag ?? 'Hero Image' }}" class="img-fluid rounded shadow-sm"
                                    style="max-height: 300px;">
                                <p class="mt-2 text-muted small">Current image</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{
                            old('is_active', $heroImage->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Set as active hero image
                        </label>
                        <div class="form-text">If checked, this image will be displayed on the home page</div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Hero Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    // File size validation and image preview functionality
    function validateFileSize(input, maxSizeMB) {
        if (input.files && input.files[0]) {
            const fileSizeMB = input.files[0].size / (1024 * 1024);
            if (fileSizeMB > maxSizeMB) {
                alert(`File size exceeds ${maxSizeMB}MB. Please select a smaller file.`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.querySelector('#imagePreview');
                imagePreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                    <p class="mt-2 text-muted small">Preview of selected image</p>
                `;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Initialize CKEditor for tag line
    ClassicEditor
        .create(document.querySelector('#tag'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection