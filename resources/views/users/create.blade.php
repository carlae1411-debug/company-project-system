@extends('layouts.app')

@section('content')

<div class="page-container">

    {{-- Page Header --}}
    <div class="page-header">

        <div class="page-title-section">
            <a href="{{ route('users.index') }}" class="back-button">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Users
            </a>

            <div class="page-title-row">
                <div class="page-title-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <div>
                    <h1>Add User</h1>
                    <p>Create a new company user account</p>
                </div>
            </div>
        </div>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="form-alert form-alert-error">

            <div class="form-alert-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>

            <div>
                <strong>Please check the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    @endif


    {{-- User Form --}}
    <div class="form-card">

        <div class="form-card-header">

            <div>
                <h2>User Information</h2>
                <p>
                    Enter the user's account information and assign an appropriate role.
                </p>
            </div>

        </div>


        <form
            action="{{ route('users.store') }}"
            method="POST"
        >

            @csrf


            {{-- Account Information --}}
            <div class="form-section">

                <div class="form-section-title">
                    <i class="fa-solid fa-user"></i>
                    <span>Account Information</span>
                </div>


                <div class="form-table">

                    {{-- Name --}}
                    <div class="form-row">

                        <div class="form-label">
                            <label for="name">
                                Full Name
                                <span class="required">*</span>
                            </label>

                            <small>
                                User's complete name
                            </small>
                        </div>

                        <div class="form-field">

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter full name"
                                required
                                autofocus
                            >

                            @error('name')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="form-row">

                        <div class="form-label">
                            <label for="email">
                                Email Address
                                <span class="required">*</span>
                            </label>

                            <small>
                                Used for login
                            </small>
                        </div>

                        <div class="form-field">

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="user@company.local"
                                required
                            >

                            @error('email')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Role --}}
                    <div class="form-row">

                        <div class="form-label">
                            <label for="role">
                                Role
                                <span class="required">*</span>
                            </label>

                            <small>
                                Determines the user's access level
                            </small>
                        </div>

                        <div class="form-field">

                            <select
                                id="role"
                                name="role"
                                required
                            >

                                <option value="" disabled
                                    {{ old('role') ? '' : 'selected' }}>
                                    Select role
                                </option>

                                <option value="administrator"
                                    {{ old('role') === 'administrator' ? 'selected' : '' }}>
                                    Administrator
                                </option>

                                <option value="manager"
                                    {{ old('role') === 'manager' ? 'selected' : '' }}>
                                    Manager
                                </option>

                                <option value="staff"
                                    {{ old('role') === 'staff' ? 'selected' : '' }}>
                                    Staff
                                </option>

                            </select>

                            @error('role')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- Security --}}
            <div class="form-section">

                <div class="form-section-title">
                    <i class="fa-solid fa-lock"></i>
                    <span>Security</span>
                </div>


                <div class="form-table">

                    {{-- Password --}}
                    <div class="form-row">

                        <div class="form-label">
                            <label for="password">
                                Password
                                <span class="required">*</span>
                            </label>

                            <small>
                                Minimum 8 characters
                            </small>
                        </div>

                        <div class="form-field password-field">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('password', this)"
                                aria-label="Show password"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            @error('password')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Confirm Password --}}
                    <div class="form-row">

                        <div class="form-label">
                            <label for="password_confirmation">
                                Confirm Password
                                <span class="required">*</span>
                            </label>

                            <small>
                                Re-enter the password
                            </small>
                        </div>

                        <div class="form-field password-field">

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('password_confirmation', this)"
                                aria-label="Show password"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Form Actions --}}
            <div class="form-actions">

                <a
                    href="{{ route('users.index') }}"
                    class="secondary-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="primary-button"
                >
                    <i class="fa-solid fa-user-plus"></i>
                    Create User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('styles')

<style>

/* =========================
   PAGE
========================= */

.page-container {
    width: 100%;
}

.page-title-section {
    width: 100%;
}

.page-header {
    margin-bottom: 24px;
}

.page-title-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 12px;
}

.page-title-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef4ff;
    color: #2563eb;
    font-size: 20px;
}

.page-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #172033;
}

.page-header p {
    margin: 4px 0 0;
    color: #7b8495;
    font-size: 14px;
}


/* =========================
   BACK BUTTON
========================= */

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #687386;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: .2s ease;
}

