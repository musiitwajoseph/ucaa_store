<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (local authentication)
        User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'is_active' => true,
            'is_admin' => true,
            'is_ldap_user' => false,
            'status' => 'active',
            'department' => 'IT',
            'job_title' => 'System Administrator',
            'employee_id' => 'EMP001',
            'phone' => '+1-555-0100',
            'office_location' => 'Main Office',
            'email_verified_at' => now(),
        ]);

        // Create regular user (local authentication)
        User::create([
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'username' => 'john.doe',
            'password' => Hash::make('password'),
            'is_active' => true,
            'is_admin' => false,
            'is_ldap_user' => false,
            'status' => 'active',
            'department' => 'Sales',
            'job_title' => 'Sales Manager',
            'employee_id' => 'EMP002',
            'phone' => '+1-555-0101',
            'office_location' => 'Main Office',
            'email_verified_at' => now(),
        ]);

        // Create LDAP user example (no password set)
        User::create([
            'name' => 'Jane Smith',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'username' => 'jane.smith',
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
            'ldap_synced_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create additional test users
        User::factory(10)->create();
    }
}
