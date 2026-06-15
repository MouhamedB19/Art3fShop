<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\Tirage;
use App\Models\User;
use App\Models\Oeuvre;
use App\Models\Dimension;
use Illuminate\Database\Seeder;
class CommandeSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère des users clients existants
        $clients = User::where('role','acheteur')->get();
 
        if ($clients->isEmpty()) {
            $this->command->warn('Aucun client trouvé en base. Seeder annulé.');
            return;
        }
 
        // Récupère des oeuvres et dimensions existantes
        $oeuvres    = Oeuvre::all();
        $dimensions = Dimension::all();
 
        if ($oeuvres->isEmpty() || $dimensions->isEmpty()) {
            $this->command->warn('Aucune œuvre ou dimension trouvée. Seeder annulé.');
            return;
        }
 
        foreach ($clients->take(3) as $client) {
            // Crée 2 commandes par client
            for ($i = 0; $i < 2; $i++) {
                $commande = Commande::create([
                    'date_commande' => now()->subDays(rand(1, 60)),
                    'user_id'       => $client->id,
                ]);
 
                // Attache 1 à 3 tirages à cette commande
                $oeuvresAleatoires = $oeuvres->random(rand(1, min(3, $oeuvres->count())));
 
                foreach ($oeuvresAleatoires as $oeuvre) {
                    // Trouve un numéro de tirage dispo pour cette oeuvre
                    $dernierNumero = Tirage::where('oeuvre_id', $oeuvre->id)->max('numero') ?? 0;
 
                    Tirage::create([
                        'oeuvre_id'       => $oeuvre->id,
                        'numero'          => $dernierNumero + 1,
                        'status'          => 'vendu',
                        'prix'            => rand(100, 5000),
                        'encadrement'     => rand(0, 1),
                        'pret_a_accrocher'=> rand(0, 1),
                        'avec_cadre'      => rand(0, 1),
                        'dimensions_id'   => $dimensions->random()->id,
                        'commande_id'    => $commande->id,
                    ]);
                }
            }
        }
 
        $this->command->info('✅ Commandes et tirages créés avec succès.');
    }
}
