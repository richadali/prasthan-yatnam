@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .register-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .register-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .register-header {
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

    .password-strength {
        height: 5px;
        transition: all 0.3s ease;
        margin-top: 5px;
        border-radius: 5px;
    }

    .password-strength.weak {
        background-color: #dc3545;
        width: 25%;
    }

    .password-strength.medium {
        background-color: #ffc107;
        width: 50%;
    }

    .password-strength.strong {
        background-color: #28a745;
        width: 100%;
    }

    .password-requirements {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
    }

    .password-requirements ul {
        padding-left: 1.2rem;
        margin-bottom: 0;
    }

    .password-requirements li.valid {
        color: #28a745;
    }

    .password-requirements li.invalid {
        color: #dc3545;
    }

    /* Select2 customization */
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal;
        padding-left: 0;
    }

    /* Make dropdown text smaller */
    .select2-results__option {
        font-size: 0.85rem;
        padding: 4px 8px;
    }

    .select2-container--default .select2-results__group {
        font-size: 0.8rem;
        font-weight: bold;
        padding: 4px 8px;
        color: #6c757d;
    }

    /* Reduce height of dropdown items */
    .select2-results__option[aria-selected] {
        padding-top: 3px;
        padding-bottom: 3px;
    }

    /* Compact dropdown list */
    .select2-container--default .select2-results>.select2-results__options {
        max-height: 250px;
    }
</style>
@endsection

