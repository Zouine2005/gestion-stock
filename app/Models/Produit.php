<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Import correct ici

class Produit extends Model
{
    use HasFactory; 

    protected $fillable = [
        'numero_inventaire', 'designation', 'quantite_stock', 'unite',
        'societe_id', 'bon_commande', 'date_reception', 'affectation_id', 'remarque','duplicable','categorie_id','est_affecte'
    ];

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }

  public function categorie()
{
    return $this->belongsTo(Categorie::class, 'categorie_id');
}



    public function mouvements()
    {
        return $this->hasMany(Mouvement::class);
    }

    public function quantiteAffecteeNonRetournee()
{
    $affectee = $this->mouvements()->where('type', 'sortie')->sum('quantite');
    $retournee = $this->mouvements()->where('type', 'retour')->sum('quantite');

    return max(0, $affectee - $retournee);
}


   
}
