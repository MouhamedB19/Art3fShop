<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
class CouponsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'BIENVENUE10',
                'type' => 'pourcentage',
                'valeur' => 10,
                'montant_min' => null,
                'date_debut' => now()->subDays(10),
                'date_fin' => now()->addMonths(6),
                'utilisation_max' => null,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'ART3F20',
                'type' => 'pourcentage',
                'valeur' => 20,
                'montant_min' => 100,
                'date_debut' => now()->subDays(5),
                'date_fin' => now()->addMonths(1),
                'utilisation_max' => 50,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'MOINS5',
                'type' => 'montant',
                'valeur' => 5,
                'montant_min' => 30,
                'date_debut' => now()->subDays(2),
                'date_fin' => now()->addMonths(3),
                'utilisation_max' => null,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'VIP50',
                'type' => 'montant',
                'valeur' => 50,
                'montant_min' => 200,
                'date_debut' => now()->subDays(1),
                'date_fin' => now()->addYear(),
                'utilisation_max' => 10,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'EXPIRE2025',
                'type' => 'pourcentage',
                'valeur' => 15,
                'montant_min' => null,
                'date_debut' => now()->subMonths(6),
                'date_fin' => now()->subMonths(1),
                'utilisation_max' => null,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'INACTIF',
                'type' => 'pourcentage',
                'valeur' => 30,
                'montant_min' => null,
                'date_debut' => now()->subDays(10),
                'date_fin' => now()->addMonths(6),
                'utilisation_max' => null,
                'nombre_utilisations' => 0,

            ],
            [
                'code' => 'EPUISE',
                'type' => 'montant',
                'valeur' => 10,
                'montant_min' => null,
                'date_debut' => now()->subDays(10),
                'date_fin' => now()->addMonths(6),
                'utilisation_max' => 5,
                'nombre_utilisations' => 5,

            ],
        ];
        foreach($coupons as $c)
            Coupon::create($c);
    }
}
