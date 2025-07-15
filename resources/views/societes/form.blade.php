@extends('layouts.template')

@section('content')
<div class="mb-3">
    <label>Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $societe->nom ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Adresse</label>
    <input type="text" name="adresse" value="{{ old('adresse', $societe->adresse ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Téléphone</label>
    <input type="text" name="telephone" value="{{ old('telephone', $societe->telephone ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $societe->email ?? '') }}" class="form-control">
</div>
@endsection
