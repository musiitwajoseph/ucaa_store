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
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room_number')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Audit fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('no action');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_locations');
    }
};
