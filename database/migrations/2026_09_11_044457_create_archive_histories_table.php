<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_archive';

    public function up(): void
    {
        Schema::connection($this->connection)->create('archive_histories', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('original_project_id');

            $table->string('project_code');
            $table->string('name');
            $table->string('client')->nullable();

            $table->enum('action', [
                'archived',
                'restored'
            ]);

            $table->timestamp('action_at')->nullable();

            $table->unsignedBigInteger('action_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)
            ->dropIfExists('archive_histories');
    }
};