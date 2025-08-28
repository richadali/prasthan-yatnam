@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('page_title', 'Edit Testimonial')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Testimonial</h5>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="/admin/testimonials/{{ $testimonial->id }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $testimonial->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                id="designation" name="designation"
                                value="{{ old('designation', $testimonial->designation) }}" required>
                            @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                id="display_order" name="display_order"
                                value="{{ old('display_order', $testimonial->display_order) }}" min="0">
                            <div class="form-text">Lower numbers will be displayed first</div>
                            @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                                <div class="form-text">Testimonial will be visible on the website if active</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" accept="image/*">
                            <div class="form-text">Recommended size: 300x300 pixels (square). Leave empty to keep
                                current image.</div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="image-preview mt-3 text-center" id="imagePreview">
                                @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                                    class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 150px; height: 150px; background: linear-gradient(135deg, #1e50a2 0%, #5b92e5 100%); margin: 0 auto; border: 5px solid #f8f9fa;">
                                    <i class="fas fa-user fa-4x" style="color: white; opacity: 0.8;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Testimonial Message <span
                            class="text-danger">*</span></label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                        rows="6" required>{{ old('message', $testimonial->message) }}</textarea>
                    @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Testimonial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Replace the placeholder or existing image with the new image
                const imagePreview = document.querySelector('#imagePreview');
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">`;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Debug form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Form is being submitted');
        
        // Log form data
        const formData = new FormData(this);
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
</script>
@endsection