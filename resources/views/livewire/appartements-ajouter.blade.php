@extends('layouts.app')

@section('title', 'Ajouter un appartement')

@push('styles')
<!-- Flatpickr styles -->
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

    input[type="month"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 0;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-11">
            <div class="form-container">
                <h3 class="form-title">Ajouter un appartement</h3>
                <p class="form-subtitle">Remplissez les informations ci-dessous</p>

                <form id="apartmentForm" method="POST" action="{{ route('appartement.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="immeuble" class="form-label">Immeuble</label>
                        <select id="immeuble" name="immeuble_id" class="form-control" required>
                            <option value="">-- Sélectionner un immeuble --</option>
                            <option value="1">🏢 Immeuble Alpha</option>
                            <option value="2">🏢 Immeuble Beta</option>
                            <option value="3">🏢 Immeuble Gamma</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numero" class="form-label">N° de porte</label>
                        <input type="text" id="numero" name="numero" class="form-control" placeholder="Ex : 12B" required>
                    </div>

                    <div class="form-group">
                        <label for="surface" class="form-label">Surface (m²)</label>
                        <input type="number" id="surface" name="surface" class="form-control" min="1" step="0.1" placeholder="Ex : 45.5" required>
                    </div>
                       
                    <div class="form-group">
                       <label for="montant_caisse" class="form-label">MONTANT de la cotisation mensuelle (DH)</label>
                       <input type="number" id="montant_caisse" name="montant_caisse" class="form-control" min="0" step="0.01" placeholder="Ex : 1500.00" required>
                    </div>
 
                    <div class="form-group">
                        <label for="dernier_mois_paye" class="form-label">Dernier mois payé</label>
                        <input type="text" id="dernier_mois_paye" name="dernier_mois_paye" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="telephone" class="form-label">Téléphone mobile</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="+212 6 12 34 56 78" pattern="^\+212[ \d]{9,13}$" required>
                    </div>

                    <button type="submit" class="btn-submit">Ajouter l'appartement</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Flatpickr scripts -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<script>
    flatpickr("#dernier_mois_paye", {
        dateFormat: "Y-m",
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y"
            })
        ]
    });

    const form = document.getElementById('apartmentForm');
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

    document.getElementById('telephone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('212')) {
            value = '+212 ' + value.slice(3).replace(/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
        } else if (value.startsWith('0')) {
            value = '+212 ' + value.slice(1).replace(/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
        }
        e.target.value = value.trim();
    });
</script>
@endpush
