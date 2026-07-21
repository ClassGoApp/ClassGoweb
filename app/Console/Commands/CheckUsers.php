<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUsers extends Command
{
    protected $signature = 'check:users';
    protected $description = 'Check first 5 users in database';

    public function handle()
    {
        $users = User::select('id', 'email', 'status', 'email_verified_at')
            ->limit(5)
            ->with('profile:user_id,first_name,last_name')
            ->get();

        $this->info("\n=== USUARIOS EN LA BASE DE DATOS ===\n");
        
        foreach ($users as $user) {
            $this->line("ID: {$user->id}");
            $this->line("Email: {$user->email}");
            $this->line("Nombre: " . ($user->profile?->first_name ?? 'N/A') . " " . ($user->profile?->last_name ?? 'N/A'));
            $this->line("Status: " . ($user->status ?? 'NULL'));
            $this->line("Email Verificado: " . ($user->email_verified_at ?? 'NO'));
            $this->line("---\n");
        }

        return 0;
    }
}
