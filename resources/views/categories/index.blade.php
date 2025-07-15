@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des Catégories</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Ajouter une catégorie</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
              
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $categorie)
                <tr>
                    <td>{{ $categorie->nom }}</td>
                   
                    <td>
                        <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune catégorie trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
