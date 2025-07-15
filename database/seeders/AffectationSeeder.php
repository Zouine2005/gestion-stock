<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffectationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $affectations = [
            'Salle de cours 1',
            'Salle de cours 2',
            'Salle TD 1',
            'Salle TD 2',
            'Zakaria Boujenoui',
            'Soufiane Imloui',
            'Othman EL Bouni',
            'Badia Bakouch',
            'Abdellah knioui',
            'Oumayma Rihani',
        ];

        foreach ($affectations as $affectation) {
            DB::table('affectations')->insert([
                'nom' => $affectation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
