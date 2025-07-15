@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 animate-header">
            <h2 class="mb-0">Détails du Produit</h2>
            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Retour à la liste">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Product Details -->
        <div class="row g-4">
            <!-- Main Details Card -->
            <div class="col-md-6">
                <div class="card shadow-sm animate-card" style="--card-delay: 0.1s;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informations Principales</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Numéro d'inventaire</dt>
                            <dd class="col-sm-7">{{ $produit->numero_inventaire }}</dd>
                            <dt class="col-sm-5">Désignation</dt>
                            <dd class="col-sm-7">{{ $produit->designation }}</dd>
                            <dt class="col-sm-5">Quantité</dt>
                            <dd class="col-sm-7">{{ $produit->quantite_stock }} {{ $produit->unite }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Supplier and Assignment Card -->
            <div class="col-md-6">
                <div class="card shadow-sm animate-card" style="--card-delay: 0.2s;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Fournisseur & Affectation</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Fournisseur</dt>
                            <dd class="col-sm-7">{{ $produit->societe->nom ?? '-' }}</dd>
                            <dt class="col-sm-5">Affectation actuelle</dt>
                            <dd class="col-sm-7">{{ $produit->affectation->nom ?? 'Stock principal' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Additional Details Card -->
            <div class="col-md-6">
                <div class="card shadow-sm animate-card" style="--card-delay: 0.3s;">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Détails Supplémentaires</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Bon de commande</dt>
                            <dd class="col-sm-7">{{ $produit->bon_commande ?: '-' }}</dd>
                            <dt class="col-sm-5">Date de réception</dt>
                            <dd class="col-sm-7">{{ $produit->date_reception ?: '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Remarks Card -->
            <div class="col-md-6">
                <div class="card shadow-sm animate-card" style="--card-delay: 0.4s;">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Remarques</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $produit->remarque ?: 'Aucune remarque.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2 mt-4 animate-buttons">
            <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier le produit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                Modifier
            </a>
            <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger d-flex align-items-center gap-2 animate-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer le produit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Embedded CSS -->
    <style>
        /* Card styling */
        .card {
            border-radius: 8px;
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

        /* Fade-in animation for alerts */
        .animate-alert {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Slide-up animation for cards with staggered delay */
        .animate-card {
            animation: slideUp 0.6s ease-out;
            animation-delay: var(--card-delay);
        }

        /* Fade-in animation for buttons */
        .animate-buttons {
            animation: fadeIn 0.5s ease-in-out 0.5s;
        }

        /* Hover scale animation for buttons */
        .animate-btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .animate-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Style definition lists */
        .row.mb-0 dt, .row.mb-0 dd {
            margin-bottom: 0.5rem;
        }

        /* Style alerts for consistency */
        .alert-success {
            border-left: 4px solid #28a745;
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

        /* Responsive layout */
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