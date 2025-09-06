@extends('admin.layouts.app')

@section('title', 'Manage Hero Images')

@section('page_title', 'Hero Images Management')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Current Active Hero Image</h5>
                <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Add New Hero Image
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($currentActive)
            <div class="row">
                <div class="col-md-8">
                    <img src="{{ asset('storage/' . $currentActive->image_path) }}" alt="Current Hero Image"
                        class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>
                <div class="col-md-4">
                    <h5>{!! $currentActive->tag ?? 'No Tag' !!}</h5>
                    <p class="text-muted">Currently active hero image</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.hero-images.edit', $currentActive->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                No active hero image. Please add one or activate an existing image.
            </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Hero Images</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="150">Image</th>
                            <th>Tag</th>
                            <th>Status</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heroImages as $image)
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->tag ?? 'Hero Image' }}" class="img-thumbnail"
                                    style="max-height: 80px;">
                            </td>
                            <td>{!! $image->tag ?? 'No Tag' !!}</td>
                            <td>
                                @if($image->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.hero-images.edit', $image->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.hero-images.toggle-active', $image->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-{{ $image->is_active ? 'warning' : 'success' }}"
                                            title="{{ $image->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $image->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.hero-images.destroy', $image->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this hero image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hero images found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection