@extends('admin.layouts.app')

@section('title', 'Enrollment Details')

@section('page_title', 'Enrollment Details')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Enrollment Details</h1>
            <p class="text-muted">View and manage enrollment</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Enrollments
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Enrollment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">User Details</h6>
                            <h5>{{ $enrollment->user_name }}</h5>
                            <p class="mb-0">{{ $enrollment->user_email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Discourse</h6>
                            <h5>{{ $enrollment->discourse_title }}</h5>
                            <p class="mb-0">Price: ₹{{ number_format($enrollment->discourse_price, 2) }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Enrollment Date</h6>
                            <p class="mb-0">{{ date('F d, Y', strtotime($enrollment->enrolled_at)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Expiry Date</h6>
                            <p class="mb-0">
                                @if($enrollment->expires_at)
                                {{ date('F d, Y', strtotime($enrollment->expires_at)) }}
                                @else
                                Never (Lifetime Access)
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Payment ID</h6>
                            <p class="mb-0">{{ $enrollment->payment_id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Amount Paid</h6>
                            <p class="mb-0">₹{{ number_format($enrollment->amount_paid, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Payment Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        @if($enrollment->payment_status == 'completed')
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                        <h4 class="text-success">Payment Completed</h4>
                        @elseif($enrollment->payment_status == 'pending')
                        <div class="mb-3">
                            <i class="fas fa-clock fa-4x text-warning"></i>
                        </div>
                        <h4 class="text-warning">Payment Pending</h4>
                        @elseif($enrollment->payment_status == 'failed')
                        <div class="mb-3">
                            <i class="fas fa-times-circle fa-4x text-danger"></i>
                        </div>
                        <h4 class="text-danger">Payment Failed</h4>
                        @elseif($enrollment->payment_status == 'refunded')
                        <div class="mb-3">
                            <i class="fas fa-undo fa-4x text-info"></i>
                        </div>
                        <h4 class="text-info">Payment Refunded</h4>
                        @endif
                        <p class="text-muted">Last Updated: {{ date('M d, Y H:i', strtotime($enrollment->updated_at)) }}
                        </p>
                    </div>

                    <form action="{{ route('admin.enrollments.update-status', $enrollment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Update Status</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror"
                                id="payment_status" name="payment_status">
                                <option value="pending" {{ $enrollment->payment_status == 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="completed" {{ $enrollment->payment_status == 'completed' ? 'selected' :
                                    '' }}>Completed</option>
                                <option value="failed" {{ $enrollment->payment_status == 'failed' ? 'selected' : ''
                                    }}>Failed</option>
                                <option value="refunded" {{ $enrollment->payment_status == 'refunded' ? 'selected' : ''
                                    }}>Refunded</option>
                            </select>
                            @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection