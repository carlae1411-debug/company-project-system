@extends('layouts.app')

@section('title', 'Reports')

@section('page-title', 'Reports')

@section('content')

<div class="reports-page">

    {{-- Page Header --}}
    <div class="page-header">

        {{-- Print Header --}}
<div class="print-report-header">

    <div class="print-company-name">
        WDC Project Directory
    </div>

    <div class="print-report-title">
        PROJECT REPORT
    </div>

    <div class="print-report-meta">
        Generated:
        {{ now()->format('F d, Y h:i A') }}
    </div>

</div>

      
        <div>
            <h2>Project Reports</h2>
            <p>Generate and review project reports.</p>
        </div>

        <div class="report-header-actions">

    <button
        type="button"
        class="btn btn-secondary"
        onclick="window.print()"
    >
        <i class="fa-solid fa-print"></i>
        Print
    </button>

    <a
        href="{{ route('reports.pdf', request()->query()) }}"
        class="btn btn-primary"
    >
        <i class="fa-solid fa-file-pdf"></i>
        Download PDF
    </a>

</div>

    </div>


    {{-- Filter Card --}}
    <div class="content-card filter-card">

        <div class="card-header">

            <div>
                <h3>
                    <i class="fa-solid fa-filter"></i>
                    Report Filters
                </h3>

                <p>
                    Filter projects by date, status, or client.
                </p>
            </div>

        </div>


        <form
            action="{{ route('reports.index') }}"
            method="GET"
            class="report-filters"
        >

            {{-- From Date --}}
            <div class="filter-group">

                <label for="from_date">
                    From Date
                </label>

                <div class="filter-input">

                    <i class="fa-regular fa-calendar"></i>

                    <input
                        type="date"
                        id="from_date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >

                </div>

            </div>


            {{-- To Date --}}
            <div class="filter-group">

                <label for="to_date">
                    To Date
                </label>

                <div class="filter-input">

                    <i class="fa-regular fa-calendar"></i>

                    <input
                        type="date"
                        id="to_date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                    >

                </div>

            </div>


            {{-- Status --}}
            <div class="filter-group">

                <label for="status">
                    Status
                </label>

                <div class="filter-input">

                    <i class="fa-solid fa-circle-half-stroke"></i>

                    <select
                        id="status"
                        name="status"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="pending"
                            {{ request('status') === 'pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="ongoing"
                            {{ request('status') === 'ongoing' ? 'selected' : '' }}
                        >
                            Ongoing
                        </option>

                        <option
                            value="completed"
                            {{ request('status') === 'completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                    </select>

                </div>

            </div>


            {{-- Client --}}
            <div class="filter-group">

                <label for="client">
                    Client
                </label>

                <div class="filter-input">

                    <i class="fa-solid fa-building"></i>

                    <select
                        id="client"
                        name="client"
                    >

                        <option value="">
                            All Clients
                        </option>

                        @foreach($clients as $client)

                            <option
                                value="{{ $client }}"
                                {{ request('client') === $client ? 'selected' : '' }}
                            >
                                {{ $client }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- Filter Buttons --}}
            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-filter"></i>
                    Apply Filters
                </button>

                <a
                    href="{{ route('reports.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Summary Cards --}}
    <div class="summary-grid report-summary-grid">
        {{-- Print Filter Summary --}}
<div class="print-filter-summary">

    <h4>Report Filters</h4>

    <div class="print-filter-grid">

        <div>
            <span>Date Range</span>

            <strong>
                @if(request('from_date') || request('to_date'))

                    {{ request('from_date')
                        ? \Carbon\Carbon::parse(request('from_date'))->format('M d, Y')
                        : 'Any' }}

                    &nbsp;–&nbsp;

                    {{ request('to_date')
                        ? \Carbon\Carbon::parse(request('to_date'))->format('M d, Y')
                        : 'Any' }}

                @else
                    All Dates
                @endif
            </strong>
        </div>


        <div>
            <span>Status</span>

            <strong>
                {{ request('status')
                    ? ucfirst(request('status'))
                    : 'All Statuses' }}
            </strong>
        </div>


        <div>
            <span>Client</span>

            <strong>
                {{ request('client') ?: 'All Clients' }}
            </strong>
        </div>

    </div>

</div>
        {{-- Total --}}
        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-folder"></i>
            </div>

            <div>

                <span>Total Projects</span>

                <strong>
                    {{ $totalProjects }}
                </strong>

            </div>

        </div>


        {{-- Pending --}}
        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div>

                <span>Pending</span>

                <strong>
                    {{ $pendingProjects }}
                </strong>

            </div>

        </div>


        {{-- Ongoing --}}
        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-spinner"></i>
            </div>

            <div>

                <span>Ongoing</span>

                <strong>
                    {{ $ongoingProjects }}
                </strong>

            </div>

        </div>


        {{-- Completed --}}
        <div class="summary-card">

            <div class="summary-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>

                <span>Completed</span>

                <strong>
                    {{ $completedProjects }}
                </strong>

            </div>

        </div>

    </div>


    {{-- Report Table --}}
    <div class="content-card report-card">

        <div class="card-header">

            <div>

                <h3>Project Report</h3>

                <p>
                    {{ $totalProjects }}
                    {{ $totalProjects === 1 ? 'project' : 'projects' }}
                    found.
                </p>

            </div>

            <div class="report-generated">

                <i class="fa-regular fa-calendar"></i>

                Generated:
                {{ now()->format('M d, Y h:i A') }}

            </div>

        </div>


        <div class="table-container">

            <table class="projects-table report-table">

                <thead>

                    <tr>

                        <th>Project Code</th>

                        <th>Project Name</th>

                        <th>Client</th>

                        <th>Status</th>

                        <th>Start Date</th>

                        <th>End Date</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($projects as $project)

                        <tr>

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

                                <span
                                    class="status-badge status-{{ $project->status }}"
                                >
                                    {{ ucfirst($project->status) }}
                                </span>

                            </td>


                            <td>
                                {{ $project->start_date?->format('M d, Y') ?? '—' }}
                            </td>


                            <td>
                                {{ $project->end_date?->format('M d, Y') ?? '—' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="report-empty-state"
                            >

                                <i class="fa-solid fa-chart-column"></i>

                                <h3>No Projects Found</h3>

                                <p>
                                    No projects match the selected filters.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

/* =========================================================
   REPORTS PAGE
   ========================================================= */

.reports-page {
    width: 100%;
}


/* =========================================================
   HEADER
   ========================================================= */

.report-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}


/* =========================================================
   FILTER CARD
   ========================================================= */

.filter-card {
    margin-bottom: 20px;
}

.filter-card .card-header {
    margin-bottom: 20px;
}

.filter-card .card-header h3 {
    display: flex;
    align-items: center;
    gap: 9px;
}

.filter-card .card-header h3 i {
    font-size: 14px;
    color: #6b7280;
}


.report-filters {
    display: grid;
    grid-template-columns:
        minmax(150px, 1fr)
        minmax(150px, 1fr)
        minmax(170px, 1fr)
        minmax(190px, 1fr)
        auto;

    gap: 14px;

    align-items: end;
}


.filter-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}


.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}


.filter-input {
    position: relative;
}


.filter-input > i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);

    color: #9ca3af;

    font-size: 13px;

    pointer-events: none;

    z-index: 1;
}


