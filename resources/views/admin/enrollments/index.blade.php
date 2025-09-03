@extends('admin.layouts.app')

@section('title', 'Enrollments')

@section('page_title', 'Enrollments')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Enrollments</h1>
            <p class="text-muted">Manage user enrollments in discourses</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0">Filters</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.enrollments.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Payment Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="all" {{ request('status')=='all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="failed" {{ request('status')=='failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status')=='refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="discourse_id" class="form-label">Discourse</label>
                    <select class="form-select" id="discourse_id" name="discourse_id">
                        <option value="">All Discourses</option>
                        @foreach($discourses as $discourse)
                        <option value="{{ $discourse->id }}" {{ request('discourse_id')==$discourse->id ? 'selected' :
                            '' }}>
                            {{ $discourse->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Enrollments ({{ $enrollments->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Discourse</th>
                            <th>Enrolled At</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->id }}</td>
                            <td>
                                <div>{{ $enrollment->user_name }}</div>
                                <div class="small text-muted">{{ $enrollment->user_email }}</div>
                            </td>
                            <td>{{ $enrollment->discourse_title }}</td>
                            <td>{{ date('M d, Y', strtotime($enrollment->enrolled_at)) }}</td>
                            <td>₹{{ number_format($enrollment->amount_paid, 2) }}</td>
                            <td>
                                @if($enrollment->payment_status == 'completed')
                                <span class="badge bg-success">Completed</span>
                                @elseif($enrollment->payment_status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($enrollment->payment_status == 'failed')
                                <span class="badge bg-danger">Failed</span>
                                @elseif($enrollment->payment_status == 'refunded')
                                <span class="badge bg-info">Refunded</span>
                                @else
                                <span class="badge bg-secondary">{{ $enrollment->payment_status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.enrollments.show', $enrollment->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-user-slash fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted mb-0">No enrollments found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-center">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection