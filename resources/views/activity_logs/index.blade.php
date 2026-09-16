@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user-logs-print.css') }}">
<div class="page-header">
    <div>
        <h1>User Logs</h1>
        <p>Monitor user activity and system actions.</p>
    </div>
</div>

<div class="logs-card">

    {{-- Filters --}}

    <form
        action="{{ route('activity_logs.index') }}"
        method="GET"
        class="logs-filters"
    >

        <div class="filter-group search-group">
            <label for="search">Search</label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search user, action, description or IP..."
            >
        </div>


        <div class="filter-group">
            <label for="from_date">From Date</label>

            <input
                type="date"
                id="from_date"
                name="from_date"
                value="{{ request('from_date') }}"
            >
        </div>


        <div class="filter-group">
            <label for="to_date">To Date</label>

            <input
                type="date"
                id="to_date"
                name="to_date"
                value="{{ request('to_date') }}"
            >
        </div>


        <div class="filter-group">
            <label for="action">Action</label>

            <select
                id="action"
                name="action"
            >

                <option value="">
                    All Actions
                </option>

                @foreach ($actions as $action)

                    <option
                        value="{{ $action }}"
                        {{ request('action') === $action ? 'selected' : '' }}
                    >
                        {{ ucfirst(str_replace('_', ' ', $action)) }}
                    </option>

                @endforeach

            </select>
        </div>


        <div class="filter-group">
            <label for="user_id">User</label>

            <select
                id="user_id"
                name="user_id"
            >

                <option value="">
                    All Users
                </option>

                @foreach ($users as $user)

                    <option
                        value="{{ $user->id }}"
                        {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}
                    >
                        {{ $user->name }}
                    </option>

                @endforeach

            </select>
        </div>


        <div class="filter-buttons">

            <button
                type="submit"
                class="btn-filter"
            >
                <i class="fa-solid fa-filter"></i>
                Filter
            </button>

            <a
                href="{{ route('activity_logs.index') }}"
                class="btn-clear"
            >
                <i class="fa-solid fa-rotate-left"></i>
                Clear
            </a>

        </div>

    </form>


    {{-- Summary --}}

    <div class="logs-summary">
            <div>
            <strong>{{ $logs->total() }}</strong>
            <span>Activity Logs</span>
        </div>
        <button
    type="button"
    class="btn btn-secondary"
    onclick="window.print()"
>
    <i class="fa-solid fa-print"></i>
    Print Logs
</button>

    </div>
<div class="print-header">
    <h1>User Activity Logs</h1>

    <p>
        Generated:
        {{ now()->format('M d, Y h:i A') }}
    </p>
</div>
    

    {{-- Table --}}

    <div class="logs-table-wrapper">

        <table class="logs-table">

            <thead>

                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($logs as $log)

                    <tr>

                        <td>
                            <div class="log-date">
                                {{ $log->created_at->format('M d, Y') }}
                            </div>

                            <div class="log-time">
                                {{ $log->created_at->format('h:i A') }}
                            </div>
                        </td>


                        <td>

                            <div class="user-cell">

                                <div class="user-avatar">
                                    {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                </div>

                                <div>

                                    <strong>
                                        {{ $log->user_name ?? 'System' }}
                                    </strong>

                                    @if ($log->user_id)
                                        <small>
                                            User ID: {{ $log->user_id }}
                                        </small>
                                    @endif

                                </div>

                            </div>

                        </td>


                        <td>

                            @if ($log->role)

                                <span class="role-badge role-{{ $log->role }}">
                                    {{ ucfirst($log->role) }}
                                </span>

                            @else

                                <span class="role-badge">
                                    System
                                </span>

                            @endif

                        </td>


                        <td>

                            @php

                                $actionLabels = [
                                    'logged_in' => 'Logged In',
                                    'logged_out' => 'Logged Out',
                                    'failed_login' => 'Failed Login',
                                    'created_project' => 'Created Project',
                                    'updated_project' => 'Updated Project',
                                    'archived_project' => 'Archived Project',
                                    'restored_project' => 'Restored Project',
                                    'permanently_deleted_project' => 'Permanently Deleted Project',
                                    'deleted_project' => 'Deleted Project',
                                    'created_user' => 'Created User',
                                    'updated_user' => 'Updated User',
                                    'deleted_user' => 'Deleted User',
                                    'viewed_reports' => 'Viewed Reports',
                                    'downloaded_report' => 'Downloaded Report',
                                ];

                                $actionLabel = $actionLabels[$log->action]
                                    ?? ucfirst(str_replace('_', ' ', $log->action));

                            @endphp

                            <span class="action-badge action-{{ $log->action }}">
                                {{ $actionLabel }}
                            </span>

                        </td>


                        <td>

                            <div class="description-cell">
                                {{ $log->description ?? '—' }}
                            </div>

                        </td>


                        <td>

                            <code class="ip-address">
                                {{ $log->ip_address ?? '—' }}
                            </code>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="empty-logs"
                        >

                            <div class="empty-icon">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>

                            <strong>
                                No activity logs found
                            </strong>

                            <p>
                                Try changing your search or filter options.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}

    @if ($logs->hasPages())

        <div class="logs-pagination">

            {{ $logs->links() }}

        </div>

    @endif

</div>

@endsection