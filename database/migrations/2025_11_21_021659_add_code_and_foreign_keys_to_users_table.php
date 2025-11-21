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
        // Check if code column doesn't exist before adding
        if (!Schema::hasColumn('users', 'code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('code')->nullable()->after('id');
            });
            
            // Create a filtered unique index for SQL Server (only indexes non-NULL values)
            DB::statement("CREATE UNIQUE INDEX users_code_unique ON users(code) WHERE code IS NOT NULL");
        }
        
        // Use raw SQL to drop indexes if they exist (SQL Server compatible)
        DB::statement("IF EXISTS (SELECT * FROM sys.indexes WHERE name = 'users_department_index' AND object_id = OBJECT_ID('users')) DROP INDEX users_department_index ON users");
        DB::statement("IF EXISTS (SELECT * FROM sys.indexes WHERE name = 'users_job_title_index' AND object_id = OBJECT_ID('users')) DROP INDEX users_job_title_index ON users");
        DB::statement("IF EXISTS (SELECT * FROM sys.indexes WHERE name = 'users_office_location_index' AND object_id = OBJECT_ID('users')) DROP INDEX users_office_location_index ON users");
        
        Schema::table('users', function (Blueprint $table) {
            // Remove old string columns if they exist
            if (Schema::hasColumn('users', 'job_title')) {
                $table->dropColumn('job_title');
            }
            if (Schema::hasColumn('users', 'department')) {
                $table->dropColumn('department');
            }
            if (Schema::hasColumn('users', 'office_location')) {
                $table->dropColumn('office_location');
            }
            
            // Add foreign keys if they don't exist
            if (!Schema::hasColumn('users', 'job_title_id')) {
                $table->foreignId('job_title_id')->nullable()->after('email_verified_at')->constrained('job_titles')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->foreignId('department_id')->nullable()->after('job_title_id')->constrained('departments')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'office_location_id')) {
                $table->foreignId('office_location_id')->nullable()->after('department_id')->constrained('office_locations')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['job_title_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['office_location_id']);
            
            $table->dropColumn(['code', 'job_title_id', 'department_id', 'office_location_id']);
            
            // Restore old string columns
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('office_location')->nullable();
        });
    }
};
