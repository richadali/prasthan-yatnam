@extends('layouts.app')

@section('styles')
<style>
    .password-reset-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .password-reset-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .password-reset-header {
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
</style>
@endsection

@section('content')
<section class="password-reset-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card password-reset-card">
                    <div class="password-reset-header text-center">
                        <h3 class="mb-2">Reset Password</h3>
                        <p class="mb-3">Enter your email to receive a password reset link.</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn navy-btn w-100 py-2">
                                    Send Password Reset Link
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