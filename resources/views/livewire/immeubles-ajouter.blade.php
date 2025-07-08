
@extends('layouts.app')

@section('title', 'Ajouter un immeuble')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
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
    }
    .form-title {
        font-size: 2rem;
        font-weight: 700;
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
        outline: none;
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
    .form-control.success {
        border-color: #10b981;
    }
    .form-control.error {
        border-color: #ef4444;
    }
    small.text-danger {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }
</style>
@endpush

@section('content')
<div>
    <div class="container" style="padding-top: 0;">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-11">
                <div class="form-container">
                    <h3 class="form-title">Ajouter un immeuble</h3>
                    <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                    <form method="POST" action="{{ route('immeubles.store') }}" id="buildingForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">L'immeuble appartient-il à une résidence ?</label><br>
                            <div style="margin-bottom: 0.5rem;">
                                <input type="radio" id="residence_oui" name="a_residence" value="oui">
                                <label for="residence_oui">Oui</label>
                            </div>
                            <div>
                                <input type="radio" id="residence_non" name="a_residence" value="non" checked>
                                <label for="residence_non">Non</label>
                            </div>
                        </div>

                        <div class="form-group" id="residence-select-group" style="display: none;">
                            <label for="residence_id" class="form-label">Résidence</label>
                            <select id="residence_id" name="residence_id" class="form-control" disabled>
                                <option value="">-- Choisir une résidence --</option>
                                @foreach($residences as $residence)
                                    <option value="{{ $residence->id }}">{{ $residence->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nom" class="form-label">Nom/numero d'immeuble</label>
                            <input type="text" id="nom" name="nom" class="form-control" required />
                        </div>

                        <div class="form-group" id="ville-group">
                            <label for="ville" class="form-label">Ville</label>
                            <select id="ville" name="ville" class="form-control" required>
                                <option value="" disabled selected>-- Choisir une ville --</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville }}">{{ $ville }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="code-postal-group">
                            <label for="code_postal" class="form-label">Code postal</label>
                            <input type="number" id="code_postal" name="code_postal" class="form-control" required />
                        </div>

                        <div class="form-group" id="adresse-group">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" id="adresse" name="adresse" class="form-control" required />
                        </div>

                        <div class="form-group" id="nombre-appartements-group">
                            <label for="nombre_app" class="form-label">Nombre d'appartements</label>
                            <input type="text" id="nombre_app" name="nombre_app" class="form-control" required />
                        </div>

                        <div class="form-group" id="cotisation-group">
                            <label for="cotisation" class="form-label">Montant de la cotisation mensuelle (DH)</label>
                            <input type="number" id="cotisation" name="cotisation" class="form-control" required />
                        </div>

                        <div class="form-group" id="caisse-group">
                            <label for="caisse" class="form-label">Montant en caisse disponible</label>
                            <div class="info-caisse">
                                Veuillez saisir votre caisse actuelle. Elle sera mise à jour en fonction des cotisations ou dépenses.
                            </div>
                            <input type="number" id="caisse" name="caisse" class="form-control" required />
                        </div>

                        <button type="submit" class="btn-submit">Ajouter l'immeuble</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
    const ouiRadio = document.getElementById('residence_oui');
    const nonRadio = document.getElementById('residence_non');

    const selectGroup = document.getElementById('residence-select-group');
    const selectElement = document.getElementById('residence_id');

    const ville = document.getElementById('ville');
    const codePostal = document.getElementById('code_postal');
    const adresse = document.getElementById('adresse');
    const caisse = document.getElementById('caisse');
    const cotisation = document.getElementById('cotisation');

    const villeGroup = document.getElementById('ville-group');
    const codePostalGroup = document.getElementById('code-postal-group');
    const adresseGroup = document.getElementById('adresse-group');
    const caisseGroup = document.getElementById('caisse-group');
    const cotisationGroup = document.getElementById('cotisation-group');

    function updateVisibility() {
        if (ouiRadio.checked) {
            selectGroup.style.display = 'block';
            selectElement.disabled = false;

            villeGroup.style.display = 'none';
            ville.disabled = true;
            ville.removeAttribute('required');

            codePostalGroup.style.display = 'none';
            codePostal.disabled = true;
            codePostal.removeAttribute('required');

            adresseGroup.style.display = 'none';
            adresse.disabled = true;
            adresse.removeAttribute('required');

            caisseGroup.style.display = 'none';
            caisse.disabled = true;
            caisse.removeAttribute('required');

            cotisationGroup.style.display = 'block';
            cotisation.disabled = true;
            cotisation.removeAttribute('required');
        } else {
            selectGroup.style.display = 'none';
            selectElement.disabled = true;

            villeGroup.style.display = 'block';
            ville.disabled = false;
            ville.setAttribute('required', 'required');

            codePostalGroup.style.display = 'block';
            codePostal.disabled = false;
            codePostal.setAttribute('required', 'required');

            adresseGroup.style.display = 'block';
            adresse.disabled = false;
            adresse.setAttribute('required', 'required');

            caisseGroup.style.display = 'block';
            caisse.disabled = false;
            caisse.setAttribute('required', 'required');

            cotisationGroup.style.display = 'block';
            cotisation.disabled = false;
            cotisation.setAttribute('required', 'required');
        }
    }

    ouiRadio.addEventListener('change', updateVisibility);
    nonRadio.addEventListener('change', updateVisibility);
    window.onload = updateVisibility;
    // Ajoutez ceci à votre script existant
selectElement.addEventListener('change', function() {
    if (ouiRadio.checked) {
        const residenceId = this.value;
        if (residenceId) {
            // Faire une requête AJAX pour récupérer les infos de la résidence
            fetch(`/residences/${residenceId}/info`)
                .then(response => response.json())
                .then(data => {
                    // Remplir automatiquement les champs avec les infos de la résidence
                    ville.value = data.ville;
                    codePostal.value = data.code_postal;
                    adresse.value = data.adresse;
                    cotisation.value = data.cotisation;
                    caisse.value = data.caisse;
                });
        }
    }
});
</script>
@endpush
