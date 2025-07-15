@extends('layouts.template')

@section('content')
<div class="container">
    <h4 class="mb-4">Retour de produit : {{ $produit->designation }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('produits.retour', $produit->id) }}" method="POST">
        @csrf

<div class="mb-3">
    <label for="quantite_retour" class="form-label">Quantité retournée</label>
    <input type="number" name="quantite_retour" class="form-control"
           min="1" max="{{ $quantite_max_retour }}" required>
    <small class="form-text text-muted">
        Quantité maximale pouvant être retournée : {{ $quantite_max_retour }}
    </small>
</div>

        <div class="mb-3">
            <label for="motif" class="form-label">Motif du retour</label>
            <input type="text" name="motif" class="form-control" required>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Valider le retour
            </button>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Annuler
            </a>
        </div>
    </form>
</div>
@endsection
