<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ArchivedProject;
use App\Models\ArchiveHistory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|max:255|unique:projects,project_code',
            'name' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,ongoing,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project = Project::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::record(
            'created_project',
            'Created project ' .
            $project->project_code .
            ' - ' .
            $project->name
        );

        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project created successfully.'
            );
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|max:255|unique:projects,project_code,' . $project->id,
            'name' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,ongoing,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $oldProjectCode = $project->project_code;
        $oldProjectName = $project->name;

        $project->update($validated);

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::record(
            'updated_project',
            'Updated project ' .
            $oldProjectCode .
            ' - ' .
            $oldProjectName
        );

        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project updated successfully.'
            );
    }

    public function archive(Project $project)
    {
        try {

            DB::connection('mysql_archive')->transaction(function () use ($project) {

                ArchivedProject::create([
                    'original_project_id' => $project->id,
                    'project_code' => $project->project_code,
                    'name' => $project->name,
                    'client' => $project->client,
                    'description' => $project->description,
                    'status' => $project->status,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'archived_at' => now(),
                    'archived_by' => auth()->user()->id,
                ]);

                ArchiveHistory::create([
                    'original_project_id' => $project->id,
                    'project_code' => $project->project_code,
                    'name' => $project->name,
                    'client' => $project->client,
                    'action' => 'archived',
                    'action_at' => now(),
                    'action_by' => auth()->user()->id,
                ]);
            });

            /*
            |--------------------------------------------------------------------------
            | Delete from Active Projects
            |--------------------------------------------------------------------------
            */

            $projectCode = $project->project_code;
            $projectName = $project->name;

            $project->delete();

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::record(
                'archived_project',
                'Archived project ' .
                $projectCode .
                ' - ' .
                $projectName
            );

            return redirect()
                ->route('projects.index')
                ->with(
                    'success',
                    'Project archived successfully.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('projects.show', $project)
                ->with(
                    'error',
                    'Unable to archive project. Please try again.'
                );
        }
    }

    public function destroy(Project $project)
    {
        /*
        |--------------------------------------------------------------------------
        | Save project information before deletion
        |--------------------------------------------------------------------------
        */

        $projectCode = $project->project_code;
        $projectName = $project->name;

        $project->delete();

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::record(
            'deleted_project',
            'Deleted project ' .
            $projectCode .
            ' - ' .
            $projectName
        );

        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project deleted successfully.'
            );
    }
}