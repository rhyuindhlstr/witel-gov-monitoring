<?php

use App\Models\User;

echo "=== USER LIST ===\n\n";

$users = User::all();

foreach ($users as $user) {
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Password: password (hashed)\n";
    echo "---\n";
}

echo "\n=== LOGIN CREDENTIALS ===\n";
echo "Email: budi@telkom.com\n";
echo "Password: password\n";
