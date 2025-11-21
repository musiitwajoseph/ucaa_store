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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // What was changed
            $table->string('auditable_type'); // Model name (e.g., "App\Models\Department")
            $table->unsignedBigInteger('auditable_id'); // Record ID
            $table->index(['auditable_type', 'auditable_id']);
            
            // What action was performed
            $table->string('event'); // created, updated, deleted, restored
            
            // Who made the change
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('no action');
            
            // Change details
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values
            
            // Additional context
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->text('url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
