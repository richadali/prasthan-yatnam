@extends('admin.layouts.app')

@section('title', 'Manage Discourses')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6">
                            <h6>All Discourses</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.discourses.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Add New Discourse
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Discourse</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Videos</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discourses as $discourse)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($discourse->thumbnail)
                                                <img src="{{ asset('storage/images/discourses/' . $discourse->thumbnail) }}"
                                                    class="avatar avatar-sm me-3" alt="{{ $discourse->title }}">
                                                @else
                                                <div class="avatar avatar-sm me-3 bg-gradient-primary">{{
                                                    substr($discourse->title, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $discourse->title }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{
                                                    Str::limit($discourse->description, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">₹{{ number_format($discourse->price, 2)
                                            }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($discourse->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                        @endif
                                        @if($discourse->is_featured)
                                        <span class="badge badge-sm bg-gradient-warning">Featured</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{
                                            $discourse->videos_count ?? 0 }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="{{ route('admin.discourses.videos.index', $discourse) }}"
                                                class="btn btn-link text-secondary mb-0" data-bs-toggle="tooltip"
                                                title="Manage Videos">
                                                <i class="fas fa-video"></i>
                                            </a>
                                            <a href="{{ route('admin.discourses.edit', $discourse) }}"
                                                class="btn btn-link text-secondary mb-0" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.discourses.destroy', $discourse) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this discourse? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger mb-0"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No discourses found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $discourses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection