@extends('layouts.app')

@section('content')

<div class="page-container">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <div class="page-title-row">

                <div class="page-title-icon">
                    <i class="fa-solid fa-user-pen"></i>
                </div>

                <div>
                    <h1>Edit User</h1>
                    <p>Update user information and access role</p>
                </div>

            </div>
        </div>

        <a
            href="{{ route('users.show', $user) }}"
            class="secondary-action-button"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to User
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="form-error-alert">

            <i class="fa-solid fa-circle-exclamation"></i>

            <div>
                <strong>Please check the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    @endif


    {{-- Edit User Form --}}
    <div class="form-card">

        <form
            action="{{ route('users.update', $user) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- Account Information --}}
            <div class="form-section">

                <div class="form-section-title">
                    <i class="fa-solid fa-user"></i>
                    Account Information
                </div>


                <div class="form-grid">

                    {{-- Name --}}
                    <div class="form-group">

                        <label for="name">
                            Full Name
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Enter full name"
                            required
                        >

                    </div>


                    {{-- Email --}}
                    <div class="form-group">

                        <label for="email">
                            Email Address
                            <span>*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Enter email address"
                            required
                        >

                    </div>


                    {{-- Role --}}
                    <div class="form-group">

                        <label for="role">
                            User Role
                            <span>*</span>
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                        >

                            <option
                                value="administrator"
                                {{ old('role', $user->role) === 'administrator' ? 'selected' : '' }}
                            >
                                Administrator
                            </option>

                            <option
                                value="manager"
                                {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}
                            >
                                Manager
                            </option>

                            <option
                                value="staff"
                                {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}
                            >
                                Staff
                            </option>

                        </select>

                        <small>
                            The role determines what this user can access.
                        </small>

                    </div>

                </div>

            </div>


            {{-- Password --}}
            <div class="form-section">

                <div class="form-section-title">
                    <i class="fa-solid fa-lock"></i>
                    Change Password
                </div>

                <div class="password-info">
                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        Leave the password fields blank if you do not want to
                        change the user's current password.
                    </span>
                </div>


                <div class="form-grid">

                    {{-- Password --}}
                    <div class="form-group">

                        <label for="password">
                            New Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter new password"
                            minlength="8"
                        >

                        <small>
                            Minimum 8 characters.
                        </small>

                    </div>


                    {{-- Confirm Password --}}
                    <div class="form-group">

                        <label for="password_confirmation">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            minlength="8"
                        >

                    </div>

                </div>

            </div>


            {{-- User Role Preview --}}
            <div class="form-section">

                <div class="form-section-title">
                    <i class="fa-solid fa-key"></i>
                    Role Permissions
                </div>

                <div id="rolePermissionPreview">

                    {{-- Administrator --}}
                    <div
                        class="role-preview"
                        data-role="administrator"
                    >

                        <div class="role-preview-header">
                            <i class="fa-solid fa-shield-halved"></i>
                            <strong>Administrator</strong>
                        </div>

                        <p>
                            Full system access including user management,
                            project management, archive restoration,
                            permanent deletion, and archive history.
                        </p>

                    </div>


                    {{-- Manager --}}
                    <div
                        class="role-preview"
                        data-role="manager"
                    >

                        <div class="role-preview-header">
                            <i class="fa-solid fa-user-tie"></i>
                            <strong>Manager</strong>
                        </div>

                        <p>
                            Can create, edit, and archive projects and view
                            archived projects and archive history.
                        </p>

                    </div>


                    {{-- Staff --}}
                    <div
                        class="role-preview"
                        data-role="staff"
                    >

                        <div class="role-preview-header">
                            <i class="fa-solid fa-user"></i>
                            <strong>Staff</strong>
                        </div>

                        <p>
                            Can view active projects and project details.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form Actions --}}
            <div class="form-actions">

                <a
                    href="{{ route('users.show', $user) }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="save-button"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('styles')

<style>

.page-container {
    width: 100%;
}


/* =========================
   SECONDARY BUTTON
========================= */

.secondary-action-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 17px;
    border-radius: 9px;
    background: #ffffff;
    color: #475569;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid #dfe3ea;
    transition: .2s ease;
}

.secondary-action-button:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}


/* =========================
   ERROR ALERT
========================= */

.form-error-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 20px;
    padding: 14px 16px;
    border: 1px solid #fecaca;
    border-radius: 9px;
    background: #fef2f2;
    color: #991b1b;
    font-size: 13px;
}

.form-error-alert > i {
    margin-top: 2px;
}

.form-error-alert strong {
    display: block;
    margin-bottom: 5px;
}

.form-error-alert ul {
    margin: 0;
    padding-left: 18px;
}


/* =========================
   FORM CARD
========================= */

.form-card {
    background: #ffffff;
    border: 1px solid #e7eaf0;
    border-radius: 12px;
    overflow: hidden;
}


/* =========================
   FORM SECTION
========================= */

.form-section {
    padding: 25px 28px;
    border-bottom: 1px solid #eef0f4;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 20px;
    color: #172033;
    font-size: 15px;
    font-weight: 700;
}

.form-section-title i {
    color: #2563eb;
}


/* =========================
   FORM GRID
========================= */

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 25px;
}


/* =========================
   FORM GROUP
========================= */

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 7px;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
}

.form-group label span {
    color: #dc2626;
}

.form-group input,
.form-group select {
    width: 100%;
    height: 43px;
    padding: 0 13px;
    border: 1px solid #dfe3ea;
    border-radius: 8px;
    outline: none;
    background: #ffffff;
    color: #293347;
    font-size: 14px;
    box-sizing: border-box;
    transition: .2s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.form-group small {
    margin-top: 6px;
    color: #8a93a3;
    font-size: 11px;
}


/* =========================
   PASSWORD INFO
========================= */

.password-info {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 18px;
    padding: 11px 13px;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    font-size: 12px;
}

.password-info i {
    margin-top: 1px;
    color: #2563eb;
}


/* =========================
   ROLE PREVIEW
========================= */

.role-preview {
    display: none;
    padding: 15px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #f8fafc;
}

.role-preview.active {
    display: block;
}

.role-preview-header {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 7px;
    color: #1f2937;
    font-size: 14px;
}

.role-preview-header i {
    color: #2563eb;
}

.role-preview p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
    line-height: 1.5;
}


/* =========================
   FORM ACTIONS
========================= */

.form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 20px 28px;
    background: #fafbfc;
    border-top: 1px solid #eef0f4;
}

.cancel-button,
.save-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 41px;
    padding: 10px 17px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
    box-sizing: border-box;
}

.cancel-button {
    border: 1px solid #dfe3ea;
    background: #ffffff;
    color: #475569;
}

.cancel-button:hover {
    background: #f8fafc;
}

.save-button {
    border: 1px solid #2563eb;
    background: #2563eb;
    color: #ffffff;
}

.save-button:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 700px) {

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .secondary-action-button {
        width: 100%;
        justify-content: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        align-items: stretch;
        flex-direction: column-reverse;
    }

    .cancel-button,
    .save-button {
        width: 100%;
    }

}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role');
    const rolePreviews = document.querySelectorAll('.role-preview');

    function updateRolePreview() {

        if (!roleSelect) {
            return;
        }

        const selectedRole = roleSelect.value;

        rolePreviews.forEach(function (preview) {

            if (preview.dataset.role === selectedRole) {
                preview.classList.add('active');
            } else {
                preview.classList.remove('active');
            }

        });

    }

    if (roleSelect) {

        roleSelect.addEventListener(
            'change',
            updateRolePreview
        );

        updateRolePreview();
    }

});

</script>

@endpush