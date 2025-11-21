<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique constraint on guid
            $table->dropUnique('users_guid_unique');
        });
        
        // Create a filtered unique index (only for non-null values)
        // This allows multiple null values but ensures uniqueness for non-null GUIDs
        DB::statement('CREATE UNIQUE INDEX users_guid_unique ON users(guid) WHERE guid IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the filtered index
        DB::statement('DROP INDEX users_guid_unique ON users');
        
        Schema::table('users', function (Blueprint $table) {
            // Recreate the original unique constraint
            $table->unique('guid');
        });
    }
};
