@extends('layouts.app')

@section('content')

<div class="page-container">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <div class="page-title-row">
                <div class="page-title-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <h1>Users</h1>
                    <p>Manage company users and access roles</p>
                </div>
            </div>
        </div>

@if(auth()->user()->role === 'administrator')
    <div class="page-actions">

    <a href="{{ route('users.trashed') }}" class="btn btn-secondary">
        Deleted Users
    </a>&nbsp;
    
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        Add User
    </a>

</div>
@endif

    </div>


    {{-- Summary Cards --}}
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-card-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <span class="summary-label">Total Users</span>
                <strong>{{ $users->count() }}</strong>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-card-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>
                <span class="summary-label">Administrators</span>
                <strong>
                    {{ $users->where('role', 'administrator')->count() }}
                </strong>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-card-icon">
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div>
                <span class="summary-label">Managers</span>
                <strong>
                    {{ $users->where('role', 'manager')->count() }}
                </strong>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-card-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>
                <span class="summary-label">Staff</span>
                <strong>
                    {{ $users->where('role', 'staff')->count() }}
                </strong>
            </div>
        </div>

    </div>


    {{-- Search --}}
    <div class="list-toolbar">

        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="userSearch"
                placeholder="Search users..."
                autocomplete="off"
            >
        </div>

        <div class="list-count">
            <span id="visibleUserCount">{{ $users->count() }}</span>
            users
        </div>

    </div>


    {{-- Users Table --}}
    <div class="content-card">

        @if($users->count())

            <div class="table-wrapper">

                <table class="data-table" id="usersTable">

                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="action-column">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)

                            <tr
                                class="user-row"
                                data-search="
                                    {{ strtolower($user->name) }}
                                    {{ strtolower($user->email) }}
                                    {{ strtolower($user->role) }}
                                "
                            >

                                {{-- User --}}
                                <td>
                                    <div class="user-cell">

                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div class="user-info">
                                            <strong>{{ $user->name }}</strong>

                                            @if($user->id === auth()->id())
                                                <span class="current-user-label">
                                                    You
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </td>


                                {{-- Email --}}
                                <td>
                                    <span class="email-text">
                                        {{ $user->email }}
                                    </span>
                                </td>


                                {{-- Role --}}
                                <td>

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

                                </td>


                                {{-- Created --}}
                                <td>
                                    <span class="date-text">
                                        {{ $user->created_at?->format('M d, Y') }}
                                    </span>
                                </td>


                                {{-- Action --}}
                                <td class="action-column">

                                    <a
                                        href="{{ route('users.show', $user) }}"
                                        class="row-action"
                                        title="View user"
                                    >
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Empty Search Result --}}
            <div id="noSearchResults" class="search-empty-state" style="display:none;">

                <div class="empty-icon">
                    <i class="fa-solid fa-user-slash"></i>
                </div>

                <h3>No users found</h3>

                <p>
                    Try searching with a different name, email, or role.
                </p>

            </div>

        @else

            {{-- Empty Users --}}
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <h3>No users yet</h3>

                <p>
                    Create your first company user to get started.
                </p>

                @if(auth()->user()->role === 'administrator')
    <a href="{{ route('users.create') }}" class="primary-action-button">
        <i class="fa-solid fa-user-plus"></i>
        Add User
    </a>
@endif

            </div>

        @endif

    </div>

</div>

@endsection


@push('styles')

<style>

.page-container {
    width: 100%;
}


/* =========================
   PAGE HEADER
========================= */

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.page-title-row {
    display: flex;
    align-items: center;
    gap: 14px;
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
   BUTTON
========================= */

.primary-action-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 17px;
    border-radius: 9px;
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: .2s ease;
}

.primary-action-button:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}


/* =========================
   SUMMARY CARDS
========================= */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}

.summary-card {
    background: #fff;
    border: 1px solid #e7eaf0;
    border-radius: 12px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.summary-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
}

.summary-label {
    display: block;
    color: #8a93a3;
    font-size: 12px;
    margin-bottom: 3px;
}

.summary-card strong {
    font-size: 22px;
    color: #172033;
}


