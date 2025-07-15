<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Mouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $societe_id = $request->societe_id;
        $affectation_id = $request->affectation_id;

        // Base query avec filtres
        $produitsQuery = Produit::query();
        if ($societe_id) $produitsQuery->where('societe_id', $societe_id);
        if ($affectation_id) $produitsQuery->where('affectation_id', $affectation_id);

        // Nombre total de produits distincts (pas par désignation)
        $totalProduits = $produitsQuery->count();  // Nous comptons directement le nombre total de produits

        // Total de stock (somme de toutes les quantités)
        $stockTotal = $produitsQuery->sum('quantite_stock');
       

        // Liste complète de produits filtrés
        $produits = $produitsQuery->get();

        // Produits à stock faible (groupés par désignation)
        $stockFaible = Produit::select('designation', DB::raw('SUM(quantite_stock) as total_stock'))
            ->groupBy('designation')
            ->having('total_stock', '<', 50)
            ->get();

        // Derniers mouvements
        $mouvements = Mouvement::with('produit')->latest()->limit(5)->get();

        // Totaux entrées / sorties
        $totalEntrees = Mouvement::where('type', 'entrée')->sum('quantite');
        $totalSorties = Mouvement::where('type', 'sortie')->sum('quantite');

        // Graphique par produit
        $chartData = Mouvement::join('produits', 'mouvements.produit_id', '=', 'produits.id')
            ->select(
                'produits.designation',
                DB::raw("SUM(CASE WHEN mouvements.type = 'entrée' THEN mouvements.quantite ELSE 0 END) as entrees"),
                DB::raw("SUM(CASE WHEN mouvements.type = 'sortie' THEN mouvements.quantite ELSE 0 END) as sorties")
            )
            ->groupBy('produits.designation')
            ->get();

        // Sorties par affectation
        $sortiesParAffectation = Mouvement::select(
                'affectations.id as affectation_id',
                'affectations.nom as affectation_name',
                DB::raw('GROUP_CONCAT(DISTINCT produits.designation) as designations'),
                DB::raw('SUM(mouvements.quantite) as total_quantite')
            )
            ->join('produits', 'mouvements.produit_id', '=', 'produits.id')
            ->join('affectations', 'produits.affectation_id', '=', 'affectations.id')
            ->where('mouvements.type', 'sortie')
            ->groupBy('affectations.id', 'affectations.nom')
            ->get()
            ->map(function ($item) {
                return [
                    'affectation_id' => $item->affectation_id,
                    'affectation_name' => $item->affectation_name ?? 'Sans affectation',
                    'designations' => array_unique(explode(',', $item->designations)),
                    'total_quantite' => $item->total_quantite,
                ];
            });

        return view('home', compact(
            'totalProduits',      // Affichera maintenant le total de produits
            'stockTotal',
            'totalEntrees',
            'totalSorties',
            'mouvements',
            'chartData',
            'stockFaible',
            'produits',
            'sortiesParAffectation'
        ));
    }
}
