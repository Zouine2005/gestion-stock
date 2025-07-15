<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Informatique',
            'Impression',
            'Mobilier de bureau',
            'Papeterie',
            'Fournitures',
            'Réseau & connectique',
            'Périphériques',
            'Archivage',
            'Entretien',
            'Autres'
        ];

        foreach ($categories as $categorie) {
            DB::table('categories')->insert([
                'nom' => $categorie,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