.filter-input input,
.filter-input select {
    width: 100%;
    height: 40px;

    padding:
        0 12px 0 35px;

    border:
        1px solid #e5e7eb;

    border-radius: 9px;

    background: #ffffff;

    color: #111827;

    font-family: inherit;

    font-size: 13px;

    outline: none;

    box-sizing: border-box;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}


.filter-input input:focus,
.filter-input select:focus {
    border-color: #9ca3af;

    box-shadow:
        0 0 0 3px rgba(107, 114, 128, 0.08);
}


.filter-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}


/* =========================================================
   REPORT SUMMARY
   ========================================================= */

.report-summary-grid {
    margin-bottom: 20px;
}


/* =========================================================
   REPORT TABLE
   ========================================================= */

.report-card {
    margin-bottom: 20px;
}


.report-generated {
    display: flex;
    align-items: center;
    gap: 6px;

    font-size: 12px;
    color: #6b7280;

    white-space: nowrap;
}


.report-generated i {
    color: #9ca3af;
}


.report-table tbody tr {
    cursor: default;
}


.report-table tbody tr:hover {
    background: #f9fafb;
}


.report-empty-state {
    padding: 60px 20px !important;

    text-align: center;

    color: #6b7280;
}


.report-empty-state i {
    display: block;

    margin-bottom: 14px;

    font-size: 32px;

    color: #9ca3af;
}


.report-empty-state h3 {
    margin:
        0 0 6px;

    font-size: 16px;

    color: #374151;
}


.report-empty-state p {
    margin: 0;

    font-size: 13px;
}


/* =========================================================
   BUTTONS
   ========================================================= */

