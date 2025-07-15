@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="app-page-title mb-0" id="greeting"></h1>
            <p class="text-muted">{{ auth()->user()->name }} ! Bienvenue dans votre espace de gestion de stock.</p>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="row gx-4 gy-4 mb-5">
        @php
            $stats = [
                ['label' => 'Total Produits', 'value' => $totalProduits, 'icon' => 'boxes', 'bg' => 'primary', 'desc' => 'Produits enregistrés', 'route' => 'produits.index'],
                ['label' => 'Stock Total', 'value' => $stockTotal, 'icon' => 'warehouse', 'bg' => 'success', 'desc' => 'Unités en stock'],
                ['label' => 'Entrées', 'value' => $totalEntrees, 'icon' => 'arrow-down', 'bg' => 'info', 'desc' => 'Unités reçues', 'route' => 'mouvements.index'],
                ['label' => 'Sorties', 'value' => $totalSorties, 'icon' => 'arrow-up', 'bg' => 'danger', 'desc' => 'Unités distribuées', 'route' => 'mouvements.index'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100 bg-{{ $stat['bg'] }} text-white">
                <div class="app-card-body p-4 d-flex align-items-center">
                    <div>
                        <h4 class="stats-type mb-1 text-white">{{ $stat['label'] }}</h4>
                        <div class="stats-figure">{{ $stat['value'] }}</div>
                        <div class="stats-desc">{{ $stat['desc'] }}</div>
                    </div>
                    <i class="fas fa-{{ $stat['icon'] }} fa-2x ms-auto opacity-75"></i>
                </div>
                @if(isset($stat['route']))
                <a class="stretched-link" href="{{ route($stat['route']) }}"></a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <!-- Boutons Graphique/Tableau -->
    <div class="mb-4 text-end">
        <div class="btn-group shadow-sm">
            <button class="btn btn-outline-primary" onclick="toggleView('chart')">
                <i class="fas fa-chart-bar me-1"></i>Graphiques
            </button>
            <button class="btn btn-outline-primary" onclick="toggleView('tables')">
                <i class="fas fa-table me-1"></i>Tableaux
            </button>
        </div>
    </div>

    <!-- Section Graphique -->
    <div id="chartView" style="display: block;">
        <div class="row gx-4 gy-4 mb-5">
            <div class="col-md-6">
                <div class="app-card shadow-sm h-100 bg-white">
                    <div class="app-card-header p-4 border-bottom">
                        <h4 class="text-dark mb-0 text-center">Mouvements par Produit</h4>
                    </div>
                    <div class="app-card-body p-4">
                        <canvas id="mouvementChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="app-card shadow-sm h-100 bg-white">
                    <div class="app-card-header p-4 border-bottom">
                        <h4 class="text-dark mb-0 text-center">Répartition des Mouvements</h4>
                    </div>
                    <div class="app-card-body p-4">
                        <canvas id="repartitionChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tableau -->
    <div id="tablesView" style="display: none;">
        <!-- Derniers Mouvements -->
        <div class="app-card shadow-sm mb-4 bg-white">
            <div class="app-card-header p-4 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-dark">Derniers Mouvements</h4>
                <a href="{{ route('mouvements.index') }}" class="btn btn-sm btn-outline-primary">Voir tous</a>
            </div>
            <div class="app-card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Produit</th>
                                <th>Type</th>
                                <th>Quantité</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mouvements as $m)
                            <tr>
                                <td>{{ $m->produit->designation ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $m->type === 'entrée' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($m->type) }}
                                    </span>
                                </td>
                                <td>{{ $m->quantite }}</td>
                                <td>{{ \Carbon\Carbon::parse($m->date_mouvement)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Aucun mouvement récent</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Produits à stock faible -->
        <div class="app-card shadow-sm bg-white">
            <div class="app-card-header p-4 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-dark">Produits à Stock Faible (&lt; 50)</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Désignation</th>
                                <th>Stock Total</th>
                                <th>Alerte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockFaible as $p)
                            <tr class="{{ $p->total_stock == 0 ? 'table-danger' : 'table-warning' }}">
                                <td>{{ $p->designation }}</td>
                                <td>{{ $p->total_stock }}</td>
                                <td>
                                    @if($p->total_stock == 0)
                                        <span class="badge bg-danger">Rupture</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Stock faible</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Aucun produit en stock faible</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleView(view) {
        document.getElementById('chartView').style.display = (view === 'chart') ? 'block' : 'none';
        document.getElementById('tablesView').style.display = (view === 'tables') ? 'block' : 'none';
    }

    @if($chartData->isNotEmpty())
    const ctxBar = document.getElementById('mouvementChart')?.getContext('2d');
    const labels = {!! json_encode($chartData->pluck('designation')) !!};
    const entrees = {!! json_encode($chartData->pluck('entrees')) !!};
    const sorties = {!! json_encode($chartData->pluck('sorties')) !!};

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Entrées',
                    data: entrees,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                },
                {
                    label: 'Sorties',
                    data: sorties,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Mouvements par Produit' },
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const ctxDoughnut = document.getElementById('repartitionChart')?.getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Entrées', 'Sorties'],
            datasets: [{
                label: 'Répartition',
                data: [{{ $totalEntrees }}, {{ $totalSorties }}],
                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Répartition Globale des Mouvements' },
                legend: { position: 'bottom' }
            }
        }
    });
    @endif
</script>

<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
}
.app-page-title {
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
}
.app-card-stat {
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    position: relative;
}
.app-card-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}
.app-card-stat .stats-figure {
    font-size: 2.5rem;
    font-weight: 800;
}
.app-card-stat .stats-type {
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
}
.app-card-stat .stats-desc {
    font-size: 0.85rem;
    opacity: 0.9;
}
</style>
@endsection
