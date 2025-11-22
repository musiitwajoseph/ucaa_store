<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Create system user first for created_by foreign key
        if (!DB::table('users')->where('code', 'USR-000')->exists()) {
            DB::table('users')->insert([
                'code' => 'USR-000',
                'username' => 'system',
                'name' => 'System Administrator',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'email' => 'system@ucaa.go.ug',
                'password' => Hash::make('System@123'),
                'is_active' => true,
                'is_admin' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Seed Departments
        $departments = [
            ['code' => 'DEPT-001', 'name' => 'Human Resources', 'description' => 'Manages employee relations and organizational development', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-002', 'name' => 'Information Technology', 'description' => 'Manages IT infrastructure and systems', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-003', 'name' => 'Finance', 'description' => 'Handles financial operations and accounting', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-004', 'name' => 'Operations', 'description' => 'Manages daily operational activities', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-005', 'name' => 'Legal Affairs', 'description' => 'Handles legal matters and compliance', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-006', 'name' => 'Procurement', 'description' => 'Manages procurement and supply chain', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-007', 'name' => 'Air Transport Regulation', 'description' => 'Regulates air transport operations', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-008', 'name' => 'Safety and Security', 'description' => 'Ensures aviation safety and security standards', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-009', 'name' => 'Air Navigation Services', 'description' => 'Provides air navigation services', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-010', 'name' => 'Aerodrome Standards', 'description' => 'Sets and monitors aerodrome standards', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-011', 'name' => 'Quality Assurance', 'description' => 'Ensures quality standards across operations', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DEPT-012', 'name' => 'Internal Audit', 'description' => 'Conducts internal audits and risk management', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('departments')->insert($departments);

        // Seed Job Titles
        $jobTitles = [
            ['code' => 'JOB-001', 'title' => 'Director General', 'description' => 'Chief Executive Officer', 'level' => 'Executive', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-002', 'title' => 'Director', 'description' => 'Department Director', 'level' => 'Senior Management', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-003', 'title' => 'Manager', 'description' => 'Department Manager', 'level' => 'Management', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-004', 'title' => 'Senior Officer', 'description' => 'Senior level officer', 'level' => 'Senior', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-005', 'title' => 'Officer', 'description' => 'Mid-level officer', 'level' => 'Mid', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-006', 'title' => 'Assistant Officer', 'description' => 'Junior level officer', 'level' => 'Junior', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-007', 'title' => 'IT Specialist', 'description' => 'Information Technology Specialist', 'level' => 'Mid', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-008', 'title' => 'Accountant', 'description' => 'Financial Accountant', 'level' => 'Mid', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-009', 'title' => 'Legal Advisor', 'description' => 'Legal and Compliance Advisor', 'level' => 'Senior', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-010', 'title' => 'HR Officer', 'description' => 'Human Resources Officer', 'level' => 'Mid', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-011', 'title' => 'Procurement Officer', 'description' => 'Procurement and Supplies Officer', 'level' => 'Mid', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'JOB-012', 'title' => 'Aviation Inspector', 'description' => 'Aviation Safety Inspector', 'level' => 'Senior', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('job_titles')->insert($jobTitles);

        // Seed Office Locations
        $officeLocations = [
            ['code' => 'LOC-001', 'name' => 'Head Office - Kampala', 'building' => 'CAA Building', 'floor' => 'Ground', 'room_number' => 'G-01', 'address' => 'Plot 10, Buganda Road, Kampala', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-002', 'name' => 'Entebbe International Airport Office', 'building' => 'Terminal Building', 'floor' => '2nd', 'room_number' => '201', 'address' => 'Entebbe Airport, Entebbe', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-003', 'name' => 'Gulu Regional Office', 'building' => 'Airport Office', 'floor' => '1st', 'room_number' => '101', 'address' => 'Airport Road, Gulu', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-004', 'name' => 'Arua Regional Office', 'building' => 'Airport Complex', 'floor' => 'Ground', 'room_number' => 'G-10', 'address' => 'Arua Airport, Arua', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-005', 'name' => 'Mbarara Regional Office', 'building' => 'Regional Office', 'floor' => '1st', 'room_number' => '105', 'address' => 'Airport Road, Mbarara', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-006', 'name' => 'Soroti Regional Office', 'building' => 'Airport Building', 'floor' => 'Ground', 'room_number' => 'G-05', 'address' => 'Soroti Airport, Soroti', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-007', 'name' => 'Kasese Regional Office', 'building' => 'Airport Office', 'floor' => '1st', 'room_number' => '102', 'address' => 'Kasese Airport, Kasese', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-008', 'name' => 'Jinja Office', 'building' => 'City Office', 'floor' => '2nd', 'room_number' => '205', 'address' => 'Main Street, Jinja', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-009', 'name' => 'Kidepo Valley Office', 'building' => 'Field Office', 'floor' => 'Ground', 'room_number' => 'G-01', 'address' => 'Kidepo Valley, Kaabong', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-010', 'name' => 'Pakuba Airfield Office', 'building' => 'Airfield Building', 'floor' => 'Ground', 'room_number' => 'G-03', 'address' => 'Murchison Falls, Pakuba', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-011', 'name' => 'Training Center - Entebbe', 'building' => 'Training Complex', 'floor' => '1st', 'room_number' => '110', 'address' => 'Near Entebbe Airport', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LOC-012', 'name' => 'Warehouse - Kampala', 'building' => 'Storage Facility', 'floor' => 'Ground', 'room_number' => 'W-01', 'address' => 'Industrial Area, Kampala', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('office_locations')->insert($officeLocations);

        // Seed Roles
        $roles = [
            ['code' => 'ROLE-001', 'name' => 'Super Administrator', 'description' => 'Full system access with all permissions', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-002', 'name' => 'Administrator', 'description' => 'System administrator with most permissions', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-003', 'name' => 'Manager', 'description' => 'Department manager role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-004', 'name' => 'HR Officer', 'description' => 'Human resources officer role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-005', 'name' => 'Finance Officer', 'description' => 'Finance and accounting role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-006', 'name' => 'Procurement Officer', 'description' => 'Procurement and supplies role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-007', 'name' => 'Store Keeper', 'description' => 'Store and inventory management role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-008', 'name' => 'Viewer', 'description' => 'Read-only access role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-009', 'name' => 'IT Support', 'description' => 'IT support and maintenance role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-010', 'name' => 'Auditor', 'description' => 'Internal audit role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-011', 'name' => 'Legal Officer', 'description' => 'Legal and compliance role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROLE-012', 'name' => 'Operations Officer', 'description' => 'Daily operations role', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('roles')->insert($roles);

        // Seed Modules
        $modules = [
            ['code' => 'MOD-001', 'name' => 'System Administration', 'description' => 'System administration and configuration', 'icon' => 'ph-gear-six', 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'MOD-002', 'name' => 'Store Management', 'description' => 'Store and inventory management', 'icon' => 'ph-package', 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('modules')->insert($modules);

        // Seed Permissions (assuming modules table exists)
        $permissions = [
            ['code' => 'PERM-001', 'name' => 'View Dashboard', 'description' => 'Access to dashboard', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-002', 'name' => 'Manage Users', 'description' => 'Create, edit, delete users', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-003', 'name' => 'Manage Roles', 'description' => 'Create, edit, delete roles', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-004', 'name' => 'Manage Departments', 'description' => 'Create, edit, delete departments', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-005', 'name' => 'View Reports', 'description' => 'Access to system reports', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-006', 'name' => 'Manage Inventory', 'description' => 'Manage store inventory', 'module_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-007', 'name' => 'Process Requisitions', 'description' => 'Create and process requisitions', 'module_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-008', 'name' => 'Approve Requisitions', 'description' => 'Approve or reject requisitions', 'module_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-009', 'name' => 'Manage Suppliers', 'description' => 'Manage supplier information', 'module_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-010', 'name' => 'View Audit Logs', 'description' => 'Access to system audit logs', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-011', 'name' => 'Export Data', 'description' => 'Export system data', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PERM-012', 'name' => 'System Configuration', 'description' => 'Configure system settings', 'module_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('permissions')->insert($permissions);

        // Seed Users
        $users = [
            ['code' => 'USR-001', 'name' => 'System Administrator', 'first_name' => 'System', 'last_name' => 'Administrator', 'email' => 'admin@caa.go.ug', 'username' => 'admin', 'password' => Hash::make('password'), 'phone' => '+256-414-349000', 'mobile' => '+256-700-000001', 'employee_id' => 'EMP001', 'department_id' => 2, 'job_title_id' => 1, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => true, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-002', 'name' => 'John Mukasa', 'first_name' => 'John', 'last_name' => 'Mukasa', 'email' => 'john.mukasa@caa.go.ug', 'username' => 'jmukasa', 'password' => Hash::make('password'), 'phone' => '+256-414-349001', 'mobile' => '+256-700-000002', 'employee_id' => 'EMP002', 'department_id' => 1, 'job_title_id' => 3, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-003', 'name' => 'Sarah Nakato', 'first_name' => 'Sarah', 'last_name' => 'Nakato', 'email' => 'sarah.nakato@caa.go.ug', 'username' => 'snakato', 'password' => Hash::make('password'), 'phone' => '+256-414-349002', 'mobile' => '+256-700-000003', 'employee_id' => 'EMP003', 'department_id' => 3, 'job_title_id' => 8, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-004', 'name' => 'David Okello', 'first_name' => 'David', 'last_name' => 'Okello', 'email' => 'david.okello@caa.go.ug', 'username' => 'dokello', 'password' => Hash::make('password'), 'phone' => '+256-414-349003', 'mobile' => '+256-700-000004', 'employee_id' => 'EMP004', 'department_id' => 2, 'job_title_id' => 7, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-005', 'name' => 'Mary Namukasa', 'first_name' => 'Mary', 'last_name' => 'Namukasa', 'email' => 'mary.namukasa@caa.go.ug', 'username' => 'mnamukasa', 'password' => Hash::make('password'), 'phone' => '+256-414-349004', 'mobile' => '+256-700-000005', 'employee_id' => 'EMP005', 'department_id' => 6, 'job_title_id' => 11, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-006', 'name' => 'Peter Wasswa', 'first_name' => 'Peter', 'last_name' => 'Wasswa', 'email' => 'peter.wasswa@caa.go.ug', 'username' => 'pwasswa', 'password' => Hash::make('password'), 'phone' => '+256-414-349005', 'mobile' => '+256-700-000006', 'employee_id' => 'EMP006', 'department_id' => 8, 'job_title_id' => 12, 'office_location_id' => 2, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-007', 'name' => 'Grace Atim', 'first_name' => 'Grace', 'last_name' => 'Atim', 'email' => 'grace.atim@caa.go.ug', 'username' => 'gatim', 'password' => Hash::make('password'), 'phone' => '+256-471-432101', 'mobile' => '+256-700-000007', 'employee_id' => 'EMP007', 'department_id' => 4, 'job_title_id' => 5, 'office_location_id' => 3, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-008', 'name' => 'James Ongom', 'first_name' => 'James', 'last_name' => 'Ongom', 'email' => 'james.ongom@caa.go.ug', 'username' => 'jongom', 'password' => Hash::make('password'), 'phone' => '+256-476-420301', 'mobile' => '+256-700-000008', 'employee_id' => 'EMP008', 'department_id' => 7, 'job_title_id' => 4, 'office_location_id' => 4, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-009', 'name' => 'Rebecca Kiggundu', 'first_name' => 'Rebecca', 'last_name' => 'Kiggundu', 'email' => 'rebecca.kiggundu@caa.go.ug', 'username' => 'rkiggundu', 'password' => Hash::make('password'), 'phone' => '+256-485-420401', 'mobile' => '+256-700-000009', 'employee_id' => 'EMP009', 'department_id' => 5, 'job_title_id' => 9, 'office_location_id' => 5, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-010', 'name' => 'Patrick Opio', 'first_name' => 'Patrick', 'last_name' => 'Opio', 'email' => 'patrick.opio@caa.go.ug', 'username' => 'popio', 'password' => Hash::make('password'), 'phone' => '+256-454-461201', 'mobile' => '+256-700-000010', 'employee_id' => 'EMP010', 'department_id' => 9, 'job_title_id' => 5, 'office_location_id' => 6, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-011', 'name' => 'Agnes Namuli', 'first_name' => 'Agnes', 'last_name' => 'Namuli', 'email' => 'agnes.namuli@caa.go.ug', 'username' => 'anamuli', 'password' => Hash::make('password'), 'phone' => '+256-414-349006', 'mobile' => '+256-700-000011', 'employee_id' => 'EMP011', 'department_id' => 1, 'job_title_id' => 10, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'USR-012', 'name' => 'Robert Ssentongo', 'first_name' => 'Robert', 'last_name' => 'Ssentongo', 'email' => 'robert.ssentongo@caa.go.ug', 'username' => 'rssentongo', 'password' => Hash::make('password'), 'phone' => '+256-414-349007', 'mobile' => '+256-700-000012', 'employee_id' => 'EMP012', 'department_id' => 12, 'job_title_id' => 4, 'office_location_id' => 1, 'is_active' => true, 'is_admin' => false, 'is_ldap_user' => false, 'created_at' => $now, 'updated_at' => $now],
        ];
        
        // Insert users one by one to avoid GUID unique constraint issues
        foreach ($users as $user) {
            if (!DB::table('users')->where('code', $user['code'])->exists()) {
                DB::table('users')->insert($user);
            }
        }

        $this->command->info('Master data seeded successfully!');
    }
}


