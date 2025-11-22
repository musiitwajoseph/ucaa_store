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

        // Seed Master Data Categories
        $categories = [
            ['code' => 'COUNTRY', 'name' => 'Countries', 'description' => 'List of countries', 'icon' => 'ph ph-globe', 'color' => '#3b82f6', 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'CURRENCY', 'name' => 'Currencies', 'description' => 'List of currencies', 'icon' => 'ph ph-currency-circle-dollar', 'color' => '#10b981', 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'UOM', 'name' => 'Units of Measure', 'description' => 'Measurement units', 'icon' => 'ph ph-ruler', 'color' => '#f59e0b', 'display_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('master_data_categories')->insert($categories);

        // Get category IDs
        $countryCategory = DB::table('master_data_categories')->where('code', 'COUNTRY')->first();
        $currencyCategory = DB::table('master_data_categories')->where('code', 'CURRENCY')->first();
        $uomCategory = DB::table('master_data_categories')->where('code', 'UOM')->first();

        // Seed Countries
        $countries = [
            ['category_id' => $countryCategory->id, 'code' => 'UG', 'name' => 'Uganda', 'description' => 'Republic of Uganda', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Kampala', 'region' => 'East Africa', 'calling_code' => '+256']), 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'KE', 'name' => 'Kenya', 'description' => 'Republic of Kenya', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Nairobi', 'region' => 'East Africa', 'calling_code' => '+254']), 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'TZ', 'name' => 'Tanzania', 'description' => 'United Republic of Tanzania', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Dodoma', 'region' => 'East Africa', 'calling_code' => '+255']), 'display_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'RW', 'name' => 'Rwanda', 'description' => 'Republic of Rwanda', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Kigali', 'region' => 'East Africa', 'calling_code' => '+250']), 'display_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'BI', 'name' => 'Burundi', 'description' => 'Republic of Burundi', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Gitega', 'region' => 'East Africa', 'calling_code' => '+257']), 'display_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'SS', 'name' => 'South Sudan', 'description' => 'Republic of South Sudan', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Juba', 'region' => 'East Africa', 'calling_code' => '+211']), 'display_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'ET', 'name' => 'Ethiopia', 'description' => 'Federal Democratic Republic of Ethiopia', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Addis Ababa', 'region' => 'East Africa', 'calling_code' => '+251']), 'display_order' => 7, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'SO', 'name' => 'Somalia', 'description' => 'Federal Republic of Somalia', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Mogadishu', 'region' => 'East Africa', 'calling_code' => '+252']), 'display_order' => 8, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'CD', 'name' => 'Democratic Republic of Congo', 'description' => 'Democratic Republic of the Congo', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Kinshasa', 'region' => 'Central Africa', 'calling_code' => '+243']), 'display_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'US', 'name' => 'United States', 'description' => 'United States of America', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Washington D.C.', 'region' => 'North America', 'calling_code' => '+1']), 'display_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'GB', 'name' => 'United Kingdom', 'description' => 'United Kingdom of Great Britain', 'type' => 'country', 'metadata' => json_encode(['capital' => 'London', 'region' => 'Europe', 'calling_code' => '+44']), 'display_order' => 11, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'CN', 'name' => 'China', 'description' => 'People\'s Republic of China', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Beijing', 'region' => 'Asia', 'calling_code' => '+86']), 'display_order' => 12, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'IN', 'name' => 'India', 'description' => 'Republic of India', 'type' => 'country', 'metadata' => json_encode(['capital' => 'New Delhi', 'region' => 'Asia', 'calling_code' => '+91']), 'display_order' => 13, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'AE', 'name' => 'United Arab Emirates', 'description' => 'United Arab Emirates', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Abu Dhabi', 'region' => 'Middle East', 'calling_code' => '+971']), 'display_order' => 14, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $countryCategory->id, 'code' => 'ZA', 'name' => 'South Africa', 'description' => 'Republic of South Africa', 'type' => 'country', 'metadata' => json_encode(['capital' => 'Pretoria', 'region' => 'Southern Africa', 'calling_code' => '+27']), 'display_order' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('master_data')->insert($countries);

        // Seed Currencies
        $currencies = [
            ['category_id' => $currencyCategory->id, 'code' => 'UGX', 'name' => 'Uganda Shilling', 'description' => 'Ugandan Shilling', 'type' => 'currency', 'unit' => 'UGX', 'metadata' => json_encode(['symbol' => 'USh', 'decimal_places' => 0, 'country' => 'Uganda']), 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'USD', 'name' => 'US Dollar', 'description' => 'United States Dollar', 'type' => 'currency', 'unit' => 'USD', 'metadata' => json_encode(['symbol' => '$', 'decimal_places' => 2, 'country' => 'United States']), 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'EUR', 'name' => 'Euro', 'description' => 'European Euro', 'type' => 'currency', 'unit' => 'EUR', 'metadata' => json_encode(['symbol' => '€', 'decimal_places' => 2, 'country' => 'European Union']), 'display_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'GBP', 'name' => 'British Pound', 'description' => 'British Pound Sterling', 'type' => 'currency', 'unit' => 'GBP', 'metadata' => json_encode(['symbol' => '£', 'decimal_places' => 2, 'country' => 'United Kingdom']), 'display_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'KES', 'name' => 'Kenya Shilling', 'description' => 'Kenyan Shilling', 'type' => 'currency', 'unit' => 'KES', 'metadata' => json_encode(['symbol' => 'KSh', 'decimal_places' => 2, 'country' => 'Kenya']), 'display_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'TZS', 'name' => 'Tanzania Shilling', 'description' => 'Tanzanian Shilling', 'type' => 'currency', 'unit' => 'TZS', 'metadata' => json_encode(['symbol' => 'TSh', 'decimal_places' => 0, 'country' => 'Tanzania']), 'display_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'RWF', 'name' => 'Rwanda Franc', 'description' => 'Rwandan Franc', 'type' => 'currency', 'unit' => 'RWF', 'metadata' => json_encode(['symbol' => 'FRw', 'decimal_places' => 0, 'country' => 'Rwanda']), 'display_order' => 7, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'ZAR', 'name' => 'South African Rand', 'description' => 'South African Rand', 'type' => 'currency', 'unit' => 'ZAR', 'metadata' => json_encode(['symbol' => 'R', 'decimal_places' => 2, 'country' => 'South Africa']), 'display_order' => 8, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'AED', 'name' => 'UAE Dirham', 'description' => 'United Arab Emirates Dirham', 'type' => 'currency', 'unit' => 'AED', 'metadata' => json_encode(['symbol' => 'د.إ', 'decimal_places' => 2, 'country' => 'UAE']), 'display_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $currencyCategory->id, 'code' => 'CNY', 'name' => 'Chinese Yuan', 'description' => 'Chinese Yuan Renminbi', 'type' => 'currency', 'unit' => 'CNY', 'metadata' => json_encode(['symbol' => '¥', 'decimal_places' => 2, 'country' => 'China']), 'display_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('master_data')->insert($currencies);

        // Seed Units of Measure
        $unitsOfMeasure = [
            // Length
            ['category_id' => $uomCategory->id, 'code' => 'MM', 'name' => 'Millimeter', 'description' => 'Millimeter (mm)', 'type' => 'length', 'unit' => 'mm', 'display_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'CM', 'name' => 'Centimeter', 'description' => 'Centimeter (cm)', 'type' => 'length', 'unit' => 'cm', 'display_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'M', 'name' => 'Meter', 'description' => 'Meter (m)', 'type' => 'length', 'unit' => 'm', 'display_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'KM', 'name' => 'Kilometer', 'description' => 'Kilometer (km)', 'type' => 'length', 'unit' => 'km', 'display_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'IN', 'name' => 'Inch', 'description' => 'Inch (in)', 'type' => 'length', 'unit' => 'in', 'display_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'FT', 'name' => 'Feet', 'description' => 'Feet (ft)', 'type' => 'length', 'unit' => 'ft', 'display_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            
            // Weight
            ['category_id' => $uomCategory->id, 'code' => 'MG', 'name' => 'Milligram', 'description' => 'Milligram (mg)', 'type' => 'weight', 'unit' => 'mg', 'display_order' => 7, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'G', 'name' => 'Gram', 'description' => 'Gram (g)', 'type' => 'weight', 'unit' => 'g', 'display_order' => 8, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'KG', 'name' => 'Kilogram', 'description' => 'Kilogram (kg)', 'type' => 'weight', 'unit' => 'kg', 'display_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'TON', 'name' => 'Metric Ton', 'description' => 'Metric Ton (t)', 'type' => 'weight', 'unit' => 't', 'display_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'LB', 'name' => 'Pound', 'description' => 'Pound (lb)', 'type' => 'weight', 'unit' => 'lb', 'display_order' => 11, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            
            // Volume
            ['category_id' => $uomCategory->id, 'code' => 'ML', 'name' => 'Milliliter', 'description' => 'Milliliter (ml)', 'type' => 'volume', 'unit' => 'ml', 'display_order' => 12, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'L', 'name' => 'Liter', 'description' => 'Liter (l)', 'type' => 'volume', 'unit' => 'l', 'display_order' => 13, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'GAL', 'name' => 'Gallon', 'description' => 'Gallon (gal)', 'type' => 'volume', 'unit' => 'gal', 'display_order' => 14, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            
            // Quantity
            ['category_id' => $uomCategory->id, 'code' => 'PCS', 'name' => 'Pieces', 'description' => 'Pieces (pcs)', 'type' => 'quantity', 'unit' => 'pcs', 'display_order' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'EA', 'name' => 'Each', 'description' => 'Each (ea)', 'type' => 'quantity', 'unit' => 'ea', 'display_order' => 16, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'SET', 'name' => 'Set', 'description' => 'Set', 'type' => 'quantity', 'unit' => 'set', 'display_order' => 17, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'BOX', 'name' => 'Box', 'description' => 'Box', 'type' => 'quantity', 'unit' => 'box', 'display_order' => 18, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'PACK', 'name' => 'Pack', 'description' => 'Pack', 'type' => 'quantity', 'unit' => 'pack', 'display_order' => 19, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'CARTON', 'name' => 'Carton', 'description' => 'Carton', 'type' => 'quantity', 'unit' => 'carton', 'display_order' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'DOZEN', 'name' => 'Dozen', 'description' => 'Dozen (12 units)', 'type' => 'quantity', 'unit' => 'dozen', 'display_order' => 21, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            
            // Area
            ['category_id' => $uomCategory->id, 'code' => 'SQM', 'name' => 'Square Meter', 'description' => 'Square Meter (m²)', 'type' => 'area', 'unit' => 'm²', 'display_order' => 22, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'SQFT', 'name' => 'Square Feet', 'description' => 'Square Feet (ft²)', 'type' => 'area', 'unit' => 'ft²', 'display_order' => 23, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            
            // Time
            ['category_id' => $uomCategory->id, 'code' => 'HR', 'name' => 'Hour', 'description' => 'Hour (hr)', 'type' => 'time', 'unit' => 'hr', 'display_order' => 24, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'DAY', 'name' => 'Day', 'description' => 'Day', 'type' => 'time', 'unit' => 'day', 'display_order' => 25, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'MONTH', 'name' => 'Month', 'description' => 'Month', 'type' => 'time', 'unit' => 'month', 'display_order' => 26, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => $uomCategory->id, 'code' => 'YEAR', 'name' => 'Year', 'description' => 'Year', 'type' => 'time', 'unit' => 'year', 'display_order' => 27, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('master_data')->insert($unitsOfMeasure);

        $this->command->info('Countries, Currencies, and Units of Measure seeded successfully!');
    }
}


