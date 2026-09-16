
@extends('layouts.app')

@section('content')

<div class="page-container">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <div class="page-title-row">

                <div class="page-title-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>
                    <h1>User Details</h1>
                    <p>View company user information and account access</p>
                </div>

            </div>
        </div>

        <a
            href="{{ route('users.index') }}"
            class="secondary-action-button"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to Users
        </a>

    </div>


    {{-- User Details Card --}}
    <div class="user-detail-card">

        {{-- Profile Header --}}
        <div class="user-profile-header">

            <div class="large-user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="user-profile-info">

                <h2>{{ $user->name }}</h2>

                <span class="user-email">
                    <i class="fa-solid fa-envelope"></i>
                    {{ $user->email }}
                </span>

                @if($user->role === 'administrator')

                    <span class="role-badge role-administrator">
                        <i class="fa-solid fa-shield-halved"></i>
                        Administrator
                    </span>

                @elseif($user->role === 'manager')

                    <span class="role-badge role-manager">
                        <i class="fa-solid fa-user-tie"></i>
                        Manager
                    </span>

                @else

                    <span class="role-badge role-staff">
                        <i class="fa-solid fa-user"></i>
                        Staff
                    </span>

                @endif

            </div>

        </div>


        {{-- Account Information --}}
        <div class="detail-section">

            <div class="detail-section-title">
                <i class="fa-solid fa-circle-info"></i>
                Account Information
            </div>

            <div class="detail-grid">

                <div class="detail-item">
                    <span class="detail-label">Full Name</span>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Email Address</span>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Role</span>
                    <strong>
                        {{ ucfirst($user->role) }}
                    </strong>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Account Created</span>
                    <strong>
                        {{ $user->created_at?->format('M d, Y h:i A') }}
                    </strong>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Last Updated</span>
                    <strong>
                        {{ $user->updated_at?->format('M d, Y h:i A') }}
                    </strong>
                </div>

                <div class="detail-item">

                    <span class="detail-label">Account Status</span>

                    <strong class="account-active">
                        <i class="fa-solid fa-circle-check"></i>
                        Active
                    </strong>

                </div>

            </div>

        </div>


        {{-- Permissions --}}
        <div class="detail-section">

            <div class="detail-section-title">
                <i class="fa-solid fa-key"></i>
                Access Permissions
            </div>

            <div class="permission-list">

                @if($user->role === 'administrator')

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Full system access</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Manage company users</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Create, edit and archive projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Restore archived projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Permanently delete archived projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>View archive history</span>
                    </div>

                @elseif($user->role === 'manager')

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>Create, edit and archive projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>View archived projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>View archive history</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Restore archived projects</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Permanently delete archived projects</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Manage company users</span>
                    </div>

                @else

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>View active projects</span>
                    </div>

                    <div class="permission-item">
                        <i class="fa-solid fa-check"></i>
                        <span>View project details</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Create or edit projects</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Archive projects</span>
                    </div>

                    <div class="permission-item permission-disabled">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Manage company users</span>
                    </div>

                @endif

            </div>

        </div>


        {{-- Actions --}}
        <div class="user-actions">

            @if(auth()->user()->role === 'administrator')

                <a
                    href="{{ route('users.edit', $user) }}"
                    class="user-action-button user-edit-button"
                >
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit User
                </a>

                @if($user->id !== auth()->id())

                    <form
                        action="{{ route('users.destroy', $user) }}"
                        method="POST"
                        onsubmit="return confirmDeleteUser();"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="user-action-button user-delete-button"
                        >
                            <i class="fa-solid fa-trash"></i>
                            Delete User
                        </button>

                    </form>

                @else

                    <span class="self-account-notice">
                        <i class="fa-solid fa-lock"></i>
                        You cannot delete your own account
                    </span>

                @endif

            @endif

        </div>

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
   USER DETAIL CARD
========================= */

.user-detail-card {
    background: #ffffff;
    border: 1px solid #e7eaf0;
    border-radius: 12px;
    overflow: hidden;
}


/* =========================
   PROFILE HEADER
========================= */

.user-profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 28px;
    border-bottom: 1px solid #eef0f4;
}

.large-user-avatar {
    width: 76px;
    height: 76px;
    min-width: 76px;
    border-radius: 50%;
    background: #e8eefc;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
}

.user-profile-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 7px;
}

.user-profile-info h2 {
    margin: 0;
    font-size: 22px;
    color: #172033;
}

.user-email {
    color: #687386;
    font-size: 14px;
}

.user-email i {
    margin-right: 5px;
}


/* =========================
   DETAIL SECTION
========================= */

.detail-section {
    padding: 25px 28px;
    border-bottom: 1px solid #eef0f4;
}

.detail-section-title {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 20px;
    color: #172033;
    font-size: 15px;
    font-weight: 700;
}

.detail-section-title i {
    color: #2563eb;
}


/* =========================
   DETAIL GRID
========================= */

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 30px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-label {
    color: #8a93a3;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.detail-item strong {
    color: #293347;
    font-size: 14px;
}

.account-active {
    color: #15803d !important;
}

.account-active i {
    margin-right: 4px;
}


/* =========================
   PERMISSIONS
========================= */

.permission-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.permission-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 13px;
    border-radius: 8px;
    background: #f0fdf4;
    color: #166534;
    font-size: 13px;
}

.permission-item i {
    width: 18px;
    text-align: center;
}

.permission-disabled {
    background: #f8fafc;
    color: #94a3b8;
}


/* =========================
   ACTIONS
========================= */

.user-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 22px 28px;
}

.user-actions form {
    margin: 0;
}

.user-action-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: .2s ease;
}

.user-edit-button {
    border: 1px solid #2563eb;
    background: #2563eb;
    color: #ffffff;
}

.user-edit-button:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}

.user-delete-button {
    border: 1px solid #dc2626;
    background: #dc2626;
    color: #ffffff;
}

.user-delete-button:hover {
    background: #b91c1c;
    border-color: #b91c1c;
}

.self-account-notice {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 14px;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    font-size: 13px;
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

    .user-profile-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .detail-grid,
    .permission-list {
        grid-template-columns: 1fr;
    }

    .user-actions {
        align-items: stretch;
        flex-direction: column;
    }

    .user-action-button,
    .self-account-notice {
        width: 100%;
        justify-content: center;
    }

}

</style>

@endpush


@push('scripts')

<script>

function confirmDeleteUser() {

    const userName = @json($user->name);

    return confirm(
        `Delete "${userName}"?\n\n` +
        `WARNING: This action cannot be undone.\n` +
        `The user account will be permanently deleted.`
    );
}

</script>

@endpush