/* =========================
   TOOLBAR
========================= */

.list-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 12px;
}

.search-box {
    position: relative;
    width: 340px;
}

.search-box i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #9aa2b1;
    font-size: 14px;
}

.search-box input {
    width: 100%;
    height: 42px;
    border: 1px solid #dfe3ea;
    border-radius: 9px;
    padding: 0 14px 0 38px;
    outline: none;
    font-size: 14px;
    color: #263043;
    background: #fff;
}

.search-box input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.list-count {
    color: #7b8495;
    font-size: 13px;
}


/* =========================
   CONTENT CARD
========================= */

.content-card {
    background: #fff;
    border: 1px solid #e7eaf0;
    border-radius: 12px;
    overflow: hidden;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}


/* =========================
   TABLE
========================= */

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f8fafc;
}

.data-table th {
    text-align: left;
    padding: 14px 18px;
    font-size: 11px;
    font-weight: 700;
    color: #7b8495;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-bottom: 1px solid #e7eaf0;
}

.data-table td {
    padding: 15px 18px;
    border-bottom: 1px solid #eef0f4;
    font-size: 14px;
    color: #394256;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.user-row {
    cursor: pointer;
    transition: background .15s ease;
}

.user-row:hover {
    background: #f8fbff;
}


/* =========================
   USER CELL
========================= */

.user-cell {
    display: flex;
    align-items: center;
    gap: 11px;
}

.user-avatar {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 50%;
    background: #e8eefc;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-info strong {
    color: #1f2937;
    font-size: 14px;
}

.current-user-label {
    font-size: 10px;
    color: #2563eb;
    font-weight: 600;
}

.email-text {
    color: #687386;
}

.date-text {
    color: #7b8495;
}


/* =========================
   ROLE BADGES
========================= */

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.role-administrator {
    background: #fef2f2;
    color: #b91c1c;
}

.role-manager {
    background: #eff6ff;
    color: #1d4ed8;
}

.role-staff {
    background: #f1f5f9;
    color: #475569;
}


/* =========================
   ACTION
========================= */

.action-column {
    width: 60px;
    text-align: center !important;
}

.row-action {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    color: #9aa2b1;
    text-decoration: none;
    transition: .15s ease;
}

.row-action:hover {
    background: #eef4ff;
    color: #2563eb;
}


/* =========================
   EMPTY STATE
========================= */

.empty-state,
.search-empty-state {
    text-align: center;
    padding: 65px 20px;
}

.empty-icon {
    width: 58px;
    height: 58px;
    margin: 0 auto 15px;
    border-radius: 14px;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
}

.empty-state h3,
.search-empty-state h3 {
    margin: 0 0 6px;
    color: #1f2937;
    font-size: 17px;
}

.empty-state p,
.search-empty-state p {
    margin: 0 0 20px;
    color: #8a93a3;
    font-size: 13px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1100px) {

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 700px) {

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .primary-action-button {
        width: 100%;
        justify-content: center;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .list-toolbar {
        align-items: stretch;
        flex-direction: column;
    }

    .search-box {
        width: 100%;
    }

    .list-count {
        text-align: right;
    }

}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('userSearch');
    const rows = document.querySelectorAll('.user-row');
    const noResults = document.getElementById('noSearchResults');
    const countDisplay = document.getElementById('visibleUserCount');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {

        const searchTerm = this.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        rows.forEach(function (row) {

            const searchData = row.dataset.search || '';

            if (searchData.includes(searchTerm)) {

                row.style.display = '';
                visibleCount++;

            } else {

                row.style.display = 'none';

            }

        });

        if (countDisplay) {
            countDisplay.textContent = visibleCount;
        }

        if (noResults) {

            noResults.style.display =
                visibleCount === 0
                    ? 'block'
                    : 'none';

        }

    });


    /*
     * Make the whole row clickable
     */
    rows.forEach(function (row) {

        row.addEventListener('click', function (event) {

            if (event.target.closest('a')) {
                return;
            }

            const link = row.querySelector('.row-action');

            if (link) {
                window.location.href = link.href;
            }

        });

    });

});

</script>

@endpush