.back-button:hover {
    color: #2563eb;
}


/* =========================
   ALERT
========================= */

.form-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 9px;
    margin-bottom: 20px;
    font-size: 13px;
}

.form-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.form-alert-icon {
    font-size: 17px;
    margin-top: 1px;
}

.form-alert strong {
    font-size: 13px;
}

.form-alert ul {
    margin: 6px 0 0 18px;
    padding: 0;
}

.form-alert li {
    margin-bottom: 2px;
}


/* =========================
   FORM CARD
========================= */

.form-card {
    background: #fff;
    border: 1px solid #e7eaf0;
    border-radius: 12px;
    overflow: hidden;
}

.form-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #eef0f4;
}

.form-card-header h2 {
    margin: 0;
    color: #172033;
    font-size: 17px;
    font-weight: 700;
}

.form-card-header p {
    margin: 5px 0 0;
    color: #8a93a3;
    font-size: 13px;
}


/* =========================
   FORM SECTION
========================= */

.form-section {
    border-bottom: 1px solid #eef0f4;
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #eef0f4;
    color: #394256;
    font-size: 13px;
    font-weight: 700;
}

.form-section-title i {
    color: #2563eb;
}


/* =========================
   FORM TABLE
========================= */

.form-table {
    width: 100%;
}

.form-row {
    display: grid;
    grid-template-columns: 260px 1fr;
    min-height: 76px;
    border-bottom: 1px solid #f0f2f5;
}

.form-row:last-child {
    border-bottom: none;
}

.form-label {
    padding: 18px 24px;
    background: #fcfcfd;
    border-right: 1px solid #eef0f4;
}

.form-label label {
    display: block;
    color: #394256;
    font-size: 13px;
    font-weight: 600;
}

.form-label small {
    display: block;
    margin-top: 4px;
    color: #9aa2b1;
    font-size: 11px;
    line-height: 1.4;
}

.required {
    color: #dc2626;
    margin-left: 2px;
}

.form-field {
    position: relative;
    padding: 14px 24px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.form-field input,
.form-field select {
    width: 100%;
    max-width: 600px;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #dfe3ea;
    border-radius: 8px;
    background: #fff;
    color: #263043;
    font-size: 13px;
    outline: none;
    transition: .2s ease;
}

.form-field input:focus,
.form-field select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.form-field input::placeholder {
    color: #a5adba;
}


/* =========================
   PASSWORD
========================= */

.password-field {
    display: block;
}

.password-field input {
    padding-right: 44px;
}

.password-toggle {
    position: absolute;
    right: 35px;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: #9aa2b1;
    cursor: pointer;
}

.password-toggle:hover {
    color: #2563eb;
}


/* =========================
   ERRORS
========================= */

.field-error {
    display: block;
    margin-top: 5px;
    color: #dc2626;
    font-size: 11px;
}


/* =========================
   ACTIONS
========================= */

.form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 18px 24px;
    background: #fafbfc;
}

.primary-button,
.secondary-button {
    height: 40px;
    padding: 0 16px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: .2s ease;
}

.primary-button {
    border: 1px solid #2563eb;
    background: #2563eb;
    color: #fff;
}

.primary-button:hover {
    background: #1d4ed8;
}

.secondary-button {
    border: 1px solid #dfe3ea;
    background: #fff;
    color: #596579;
}

.secondary-button:hover {
    background: #f8fafc;
    color: #263043;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 700px) {

    .page-header h1 {
        font-size: 23px;
    }

    .form-card-header {
        padding: 18px;
    }

    .form-section-title {
        padding: 14px 18px;
    }

    .form-row {
        display: block;
    }

    .form-label {
        padding: 13px 18px 8px;
        border-right: none;
        border-bottom: none;
        background: #fff;
    }

    .form-field {
        padding: 6px 18px 16px;
    }

    .form-field input,
    .form-field select {
        max-width: none;
    }

    .form-actions {
        padding: 16px 18px;
        flex-direction: column-reverse;
    }

    .primary-button,
    .secondary-button {
        width: 100%;
    }

}

</style>

@endpush


@push('scripts')

<script>

function togglePassword(fieldId, button) {

    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');

    if (field.type === 'password') {

        field.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

        button.setAttribute('aria-label', 'Hide password');

    } else {

        field.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

        button.setAttribute('aria-label', 'Show password');

    }

}

</script>

@endpush