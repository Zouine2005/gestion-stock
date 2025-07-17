<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProfileController;


// Page de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Redirection '/' vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes protégées par middleware
Route::middleware('auth.custom')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Ressources principales
    Route::resource('societes', SocieteController::class);
    Route::get('/societes/export/pdf', [SocieteController::class, 'exportPDF'])->name('societes.export.pdf');
Route::get('/societes/export/excel', [SocieteController::class, 'exportExcel'])->name('societes.export.excel');

    Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);
    Route::resource('affectations', AffectationController::class);
    Route::get('/affectations/export/pdf', [AffectationController::class, 'exportPDF'])->name('affectations.export.pdf');
   Route::get('affectations/export/excel', [AffectationController::class, 'exportExcel'])->name('affectations.export.excel');



    Route::resource('produits', ProduitController::class);
    Route::get('/produits/{produit}/retour', [ProduitController::class, 'retourForm'])->name('produits.retour.form');
Route::post('/produits/{produit}/retour', [ProduitController::class, 'retour'])->name('produits.retour');


    Route::get('/produits/export/pdf', [ProduitController::class, 'exportPDF'])->name('produits.export.pdf');

    Route::get('/produits/export/excel', [ProduitController::class, 'exportExcel'])->name('produits.export.excel');

    // Exporter tous les mouvements en Excel
Route::get('/mouvements/export/excel', [MouvementController::class, 'exportExcel'])->name('mouvements.export.excel');

// Exporter tous les mouvements en PDF
Route::get('/mouvements/export/pdf', [MouvementController::class, 'exportAll'])->name('mouvements.export.pdf');


Route::get('/mouvements/export/pdf', [MouvementController::class, 'exportFilteredPDF'])->name('mouvements.export.pdf');
Route::get('/mouvements/export/pdf/single/{mouvement}', [MouvementController::class, 'exportSinglePDF'])->name('mouvements.export.pdf.single');






    // ✅ Routes personnalisées pour affectation d’un produit
    Route::get('produits/{produit}/affecter', [ProduitController::class, 'affectationForm'])->name('produits.affecter.form');
    Route::post('produits/{produit}/affecter', [ProduitController::class, 'affecter'])->name('produits.affecter');

    // ✅ Route pour l'historique des mouvements
    Route::get('/mouvements', [MouvementController::class, 'index'])->name('mouvements.index');
});
