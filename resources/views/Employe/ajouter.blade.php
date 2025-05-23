<script>

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un employé</h2>

    <form method="POST" action="{{ url('/employes') }}">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="poste" class="form-label">Poste :</label>
            <input type="text" name="poste" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection

</script>