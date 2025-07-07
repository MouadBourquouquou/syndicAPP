@extends('layouts.app')

@section('title', 'Ajouter une résidence')

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
    }

    .text-danger {
        color: red;
        margin-left: 4px;
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

    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        appearance: none;
        cursor: pointer;
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

    /* Style du texte info sous label MONTANT en caisse disponible */
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
                <h3 class="form-title">Ajouter une résidence</h3>
                <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                <form id="residenceForm" method="POST" action="{{ route('residence.store') }}"> 
                    @csrf

                    <div class="form-group">
                        <label for="nom" class="form-label">Nom de la résidence <span class="text-danger">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required />
                        @error('nom')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre_immeubles" class="form-label">Nombre d’immeubles <span class="text-danger">*</span></label>
                        <input type="number" id="nombre_immeubles" name="nombre_immeubles" class="form-control" min="1" value="{{ old('nombre_immeubles') }}" required />
                        @error('nombre_immeubles')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div> 

                    <div class="form-group">
                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                        <select id="ville" name="ville" class="form-control" required>
                            <option value="" disabled {{ old('ville') ? '' : 'selected' }}>-- Choisir une ville --</option>
                            <option value="Casablanca" {{ old('ville') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                            <option value="Rabat" {{ old('ville') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                            <option value="Marrakech" {{ old('ville') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                            <option value="Fès" {{ old('ville') == 'Fès' ? 'selected' : '' }}>Fès</option>
                            <option value="Tanger" {{ old('ville') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                            <option value="Agadir" {{ old('ville') == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                            <option value="Meknès" {{ old('ville') == 'Meknès' ? 'selected' : '' }}>Meknès</option>
                            <option value="Oujda" {{ old('ville') == 'Oujda' ? 'selected' : '' }}>Oujda</option>
                            <option value="Kenitra" {{ old('ville') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                            <option value="Temara" {{ old('ville') == 'Temara' ? 'selected' : '' }}>Temara</option>
                        </select>
                        @error('ville')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div> 

                    <div class="form-group">
                        <label for="code_postal" class="form-label">Code postal <span class="text-danger">*</span></label>
                        <input type="text" id="code_postal" name="code_postal" class="form-control" value="{{ old('code_postal') }}" required />
                        @error('code_postal')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                        <input type="text" id="adresse" name="adresse" class="form-control" value="{{ old('adresse') }}" required />
                        @error('adresse')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="cotisation-group">
                        <label for="cotisation" class="form-label">Montant de la cotisation mensuelle (DH)</label>
                        <input type="number" id="cotisation" name="cotisation" class="form-control" value="{{ old('cotisation') }}" required />
                        @error('cotisation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="caisse-group">
                        <label for="caisse" class="form-label">Montant en caisse disponible</label>
                        <div class="info-caisse">
                            Veuillez saisir votre caisse actuelle. Elle sera mise à jour automatiquement selon les cotisations ou dépenses.
                        </div>
                        <input type="number" id="caisse" name="caisse" class="form-control" value="{{ old('caisse') }}" required />
                        @error('caisse')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">Ajouter la résidence</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('residenceForm');
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

    form.addEventListener('submit', function () {
        form.classList.add('loading');
    });
</script>
@endpush
