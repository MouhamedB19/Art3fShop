<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimensionsSeeder extends Seeder
{
    public function run(): void
    {
        $dims = [
            [30, 30], [40, 40], [50, 50], [60, 60], [80, 80], [100, 100],
            [40, 60], [50, 70], [60, 80], [80, 100], [100, 120], [100, 150],
            [60, 40], [80, 60], [120, 80],
        ];

        foreach ($dims as [$h, $l]) {
            DB::table('dimensions')->insert([
                'hauteur'    => $h,
                'largeur'    => $l,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Dimensions créées.');
    }
}