<script>
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un immeuble</h2>

    <form method="POST" action="{{ url('/immeubles') }}">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse :</label>
            <input type="text" name="adresse" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection

</script>