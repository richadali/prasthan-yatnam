@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('page_title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px; background-color: rgba(0, 0, 128, 0.1);">
                                <i class="fas fa-users fa-2x" style="color: #000080;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['total_users']) }}</h4>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px; background-color: rgba(255, 165, 0, 0.1);">
                                <i class="fas fa-book fa-2x" style="color: #FA8128;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['total_discourses']) }}</h4>
                            <p class="text-muted mb-0">Total Discourses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.1);">
                                <i class="fas fa-check-circle fa-2x" style="color: #28a745;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['active_discourses']) }}</h4>
                            <p class="text-muted mb-0">Active Discourses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 60px; height: 60px; background-color: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-star fa-2x" style="color: #dc3545;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ number_format($stats['featured_discourses']) }}</h4>
                            <p class="text-muted mb-0">Featured Discourses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Discourses -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Discourses</h5>
                        <a href="{{ route('admin.discourses.index') }}" class="btn btn-sm btn-outline-primary">View
                            All</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest_discourses as $discourse)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if($discourse->thumbnail)
                                                <img src="{{ asset('storage/images/discourses/' . $discourse->thumbnail) }}"
                                                    alt="{{ $discourse->title }}" class="rounded"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-book text-secondary"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{
                                                    $discourse->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($discourse->is_active)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($discourse->is_featured)
                                        <span class="text-warning"><i class="fas fa-star"></i></span>
                                        @else
                                        <span class="text-muted"><i class="far fa-star"></i></span>
                                        @endif
                                    </td>
                                    <td>₹{{ number_format($discourse->price) }}</td>
                                    <td>
                                        <a href="{{ route('admin.discourses.edit', $discourse->id) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Users</h5>
                        <button class="btn btn-sm btn-outline-primary">View All</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest_users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar-circle"
                                                    style="width: 40px; height: 40px; border-radius: 50%; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                                    <span class="avatar-text" style="font-weight: 500; color: #6c757d;">
                                                        {{ strtoupper(substr($user->full_name ?? $user->name ?? 'U', 0,
                                                        1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $user->full_name ?? $user->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">No users found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Welcome to the Admin Dashboard</h5>
                    <p class="card-text">
                        This is your central control panel for managing Prasthan Yatnam's content. From here, you can:
                    </p>
                    <ul class="mb-0">
                        <li>Create and manage spiritual discourses</li>
                        <li>Add videos to existing discourses</li>
                        <li>Track user registrations and engagement</li>
                        <li>Configure featured content on the homepage</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection