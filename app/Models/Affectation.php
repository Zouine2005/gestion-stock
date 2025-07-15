<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Import correct ici


class Affectation extends Model
{
    use HasFactory; // ✅ Maintenant ça fonctionnera
    protected $fillable = ['nom'];

    // Relation avec le modèle Produit (Relation One-to-Many)
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    // Relation avec le modèle Produit (Relation Many-to-Many)
    public function produitsPivot()
    {
        return $this->belongsToMany(Produit::class, 'affectation_produit')
                    ->withPivot('quantite') // Ajoute la colonne 'quantite' à la table pivot
                    ->withTimestamps();
    }
}
