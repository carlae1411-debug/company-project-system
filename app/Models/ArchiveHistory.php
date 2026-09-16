<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveHistory extends Model
{
    protected $connection = 'mysql_archive';

    protected $table = 'archive_histories';

    protected $fillable = [
        'original_project_id',
        'project_code',
        'name',
        'client',
        'action',
        'action_at',
        'action_by',
    ];

    protected $casts = [
        'action_at' => 'datetime',
    ];
}