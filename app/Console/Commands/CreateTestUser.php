<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    protected $signature = 'create:testuser {email=test@test.com} {password=password123}';
    protected $description = 'Create a test user for login testing';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user exists
        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Create user
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create profile
        Profile::create([
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

        $this->info("\n✅ Test user created successfully!\n");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->line("Status: active");
        $this->line("Email Verified: Yes");
        $this->line("\nYou can now login with these credentials.\n");

        return 0;
    }
}
