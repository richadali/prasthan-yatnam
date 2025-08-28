@extends('admin.layouts.app')

@section('title', 'Albums')
@section('page_title', 'Albums')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Manage Albums</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Create New Album
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($albums->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cover</th>
                            <th>Name</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($albums as $album)
                        <tr>
                            <td>{{ $album->id }}</td>
                            <td>
                                @if($album->cover_image)
                                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}"
                                    class="img-thumbnail" width="60">
                                @else
                                <div class="bg-light text-center p-2" style="width: 60px">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $album->name }}</td>
                            <td>{{ $album->galleryImages->count() }}</td>
                            <td>
                                @if($album->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $album->sort_order }}</td>
                            <td>{{ $album->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.albums.show', $album->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.albums.edit', $album->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this album? This will also delete all images in this album.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-photo-album fa-3x text-muted mb-3"></i>
                <p class="h5 text-muted">No albums found</p>
                <p class="text-muted">Create your first album to start organizing your gallery images.</p>
                <a href="{{ route('admin.albums.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus-circle me-1"></i> Create New Album
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
