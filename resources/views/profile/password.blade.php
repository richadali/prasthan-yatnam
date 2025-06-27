@extends('layouts.app')

@section('styles')
<style>
    .password-section {
        background-color: #f8f9fa;
        padding: 3rem 0;
    }

    .password-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        max-width: 600px;
        margin: 0 auto;
    }

    .password-header {
        background: linear-gradient(135deg, var(--primary-blue), #000080);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .password-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    .password-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    .password-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 500;
        color: #444;
    }

    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 0, 128, 0.1);
    }

    .btn-password {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-password:hover {
        background-color: #000066;
        color: white;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
        color: white;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
        gap: 1rem;
    }

    .required-star {
        color: #dc3545;
    }

    .password-requirements {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .password-requirements ul {
        margin-top: 0.5rem;
        padding-left: 1.25rem;
    }
</style>
@endsection

@section('content')
<section class="password-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="password-card">
                    <!-- Password Header -->
                    <div class="password-header">
                        <h1 class="password-title">Change Password</h1>
                        <p class="password-subtitle">Update your account password</p>
                    </div>

                    <!-- Password Form -->
                    <div class="password-body">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <span
                                        class="required-star">*</span></label>
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <span
                                        class="required-star">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="password-requirements">
                                    Password must:
                                    <ul>
                                        <li>Be at least 8 characters long</li>
                                        <li>Include at least one uppercase and one lowercase letter</li>
                                        <li>Include at least one number</li>
                                        <li>Be different from your current password</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password <span
                                        class="required-star">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <a href="{{ route('profile.show') }}" class="btn btn-cancel">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-password">
                                    <i class="fas fa-key me-1"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection