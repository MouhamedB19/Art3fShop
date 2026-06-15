<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['nom' => 'Dupont',   'prenom' => 'Camille',   'email' => 'camille.dupont@example.com'],
            ['nom' => 'Martin',   'prenom' => 'Lucas',   'email' => 'lucas.martin@example.com'],
            ['nom' => 'Bernard',  'prenom' => 'Sophie',  'email' => 'sophie.bernard@example.com'],
            ['nom' => 'Leroy',    'prenom' => 'Thomas',  'email' => 'thomas.leroy@example.com'],
            ['nom' => 'Moreau',   'prenom' => 'Marie', 'email' => 'marie.moreau@example.com'],
        ];
        foreach($users as $data)
        {
            $user = User::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'acheteur',
            ]);
            Client::create([
                'user_id' => $user->id,
                'localisations_id' => null,
            ]);
        }
        $this->command->info('✅ ' . count($users) . ' clients créés avec succès.');
    }
}
