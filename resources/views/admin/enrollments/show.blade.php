@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Enrollment Details</h1>
        <a href="{{ route('admin.enrollments.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Enrollments
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Enrollment Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">Enrollment ID</th>
                                <td>{{ $enrollment->id }}</td>
                            </tr>
                            <tr>
                                <th>Enrolled At</th>
                                <td>{{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Expires At</th>
                                <td>
                                    @if($enrollment->expires_at)
                                    {{ \Carbon\Carbon::parse($enrollment->expires_at)->format('M d, Y H:i:s') }}
                                    @else
                                    <span class="badge badge-success">Lifetime Access</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
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
                            </tr>
                            <tr>
                                <th>Amount Paid</th>
                                <td>₹{{ number_format($enrollment->amount_paid, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Payment ID</th>
                                <td>{{ $enrollment->payment_id ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Update Payment Status Form -->
                    <form action="{{ route('admin.enrollments.update-status', $enrollment->id) }}" method="POST"
                        class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="payment_status">Update Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control">
                                <option value="pending" {{ $enrollment->payment_status == 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="completed" {{ $enrollment->payment_status == 'completed' ? 'selected' :
                                    '' }}>Completed</option>
                                <option value="failed" {{ $enrollment->payment_status == 'failed' ? 'selected' : ''
                                    }}>Failed</option>
                                <option value="refunded" {{ $enrollment->payment_status == 'refunded' ? 'selected' : ''
                                    }}>Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 40%">User ID</th>
                                        <td>{{ $enrollment->user_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $enrollment->first_name }} {{ $enrollment->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $enrollment->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $enrollment->country_code }}{{ $enrollment->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Organization</th>
                                        <td>{{ $enrollment->organization ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Discourse Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 40%">Discourse ID</th>
                                        <td>{{ $enrollment->discourse_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $enrollment->discourse_title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>₹{{ number_format($enrollment->discourse_price, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.discourses.show', $enrollment->discourse_id) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View Discourse
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection