@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des Affectations</h4>
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Exporter
            </button>
           <ul class="dropdown-menu shadow" aria-labelledby="exportDropdown">
    <li>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('affectations.export.excel', ['search' => request('search')]) }}">
            <i class="bi bi-file-earmark-excel text-success me-2"></i> Exporter en Excel
        </a>
    </li>
    <li>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('affectations.export.pdf', ['search' => request('search')]) }}">
            <i class="bi bi-file-earmark-pdf text-danger me-2"></i> Exporter en PDF
        </a>
    </li>
</ul>

        </div>
    </div>

    {{-- Formulaire de recherche --}}
    <form action="{{ route('affectations.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher une affectation..." value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </div>
    </form>

    {{-- Table des affectations --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($affectations as $affectation)
                        <tr>
                            <td>{{ $affectation->nom }}</td>
                            <td>{{ $affectation->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('affectations.edit', $affectation->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('affectations.destroy', $affectation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Aucune affectation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
