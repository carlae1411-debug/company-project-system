@extends('layouts.app')

@section('title', 'Project Details')

@section('page-title', 'Project Details')

@section('content')

<div class="project-details-page">


    {{-- Header --}}
    <div class="project-details-header">

        <div class="project-details-heading">

            <a
                href="{{ route('projects.index') }}"
                class="back-button"
            >
                <i class="fa-solid fa-arrow-left"></i>
            </a>


            <div class="project-details-title">

                <div class="project-details-folder">
                    <i class="fa-solid fa-folder"></i>
                </div>

                <div>

                    <span class="project-details-code">
                        {{ $project->project_code }}
                    </span>

                    <h2>
                        {{ $project->name }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="project-detail-actions">

            @if(in_array(auth()->user()->role, ['administrator', 'manager']))
            <a
                href="{{ route('projects.edit', $project) }}"
                class="detail-btn detail-btn-edit"
            >
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>@endif


@if(auth()->user()->role === 'administrator' || auth()->user()->role === 'manager')
    <form
        action="{{ route('projects.archive', $project) }}"
        method="POST"
        onsubmit="return confirm('Are you sure you want to delete this project? It will be moved to the Archive database.');"
    >
        @csrf

        <button type="submit" class="detail-btn detail-btn-delete">
            <i class="fa-solid fa-box-archive"></i>
            Delete
        </button>
    </form>
@endif
        </div>

    </div>


    {{-- Project Status --}}
    <div class="project-status-banner">

        <div class="status-banner-left">
            
            <span class="status-dot status-dot-{{ $project->status }}"></span>

            <div>

                <span class="status-label">
                    PROJECT STATUS
                </span>

                <strong>
                    {{ ucfirst($project->status) }}
                </strong>

            </div>

        </div>


        <div class="status-banner-icon">

            @if($project->status === 'completed')

                <i class="fa-solid fa-circle-check"></i>

            @elseif($project->status === 'ongoing')

                <i class="fa-solid fa-spinner"></i>

            @else

                <i class="fa-solid fa-clock"></i>

            @endif

        </div>

    </div>


    {{-- Information --}}
    <div class="details-card">

        <div class="details-card-header">

            <div>
                <h3>Project Information</h3>
                <p>Basic information about this project.</p>
            </div>

        </div>


        <div class="details-table">


            <div class="details-row">

                <div class="details-label">
                    Project Code
                </div>

                <div class="details-value">
                    {{ $project->project_code }}
                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    Project Name
                </div>

                <div class="details-value">
                    {{ $project->name }}
                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    Client
                </div>

                <div class="details-value">
                    {{ $project->client ?? '—' }}
                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    Status
                </div>

                <div class="details-value">

                    <span class="status-badge status-{{ $project->status }}">
                        {{ ucfirst($project->status) }}
                    </span>

                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    Start Date
                </div>

                <div class="details-value">
                    {{ $project->start_date?->format('F d, Y') ?? '—' }}
                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    End Date
                </div>

                <div class="details-value">
                    {{ $project->end_date?->format('F d, Y') ?? '—' }}
                </div>

            </div>


            <div class="details-row details-description">

                <div class="details-label">
                    Description
                </div>

                <div class="details-value description-text">
                    {{ $project->description ?? 'No description provided.' }}
                </div>

            </div>


        </div>

    </div>


    {{-- System Information --}}
    <div class="details-card">

        <div class="details-card-header">

            <div>
                <h3>System Information</h3>
                <p>Project record information.</p>
            </div>

        </div>


        <div class="details-table">

            <div class="details-row">

                <div class="details-label">
                    Created
                </div>

                <div class="details-value">
                    {{ $project->created_at?->format('F d, Y h:i A') }}
                </div>

            </div>


            <div class="details-row">

                <div class="details-label">
                    Last Updated
                </div>

                <div class="details-value">
                    {{ $project->updated_at?->format('F d, Y h:i A') }}
                </div>

            </div>

        </div>

    </div>


    {{-- Bottom Back --}}
    <div class="details-bottom-action">

        <a
            href="{{ route('projects.index') }}"
            class="back-to-projects"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to Projects
        </a>

    </div>


</div>

@endsection