<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            // Polymorphic relationship
            $table->unsignedBigInteger('attachable_id');
            $table->string('attachable_type');

            // File information
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // User who uploaded
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->unsignedBigInteger('level')->nullable();

            $table->timestamps();

            // Foreign key for uploaded_by
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Index for morph lookup
            $table->index(['attachable_id', 'attachable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
