@extends('layouts.app')

@section('styles')
<style>
    .login-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .login-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .login-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-card">
                    <div class="login-header text-center">
                        <h2 class="mb-3">Welcome Back</h2>
                        <p class="mb-0">Login to continue your spiritual journey</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="login" class="form-label">Email or Phone Number <span
                                        class="text-danger">*</span></label>
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}" required autofocus>
                                <small class="form-text text-muted">Enter your email address or phone number without
                                    country code</small>
                                @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <a href="{{ route('password.request') }}" class="text-blue small">Forgot
                                        Password?</a>
                                </div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    Login
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p>Don't have an account? <a href="{{ route('register') }}" class="text-blue">Register
                                        here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@endsection