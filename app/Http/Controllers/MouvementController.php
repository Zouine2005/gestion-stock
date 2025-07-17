<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Exports\MouvementsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class MouvementController extends Controller
{
    public function index(Request $request)
    {
        $query = Mouvement::query()->with('produit');

        // Recherche par numéro d'inventaire
        if ($request->numero_inventaire) {
            $query->whereHas('produit', function ($q) use ($request) {
                $q->where('numero_inventaire', 'like', '%' . $request->numero_inventaire . '%');
            });
        }

        // Filtrage par type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filtrage par destination
        if ($request->destination) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }


        // Filtrage par plage de dates
        if ($request->date_debut && $request->date_fin) {
            $query->whereBetween('date_mouvement', [$request->date_debut, $request->date_fin]);
        }

        // Résultats triés par date ascendante
        $mouvements = $query->orderBy('id', 'desc')->paginate(10);

        return view('mouvements.index', compact('mouvements'));
    }

    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new MouvementsExport, 'mouvements.xlsx');
    }

    // Export PDF (tous les mouvements, sans filtre)
    public function exportAll()
    {
        $mouvements = Mouvement::with('produit')->orderBy('date_mouvement', 'asc')->get();
        $produit = null;

        $pdf = PDF::loadView('mouvements.pdf', compact('mouvements', 'produit'));

        return $pdf->download('tous_les_mouvements.pdf');
    }

    // Export PDF après filtrage
    public function exportFilteredPDF(Request $request)
    {
        $query = Mouvement::query()->with('produit');

        if ($request->numero_inventaire) {
            $query->whereHas('produit', function ($q) use ($request) {
                $q->where('numero_inventaire', 'like', '%' . $request->numero_inventaire . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }
if ($request->destination) {
    $query->where('destination', 'like', '%' . $request->destination . '%');
}


        if ($request->date_debut && $request->date_fin) {
            $query->whereBetween('date_mouvement', [$request->date_debut, $request->date_fin]);
        }

        $mouvements = $query->orderBy('date_mouvement', 'asc')->get();
        $produit = null;

        $pdf = PDF::loadView('mouvements.pdf', compact('mouvements', 'produit'));

        return $pdf->download('mouvements_filtrés.pdf');
    }

     public function exportSinglePDF($id)
 {
 // Récupérer le mouvement avec son produit associé
 $mouvement = Mouvement::with('produit')->findOrFail($id);

 // Vérifier que le mouvement est une sortie
 if ($mouvement->type !== 'sortie') {
 return redirect()->back()->with('error', 'Ce mouvement n\'est pas une sortie.');
 }

 // Générer le PDF en passant une collection contenant uniquement ce mouvement
 $mouvements = collect([$mouvement]);
 $produit = $mouvement->produit;

 $pdf = PDF::loadView('mouvements.pdf_sortie', compact('mouvements', 'produit'));

 return $pdf->download('mouvement_sortie_' . $mouvement->id . '.pdf');
 }
}
