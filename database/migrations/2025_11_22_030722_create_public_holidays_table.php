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
        Schema::create('public_holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('type')->default('public'); // public, internal, religious
            $table->text('description')->nullable();
            $table->boolean('is_recurring')->default(true); // If it recurs every year
            $table->boolean('is_active')->default(true);
            $table->integer('reminder_days')->default(1); // Days before to send reminder
            $table->timestamps();
            
            $table->index('date');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_holidays');
    }
};
