@extends('layouts.app')

@section('title', 'Ajouter une charge')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        text-align: center;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-subtitle {
        color: #6b7280;
        text-align: center;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        background: #ffffff;
        color: #1f2937;
        height: 58px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-transform: uppercase;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-submit:hover::before {
        left: 100%;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-11">
            <div class="form-container">
                <h3 class="form-title">Ajouter une charge</h3>
                <p class="form-subtitle">Saisissez les détails de la charge ci-dessous</p>

                <form method="POST" action="{{ route('charge.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="id_residence" class="form-label">Résidence <span class="required-star">*</span></label>
                        <select id="id_residence" name="id_residence" class="form-control" required>
                            <option value="" disabled selected>-- Sélectionnez une résidence --</option>
                    @foreach($residences as $residence)
                           <option value="{{ $residence->id }}">{{ $residence->nom }}</option>
                    @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="immeuble_id" class="form-label">Immeuble </label>
                        <select id="immeuble_id" name="immeuble_id" class="form-control">
                            <option value="" selected>-- Aucun immeuble spécifique --</option>
                        @foreach($immeubles as $immeuble)
                              <option value="{{ $immeuble->id }}">{{ $immeuble->nom }}</option>
                        @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Type de charge <span class="text-danger">*</span></label>
                        <input type="text" id="type" name="type" class="form-control" placeholder="Ex : Eau, Sécurité..." required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Ex : Facture d'eau du mois de mai..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="montant" class="form-label">Montant (DH) <span class="text-danger">*</span></label>
                        <input type="number" id="montant" name="montant" class="form-control" step="0.01" min="0" placeholder="Ex : 100.00" required>
                    </div>

                    <div class="form-group">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn-submit mt-3">Ajouter la charge</button>
                </form>
                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const residenceSelect = document.getElementById('id_residence');
                            const immeubleSelect = document.getElementById('immeuble_id');

                            residenceSelect.addEventListener('change', function () {
                                const residenceId = this.value;

                                // Clear existing immeubles
                                immeubleSelect.innerHTML = '<option value="">-- Chargement... --</option>';

                                fetch(`/immeubles/by-residence/${residenceId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        immeubleSelect.innerHTML = '<option value="">-- Aucun immeuble spécifique --</option>';
                                        data.forEach(immeuble => {
                                            const option = document.createElement('option');
                                            option.value = immeuble.id;
                                            option.textContent = immeuble.nom;
                                            immeubleSelect.appendChild(option);
                                        });
                                    })
                                    .catch(error => {
                                        immeubleSelect.innerHTML = '<option value="">-- Erreur lors du chargement --</option>';
                                        console.error('Erreur:', error);
                                    });
                            });
                        });
                    </script>
                @endpush


            </div>
        </div>
    </div>
</div>
@endsection