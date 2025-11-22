<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get Audit Trail Module
        $module = Module::firstOrCreate(
            ['code' => 'AUDIT_TRAIL'],
            [
                'name' => 'Audit Trail',
                'description' => 'System audit trail and activity logging',
                'icon' => 'ph-clock-counter-clockwise',
                'display_order' => 100,
                'is_active' => true,
            ]
        );

        // Create Permissions for Audit Trail
        $permissions = [
            [
                'code' => 'AUDIT_LOGS_VIEW',
                'name' => 'audit-logs-view',
                'description' => 'Can view audit trail logs',
            ],
            [
                'code' => 'AUDIT_LOGS_VIEW_DETAILS',
                'name' => 'audit-logs-view-details',
                'description' => 'Can view detailed audit log information',
            ],
            [
                'code' => 'AUDIT_LOGS_STATISTICS',
                'name' => 'audit-logs-statistics',
                'description' => 'Can view audit trail statistics and reports',
            ],
            [
                'code' => 'AUDIT_LOGS_CLEAR',
                'name' => 'audit-logs-clear',
                'description' => 'Can delete old audit logs',
            ],
        ];

        foreach ($permissions as $index => $permission) {
            Permission::firstOrCreate(
                ['code' => $permission['code']],
                [
                    'module_id' => $module->id,
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Audit Trail module and permissions created successfully!');
    }
}

