<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_archive';

    public function up(): void
    {
        Schema::connection($this->connection)
            ->table('archive_histories', function (Blueprint $table) {
                $table->string('action')->change();
            });
    }

    public function down(): void
    {
        //
    }
};