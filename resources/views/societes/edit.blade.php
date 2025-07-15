@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">{{ isset($societe) ? 'Modifier la Société' : 'Ajouter une Nouvelle Société' }}</h2>
            <a href="{{ route('societes.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Error and Success Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ isset($societe) ? route('societes.update', $societe) : route('societes.store') }}" method="POST">
                    @csrf
                    @if (isset($societe))
                        @method('PUT')
                    @endif

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $societe->nom ?? '') }}" class="form-control @error('nom') is-invalid @enderror" required aria-describedby="nom-error">
                        @error('nom')
                            <div id="nom-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $societe->adresse ?? '') }}" class="form-control @error('adresse') is-invalid @enderror" aria-describedby="adresse-error">
                        @error('adresse')
                            <div id="adresse-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $societe->telephone ?? '') }}" class="form-control @error('telephone') is-invalid @enderror" aria-describedby="telephone-error">
                        @error('telephone')
                            <div id="telephone-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $societe->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" aria-describedby="email-error">
                        @error('email')
                            <div id="email-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm10.5 12.5h-9v-9h9v9zm-7-10v2h6v-2h-6zm2 8v-2h2v2h-2z"/>
                            </svg>
                            {{ isset($societe) ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                        <a href="{{ route('societes.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
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
@endsection