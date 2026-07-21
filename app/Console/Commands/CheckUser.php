<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUser extends Command
{
    protected $signature = 'check:user {email}';
    protected $description = 'Check if a user exists';

    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)
            ->with('profile:user_id,first_name,last_name')
            ->first();

        if (!$user) {
            $this->error("❌ Usuario con email '{$email}' NO existe");
            return 1;
        }

        $this->info("\n✅ Usuario encontrado:\n");
        $this->line("ID: {$user->id}");
        $this->line("Email: {$user->email}");
        $this->line("Nombre: " . ($user->profile?->first_name ?? 'N/A') . " " . ($user->profile?->last_name ?? 'N/A'));
        $this->line("Status: " . ($user->status ?? 'NULL'));
        $this->line("Email Verificado: " . ($user->email_verified_at ? 'Sí ✅' : 'No'));
        
        // Show roles
        $roles = $user->getRoleNames();
        $this->line("Roles: " . ($roles->count() > 0 ? implode(', ', $roles->toArray()) : 'Ninguno'));
        
        $this->line("");

        return 0;
    }
}
