@extends('layouts.app')
<a
    href="{{ route('archive.history') }}"
    class="archive-history-button"
>
    <i class="fa-solid fa-clock-rotate-left"></i>
    Archive History
</a>
@section('title', 'Archive')

@section('page-title', 'Archive')

@section('content')

    
    <div class="archive-page">

        {{-- Page Header --}}
       <div class="archive-header">

    <div>

        <h2>Archived Projects</h2>

        <p>
            Projects that have been moved to the archive.
        </p>

    </div>

    <a
        href="{{ route('archive.history') }}"
        class="archive-history-button"
    >
        <i class="fa-solid fa-clock-rotate-left"></i>
        Archive History
    </a>

       </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="archive-alert archive-alert-success">
                <i class="fa-solid fa-circle-check"></i>

                <span>
                    {{ session('success') }}
                </span>
            </div>

        @endif


        {{-- Archive Table --}}
        <div class="archive-card">

            <div class="archive-card-header">
                
                <div>
                    <h3>Project Archive</h3>

                    <p>
                        Archived projects are stored separately from active projects.
                    </p>
                </div>

            </div>


            @if($archivedProjects->count())

                <div class="archive-table-wrapper">

                    <table class="archive-table">

                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Archived Date</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($archivedProjects as $project)

                                <tr class="archive-row" 
                                    onclick="window.location='{{ route('archive.show', $project) }}'">

                                    <td>
                                        <span class="archive-project-code">
                                            {{ $project->project_code }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="archive-project-name">

                                            <div class="archive-folder-icon">
                                                <i class="fa-solid fa-folder"></i>
                                            </div>

                                            <div>
                                                <strong>
                                                    {{ $project->name }}
                                                </strong>

                                                @if($project->description)
                                                    <small>
                                                        {{ Str::limit($project->description, 80) }}
                                                    </small>
                                                @endif
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        {{ $project->client ?? '—' }}
                                    </td>

                                    <td>

                                        <span class="archive-status status-{{ $project->status }}">
                                            {{ ucfirst($project->status) }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ $project->archived_at?->format('M d, Y h:i A') ?? '—' }}
                                    </td>

                                    <td class="archive-arrow-cell">

                                        <span class="archive-arrow">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- Empty State --}}

                <div class="archive-empty">

                    <div class="archive-empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>

                    <h3>No Archived Projects</h3>

                    <p>
                        Projects that you archive will appear here.
                    </p>

                    <a
                        href="{{ route('projects.index') }}"
                        class="archive-back-button"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Projects
                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection