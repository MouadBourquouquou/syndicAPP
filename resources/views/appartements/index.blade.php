<script>
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des appartements</h2>
    <a href="{{ url('/appartements/ajouter') }}" class="btn btn-primary mb-3">Ajouter un appartement</a>

    <ul class="list-group">
        @foreach($appartements as $appartement)
            <li class="list-group-item">
                {{ $appartement->nom }} - {{ $appartement->surface }} m²
            </li>
        @endforeach
    </ul>
</div>
@endsection
</script>