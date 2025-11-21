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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 'create_department'
            $table->string('name'); // e.g., 'Create Department'
            $table->string('module'); // e.g., 'departments', 'users', 'stores'
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Audit fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('no action');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
