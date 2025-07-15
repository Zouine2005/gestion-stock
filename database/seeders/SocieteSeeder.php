<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocieteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $societes = [
            [
                'nom' => 'Technologie Atlas',
                'adresse' => 'Rue Mohammed V, Casablanca',
                'telephone' => '0522-123456',
                'email' => 'contact@atlastech.ma',
            ],
            [
                'nom' => 'Maroc Solutions Informatiques',
                'adresse' => 'Av. Hassan II, Rabat',
                'telephone' => '0537-987654',
                'email' => 'info@msi.ma',
            ],
            [
                'nom' => 'Ouarzate Service Bureau',
                'adresse' => 'Centre-ville, Ouarzazate',
                'telephone' => '0524-456789',
                'email' => 'Ouarzazate.service@gmail.com',
            ],
            [
                'nom' => 'Agadir Supplies',
                'adresse' => 'Quartier Industriel, Agadir',
                'telephone' => '0528-654321',
                'email' => 'contact@agadirsupplies.ma',
            ],
        ];

        foreach ($societes as $societe) {
            DB::table('societes')->insert([
                'nom' => $societe['nom'],
                'adresse' => $societe['adresse'],
                'telephone' => $societe['telephone'],
                'email' => $societe['email'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
