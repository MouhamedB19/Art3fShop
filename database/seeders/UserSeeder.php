<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Martin',
            'prenom' => 'Lucas',
            'email' => 'lucas.martin@example.com',
            'email_verified_at' => null,
            'password' => Hash::make('password'),
            'role' => 'artiste',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'nom' => 'Durand',
            'prenom' => 'Emma',
            'email' => 'emma.durand@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'artiste',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'nom' => 'Ba',
            'prenom' => 'Mouhamed',
            'email' => 'mouhamedba759@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Yo Angelo'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);
    }
}
