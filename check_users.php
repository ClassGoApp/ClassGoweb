<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

$users = DB::table('users')
    ->select('id', 'email', 'first_name', 'last_name', 'status', 'email_verified_at', 'role')
    ->limit(5)
    ->get();

echo "=== USUARIOS EN LA BASE DE DATOS ===\n\n";
foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Email: {$user->email}\n";
    echo "Nombre: {$user->first_name} {$user->last_name}\n";
    echo "Status: " . ($user->status ?? 'NULL') . "\n";
    echo "Email Verificado: " . ($user->email_verified_at ?? 'NO') . "\n";
    echo "Role: {$user->role}\n";
    echo "---\n\n";
}
