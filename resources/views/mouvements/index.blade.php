@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
   <div class="d-flex justify-content-between align-items-center mb-4 animate-header">
    <h2 class="mb-0 fw-semibold text-primary">
        <i class="bi bi-clock-history me-2"></i>Historique des Mouvements
    </h2>
    <a href="{{ route('mouvements.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 animate-btn rounded-pill shadow-sm"
       data-bs-toggle="tooltip" data-bs-placement="top" title="Rafraîchir la liste">
        <i class="bi bi-arrow-clockwise"></i> Rafraîchir
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show animate-alert shadow-sm rounded" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

<div class="card shadow border-0 animate-card">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-funnel-fill me-2"></i>
        <h5 class="mb-0">Filtres de Recherche</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('mouvements.index') }}" class="row gy-3 gx-4 align-items-end">

            <div class="col-md-3">
                <label for="numero_inventaire" class="form-label fw-semibold">N° d'inventaire</label>
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="numero_inventaire" id="numero_inventaire"
                           class="form-control @error('numero_inventaire') is-invalid @enderror"
                           placeholder="Ex: ESTO-20250515-..." value="{{ request('numero_inventaire') }}">
                    @error('numero_inventaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-3">
                <label for="destination" class="form-label fw-semibold">Destination</label>
                <input type="text" name="destination" id="destination" class="form-control shadow-sm"
                       value="{{ request('destination') }}" placeholder="Ex: Salle 204, Magasin...">
            </div>

            <div class="col-md-2">
                <label for="type" class="form-label fw-semibold">Type</label>
                <select name="type" id="type" class="form-select shadow-sm @error('type') is-invalid @enderror">
                    <option value="">Tous</option>
                    <option value="entrée" {{ request('type') == 'entrée' ? 'selected' : '' }}>Entrée</option>
                    <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>Sortie</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-2">
                <label for="date_debut" class="form-label fw-semibold">Date début</label>
                <input type="date" name="date_debut" id="date_debut"
                       class="form-control shadow-sm @error('date_debut') is-invalid @enderror"
                       value="{{ request('date_debut') }}">
                @error('date_debut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="col-md-2">
                <label for="date_fin" class="form-label fw-semibold">Date fin</label>
                <input type="date" name="date_fin" id="date_fin"
                       class="form-control shadow-sm @error('date_fin') is-invalid @enderror"
                       value="{{ request('date_fin') }}">
                @error('date_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3 text-end">
                <button type="submit"
                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm animate-btn rounded">
                    <i class="bi bi-funnel-fill"></i> Appliquer les filtres
                </button>
            </div>

        </form>
    </div>
</div>


      <div class="mb-3 d-flex justify-content-end gap-2">
    <!-- Export PDF avec filtres actuels -->
    <a href="{{ route('mouvements.export.pdf', request()->query()) }}" 
       class="btn btn-outline-danger d-flex align-items-center gap-2">
        <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
    </a>

    <!-- Export Excel (statique ou ajouter aussi les filtres si nécessaire) -->
    <a href="{{ route('mouvements.export.excel') }}" 
       class="btn btn-outline-success d-flex align-items-center gap-2">
        <i class="bi bi-file-earmark-excel"></i> Exporter en Excel
    </a>
</div>


        <!-- Table -->
        <div class="table-responsive shadow-sm animate-table">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">Numero_inventaire</th>
                        <th scope="col">Produit</th>
                        <th scope="col">Type</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Date</th>
                        <th scope="col">Motif</th>
                        <th scope="col">Destination</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mouvements as $mouvement)
                        <tr class="animate-row">
                            <td>{{ $mouvement->produit ? $mouvement->produit->numero_inventaire : '-' }}</td>
                            <td>{{ $mouvement->produit ? $mouvement->produit->designation : '-' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $mouvement->type === 'entrée' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($mouvement->type) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $mouvement->quantite }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($mouvement->date_mouvement)->format('d/m/Y') }}</td>
                            <td>{{ $mouvement->motif ?? '-' }}</td>
                            <td>{{ $mouvement->destination ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun mouvement trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
<div class="d-flex justify-content-center mt-4">
    {{ $mouvements->links() }}
</div>
    </div>

    <!-- Embedded CSS -->
    <style>
        /* Card styling for filter form */
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

        /* Fade-in animation for alerts */
        .animate-alert {
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Slide-up animation for card */
        .animate-card {
            animation: slideUp 0.6s ease-out;
        }

        /* Slide-up animation for table */
        .animate-table {
            animation: slideUp 0.6s ease-out 0.2s;
        }

        /* Fade-in animation for pagination */
        .animate-pagination {
            animation: fadeIn 0.5s ease-in-out 0.4s;
        }

        /* Fade-in animation for table rows */
        .animate-row {
            animation: fadeInRow 0.5s ease-out;
            animation-delay: calc(0.1s * var(--row-index));
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

        /* Table styling */
        .table th, .table td {
            vertical-align: middle;
        }

        .table-responsive {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

        @keyframes fadeInRow {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive form layout */
        @media (max-width: 576px) {
            .row.g-3 {
                flex-direction: column;
            }
            .col-md-3, .col-md-2 {
                width: 100%;
            }
            .btn.w-100 {
                width: 100% !important;
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

            // Row animation delay
            const rows = document.querySelectorAll('.animate-row');
            rows.forEach((row, index) => {
                row.style.setProperty('--row-index', index);
            });
        });

   
    document.addEventListener('DOMContentLoaded', function () {
        const exportBtn = document.getElementById('btn-export-pdf');
        const produitId = document.getElementById('produit_id').value;

        exportBtn.addEventListener('click', function (e) {
            e.preventDefault();

            let url = produitId
                ? `/mouvements/export/${produitId}`
                : `/mouvements/export`;

            window.location.href = url;
        });
    });

    </script>
@endsection