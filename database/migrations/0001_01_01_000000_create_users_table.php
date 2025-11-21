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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            
            // LDAP Fields
            $table->string('guid')->unique()->nullable()->comment('LDAP GUID');
            $table->string('domain')->nullable()->comment('LDAP Domain');
            $table->text('ldap_dn')->nullable()->comment('LDAP Distinguished Name');
            $table->timestamp('ldap_synced_at')->nullable();
            
            // Contact Information
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            
            // Organization Information
            $table->string('department')->nullable();
            $table->string('job_title')->nullable();
            $table->string('employee_id')->unique()->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('office_location')->nullable();
            
            // Profile Information
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            
            // Account Status
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_ldap_user')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            
            // Preferences
            $table->string('locale', 10)->default('en');
            $table->string('timezone', 50)->default('UTC');
            $table->string('theme', 20)->default('light');
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('email');
            $table->index('username');
            $table->index('employee_id');
            $table->index('department');
            $table->index(['is_active', 'status']);
            $table->index('guid');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
