<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ArchivedProject extends Model
{
    protected $connection = 'mysql_archive';
    protected $table = 'archived_projects';

    protected $fillable = [
        'original_project_id',
        'project_code',
        'name',
        'client',
        'description',
        'status',
        'start_date',
        'end_date',
        'archived_at',
        'archived_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'archived_at' => 'datetime',
    ];

    public function getArchivedByNameAttribute()
{
    if (! $this->archived_by) {
        return 'Unknown User';
    }

    return User::on('mysql')
        ->where('id', $this->archived_by)
        ->value('name') ?? 'Unknown User';
}
}