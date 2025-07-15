@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Affecter le produit : {{ $produit->designation }}</h2>

    <form action="{{ route('produits.affecter', $produit->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="affectation_id">Sélectionner une affectation</label>
            <select name="affectation_id" class="form-control" required>
                <option value="">-- Choisissez une affectation --</option>
                @foreach($affectations as $affectation)
                    <option value="{{ $affectation->id }}">{{ $affectation->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantite">Quantité à affecter</label>
            <input type="number" name="quantite" class="form-control" min="1" max="{{ $produit->quantite_stock }}" required>
            <small>Quantité disponible : {{ $produit->quantite_stock }}</small>
        </div>

        <div class="mb-3">
            <label for="motif">Motif (optionnel)</label>
            <input type="text" name="motif" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Affecter</button>
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
