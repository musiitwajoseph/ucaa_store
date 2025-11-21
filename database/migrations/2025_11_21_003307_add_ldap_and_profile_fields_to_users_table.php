<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Basic Information
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('username')->unique()->nullable()->after('email');
            
            // LDAP Fields
            $table->string('guid')->unique()->nullable()->after('password')->comment('LDAP GUID');
            $table->string('domain')->nullable()->after('guid')->comment('LDAP Domain');
            $table->text('ldap_dn')->nullable()->after('domain')->comment('LDAP Distinguished Name');
            $table->timestamp('ldap_synced_at')->nullable()->after('ldap_dn');
            
            // Contact Information
            $table->string('phone', 20)->nullable()->after('ldap_synced_at');
            $table->string('mobile', 20)->nullable()->after('phone');
            $table->string('address')->nullable()->after('mobile');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('state');
            $table->string('postal_code', 20)->nullable()->after('country');
            
            // Organization Information
            $table->string('department')->nullable()->after('postal_code');
            $table->string('job_title')->nullable()->after('department');
            $table->string('employee_id')->unique()->nullable()->after('job_title');
            $table->unsignedBigInteger('manager_id')->nullable()->after('employee_id');
            $table->string('office_location')->nullable()->after('manager_id');
            
            // Profile Information
            $table->string('avatar')->nullable()->after('office_location');
            $table->text('bio')->nullable()->after('avatar');
            $table->date('date_of_birth')->nullable()->after('bio');
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable()->after('date_of_birth');
            
            // Account Status
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active')->after('gender');
            $table->boolean('is_active')->default(true)->after('status');
            $table->boolean('is_admin')->default(false)->after('is_active');
            $table->boolean('is_ldap_user')->default(false)->after('is_admin');
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            
            // Preferences
            $table->string('locale', 10)->default('en')->after('remember_token');
            $table->string('timezone', 50)->default('UTC')->after('locale');
            $table->string('theme', 20)->default('light')->after('timezone');
            
            // Soft Deletes
            $table->softDeletes()->after('updated_at');
            
            // Indexes for performance
            $table->index('username');
            $table->index('employee_id');
            $table->index('department');
            $table->index(['is_active', 'status']);
            $table->index('guid');
        });
        
        // Create default users
        $this->createDefaultUsers();
    }
    
    /**
     * Create default users
     */
    private function createDefaultUsers(): void
    {
        $now = now();
        
        // Admin User
        DB::table('users')->insert([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => $now,
            'is_active' => true,
            'is_admin' => true,
            'is_ldap_user' => false,
            'status' => 'active',
            'department' => 'IT',
            'job_title' => 'System Administrator',
            'employee_id' => 'EMP001',
            'phone' => '+1-555-0100',
            'office_location' => 'Main Office',
            'locale' => 'en',
            'timezone' => 'UTC',
            'theme' => 'light',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
        // Regular User
        DB::table('users')->insert([
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'username' => 'john.doe',
            'password' => Hash::make('password'),
            'email_verified_at' => $now,
            'is_active' => true,
            'is_admin' => false,
            'is_ldap_user' => false,
            'status' => 'active',
            'department' => 'Sales',
            'job_title' => 'Sales Manager',
            'employee_id' => 'EMP002',
            'phone' => '+1-555-0101',
            'office_location' => 'Main Office',
            'locale' => 'en',
            'timezone' => 'UTC',
            'theme' => 'light',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
        // LDAP User Example
        DB::table('users')->insert([
            'name' => 'Jane Smith',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'username' => 'jane.smith',
            'email_verified_at' => $now,
            'is_active' => true,
            'is_admin' => false,
            'is_ldap_user' => true,
            'status' => 'active',
            'department' => 'Marketing',
            'job_title' => 'Marketing Director',
            'employee_id' => 'EMP003',
            'phone' => '+1-555-0102',
            'office_location' => 'Branch Office',
            'guid' => 'ldap-guid-example-123',
            'ldap_dn' => 'cn=jane.smith,ou=users,dc=example,dc=com',
            'domain' => 'example.com',
            'ldap_synced_at' => $now,
            'locale' => 'en',
            'timezone' => 'UTC',
            'theme' => 'light',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop unique constraints first
            $table->dropUnique(['username']);
            $table->dropUnique(['employee_id']);
            $table->dropUnique(['guid']);
            
            // Drop regular indexes
            $table->dropIndex(['username']);
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['guid']);
            $table->dropIndex(['department']);
            $table->dropIndex(['is_active', 'status']);
            
            // Drop columns
            $table->dropColumn([
                'first_name',
                'last_name',
                'username',
                'guid',
                'domain',
                'ldap_dn',
                'ldap_synced_at',
                'phone',
                'mobile',
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'department',
                'job_title',
                'employee_id',
                'manager_id',
                'office_location',
                'avatar',
                'bio',
                'date_of_birth',
                'gender',
                'status',
                'is_active',
                'is_admin',
                'is_ldap_user',
                'last_login_at',
                'last_login_ip',
                'locale',
                'timezone',
                'theme',
                'deleted_at',
            ]);
        });
    }
};
