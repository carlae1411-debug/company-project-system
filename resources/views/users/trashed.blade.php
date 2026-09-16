@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/users-trashed.css') }}">

<div class="deleted-users-page">

    <div class="deleted-users-header">

        <div>
            <h1>Deleted Users</h1>
            <p>Users that have been temporarily deleted.</p>
        </div>

        <div class="deleted-users-actions">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Users
            </a>
        </div>

    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="deleted-users-card">

        @if ($users->count())

            <div class="deleted-users-table-wrapper">

                <table class="deleted-users-table">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($users as $user)

                            <tr>

                                <td>
                                    <div class="deleted-user-name">
                                        {{ $user->name }}
                                    </div>
                                </td>

                                <td>
                                    <div class="deleted-user-email">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                <td>
                                    <span class="deleted-role-badge">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="deleted-date">
                                        {{ $user->deleted_at?->format('M d, Y h:i A') }}
                                    </span>
                                </td>

                                <td>

                                    <form
                                        action="{{ route('users.restore', $user->id) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Restore this user?');"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="restore-user-btn"
                                        >
                                            <i class="fa-solid fa-rotate-left"></i>
                                            Restore
                                        </button></form>
                                        <form
    action="{{ route('users.forceDelete', $user->id) }}"
    method="POST"
    style="display: inline;"
    onsubmit="return confirm('WARNING: This will permanently delete this user and cannot be undone. Continue?');"
>
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="permanent-delete-user-btn"
    >
        <i class="fa-solid fa-trash"></i>
        Permanent Delete
    </button>
</form>
                                    

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="deleted-users-empty">

                <div class="deleted-users-empty-icon">
                    <i class="fa-solid fa-trash-can"></i>
                </div>

                <h3>No Deleted Users</h3>

                <p>
                    There are currently no soft-deleted users.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection