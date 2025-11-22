<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\Permission;
use App\Models\Module;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:sync {--force : Force sync without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions from PermissionsSeeder to database (idempotent - safe to run multiple times)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║   UCAA Store - Permission Sync Tool   ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->newLine();

        // Show current state
        $currentPermissions = Permission::count();
        $currentModules = Module::count();
        
        $this->line("Current State:");
        $this->line("  • Modules: {$currentModules}");
        $this->line("  • Permissions: {$currentPermissions}");
        $this->newLine();

        // Confirm action
        if (!$this->option('force')) {
            if (!$this->confirm('This will update permissions from PermissionsSeeder. Continue?', true)) {
                $this->warn('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        $this->newLine();
        $this->info('⏳ Syncing permissions...');
        $this->newLine();

        // Run the seeder
        try {
            Artisan::call('db:seed', [
                '--class' => 'PermissionsSeeder',
                '--force' => true
            ]);

            $output = Artisan::output();
            $this->line($output);

            // Show new state
            $newPermissions = Permission::count();
            $newModules = Module::count();
            
            $permissionsDiff = $newPermissions - $currentPermissions;
            $modulesDiff = $newModules - $currentModules;

            $this->newLine();
            $this->info('✅ Sync completed successfully!');
            $this->newLine();
            
            $this->line("New State:");
            $this->line("  • Modules: {$newModules} " . ($modulesDiff > 0 ? "(+{$modulesDiff})" : ''));
            $this->line("  • Permissions: {$newPermissions} " . ($permissionsDiff > 0 ? "(+{$permissionsDiff})" : ''));
            $this->newLine();

            // Show permissions by module
            $this->info('📋 Permissions by Module:');
            $modules = Module::withCount('permissions')->orderBy('display_order')->get();
            
            foreach ($modules as $module) {
                $this->line("  • {$module->name}: {$module->permissions_count} permissions");
            }

            $this->newLine();
            $this->comment('💡 Tip: Clear cache with: php artisan cache:clear');
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error syncing permissions:');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
