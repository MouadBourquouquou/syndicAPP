@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="mb-4 text-primary">Ajouter un appartement</h2>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="ajouter">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numero" class="form-label">N° de porte</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-door-closed"></i></span>
                            <input type="text" class="form-control" id="numero" wire:model.defer="numero">
                        </div>
                        @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="surface" class="form-label">Surface (m²)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bounding-box"></i></span>
                            <input type="number" class="form-control" id="surface" wire:model.defer="surface">
                        </div>
                        @error('surface') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dernier_mois_paye" class="form-label">Dernier mois payé</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="month" class="form-control" id="dernier_mois_paye" wire:model.defer="dernier_mois_paye">
                        </div>
                        @error('dernier_mois_paye') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone mobile</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" class="form-control" id="telephone" wire:model.defer="telephone">
                        </div>
                        @error('telephone') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="immeuble_id" class="form-label">Immeuble</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <select class="form-select" id="immeuble_id" wire:model.defer="immeuble_id">
                                <option value="">-- Sélectionner un immeuble --</option>
                                @foreach ($immeubles as $immeuble)
                                    <option value="{{ $immeuble->id }}">{{ $immeuble->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('immeuble_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Ajouter l'appartement</button>
            </form>
        </div>
    </div>
</div>
@endsection
