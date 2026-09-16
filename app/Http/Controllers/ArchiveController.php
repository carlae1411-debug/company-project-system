<?php

namespace App\Http\Controllers;

use App\Models\ArchivedProject;

class ArchiveController extends Controller
{
    public function index()
    {
        $archivedProjects = ArchivedProject::latest('archived_at')->get();

        return view('archive.index', compact('archivedProjects'));
    }
}