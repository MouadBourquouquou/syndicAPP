<script>
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des employés</h2>
    <a href="{{ url('/employes/ajouter') }}" class="btn btn-primary mb-3">Ajouter un employé</a>

    <ul class="list-group">
        @foreach($employes as $employe)
            <li class="list-group-item">
                {{ $employe->nom }} - {{ $employe->poste }}
            </li>
        @endforeach
    </ul>
</div>
@endsection




</script>