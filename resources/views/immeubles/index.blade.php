<script>
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des immeubles</h2>
    <a href="{{ url('/immeubles/ajouter') }}" class="btn btn-primary mb-3">Ajouter un immeuble</a>

    <ul class="list-group">
        @foreach($immeubles as $immeuble)
            <li class="list-group-item">
                {{ $immeuble->nom }} - {{ $immeuble->adresse }}
            </li>
        @endforeach
    </ul>
</div>
@endsection

</script>