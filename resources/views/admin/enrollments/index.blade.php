@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Enrollments</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Enrollments</h6>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <div class="mb-4">
                <form action="{{ route('admin.enrollments.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="discourse_id" class="form-label">Filter by Discourse</label>
                        <select name="discourse_id" id="discourse_id" class="form-control">
                            <option value="">All Discourses</option>
                            @foreach($discourses as $discourse)
                            <option value="{{ $discourse->id }}" {{ request('discourse_id')==$discourse->id ? 'selected'
                                : '' }}>
                                {{ $discourse->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('payment_status')=='pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="completed" {{ request('payment_status')=='completed' ? 'selected' : '' }}>
                                Completed</option>
                            <option value="failed" {{ request('payment_status')=='failed' ? 'selected' : '' }}>Failed
                            </option>
                            <option value="refunded" {{ request('payment_status')=='refunded' ? 'selected' : '' }}>
                                Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Discourse</th>
                            <th>Enrolled At</th>
                            <th>Expires At</th>
                            <th>Payment Status</th>
                            <th>Amount Paid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->id }}</td>
                            <td>{{ $enrollment->first_name }} {{ $enrollment->last_name }}</td>
                            <td>{{ $enrollment->email }}</td>
                            <td>{{ $enrollment->discourse_title }}</td>
                            <td>{{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y H:i') }}</td>
                            <td>
                                @if($enrollment->expires_at)
                                {{ \Carbon\Carbon::parse($enrollment->expires_at)->format('M d, Y H:i') }}
                                @else
                                <span class="badge badge-success">Lifetime</span>
                                @endif
                            </td>
                            <td>
                                @php
                                $statusClass = [
                                'pending' => 'warning',
                                'completed' => 'success',
                                'failed' => 'danger',
                                'refunded' => 'info'
                                ][$enrollment->payment_status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }}">
                                    {{ ucfirst($enrollment->payment_status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($enrollment->amount_paid, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.enrollments.show', $enrollment->id) }}"
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No enrollments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection