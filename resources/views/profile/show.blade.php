@extends('layouts.app')

@section('styles')
<style>
    .profile-section {
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
        padding: 2rem;
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #fff;
        border: 5px solid rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--primary-blue);
        font-size: 4rem;
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .profile-email {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
        text-align: center;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 0 1.5rem;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .profile-body {
        padding: 2rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        color: var(--primary-blue);
    }

    .info-item {
        margin-bottom: 1.25rem;
    }

    .info-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn-profile {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        margin-left: 0.5rem;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-profile:hover {
        background-color: #000066;
        color: white;
        transform: translateY(-2px);
    }

    .btn-password {
        background-color: #FA8128;
        color: white;
        border: none;
    }

    .btn-password:hover {
        background-color: #e57422;
        color: white;
    }

    @media (max-width: 767.98px) {
        .profile-stats {
            flex-direction: column;
            align-items: center;
        }

        .stat-item {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            width: 100%;
        }

        .stat-item:last-child {
            border-bottom: none;
        }
    }
</style>
@endsection

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="profile-card">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h1 class="profile-name">{{ $user->full_name }}</h1>
                        <p class="profile-email">{{ $user->email }}</p>

                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $enrolledCoursesCount }}</div>
                                <div class="stat-label">Enrolled Courses</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $user->created_at->format('M Y') }}</div>
                                <div class="stat-label">Member Since</div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Body -->
                    <div class="profile-body">
                        <!-- Personal Information -->
                        <div class="info-section">
                            <h2 class="section-title">Personal Information</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">First Name</div>
                                        <div class="info-value">{{ $user->first_name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Last Name</div>
                                        <div class="info-value">{{ $user->last_name }}</div>
                                    </div>
                                </div>
                                @if($user->middle_name)
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Middle Name</div>
                                        <div class="info-value">{{ $user->middle_name }}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Gender</div>
                                        <div class="info-value">{{ ucfirst($user->gender) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Age Group</div>
                                        <div class="info-value">{{ $user->formatted_age_group }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="info-section">
                            <h2 class="section-title">Contact Information</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Phone</div>
                                        <div class="info-value">{{ $user->full_phone }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Organization</div>
                                        <div class="info-value">{{ $user->organization }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('profile.edit') }}" class="btn btn-profile">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </a>
                            <a href="{{ route('profile.password.edit') }}" class="btn btn-profile btn-password">
                                <i class="fas fa-key me-1"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection