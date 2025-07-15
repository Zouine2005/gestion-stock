<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    protected $fillable = ['nom', 'adresse', 'telephone', 'email'];

    // Relation avec le modèle Produit (Relation One-to-Many)
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
