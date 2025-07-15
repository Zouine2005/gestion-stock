<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Societe;
use App\Models\Mouvement;
use App\Models\Affectation;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProduitsExport;

class ProduitController extends Controller
{
  public function index(Request $request)
{
    $query = Produit::with(['societe', 'affectation', 'categorie'])->orderBy('id', 'asc');

    // Recherche par mot-clé (dans désignation ou numéro inventaire)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('designation', 'like', "%$search%")
              ->orWhere('numero_inventaire', 'like', "%$search%");
        });
    }

    // Filtrage par affectation
    if ($request->filled('affecte')) {
        if ($request->affecte === 'oui') {
            $query->where('est_affecte', true);
        } elseif ($request->affecte === 'non') {
            $query->where('est_affecte', false);
        }
    }

    // Récupération des résultats paginés
    $produits = $query->paginate(10)->appends($request->query());

    return view('produits.index', compact('produits'));
}



    public function create()
    {
        $societes = Societe::all();
        $categories = Categorie::all();
        return view('produits.create', compact('societes', 'categories'));
    }

 public function store(Request $request)
{
    $data = $request->validate([
        'designation' => 'required|string|max:255',
        'duplicable' => 'required|boolean',
        'quantite_stock' => 'required|integer|min:1',
        'unite' => 'required|string|max:50',
        'categorie_id' => 'required|exists:categories,id',
        'societe_id' => 'required|exists:societes,id',
        'bon_commande' => 'nullable|string|max:255',
        'date_reception' => 'nullable|date',
        'remarque' => 'nullable|string',
    ]);

    DB::transaction(function () use ($data) {
        $dateReception = $data['date_reception'] ?? now()->toDateString();
        $year = \Carbon\Carbon::parse($dateReception)->format('Y');

        // Compter les produits pour l'année donnée
        $baseCount = Produit::whereYear('date_reception', $year)->count();

        if ($data['duplicable']) {
            for ($i = 1; $i <= $data['quantite_stock']; $i++) {
                $offset = 0;
                do {
                    $sequence = str_pad($baseCount + $i + $offset, 3, '0', STR_PAD_LEFT);
                    $numeroInventaire = 'ESTO-' . $year . '-' . $sequence;
                    $exists = Produit::where('numero_inventaire', $numeroInventaire)->exists();
                    $offset++;
                } while ($exists);

                $produit = Produit::create([
                    'numero_inventaire' => $numeroInventaire,
                    'designation' => $data['designation'],
                    'duplicable' => true,
                    'categorie_id' => $data['categorie_id'],
                    'quantite_stock' => 1,
                    'unite' => $data['unite'],
                    'societe_id' => $data['societe_id'],
                    'bon_commande' => $data['bon_commande'],
                    'date_reception' => $dateReception,
                    'remarque' => $data['remarque'],
                ]);

                Mouvement::create([
                    'produit_id' => $produit->id,
                    'type' => 'entrée',
                    'quantite' => 1,
                    'date_mouvement' => now(),
                    'motif' => 'Ajout initial (duplicable)',
                ]);
            }
        } else {
            $offset = 0;
            do {
                $sequence = str_pad($baseCount + 1 + $offset, 3, '0', STR_PAD_LEFT);
                $numeroInventaire = 'ESTO-' . $year . '-' . $sequence;
                $exists = Produit::where('numero_inventaire', $numeroInventaire)->exists();
                $offset++;
            } while ($exists);

            $produit = Produit::create([
                'numero_inventaire' => $numeroInventaire,
                'designation' => $data['designation'],
                'duplicable' => false,
                'quantite_stock' => $data['quantite_stock'],
                'unite' => $data['unite'],
                'societe_id' => $data['societe_id'],
                'categorie_id' => $data['categorie_id'],
                'bon_commande' => $data['bon_commande'],
                'date_reception' => $dateReception,
                'remarque' => $data['remarque'],
            ]);

            Mouvement::create([
                'produit_id' => $produit->id,
                'type' => 'entrée',
                'quantite' => $data['quantite_stock'],
                'date_mouvement' => now(),
                'motif' => 'Ajout initial (non duplicable)',
            ]);
        }
    });

    return redirect()->route('produits.index')->with('success', 'Produit(s) ajouté(s) avec succès.');
}


    public function affectationForm(Produit $produit)
    {
        $affectations = Affectation::all();
        return view('produits.affecter', compact('produit', 'affectations'));
    }

    public function affecter(Request $request, Produit $produit)
    {
        // Bloquer si produit déjà totalement affecté
        if ($produit->est_affecte) {
            return redirect()->route('produits.index')->with('error', 'Ce produit a déjà été entièrement affecté.');
        }

        // Bloquer si produit non duplicable et quantité à 0
        if (!$produit->duplicable && $produit->quantite_stock <= 0) {
            return redirect()->route('produits.index')->with('error', 'Impossible d\'affecter un produit non duplicable avec une quantité nulle.');
        }

        $data = $request->validate([
            'affectation_id' => 'required|exists:affectations,id',
            'quantite' => 'required|integer|min:1|max:' . $produit->quantite_stock,
            'motif' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($produit, $data) {
            $produit->decrement('quantite_stock', $data['quantite']);
            $produit->refresh(); // rafraîchir l’objet

            Mouvement::create([
                'produit_id' => $produit->id,
                'type' => 'sortie',
                'quantite' => $data['quantite'],
                'date_mouvement' => now(),
                'motif' => $data['motif'],
                'destination' => Affectation::find($data['affectation_id'])->nom ?? 'Inconnue',
            ]);

            if ($produit->quantite_stock == 0) {
                $produit->update(['est_affecte' => true]);
            }
        });

        return redirect()->route('produits.index')->with('success', 'Produit affecté avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $societes = Societe::all();
        $categories = Categorie::all();
        return view('produits.edit', compact('produit', 'societes', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $data = $request->validate([
            'designation' => 'required',
            'unite' => 'required',
            'societe_id' => 'required|exists:societes,id',
            'categorie_id' => 'required|exists:categories,id',
            'quantite_stock' => 'required|integer|min:0',
            'bon_commande' => 'nullable',
            'date_reception' => 'nullable|date',
            'remarque' => 'nullable',
        ]);

        DB::transaction(function () use ($produit, $data) {
            $ancienneQuantite = $produit->quantite_stock;
            $produit->update($data);

            if ($data['quantite_stock'] != $ancienneQuantite) {
                $dernierEntree = $produit->mouvements()
                    ->where('type', 'entrée')
                    ->latest('date_mouvement')
                    ->first();

                if ($dernierEntree) {
                    $dernierEntree->update([
                        'quantite' => $data['quantite_stock'],
                        'motif' => 'Mise à jour manuelle du stock',
                        'date_mouvement' => now(),
                    ]);
                }
            }
        });

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec ajustement de la quantité.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function exportPDF()
    {
        $produits = Produit::with('societe')->get();
        $pdf = PDF::loadView('produits.pdf', compact('produits'));
        return $pdf->download('produits.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProduitsExport, 'produits.xlsx');
    }

public function retourForm(Produit $produit)
{
    $quantite_max_retour = $produit->quantiteAffecteeNonRetournee();
    return view('produits.retour', compact('produit', 'quantite_max_retour'));
}


public function retour(Request $request, Produit $produit)
{
    $quantite_max = $produit->quantiteAffecteeNonRetournee();

    $data = $request->validate([
        'quantite_retour' => ['required', 'integer', 'min:1', 'max:' . $quantite_max],
        'motif' => 'required|string|max:255',
    ]);

    DB::transaction(function () use ($produit, $data) {
        $produit->increment('quantite_stock', $data['quantite_retour']);

        if ($produit->quantite_stock > 0) {
            $produit->update(['est_affecte' => false]);
        }

        Mouvement::create([
            'produit_id' => $produit->id,
            'type' => 'retour',
            'quantite' => $data['quantite_retour'],
            'date_mouvement' => now(),
            'motif' => $data['motif'],
        ]);
    });

    return redirect()->route('produits.index')->with('success', 'Produit retourné avec succès.');
}


}