@section('content')
<section class="register-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card register-card">
                    <div class="register-header text-center">
                        <h2 class="mb-3">Create Your Account</h2>
                        <p class="mb-0">Join Prasthan Yatnam and start your spiritual journey</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" id="registrationForm">
                            @csrf

                            <div class="row">
                                <!-- First Name -->
                                <div class="col-md-4 form-group">
                                    <label for="first_name" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name') }}" required autocomplete="given-name" autofocus>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div class="col-md-4 form-group">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input id="middle_name" type="text"
                                        class="form-control @error('middle_name') is-invalid @enderror"
                                        name="middle_name" value="{{ old('middle_name') }}"
                                        autocomplete="additional-name">
                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-4 form-group">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') }}" required autocomplete="family-name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Gender -->
                                <div class="col-md-6 form-group">
                                    <label for="gender" class="form-label">Gender <span
                                            class="text-danger">*</span></label>
                                    <select id="gender" class="form-select @error('gender') is-invalid @enderror"
                                        name="gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Age Group -->
                                <div class="col-md-6 form-group">
                                    <label for="age_group" class="form-label">Age Group <span
                                            class="text-danger">*</span></label>
                                    <select id="age_group" class="form-select @error('age_group') is-invalid @enderror"
                                        name="age_group" required>
                                        <option value="" selected disabled>Select Age Group</option>
                                        <option value="below_20" {{ old('age_group')=='below_20' ? 'selected' : '' }}>
                                            Below 20</option>
                                        <option value="20_to_32" {{ old('age_group')=='20_to_32' ? 'selected' : '' }}>20
                                            to 32</option>
                                        <option value="32_to_45" {{ old('age_group')=='32_to_45' ? 'selected' : '' }}>32
                                            to 45</option>
                                        <option value="45_to_60" {{ old('age_group')=='45_to_60' ? 'selected' : '' }}>45
                                            to 60</option>
                                        <option value="60_to_70" {{ old('age_group')=='60_to_70' ? 'selected' : '' }}>60
                                            to 70</option>
                                        <option value="above_70" {{ old('age_group')=='above_70' ? 'selected' : '' }}>
                                            Above 70</option>
                                    </select>
                                    @error('age_group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                <div id="email-feedback"></div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Country Code -->
                                <div class="col-md-3 form-group">
                                    <label for="country_code" class="form-label">Country Code <span
                                            class="text-danger">*</span></label>
                                    <select id="country_code"
                                        class="form-select @error('country_code') is-invalid @enderror"
                                        name="country_code" required>
                                        <optgroup label="Popular Countries">
                                            @foreach($popularCountryCodes as $code => $country)
                                            <option value="{{ $code }}" {{ old('country_code', '+91' )==$code
                                                ? 'selected' : '' }}>{{ $country }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="All Countries">
                                            @foreach($allCountryCodes as $code => $country)
                                            <option value="{{ $code }}" {{ old('country_code')==$code ? 'selected' : ''
                                                }}>{{ $country }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    @error('country_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-9 form-group">
                                    <label for="phone" class="form-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input id="phone" type="tel"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="tel">
                                    <div id="phone-feedback"></div>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Organization -->
                            <div class="form-group">
                                <label for="organization" class="form-label">Organization/Institution</label>
                                <input id="organization" type="text"
                                    class="form-control @error('organization') is-invalid @enderror" name="organization"
                                    value="{{ old('organization') }}" autocomplete="organization">
                                @error('organization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                <div class="password-strength"></div>
                                <div class="password-requirements">
                                    <small>Password must:</small>
                                    <ul>
                                        <li id="length">Be at least 8 characters long</li>
                                        <li id="uppercase">Contain at least one uppercase letter</li>
                                        <li id="lowercase">Contain at least one lowercase letter</li>
                                        <li id="number">Contain at least one number</li>
                                    </ul>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password-confirm" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <div id="password-match-feedback"></div>
                            </div>

                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    Register
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p>Already have an account? <a href="{{ route('login') }}" class="text-blue">Login
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for country code dropdown
        $('#country_code').select2({
            placeholder: 'Select country code',
            width: '100%',
            templateResult: formatCountryCode,
            templateSelection: formatCountryCodeSelection
        });
        
        // Format dropdown options
        function formatCountryCode(country) {
            if (!country.id) {
                return country.text;
            }
            
            // Extract just the country code from the text
            const code = country.id;
            const text = country.text.replace(/\(\+\d+\)$/, '').trim();
            
            return $(`<span><small class="fw-bold">${code}</small> <span class="small">${text}</span></span>`);
        }
        
        // Format selected option
        function formatCountryCodeSelection(country) {
            if (!country.id) {
                return country.text;
            }
            
            // Just show the country code when selected
            return country.id;
        }
        
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password-confirm');
        const passwordStrength = document.querySelector('.password-strength');
        const lengthReq = document.getElementById('length');
        const uppercaseReq = document.getElementById('uppercase');
        const lowercaseReq = document.getElementById('lowercase');
        const numberReq = document.getElementById('number');
        const passwordMatchFeedback = document.getElementById('password-match-feedback');
        const emailInput = document.getElementById('email');
        const emailFeedback = document.getElementById('email-feedback');
        const phoneInput = document.getElementById('phone');
        const phoneFeedback = document.getElementById('phone-feedback');

        // Email validation
        emailInput.addEventListener('input', validateEmail);
        emailInput.addEventListener('blur', validateEmail);
        
        function validateEmail() {
            const email = emailInput.value.trim();
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            // Clear previous feedback
            emailFeedback.innerHTML = '';
            emailFeedback.className = '';
            
            if (email === '') {
                return;
            }
            
            if (!emailRegex.test(email)) {
                emailFeedback.innerHTML = '<small class="text-danger">Please enter a valid email address</small>';
                emailFeedback.className = 'mt-1';
                return false;
            }
            
            // Check for disposable email domains
            const disposableDomains = ['mailinator.com', 'yopmail.com', 'tempmail.com', 'temp-mail.org', 'fakeinbox.com', 'guerrillamail.com'];
            const domain = email.split('@')[1];
            
            if (domain && disposableDomains.includes(domain.toLowerCase())) {
                emailFeedback.innerHTML = '<small class="text-danger">Please use a non-disposable email address</small>';
                emailFeedback.className = 'mt-1';
                return false;
            }
            
            emailFeedback.innerHTML = '<small class="text-success">Email format is valid</small>';
            emailFeedback.className = 'mt-1';
            return true;
        }
        
        // Phone validation
        phoneInput.addEventListener('input', function() {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
            validatePhone();
        });
        
        phoneInput.addEventListener('blur', validatePhone);
        
        function validatePhone() {
            const phone = phoneInput.value.trim();
            
            // Clear previous feedback
            phoneFeedback.innerHTML = '';
            phoneFeedback.className = '';
            
            if (phone === '') {
                return;
            }
            
            if (phone.length < 6) {
                phoneFeedback.innerHTML = '<small class="text-danger">Phone number is too short (minimum 6 digits)</small>';
                phoneFeedback.className = 'mt-1';
                return false;
            }
            
            if (phone.length > 15) {
                phoneFeedback.innerHTML = '<small class="text-danger">Phone number is too long (maximum 15 digits)</small>';
                phoneFeedback.className = 'mt-1';
                return false;
            }
            
            if (!/^\d+$/.test(phone)) {
                phoneFeedback.innerHTML = '<small class="text-danger">Phone number should contain digits only</small>';
                phoneFeedback.className = 'mt-1';
                return false;
            }
            
            phoneFeedback.innerHTML = '<small class="text-success">Phone number format is valid</small>';
            phoneFeedback.className = 'mt-1';
            return true;
        }

        // Password strength and requirements check
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            
            // Check requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            // Update requirement indicators
            lengthReq.className = hasLength ? 'valid' : 'invalid';
            uppercaseReq.className = hasUppercase ? 'valid' : 'invalid';
            lowercaseReq.className = hasLowercase ? 'valid' : 'invalid';
            numberReq.className = hasNumber ? 'valid' : 'invalid';
            
            // Calculate strength
            let strength = 0;
            if (hasLength) strength += 1;
            if (hasUppercase) strength += 1;
            if (hasLowercase) strength += 1;
            if (hasNumber) strength += 1;
            
            // Update strength indicator
            passwordStrength.className = 'password-strength';
            if (password.length === 0) {
                passwordStrength.style.width = '0';
            } else if (strength <= 2) {
                passwordStrength.classList.add('weak');
            } else if (strength === 3) {
                passwordStrength.classList.add('medium');
            } else {
                passwordStrength.classList.add('strong');
            }
            
            // Check password match if confirm field has value
            if (confirmPasswordInput.value) {
                checkPasswordMatch();
            }
        });
        
        // Password match check
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword === '') {
                passwordMatchFeedback.innerHTML = '';
                passwordMatchFeedback.className = '';
            } else if (password === confirmPassword) {
                passwordMatchFeedback.innerHTML = '<small class="text-success">Passwords match</small>';
                passwordMatchFeedback.className = 'mt-1';
            } else {
                passwordMatchFeedback.innerHTML = '<small class="text-danger">Passwords do not match</small>';
                passwordMatchFeedback.className = 'mt-1';
            }
        }
        
        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            // Validate email
            if (!validateEmail()) {
                event.preventDefault();
            }
            
            // Validate phone
            if (!validatePhone()) {
                event.preventDefault();
            }
            
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            // Check if passwords match
            if (password !== confirmPassword) {
                event.preventDefault();
                passwordMatchFeedback.innerHTML = '<small class="text-danger">Passwords do not match</small>';
                passwordMatchFeedback.className = 'mt-1';
            }
            
            // Check password requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            if (!(hasLength && hasUppercase && hasLowercase && hasNumber)) {
                event.preventDefault();
                document.querySelector('.password-requirements').classList.add('text-danger');
            }
        });
    });
</script>
@endsection