.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    min-height: 40px;

    padding:
        0 14px;

    border:
        1px solid #e5e7eb;

    border-radius: 9px;

    background: #ffffff;

    color: #374151;

    font-family: inherit;

    font-size: 13px;

    font-weight: 500;

    text-decoration: none;

    cursor: pointer;

    transition:
        background 0.2s ease,
        border-color 0.2s ease;
}


.btn-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1100px) {

    .report-filters {
        grid-template-columns:
            repeat(2, minmax(180px, 1fr));
    }

    .filter-actions {
        grid-column: span 2;
    }

}


@media (max-width: 700px) {

    .report-filters {
        grid-template-columns: 1fr;
    }

    .filter-actions {
        grid-column: auto;
    }

    .filter-actions .btn {
        flex: 1;
    }

    .report-generated {
        margin-top: 8px;
    }

}


@media (max-width: 600px) {

    .report-header-actions {
        width: 100%;
    }

    .report-header-actions .btn {
        width: 100%;
    }

}

/* =========================================================
   PRINT REPORT
   ========================================================= */

.print-report-header {
    display: none;
}

.print-filter-summary {
    display: none;
}


/* =========================================================
   PRINT MODE
   ========================================================= */

@media print {

    @page {
        size: A4 portrait;
        margin: 15mm;
    }


    /* Hide application UI */

    .sidebar,
    .topbar,
    .page-header,
    .filter-card,
    .report-header-actions,
    .report-summary-grid,
    .btn,
    button,
    .navigation,
    .nav-item {
        display: none !important;
    }


    /* Reset application layout */

    html,
    body {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
    }


    .app,
    .app-layout,
    .main-content,
    .content,
    .page-content {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
    }


    .reports-page {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }


    /* Print Header */

    .print-report-header {
        display: block !important;
        text-align: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid #111827;
    }


    .print-company-name {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #111827;
    }


    .print-report-title {
        margin-top: 4px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.3px;
        color: #374151;
    }


    .print-report-meta {
        margin-top: 5px;
        font-size: 10px;
        color: #6b7280;
    }


    /* Filter Summary */

    .print-filter-summary {
        display: block !important;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #d1d5db;
    }


    .print-filter-summary h4 {
        margin: 0 0 9px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #374151;
    }


    .print-filter-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }


    .print-filter-grid > div {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }


    .print-filter-grid span {
        font-size: 9px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }


    .print-filter-grid strong {
        font-size: 10px;
        font-weight: 600;
        color: #111827;
    }


    /* Report Card */

    .report-card {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: #ffffff !important;
    }


    .report-card .card-header {
        display: flex !important;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 10px;
        padding: 0 !important;
    }


    .report-card .card-header h3 {
        font-size: 13px;
        margin: 0;
    }


    .report-card .card-header p {
        font-size: 10px;
        margin: 3px 0 0;
        color: #6b7280;
    }


    .report-generated {
        font-size: 9px !important;
    }


    /* Table */

    .table-container {
        width: 100% !important;
        overflow: visible !important;
    }


    .report-table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 9px !important;
    }


    .report-table thead {
        display: table-header-group;
    }


    .report-table th {
        padding: 8px 7px !important;
        border-top: 1px solid #111827 !important;
        border-bottom: 1px solid #111827 !important;
        background: #f3f4f6 !important;
        color: #111827 !important;
        font-size: 9px !important;
        font-weight: 700 !important;
        text-align: left;
    }


    .report-table td {
        padding: 7px !important;
        border-bottom: 1px solid #e5e7eb !important;
        color: #374151 !important;
        font-size: 9px !important;
        vertical-align: middle;
    }


    .report-table tbody tr {
        page-break-inside: avoid;
        break-inside: avoid;
    }


    .report-table tbody tr:hover {
        background: transparent !important;
    }


    .project-code {
        font-size: 9px !important;
        color: #111827 !important;
    }


    .project-name-cell span {
        font-size: 9px !important;
    }


    .status-badge {
        display: inline-block !important;
        padding: 3px 7px !important;
        border-radius: 10px !important;
        font-size: 8px !important;
        font-weight: 600 !important;
        border: 1px solid #d1d5db !important;
        background: #ffffff !important;
        color: #374151 !important;
    }


    /* Empty State */

    .report-empty-state {
        padding: 40px 10px !important;
    }


    /* Don't print unnecessary icons */

    .report-table i,
    .report-table .project-arrow,
    .report-table .project-arrow-cell {
        display: none !important;
    }


    /* Footer */

    .reports-page::after {
        content: "Company Project System — Project Report";
        display: block;
        margin-top: 18px;
        padding-top: 8px;
        border-top: 1px solid #d1d5db;
        text-align: center;
        font-size: 8px;
        color: #9ca3af;
    }

}

</style>

@endsection