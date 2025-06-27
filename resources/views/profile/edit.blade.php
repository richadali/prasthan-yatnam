@extends('layouts.app')

@section('styles')
<style>
    .profile-edit-section {
        background-color: #f8f9fa;
        padding: 3rem 0;
    }

    .profile-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary-blue), #000080);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .profile-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    .profile-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    .profile-body {
        padding: 2rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        color: var(--primary-blue);
    }

    .form-label {
        font-weight: 500;
        color: #444;
    }

    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 0, 128, 0.1);
    }

    .btn-profile {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-profile:hover {
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

    .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 0, 128, 0.1);
    }
</style>
@endsection

@section('content')
<section class="profile-edit-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile-card">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <h1 class="profile-title">Edit Profile</h1>
                        <p class="profile-subtitle">Update your personal information</p>
                    </div>

                    <!-- Profile Form -->
                    <div class="profile-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Personal Information -->
                            <div class="mb-4">
                                <h2 class="section-title">Personal Information</h2>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="first_name" class="form-label">First Name <span
                                                class="required-star">*</span></label>
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name"
                                            value="{{ old('first_name', $user->first_name) }}" required>
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text"
                                            class="form-control @error('middle_name') is-invalid @enderror"
                                            id="middle_name" name="middle_name"
                                            value="{{ old('middle_name', $user->middle_name) }}">
                                        @error('middle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="last_name" class="form-label">Last Name <span
                                                class="required-star">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name"
                                            value="{{ old('last_name', $user->last_name) }}" required>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender <span
                                                class="required-star">*</span></label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                            name="gender" required>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected'
                                                : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ?
                                                'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ?
                                                'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="age_group" class="form-label">Age Group <span
                                                class="required-star">*</span></label>
                                        <select class="form-select @error('age_group') is-invalid @enderror"
                                            id="age_group" name="age_group" required>
                                            <option value="below_20" {{ old('age_group', $user->age_group) == 'below_20'
                                                ? 'selected' : '' }}>Below 20</option>
                                            <option value="20_to_32" {{ old('age_group', $user->age_group) == '20_to_32'
                                                ? 'selected' : '' }}>20 to 32</option>
                                            <option value="32_to_45" {{ old('age_group', $user->age_group) == '32_to_45'
                                                ? 'selected' : '' }}>32 to 45</option>
                                            <option value="45_to_60" {{ old('age_group', $user->age_group) == '45_to_60'
                                                ? 'selected' : '' }}>45 to 60</option>
                                            <option value="60_to_70" {{ old('age_group', $user->age_group) == '60_to_70'
                                                ? 'selected' : '' }}>60 to 70</option>
                                            <option value="above_70" {{ old('age_group', $user->age_group) == 'above_70'
                                                ? 'selected' : '' }}>Above 70</option>
                                        </select>
                                        @error('age_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="mb-4">
                                <h2 class="section-title">Contact Information</h2>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span
                                                class="required-star">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="organization" class="form-label">Organization <span
                                                class="required-star">*</span></label>
                                        <input type="text"
                                            class="form-control @error('organization') is-invalid @enderror"
                                            id="organization" name="organization"
                                            value="{{ old('organization', $user->organization) }}" required>
                                        @error('organization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="country_code" class="form-label">Country Code <span
                                                class="required-star">*</span></label>
                                        <select class="form-select @error('country_code') is-invalid @enderror"
                                            id="country_code" name="country_code" required>
                                            <optgroup label="Popular">
                                                @foreach($popularCountryCodes as $code => $country)
                                                <option value="{{ $code }}" {{ old('country_code', $user->country_code)
                                                    == $code ? 'selected' : '' }}>
                                                    {{ $country }} ({{ $code }})
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="All Countries">
                                                @foreach($allCountryCodes as $code => $country)
                                                <option value="{{ $code }}" {{ old('country_code', $user->country_code)
                                                    == $code ? 'selected' : '' }}>
                                                    {{ $country }} ({{ $code }})
                                                </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        @error('country_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-9">
                                        <label for="phone" class="form-label">Phone Number <span
                                                class="required-star">*</span></label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                                            placeholder="Phone number without country code">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <a href="{{ route('profile.show') }}" class="btn btn-cancel">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-profile">
                                    <i class="fas fa-save me-1"></i> Save Changes
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