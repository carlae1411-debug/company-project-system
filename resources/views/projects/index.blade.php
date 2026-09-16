@extends('layouts.app')

@section('title', 'Projects')

@section('page-title', 'Projects')

@section('content')

<div class="projects-page">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <h2>Projects</h2>
            <p>Manage your company projects.</p>
        </div>

        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            New Project
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- Summary Cards --}}
    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-folder"></i>
            </div>

            <div>
                <span>Total Projects</span>
                <strong>{{ $projects->count() }}</strong>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-spinner"></i>
            </div>

            <div>
                <span>Ongoing</span>

                <strong>
                    {{ $projects->where('status', 'ongoing')->count() }}
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <span>Completed</span>

                <strong>
                    {{ $projects->where('status', 'completed')->count() }}
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div>
                <span>Pending</span>

                <strong>
                    {{ $projects->where('status', 'pending')->count() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- Project List --}}
    <div class="content-card">

        <div class="card-header">

    <div>
        <h3>Project List</h3>
        <p>Select a project to view its details.</p>
    </div>

    <div class="project-list-tools">

        <div class="project-search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="projectSearch"
                placeholder="Search projects..."
                autocomplete="off"
            >

            <button
                type="button"
                id="clearProjectSearch"
                class="clear-search"
                aria-label="Clear search"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <span class="project-count" id="projectCount">
            {{ $projects->count() }} Projects
        </span>

    </div>

</div>


        <div class="table-container">

            <table class="projects-table">

                <thead>

                    <tr>
                        <th>Project Code</th>
                        <th>Project Name</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th></th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($projects as $project)

                        <tr
    class="project-row"
    data-search="{{ strtolower(
        $project->project_code . ' ' .
        $project->name . ' ' .
        ($project->client ?? '') . ' ' .
        $project->status
    ) }}"
    onclick="window.location='{{ route('projects.show', $project) }}'"
>

                            <td>

                                <strong class="project-code">
                                    {{ $project->project_code }}
                                </strong>

                            </td>


                            <td>

                                <div class="project-name-cell">

                                    <span>
                                        {{ $project->name }}
                                    </span>

                                </div>

                            </td>


                            <td>
                                {{ $project->client ?? '—' }}
                            </td>


                            <td>

                                <span class="status-badge status-{{ $project->status }}">
                                    {{ ucfirst($project->status) }}
                                </span>

                            </td>


                            <td>
                                {{ $project->start_date?->format('M d, Y') ?? '—' }}
                            </td>


                            <td>
                                {{ $project->end_date?->format('M d, Y') ?? '—' }}
                            </td>


                            <td class="project-arrow-cell">

                                <span class="project-arrow">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="empty-state">

                                <i class="fa-solid fa-folder-open"></i>

                                <h3>No Projects Yet</h3>

                                <p>
                                    Create your first project to get started.
                                </p>
                            @if(in_array(auth()->user()->role, ['administrator', 'manager']))
                                <a
                                    href="{{ route('projects.create') }}"
                                    class="btn btn-primary"
                                >@endif
                                    <i class="fa-solid fa-plus"></i>
                                    Create Project
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>

.project-list-tools {
    display: flex;
    align-items: center;
    gap: 14px;
}

.project-search {
    position: relative;
    width: 280px;
}

.project-search > i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
}

.project-search input {
    width: 100%;
    height: 38px;
    padding: 0 38px 0 36px;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    background: #ffffff;
    color: #111827;
    font-family: inherit;
    font-size: 13px;
    outline: none;
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
    box-sizing: border-box;
}

.project-search input::placeholder {
    color: #9ca3af;
}

.project-search input:focus {
    border-color: #9ca3af;
    box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.08);
}

.clear-search {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    border: none;
    border-radius: 6px;
    background: transparent;
    color: #9ca3af;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}

.clear-search:hover {
    background: #f3f4f6;
    color: #4b5563;
}

.project-count {
    white-space: nowrap;
}

.project-row.search-hidden {
    display: none;
}

.search-no-results {
    display: none;
}

.search-no-results td {
    padding: 50px 20px;
    text-align: center;
    color: #6b7280;
}

.search-no-results i {
    font-size: 28px;
    color: #9ca3af;
    margin-bottom: 12px;
}

.search-no-results h3 {
    margin: 0 0 6px;
    font-size: 16px;
    color: #374151;
}

.search-no-results p {
    margin: 0;
    font-size: 13px;
}

@media (max-width: 900px) {

    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
    }

    .project-list-tools {
        width: 100%;
        justify-content: space-between;
    }

    .project-search {
        width: min(100%, 320px);
    }

}

@media (max-width: 600px) {

    .project-list-tools {
        flex-direction: column;
        align-items: stretch;
    }

    .project-search {
        width: 100%;
    }

}

</style>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('projectSearch');
    const clearButton = document.getElementById('clearProjectSearch');
    const projectCount = document.getElementById('projectCount');

    if (!searchInput) {
        return;
    }

    const projectRows = Array.from(
        document.querySelectorAll('.project-row')
    );

    const tableBody = document.querySelector('.projects-table tbody');

    const noResultsRow = document.createElement('tr');

    noResultsRow.className = 'search-no-results';

    noResultsRow.innerHTML = `
        <td colspan="7">
            <i class="fa-solid fa-magnifying-glass"></i>
            <h3>No Projects Found</h3>
            <p>Try searching with a different keyword.</p>
        </td>
    `;

    tableBody.appendChild(noResultsRow);


    function performSearch() {

        const searchTerm = searchInput.value
            .trim()
            .toLowerCase();

        let visibleCount = 0;


        projectRows.forEach(function (row) {

            const searchData =
                row.dataset.search || '';

            const matches =
                searchTerm === '' ||
                searchData.includes(searchTerm);

            if (matches) {

                row.classList.remove('search-hidden');

                visibleCount++;

            } else {

                row.classList.add('search-hidden');

            }

        });


        if (visibleCount === 0 && searchTerm !== '') {

            noResultsRow.style.display = 'table-row';

        } else {

            noResultsRow.style.display = 'none';

        }


        projectCount.textContent =
            visibleCount +
            (visibleCount === 1 ? ' Project' : ' Projects');


        clearButton.style.display =
            searchTerm !== '' ? 'flex' : 'none';

    }


    searchInput.addEventListener(
        'input',
        performSearch
    );


    clearButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            performSearch();

            searchInput.focus();

        }
    );

});

</script>
@endsection