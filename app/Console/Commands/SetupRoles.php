<?php

namespace App\Console\Commands;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Console\Command;

class SetupRoles extends Command
{
    protected $signature = 'setup:roles';
    protected $description = 'Create default roles and permissions';

    public function handle()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $tutorRole = Role::firstOrCreate(['name' => 'tutor', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        $this->info("✅ Roles created successfully:");
        $this->line("  - admin");
        $this->line("  - tutor");
        $this->line("  - student");

        return 0;
    }
}
