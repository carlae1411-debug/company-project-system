<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Project Report</title>

    <style>

        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111827;
            margin: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .report-title {
            margin-top: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .generated {
            margin-top: 5px;
            font-size: 9px;
            color: #6b7280;
        }

        .filter-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .filters {
            width: 100%;
            margin-bottom: 18px;
        }

        .filters td {
            width: 33.33%;
            padding-right: 10px;
            vertical-align: top;
        }

        .filter-label {
            display: block;
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .filter-value {
            font-size: 9px;
            font-weight: bold;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: center;
        }

        .summary-label {
            display: block;
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        table.projects {
            width: 100%;
            border-collapse: collapse;
        }

        table.projects th {
            background: #f3f4f6;
            border-top: 1px solid #111827;
            border-bottom: 1px solid #111827;
            padding: 7px 6px;
            text-align: left;
            font-size: 8px;
        }

        table.projects td {
            border-bottom: 1px solid #e5e7eb;
            padding: 7px 6px;
            font-size: 8px;
        }

        .status {
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
        }

    </style>

</head>


<body>


<div class="header">

    <div class="company-name">
        WDC Project Directory
    </div>

    <div class="report-title">
        PROJECT REPORT
    </div>

    <div class="generated">
        Generated:
        {{ now()->format('F d, Y h:i A') }}
    </div>

</div>


<div class="filter-title">
    Report Filters
</div>


<table class="filters">

    <tr>

        <td>

            <span class="filter-label">
                Date Range
            </span>

            <span class="filter-value">

                @if(request('from_date') || request('to_date'))

                    {{ request('from_date')
                        ? \Carbon\Carbon::parse(request('from_date'))->format('M d, Y')
                        : 'Any' }}

                    –

                    {{ request('to_date')
                        ? \Carbon\Carbon::parse(request('to_date'))->format('M d, Y')
                        : 'Any' }}

                @else

                    All Dates

                @endif

            </span>

        </td>


        <td>

            <span class="filter-label">
                Status
            </span>

            <span class="filter-value">

                {{ request('status')
                    ? ucfirst(request('status'))
                    : 'All Statuses' }}

            </span>

        </td>


        <td>

            <span class="filter-label">
                Client
            </span>

            <span class="filter-value">

                {{ request('client') ?: 'All Clients' }}

            </span>

        </td>

    </tr>

</table>


<table class="summary">

    <tr>

        <td>

            <span class="summary-label">
                Total Projects
            </span>

            <span class="summary-value">
                {{ $totalProjects }}
            </span>

        </td>


        <td>

            <span class="summary-label">
                Pending
            </span>

            <span class="summary-value">
                {{ $pendingProjects }}
            </span>

        </td>


        <td>

            <span class="summary-label">
                Ongoing
            </span>

            <span class="summary-value">
                {{ $ongoingProjects }}
            </span>

        </td>


        <td>

            <span class="summary-label">
                Completed
            </span>

            <span class="summary-value">
                {{ $completedProjects }}
            </span>

        </td>

    </tr>

</table>


<div class="section-title">
    Project Details
</div>


<table class="projects">

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
                    {{ $project->project_code }}
                </td>

                <td>
                    {{ $project->name }}
                </td>

                <td>
                    {{ $project->client ?? '—' }}
                </td>

                <td class="status">
                    {{ ucfirst($project->status) }}
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
                    class="empty"
                >
                    No projects found.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


<div class="footer">

    WDC Project Directory Report

</div>


</body>

</html>