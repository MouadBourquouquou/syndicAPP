<script>
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un appartement</h2>

    <form method="POST" action="{{ url('/appartements') }}">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="surface" class="form-label">Surface (m²) :</label>
            <input type="number" name="surface" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection
</script>