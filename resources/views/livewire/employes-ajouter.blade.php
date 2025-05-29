@extends('layouts.app')

@section('title', 'Ajouter un employé')

@push('styles')
<!-- Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

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
        width: 100%;
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

    .required-star {
        color: red;
        margin-left: 2px;
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
        outline: none;
    }

    .input-salaire-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .input-salaire-wrapper input {
        padding-right: 60px;
        box-sizing: border-box;
    }

    .input-salaire-wrapper::after {
        content: 'DH';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-weight: 600;
        font-size: 0.95rem;
        pointer-events: none;
        background: #ffffff;
        padding-left: 4px;
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
<div class="container" style="padding-top: 0;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-11">
            <div class="form-container">
                <h3 class="form-title">Ajouter un employé</h3>
                <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                <form method="POST" action="{{ route('employe.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="nom" class="form-label">Nom <span class="required-star">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom <span class="required-star">*</span></label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">adresse email <span class="required-star">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="telephone" class="form-label">Téléphone mobile</label>
                        <input type="text" id="telephone" name="telephone" class="form-control" />
                    </div>
                    <div class="form-group" id="ville-group">
                        <label for="ville" class="form-label">VILLE</label>
                        <select id="ville" name="ville" class="form-control" required>
                            <option value="" disabled selected>-- Choisir une ville --</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Rabat">Rabat</option>
                            <option value="Marrakech">Marrakech</option>
                            <!-- autres villes -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea id="adresse" name="adresse" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
    <label for="poste" class="form-label">Poste / Fonction <span class="required-star">*</span></label>
    <select id="poste" name="poste" class="form-control" required>
        <option value="" disabled selected hidden>Choisissez un poste</option>
        <option value="assistant_syndic">Assistant syndic</option>
        <option value="concierge">Concierge</option>
        <option value="femme_menage">Femme de ménage</option>
    </select>
</div>


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
                        <label for="date_embauche" class="form-label">Date d'embauche <span class="required-star">*</span></label>
                        <input type="text" id="date_embauche" name="date_embauche" class="form-control flatpickr" placeholder="Sélectionnez une date" required />
                    </div>

                    <div class="form-group input-salaire-wrapper">
                        <label for="salaire" class="form-label">Salaire</label>
                        <input type="number" id="salaire" name="salaire" class="form-control" step="0.01" min="0" placeholder="Montant en dirhams" />
                    </div>

                    <button type="submit" class="btn-submit">Ajouter l'employé</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".flatpickr", {
        dateFormat: "d/m/Y",
        maxDate: "today",
        locale: {
            firstDayOfWeek: 1
        }
    });
</script>
@endpush