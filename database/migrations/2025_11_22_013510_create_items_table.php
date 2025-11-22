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
        Schema::create('master_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('master_data_categories')->onDelete('set null');
            $table->string('code', 100)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type', 50)->nullable()->index();
            $table->string('unit', 50)->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->json('metadata')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'type']);
            $table->index(['is_active', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_data');
    }
};
