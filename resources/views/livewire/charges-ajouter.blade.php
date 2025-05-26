@extends('layouts.app')

@section('title', 'Ajouter une charge')

@push('styles')
<!-- Réutilisation des styles existants -->
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

                <form>
                      <div class="form-group">
    <label for="immeuble_id" class="form-label">Immeuble ou Résidence <span class="required-star">*</span></label>
    <select id="immeuble_id" name="immeuble_id" class="form-control" required>
        <option value="" disabled selected>-- Sélectionnez un immeuble ou une résidence --</option>
        <optgroup label="Résidences">
            <option value="residence_1">Résidence X</option>
            <option value="residence_2">Résidence Y</option>
            <option value="residence_3">Résidence Z</option>
        </optgroup>
         <optgroup label="Immeubles">
            <option value="immeuble_1">Immeuble A</option>
            <option value="immeuble_2">Immeuble B</option>
            <option value="immeuble_3">Immeuble C</option>
        </optgroup>
    </select>
</div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" placeholder="Ex : Eau, Sécurité..." required>
                    </div>
                     <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Ex : Facture d'eau du mois de mai..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Montant (DH)</label>
                        <input type="number" class="form-control" step="0.01" min="0" placeholder="Ex : 100.00" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" required>
                    </div>

                    <button type="button" class="btn-submit mt-3">Simuler l'ajout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
