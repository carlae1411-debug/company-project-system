<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ArchivedProjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ActivityLogController;


Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');




Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'prevent.back'])
    ->name('dashboard');



Route::get('/reports', [ReportsController::class, 'index'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('reports.index');

Route::get('/reports/pdf', [ReportsController::class, 'pdf'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('reports.pdf');

Route::get('/projects/create', [ProjectController::class, 'create'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('projects.create');

Route::post('/projects', [ProjectController::class, 'store'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('projects.store');

Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('projects.edit');

Route::put('/projects/{project}', [ProjectController::class, 'update'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('projects.update');

Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator,manager',
    ])
    ->name('projects.archive');

Route::get('/projects', [ProjectController::class, 'index'])
    ->middleware([
        'auth',
        'prevent.back',
    ])
    ->name('projects.index');

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->middleware([
        'auth',
        'prevent.back',
    ])
    ->name('projects.show');

Route::get('/archive', [ArchiveController::class, 'index'])
    ->middleware(['auth', 'prevent.back', 'role:administrator,manager'])
    ->name('archive.index');

Route::get('/archive/history', [ArchivedProjectController::class, 'history'])
    ->middleware(['auth', 'prevent.back', 'role:administrator,manager'])
    ->name('archive.history');

Route::get('/archive/{archivedProject}', [ArchivedProjectController::class, 'show'])
    ->middleware(['auth', 'prevent.back', 'role:administrator,manager'])
    ->name('archive.show');

Route::post('/archive/{archivedProject}/restore', [ArchivedProjectController::class, 'restore'])
    ->middleware(['auth', 'prevent.back', 'role:administrator'])
    ->name('archive.restore');

Route::delete('/archive/{archivedProject}', [ArchivedProjectController::class, 'destroy'])
    ->middleware(['auth', 'prevent.back', 'role:administrator'])
    ->name('archive.destroy'); 


Route::resource('users', UserController::class)
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator',
    ]);

    Route::get('/user-logs', [ActivityLogController::class, 'index'])
    ->middleware([
        'auth',
        'prevent.back',
        'role:administrator',
    ])
    ->name('activity_logs.index');