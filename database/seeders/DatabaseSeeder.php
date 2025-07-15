<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Affectation;
use App\Models\Societe;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Boujenoui Zakaria',
            'email' => 'z.boujenoui@gmail.com',
            'password' => Hash::make('12345'),
        ]);

        $this->call([
        CategorieSeeder::class,
        AffectationSeeder::class,
        SocieteSeeder::class,
    ]);
    }
}
