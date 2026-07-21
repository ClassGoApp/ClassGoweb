<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    protected $signature = 'assign:role {email} {role}';
    protected $description = 'Assign a role to a user (student or tutor)';

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!in_array($role, ['student', 'tutor', 'admin'])) {
            $this->error("Role must be 'student', 'tutor' or 'admin'");
            return 1;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User with email {$email} not found");
            return 1;
        }

        // Sync role
        $user->syncRoles([$role]);

        $this->info("✅ Role '{$role}' assigned to {$email}");
        return 0;
    }
}
