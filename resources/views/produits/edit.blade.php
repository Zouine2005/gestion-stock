@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 animate-header">
            <h2 class="mb-0">{{ isset($produit) ? 'Modifier le Produit' : 'Ajouter un Produit' }}</h2>
            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Retour à la liste">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Error and Success Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show animate-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form -->
        <div class="card shadow-sm animate-card">
            <div class="card-body">
                <form action="{{ isset($produit) ? route('produits.update', $produit) : route('produits.store') }}" method="POST">
                    @csrf
                    @if (isset($produit))
                        @method('PUT')
                    @endif

                    <!-- Numéro d'inventaire -->
                    <div class="mb-3">
                        <label for="numero_inventaire" class="form-label">Numéro d'inventaire <span class="text-danger">*</span></label>
                        <input type="text" name="numero_inventaire" id="numero_inventaire" value="{{ old('numero_inventaire', $produit->numero_inventaire ?? '') }}" class="form-control @error('numero_inventaire') is-invalid @enderror" required aria-describedby="numero_inventaire-error">
                        @error('numero_inventaire')
                            <div id="numero_inventaire-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

<div class="mb-3">
    <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
    <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required aria-describedby="categorie_id-error">
        <option value="" disabled {{ old('categorie_id', $produit->categorie_id ?? '') ? '' : 'selected' }}>-- Sélectionnez une catégorie --</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->nom }}
            </option>
        @endforeach
    </select>
    @error('categorie_id')
        <div id="categorie_id-error" class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
  

                    <!-- Désignation -->
                    <div class="mb-3">
                        <label for="designation" class="form-label">Désignation <span class="text-danger">*</span></label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation', $produit->designation ?? '') }}" class="form-control @error('designation') is-invalid @enderror" required aria-describedby="designation-error">
                        @error('designation')
                            <div id="designation-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantité -->
                    <div class="mb-3">
                        <label for="quantite_stock" class="form-label">Quantité <span class="text-danger">*</span></label>
                        <input type="number" name="quantite_stock" id="quantite_stock" value="{{ old('quantite_stock', $produit->quantite_stock ?? '') }}" class="form-control @error('quantite_stock') is-invalid @enderror" required min="0" aria-describedby="quantite_stock-error">
                        @error('quantite_stock')
                            <div id="quantite_stock-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Unité -->
                    <div class="mb-3">
                        <label for="unite" class="form-label">Unité <span class="text-danger">*</span></label>
                        <input type="text" name="unite" id="unite" value="{{ old('unite', $produit->unite ?? '') }}" class="form-control @error('unite') is-invalid @enderror" required aria-describedby="unite-error">
                        @error('unite')
                            <div id="unite-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fournisseur (Société) -->
                    <div class="mb-3">
                        <label for="societe_id" class="form-label">Fournisseur (Société) <span class="text-danger">*</span></label>
                        <select name="societe_id" id="societe_id" class="form-select @error('societe_id') is-invalid @enderror" required aria-describedby="societe_id-error">
                            <option value="" disabled {{ old('societe_id', $produit->societe_id ?? '') ? '' : 'selected' }}>Sélectionner une société</option>
                            @foreach ($societes as $societe)
                                <option value="{{ $societe->id }}" {{ old('societe_id', $produit->societe_id ?? '') == $societe->id ? 'selected' : '' }}>{{ $societe->nom }}</option>
                            @endforeach
                        </select>
                        @error('societe_id')
                            <div id="societe_id-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
   


                    <!-- Bon de commande -->
                    <div class="mb-3">
                        <label for="bon_commande" class="form-label">Bon de commande</label>
                        <input type="text" name="bon_commande" id="bon_commande" value="{{ old('bon_commande', $produit->bon_commande ?? '') }}" class="form-control @error('bon_commande') is-invalid @enderror" aria-describedby="bon_commande-error">
                        @error('bon_commande')
                            <div id="bon_commande-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date de réception -->
                    <div class="mb-3">
                        <label for="date_reception" class="form-label">Date de réception</label>
                        <input type="date" name="date_reception" id="date_reception" value="{{ old('date_reception', $produit->date_reception ?? '') }}" class="form-control @error('date_reception') is-invalid @enderror" aria-describedby="date_reception-error">
                        @error('date_reception')
                            <div id="date_reception-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remarques -->
                    <div class="mb-3">
                        <label for="remarque" class="form-label">Remarques</label>
                        <textarea name="remarque" id="remarque" class="form-control @error('remarque') is-invalid @enderror" rows="4" aria-describedby="remarque-error">{{ old('remarque', $produit->remarque ?? '') }}</textarea>
                        @error('remarque')
                            <div id="remarque-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ isset($produit) ? 'Mettre à jour le produit' : 'Enregistrer le produit' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm10.5 12.5h-9v-9h9v9zm-7-10v2h6v-2h-6zm2 8v-2h2v2h-2z"/>
                            </svg>
                            {{ isset($produit) ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Annuler et revenir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Embedded CSS -->
    <style>
        /* Card styling for forms */
        .card {
            border-radius: 8px;
            border: none;
        }

        /* Tooltip styling */
        .tooltip-inner {
            background-color: #333;
            color: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .tooltip .tooltip-arrow::before {
            border-top-color: #333 !important;
        }

        /* Fade-in animation for header */
        .animate-header {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Fade-in and slide-up animation for card */
        .animate-card {
            animation: slideUp 0.6s ease-out;
        }

        /* Fade-in animation for alerts */
        .animate-alert {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Hover scale animation for buttons */
        .animate-btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .animate-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Ensure form inputs are visually clear */
        .form-control, .form-select {
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        /* Highlight invalid inputs */
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
        }

        /* Style alerts for consistency */
        .alert {
            border-left: 4px solid;
        }
        .alert-danger {
            border-color: #dc3545;
        }
        .alert-success {
            border-color: #28a745;
        }

        /* Keyframes for animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive button layout */
        @media (max-width: 576px) {
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 1rem;
            }
            .btn {
                width: 100%;
            }
        }
    </style>

    <!-- Embedded JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(tooltipTriggerEl => {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection