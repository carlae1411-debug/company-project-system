<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ArchivedProject;
use App\Models\ArchiveHistory;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ArchivedProjectController extends Controller
{
    public function index()
    {
        $archivedProjects = ArchivedProject::latest('archived_at')->get();

        return view('archive.index', compact('archivedProjects'));
    }

    public function show(ArchivedProject $archivedProject)
    {
        return view('archive.show', compact('archivedProject'));
    }

    public function restore(ArchivedProject $archivedProject)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Check if project already exists
            |--------------------------------------------------------------------------
            */

            $existingProject = Project::where(
                'project_code',
                $archivedProject->project_code
            )->first();

            if ($existingProject) {
                return redirect()
                    ->route('archive.show', $archivedProject)
                    ->with(
                        'error',
                        'This project already exists in the active project list.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Save project information before deleting archive record
            |--------------------------------------------------------------------------
            */

            $projectCode = $archivedProject->project_code;
            $projectName = $archivedProject->name;

            /*
            |--------------------------------------------------------------------------
            | Restore Project
            |--------------------------------------------------------------------------
            */

            $project = DB::transaction(function () use ($archivedProject) {

                return Project::create([
                    'project_code' => $archivedProject->project_code,
                    'name' => $archivedProject->name,
                    'client' => $archivedProject->client,
                    'description' => $archivedProject->description,
                    'status' => $archivedProject->status,
                    'start_date' => $archivedProject->start_date,
                    'end_date' => $archivedProject->end_date,
                ]);
            });

            /*
            |--------------------------------------------------------------------------
            | Archive History
            |--------------------------------------------------------------------------
            */

            ArchiveHistory::create([
                'original_project_id' => $archivedProject->original_project_id,
                'project_code' => $archivedProject->project_code,
                'name' => $archivedProject->name,
                'client' => $archivedProject->client,
                'description' => $archivedProject->description,
                'action' => 'restored',
                'action_at' => now(),
                'action_by' => auth()->user()->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::record(
                'restored_project',
                'Restored project ' .
                $projectCode .
                ' - ' .
                $projectName
            );

            /*
            |--------------------------------------------------------------------------
            | Remove Project from Archive
            |--------------------------------------------------------------------------
            */

            $archivedProject->delete();

            return redirect()
                ->route('projects.show', $project)
                ->with(
                    'success',
                    'Project restored successfully.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('archive.show', $archivedProject)
                ->with(
                    'error',
                    'Unable to restore project. Please try again.'
                );
        }
    }

    public function destroy(ArchivedProject $archivedProject)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Save project information before permanent deletion
            |--------------------------------------------------------------------------
            */

            $projectCode = $archivedProject->project_code;
            $projectName = $archivedProject->name;

            /*
            |--------------------------------------------------------------------------
            | Archive History + Permanent Delete
            |--------------------------------------------------------------------------
            */

            DB::connection('mysql_archive')->transaction(function () use ($archivedProject) {

                ArchiveHistory::create([
                    'original_project_id' => $archivedProject->original_project_id,
                    'project_code' => $archivedProject->project_code,
                    'name' => $archivedProject->name,
                    'client' => $archivedProject->client,
                    'description' => $archivedProject->description,
                    'action' => 'permanently_deleted',
                    'action_at' => now(),
                    'action_by' => auth()->user()->id,
                ]);

                $archivedProject->delete();
            });

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::record(
                'permanently_deleted_project',
                'Permanently deleted project ' .
                $projectCode .
                ' - ' .
                $projectName
            );

            return redirect()
                ->route('archive.index')
                ->with(
                    'success',
                    'Project permanently deleted.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('archive.show', $archivedProject)
                ->with(
                    'error',
                    'Unable to permanently delete project. Please try again.'
                );
        }
    }

    public function history()
    {
        $histories = ArchiveHistory::latest('action_at')->get();

        $userIds = $histories
            ->pluck('action_by')
            ->filter()
            ->unique()
            ->values();

        $users = User::whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        return view('archive.history', compact('histories', 'users'));
    }
}