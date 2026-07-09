<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            
            [
                'nom'        => 'Ba',
                'prenom'     => 'Mouhamed',
                'email'      => 'admin@art3f.test',
                'password'   => Hash::make('TheAdmin68'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom'        => 'Gbantehou',
                'prenom'     => 'Joseph',
                'email'      => 'joseph@art3f.fr',
                'password'   => Hash::make('salonArt3f'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
        $this->command->info('Les comptes admin sont crees');
    }
}
