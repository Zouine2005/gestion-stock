<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class Mouvement extends Model
{
    use HasFactory;

    protected $fillable = ['produit_id', 'type', 'quantite', 'date_mouvement', 'motif', 'destination'];

    public function produit() {
        return $this->belongsTo(Produit::class);
    }
}