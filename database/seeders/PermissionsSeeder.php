<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder is IDEMPOTENT - safe to run multiple times.
     * It will create or update permissions based on the code.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // First, ensure modules exist
        $this->seedModules($now);

        // Then seed permissions
        $this->seedPermissions($now);

        $this->command->info('Permissions seeded successfully!');
    }

    /**
     * Seed or update modules
     */
    private function seedModules($now): void
    {
        $modules = [
            [
                'code' => 'MOD-001',
                'name' => 'System Administration',
                'description' => 'User management, roles, permissions, and system settings',
                'icon' => 'ph-gear-six',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'MOD-002',
                'name' => 'Store Management',
                'description' => 'Inventory, requisitions, and store operations',
                'icon' => 'ph-package',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'code' => 'MOD-003',
                'name' => 'Organization Management',
                'description' => 'Departments, job titles, and office locations',
                'icon' => 'ph-buildings',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'MOD-004',
                'name' => 'Reports & Analytics',
                'description' => 'System reports and data analytics',
                'icon' => 'ph-chart-line',
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($modules as $module) {
            $existing = DB::table('modules')->where('code', $module['code'])->first();
            
            if ($existing) {
                // Update existing module
                DB::table('modules')->where('code', $module['code'])->update(array_merge($module, [
                    'updated_at' => $now,
                ]));
            } else {
                // Insert new module
                DB::table('modules')->insert(array_merge($module, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]));
            }
        }
    }

    /**
     * Seed or update permissions
     * This is the SINGLE SOURCE OF TRUTH for all permissions in the system
     */
    private function seedPermissions($now): void
    {
        // Get module IDs by code
        $modules = DB::table('modules')->select('id', 'code')->get()->keyBy('code');

        $permissions = [
            // ============================================
            // System Administration Module (MOD-001)
            // ============================================
            
            // Dashboard
            ['code' => 'dashboard-view', 'name' => 'View Dashboard', 'description' => 'Access to main dashboard and statistics', 'module_code' => 'MOD-001', 'category' => 'Dashboard', 'display_order' => 1],

            // Users
            ['code' => 'users-view', 'name' => 'View Users', 'description' => 'View user list and details', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 10],
            ['code' => 'users-create', 'name' => 'Create Users', 'description' => 'Create new users', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 11],
            ['code' => 'users-edit', 'name' => 'Edit Users', 'description' => 'Edit existing users', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 12],
            ['code' => 'users-delete', 'name' => 'Delete Users', 'description' => 'Delete users', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 13],
            ['code' => 'users-assign-roles', 'name' => 'Assign User Roles', 'description' => 'Assign or remove roles from users', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 14],
            ['code' => 'users-assign-permissions', 'name' => 'Assign User Permissions', 'description' => 'Assign direct permissions to users', 'module_code' => 'MOD-001', 'category' => 'Users', 'display_order' => 15],

            // Roles
            ['code' => 'roles-view', 'name' => 'View Roles', 'description' => 'View role list and details', 'module_code' => 'MOD-001', 'category' => 'Roles', 'display_order' => 20],
            ['code' => 'roles-create', 'name' => 'Create Roles', 'description' => 'Create new roles', 'module_code' => 'MOD-001', 'category' => 'Roles', 'display_order' => 21],
            ['code' => 'roles-edit', 'name' => 'Edit Roles', 'description' => 'Edit existing roles', 'module_code' => 'MOD-001', 'category' => 'Roles', 'display_order' => 22],
            ['code' => 'roles-delete', 'name' => 'Delete Roles', 'description' => 'Delete roles', 'module_code' => 'MOD-001', 'category' => 'Roles', 'display_order' => 23],
            ['code' => 'roles-assign-permissions', 'name' => 'Assign Role Permissions', 'description' => 'Assign permissions to roles', 'module_code' => 'MOD-001', 'category' => 'Roles', 'display_order' => 24],

            // Permissions
            ['code' => 'permissions-view', 'name' => 'View Permissions', 'description' => 'View permission list and details', 'module_code' => 'MOD-001', 'category' => 'Permissions', 'display_order' => 30],
            ['code' => 'permissions-create', 'name' => 'Create Permissions', 'description' => 'Create new permissions', 'module_code' => 'MOD-001', 'category' => 'Permissions', 'display_order' => 31],
            ['code' => 'permissions-edit', 'name' => 'Edit Permissions', 'description' => 'Edit existing permissions', 'module_code' => 'MOD-001', 'category' => 'Permissions', 'display_order' => 32],
            ['code' => 'permissions-delete', 'name' => 'Delete Permissions', 'description' => 'Delete permissions', 'module_code' => 'MOD-001', 'category' => 'Permissions', 'display_order' => 33],

            // Modules
            ['code' => 'modules-view', 'name' => 'View Modules', 'description' => 'View module list and details', 'module_code' => 'MOD-001', 'category' => 'Modules', 'display_order' => 40],
            ['code' => 'modules-create', 'name' => 'Create Modules', 'description' => 'Create new modules', 'module_code' => 'MOD-001', 'category' => 'Modules', 'display_order' => 41],
            ['code' => 'modules-edit', 'name' => 'Edit Modules', 'description' => 'Edit existing modules', 'module_code' => 'MOD-001', 'category' => 'Modules', 'display_order' => 42],
            ['code' => 'modules-delete', 'name' => 'Delete Modules', 'description' => 'Delete modules', 'module_code' => 'MOD-001', 'category' => 'Modules', 'display_order' => 43],

            // Audit Logs
            ['code' => 'audit-logs-view', 'name' => 'View Audit Logs', 'description' => 'View system audit logs', 'module_code' => 'MOD-001', 'category' => 'Audit Logs', 'display_order' => 50],
            ['code' => 'audit-logs-export', 'name' => 'Export Audit Logs', 'description' => 'Export audit logs', 'module_code' => 'MOD-001', 'category' => 'Audit Logs', 'display_order' => 51],
            ['code' => 'audit-logs-delete', 'name' => 'Delete Audit Logs', 'description' => 'Delete or purge old audit logs', 'module_code' => 'MOD-001', 'category' => 'Audit Logs', 'display_order' => 52],

            // System Settings
            ['code' => 'settings-view', 'name' => 'View Settings', 'description' => 'View system settings', 'module_code' => 'MOD-001', 'category' => 'Settings', 'display_order' => 60],
            ['code' => 'settings-edit', 'name' => 'Edit Settings', 'description' => 'Modify system settings', 'module_code' => 'MOD-001', 'category' => 'Settings', 'display_order' => 61],

            // ============================================
            // Store Management Module (MOD-002)
            // ============================================
            
            // Inventory
            ['code' => 'inventory-view', 'name' => 'View Inventory', 'description' => 'View inventory list and details', 'module_code' => 'MOD-002', 'category' => 'Inventory', 'display_order' => 70],
            ['code' => 'inventory-create', 'name' => 'Create Inventory', 'description' => 'Add new inventory items', 'module_code' => 'MOD-002', 'category' => 'Inventory', 'display_order' => 71],
            ['code' => 'inventory-edit', 'name' => 'Edit Inventory', 'description' => 'Edit inventory items', 'module_code' => 'MOD-002', 'category' => 'Inventory', 'display_order' => 72],
            ['code' => 'inventory-delete', 'name' => 'Delete Inventory', 'description' => 'Delete inventory items', 'module_code' => 'MOD-002', 'category' => 'Inventory', 'display_order' => 73],
            ['code' => 'inventory-adjust', 'name' => 'Adjust Inventory', 'description' => 'Adjust inventory quantities', 'module_code' => 'MOD-002', 'category' => 'Inventory', 'display_order' => 74],

            // Requisitions
            ['code' => 'requisitions-view', 'name' => 'View Requisitions', 'description' => 'View requisition list and details', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 80],
            ['code' => 'requisitions-create', 'name' => 'Create Requisitions', 'description' => 'Create new requisitions', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 81],
            ['code' => 'requisitions-edit', 'name' => 'Edit Requisitions', 'description' => 'Edit requisitions', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 82],
            ['code' => 'requisitions-delete', 'name' => 'Delete Requisitions', 'description' => 'Delete requisitions', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 83],
            ['code' => 'requisitions-approve', 'name' => 'Approve Requisitions', 'description' => 'Approve or reject requisitions', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 84],
            ['code' => 'requisitions-issue', 'name' => 'Issue Items', 'description' => 'Issue items from inventory', 'module_code' => 'MOD-002', 'category' => 'Requisitions', 'display_order' => 85],

            // Suppliers
            ['code' => 'suppliers-view', 'name' => 'View Suppliers', 'description' => 'View supplier list and details', 'module_code' => 'MOD-002', 'category' => 'Suppliers', 'display_order' => 90],
            ['code' => 'suppliers-create', 'name' => 'Create Suppliers', 'description' => 'Create new suppliers', 'module_code' => 'MOD-002', 'category' => 'Suppliers', 'display_order' => 91],
            ['code' => 'suppliers-edit', 'name' => 'Edit Suppliers', 'description' => 'Edit suppliers', 'module_code' => 'MOD-002', 'category' => 'Suppliers', 'display_order' => 92],
            ['code' => 'suppliers-delete', 'name' => 'Delete Suppliers', 'description' => 'Delete suppliers', 'module_code' => 'MOD-002', 'category' => 'Suppliers', 'display_order' => 93],

            // ============================================
            // Organization Management Module (MOD-003)
            // ============================================
            
            // Departments
            ['code' => 'departments-view', 'name' => 'View Departments', 'description' => 'View department list and details', 'module_code' => 'MOD-003', 'category' => 'Departments', 'display_order' => 100],
            ['code' => 'departments-create', 'name' => 'Create Departments', 'description' => 'Create new departments', 'module_code' => 'MOD-003', 'category' => 'Departments', 'display_order' => 101],
            ['code' => 'departments-edit', 'name' => 'Edit Departments', 'description' => 'Edit departments', 'module_code' => 'MOD-003', 'category' => 'Departments', 'display_order' => 102],
            ['code' => 'departments-delete', 'name' => 'Delete Departments', 'description' => 'Delete departments', 'module_code' => 'MOD-003', 'category' => 'Departments', 'display_order' => 103],

            // Job Titles
            ['code' => 'job-titles-view', 'name' => 'View Job Titles', 'description' => 'View job title list and details', 'module_code' => 'MOD-003', 'category' => 'Job Titles', 'display_order' => 110],
            ['code' => 'job-titles-create', 'name' => 'Create Job Titles', 'description' => 'Create new job titles', 'module_code' => 'MOD-003', 'category' => 'Job Titles', 'display_order' => 111],
            ['code' => 'job-titles-edit', 'name' => 'Edit Job Titles', 'description' => 'Edit job titles', 'module_code' => 'MOD-003', 'category' => 'Job Titles', 'display_order' => 112],
            ['code' => 'job-titles-delete', 'name' => 'Delete Job Titles', 'description' => 'Delete job titles', 'module_code' => 'MOD-003', 'category' => 'Job Titles', 'display_order' => 113],

            // Office Locations
            ['code' => 'office-locations-view', 'name' => 'View Office Locations', 'description' => 'View office location list and details', 'module_code' => 'MOD-003', 'category' => 'Office Locations', 'display_order' => 120],
            ['code' => 'office-locations-create', 'name' => 'Create Office Locations', 'description' => 'Create new office locations', 'module_code' => 'MOD-003', 'category' => 'Office Locations', 'display_order' => 121],
            ['code' => 'office-locations-edit', 'name' => 'Edit Office Locations', 'description' => 'Edit office locations', 'module_code' => 'MOD-003', 'category' => 'Office Locations', 'display_order' => 122],
            ['code' => 'office-locations-delete', 'name' => 'Delete Office Locations', 'description' => 'Delete office locations', 'module_code' => 'MOD-003', 'category' => 'Office Locations', 'display_order' => 123],

            // ============================================
            // Reports & Analytics Module (MOD-004)
            // ============================================
            
            // Reports
            ['code' => 'reports-view', 'name' => 'View Reports', 'description' => 'Access and view reports', 'module_code' => 'MOD-004', 'category' => 'Reports', 'display_order' => 130],
            ['code' => 'reports-export', 'name' => 'Export Reports', 'description' => 'Export reports to Excel/PDF', 'module_code' => 'MOD-004', 'category' => 'Reports', 'display_order' => 131],
            ['code' => 'reports-schedule', 'name' => 'Schedule Reports', 'description' => 'Schedule automated reports', 'module_code' => 'MOD-004', 'category' => 'Reports', 'display_order' => 132],

            // Data Import/Export
            ['code' => 'data-import', 'name' => 'Import Data', 'description' => 'Import data from Excel/CSV', 'module_code' => 'MOD-004', 'category' => 'Data Management', 'display_order' => 140],
            ['code' => 'data-export', 'name' => 'Export Data', 'description' => 'Export data to Excel/CSV', 'module_code' => 'MOD-004', 'category' => 'Data Management', 'display_order' => 141],

            // Attachments
            ['code' => 'attachments-view', 'name' => 'View Attachments', 'description' => 'View attachments', 'module_code' => 'MOD-002', 'category' => 'Attachments', 'display_order' => 150],
            ['code' => 'attachments-upload', 'name' => 'Upload Attachments', 'description' => 'Upload new attachments', 'module_code' => 'MOD-002', 'category' => 'Attachments', 'display_order' => 151],
            ['code' => 'attachments-download', 'name' => 'Download Attachments', 'description' => 'Download attachments', 'module_code' => 'MOD-002', 'category' => 'Attachments', 'display_order' => 152],
            ['code' => 'attachments-delete', 'name' => 'Delete Attachments', 'description' => 'Delete attachments', 'module_code' => 'MOD-002', 'category' => 'Attachments', 'display_order' => 153],
        ];

        // Insert or update each permission
        foreach ($permissions as $permission) {
            $moduleCode = $permission['module_code'];
            $category = $permission['category'] ?? null;
            $displayOrder = $permission['display_order'] ?? 0;
            
            unset($permission['module_code']);
            unset($permission['category']);
            unset($permission['display_order']);

            // Get module ID from code
            $moduleId = $modules[$moduleCode]->id ?? null;
            
            if (!$moduleId) {
                $this->command->warn("Module {$moduleCode} not found. Skipping permission: {$permission['code']}");
                continue;
            }

            $existing = DB::table('permissions')->where('code', $permission['code'])->first();
            
            if ($existing) {
                // Update existing permission
                DB::table('permissions')->where('code', $permission['code'])->update(array_merge($permission, [
                    'module_id' => $moduleId,
                    'category' => $category,
                    'display_order' => $displayOrder,
                    'is_active' => true,
                    'updated_at' => $now,
                ]));
            } else {
                // Insert new permission
                DB::table('permissions')->insert(array_merge($permission, [
                    'module_id' => $moduleId,
                    'category' => $category,
                    'display_order' => $displayOrder,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]));
            }
        }

        $this->command->info('Total permissions: ' . count($permissions));
    }
}
