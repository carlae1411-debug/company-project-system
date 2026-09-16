@extends('layouts.app')

@section('title', 'Archived Project')

@section('page-title', 'Archived Project')

@section('content')

<div class="archived-detail-page">

    {{-- Back --}}
    <div class="archived-detail-back">
        <a href="{{ route('archive.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Archive
        </a>
    </div>

    {{-- Header --}}
    <div class="archived-detail-header">

        <div class="archived-detail-title">

            <div class="archived-detail-icon">
                <i class="fa-solid fa-box-archive"></i>
            </div>

            <div>
                <div class="archived-detail-label">
                    <i class="fa-solid fa-box-archive"></i>
                    Archived Project
                </div>

                <h2>{{ $archivedProject->name }}</h2>

                <p>{{ $archivedProject->project_code }}</p>
            </div>

        </div>

        <div class="archived-detail-actions">

@if(auth()->user()->role === 'administrator')
  

    <form
        action="{{ route('archive.restore', $archivedProject) }}"
        method="POST"
        onsubmit="return confirmRestoreProject();"
    >
        @csrf

        <button type="submit" class="archived-restore-btn">
            <i class="fa-solid fa-rotate-left"></i>
            Restore Project
        </button>
    </form>

    <form
        action="{{ route('archive.destroy', $archivedProject) }}"
        method="POST"
        onsubmit="return confirmPermanentDeleteProject();"
    >
        @csrf
        @method('DELETE')

        <button type="submit" class="archived-delete-btn">
            <i class="fa-solid fa-trash"></i>
            Delete Permanently
        </button>
    </form>

    

@elseif(auth()->user()->role === 'manager')

    {{-- Manager can view archive but cannot restore or permanently delete. --}}







@endif

        </div>

    </div>

    {{-- Archive Notice --}}
    <div class="archived-notice">

        <div class="archived-notice-icon">
            <i class="fa-solid fa-box-archive"></i>
        </div>

        <div>
            <strong>This project is archived</strong>

            <span>
                This project is stored in the archive database and is no longer
                part of the active project list.
            </span>
        </div>

    </div>

    {{-- Project Information --}}
    <div class="archived-detail-card">

        <div class="archived-detail-card-header">

            <h3>Project Information</h3>

            <p>
                General information about this archived project.
            </p>

        </div>

        <div class="archived-detail-table-wrapper">

            <table class="archived-detail-table">

                <tbody>

                    <tr>
                        <th>Project Code</th>
                        <td>
                            <strong>{{ $archivedProject->project_code }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Project Name</th>
                        <td>{{ $archivedProject->name }}</td>
                    </tr>

                    <tr>
                        <th>Client</th>
                        <td>
                            {{ $archivedProject->client ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="archived-status status-{{ $archivedProject->status }}">
                                {{ ucfirst($archivedProject->status) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Start Date</th>
                        <td>
                            {{ $archivedProject->start_date?->format('F d, Y') ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>End Date</th>
                        <td>
                            {{ $archivedProject->end_date?->format('F d, Y') ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Description</th>
                        <td>
                            @if($archivedProject->description)

                                <div class="archived-description">
                                    {{ $archivedProject->description }}
                                </div>

                            @else

                                <span class="archived-empty">
                                    No description provided.
                                </span>

                            @endif
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- Archive Information --}}
    <div class="archived-detail-card">

        <div class="archived-detail-card-header">

            <h3>Archive Information</h3>

            <p>
                System information related to this archived project.
            </p>

        </div>

        <div class="archived-detail-table-wrapper">

            <table class="archived-detail-table">

                <tbody>

                    <tr>
                        <th>Original Project ID</th>
                        <td>
                            #{{ $archivedProject->original_project_id }}
                        </td>
                    </tr>

                    <tr>
                        <th>Archived Date</th>
                        <td>
                            {{ $archivedProject->archived_at?->format('F d, Y h:i A') ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Archived By</th>
                        <td>
                           {{ $archivedProject->archived_by_name }}
                        </td>
                    </tr>

                    <tr>
                        <th>Archive Record ID</th>
                        <td>
                            #{{ $archivedProject->id }}
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- Bottom Back --}}
    <div class="archived-detail-bottom">

        <a href="{{ route('archive.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Archive
        </a>

    </div>

</div>

@endsection