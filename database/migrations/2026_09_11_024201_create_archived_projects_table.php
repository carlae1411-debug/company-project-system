<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The database connection that this migration should use.
     */
    protected $connection = 'mysql_archive';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('archived_projects', function (Blueprint $table) {
            $table->id();

            // Original project information
            $table->unsignedBigInteger('original_project_id');
            $table->string('project_code');
            $table->string('name');
            $table->string('client')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', [
                'pending',
                'ongoing',
                'completed'
            ])->default('pending');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Archive information
            $table->timestamp('archived_at')->nullable();
            $table->unsignedBigInteger('archived_by')->nullable();

            $table->timestamps();

            // Prevent the same original project from being archived twice
            $table->unique('original_project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)
            ->dropIfExists('archived_projects');
    }
};