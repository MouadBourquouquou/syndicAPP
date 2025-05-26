@extends('layouts.app')

@section('title', 'Ajouter un immeuble')

@push('styles')
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
        display: block;
        margin-bottom: 0.3rem;
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

    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        appearance: none;
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

    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .loading .btn-submit {
        background: #9ca3af;
    }

      .info-caisse {
    color: #E53E3E;       /* rouge vif */
    font-size: 0.85rem;
    font-style: italic;
    margin-top: 6px;
    margin-bottom: 12px;
    font-weight: 500;
    line-height: 1.3;
    opacity: 0.95;
}

</style>
@endpush

@section('content')
<div class="container" style="padding-top: 0;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-11">
            <div class="form-container">
                <h3 class="form-title">Ajouter un immeuble</h3>
                <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                <form id="buildingForm" method="POST" action="{{ route('immeuble.store') }}">
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
                        <label for="residence_id" class="form-label">Sélectionnez une résidence</label>
                        <select id="residence_id" name="residence_id" class="form-control" disabled>
                            <option value="">-- Choisir une résidence --</option>
                            <option value="1">Résidence A</option>
                            <option value="2">Résidence B</option>
                            <option value="3">Résidence C</option>
                        </select>
                    </div>

                    <div class="form-group" id="nom-group">
                        <label for="nom" class="form-label">Nom de l'immeuble / Numero de l'immeuble</label>
                        <input type="text" id="nom" name="nom" class="form-control" required />
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

                    <div class="form-group" id="code-postal-group">
                        <label for="code_postal" class="form-label">CODE POSTAL</label>
                        <input type="number" id="code_postal" name="code_postal" class="form-control" required />
                    </div>

                    <div class="form-group" id="adresse-group">
                        <label for="adresse" class="form-label">ADRESSE</label>
                        <input type="text" id="adresse" name="adresse" class="form-control" required />
                    </div>

                    <div class="form-group" id="cotisation-group">
                        <label for="cotisation" class="form-label">MONTANT de la cotisation mensuelle (DH)</label>
                        <input type="number" id="cotisation" name="cotisation" class="form-control" required />
                    </div>
                      <div class="form-group" id="caisse-group">
                        <label for="caisse" class="form-label">MONTANT en caisse disponible</label>
                        <div class="info-caisse">
                            Veuillez saisir votre caisse actuelle. Notez aussi qu'elle sera mise à jour dès que vous saisissez ou modifiez une cotisation ou une dépense.
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
