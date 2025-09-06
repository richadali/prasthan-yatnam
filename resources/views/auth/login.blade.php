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
        background: linear-gradient(135deg, #FA8128, #e86b00);
        color: white;
        padding: 2rem 2rem 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .invalid-feedback {
        display: block;
    }

    .account-tabs {
        margin-top: 20px;
    }

    .account-tabs .btn {
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .account-tabs .btn-outline-light {
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .account-tabs .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .account-tabs .btn-light {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Custom Button Styles with Gradients */
    .navy-btn {
        background: linear-gradient(to bottom, #000080, #0000b3);
        border: none;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .navy-btn:hover {
        background: linear-gradient(to bottom, #0000b3, #000080);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    }

    .orange-btn {
        background: linear-gradient(to bottom, #FA8128, #e86b00);
        border: none;
        color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .orange-btn:hover {
        background: linear-gradient(to bottom, #e86b00, #FA8128);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
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
                        <h3 class="mb-2">Welcome</h3>
                        <p class="mb-3">Embark on your spiritual journey with Prasthan Yatnam</p>

                        <!-- Account Navigation Tabs -->
                        <div class="account-tabs mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('register') }}"
                                        class="btn btn-outline-light btn-block py-2 w-100 text-white opacity-75">I am
                                        new</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('login') }}"
                                        class="btn btn-light btn-block py-2 w-100 text-warning fw-bold">I have an
                                        account</a>
                                </div>
                            </div>
                        </div>
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
                                <button type="submit" class="btn navy-btn w-100 py-2">
                                    Login
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

@section('scripts')
@endsection