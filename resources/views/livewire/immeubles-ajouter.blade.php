@extends('layouts.app')

@section('title', 'Ajouter un immeuble')

@push('styles')
<style>
    /* ... (garder tout ton CSS actuel tel quel) ... */
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 0;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-11">
            <div class="form-container">
                <h3 class="form-title">Ajouter un immeuble</h3>
                <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                <form method="POST" action="{{ route('immeuble.store') }}" id="buildingForm">
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
                        <label for="residence_id" class="form-label">Résidence </label>
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


                    <div class="form-group" id="adresse-group">
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
<script>
    const ouiRadio = document.getElementById('residence_oui');
    const nonRadio = document.getElementById('residence_non');

    const selectGroup = document.getElementById('residence-select-group');
    const selectElement = document.getElementById('residence_id');

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
            codePostalGroup.style.display = 'none';
            adresseGroup.style.display = 'none';
            caisseGroup.style.display = 'none';

            cotisationGroup.style.display = 'block';

        } else {
            selectGroup.style.display = 'none';
            selectElement.disabled = true;

            villeGroup.style.display = 'block';
            codePostalGroup.style.display = 'block';
            adresseGroup.style.display = 'block';
            caisseGroup.style.display = 'block';

            cotisationGroup.style.display = 'block';
        }
    }

    ouiRadio.addEventListener('change', updateVisibility);
    nonRadio.addEventListener('change', updateVisibility);

    // Initialisation
    document.addEventListener('DOMContentLoaded', updateVisibility);
</script>

<script>
    const form = document.getElementById('buildingForm');
    const inputs = form.querySelectorAll('.form-control');

    inputs.forEach(input => {
        input.addEventListener('blur', function () {
            if (this.checkValidity()) {
                this.classList.remove('error');
                this.classList.add('success');
            } else {
                this.classList.remove('success');
                this.classList.add('error');
            }
        });

        input.addEventListener('input', function () {
            this.classList.remove('success', 'error');
        });
    });

    form.addEventListener('submit', function (e) {
        form.classList.add('loading');
    });
</script>
@endpush
