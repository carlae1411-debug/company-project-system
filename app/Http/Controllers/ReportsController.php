<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'status' => 'nullable|in:pending,ongoing,completed',
            'client' => 'nullable|string|max:255',
        ]);

        $query = Project::query();

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        | Filters projects based on their start date.
        */

        if (!empty($validated['from_date'])) {
            $query->whereDate(
                'start_date',
                '>=',
                $validated['from_date']
            );
        }

        if (!empty($validated['to_date'])) {
            $query->whereDate(
                'start_date',
                '<=',
                $validated['to_date']
            );
        }

        


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['status'])) {
            $query->where(
                'status',
                $validated['status']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Client Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['client'])) {
            $query->where(
                'client',
                $validated['client']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Report Projects
        |--------------------------------------------------------------------------
        */

        $projects = $query
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Report Summary
        |--------------------------------------------------------------------------
        */

        $totalProjects = $projects->count();

        $pendingProjects = $projects
            ->where('status', 'pending')
            ->count();

        $ongoingProjects = $projects
            ->where('status', 'ongoing')
            ->count();

        $completedProjects = $projects
            ->where('status', 'completed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Client List
        |--------------------------------------------------------------------------
        | Used by the Client filter dropdown.
        */

        $clients = Project::query()
            ->whereNotNull('client')
            ->where('client', '!=', '')
            ->select('client')
            ->distinct()
            ->orderBy('client')
            ->pluck('client');


        return view('reports.index', compact(
            'projects',
            'clients',
            'totalProjects',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects'
        ));
    }

public function pdf(Request $request)
{
    $validated = $request->validate([
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date|after_or_equal:from_date',
        'status' => 'nullable|in:pending,ongoing,completed',
        'client' => 'nullable|string|max:255',
    ]);

    $query = Project::query();

    if (!empty($validated['from_date'])) {
        $query->whereDate(
            'start_date',
            '>=',
            $validated['from_date']
        );
    }

    if (!empty($validated['to_date'])) {
        $query->whereDate(
            'start_date',
            '<=',
            $validated['to_date']
        );
    }

    if (!empty($validated['status'])) {
        $query->where(
            'status',
            $validated['status']
        );
    }

    if (!empty($validated['client'])) {
        $query->where(
            'client',
            $validated['client']
        );
    }

    $projects = $query
        ->orderByDesc('start_date')
        ->orderByDesc('id')
        ->get();

    $totalProjects = $projects->count();

    $pendingProjects = $projects
        ->where('status', 'pending')
        ->count();

    $ongoingProjects = $projects
        ->where('status', 'ongoing')
        ->count();

    $completedProjects = $projects
        ->where('status', 'completed')
        ->count();

    $pdf = Pdf::loadView(
        'reports.pdf',
        compact(
            'projects',
            'totalProjects',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects'
        )
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->download(
        'project-report-' . now()->format('Y-m-d-His') . '.pdf'
    );
}





    }