@extends('layouts.app')

@section('title', 'Ajouter un appartement')

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

#immeuble-full-message {
    background-color: #fff3cd;
    padding: 0.5rem;
    border-radius: 4px;
    border-left: 4px solid #ffc107;
    font-size: 0.9rem;
    margin-top: 0.5rem;
    transition: all 0.3s ease;
}

button[disabled] {
    opacity: 0.7;
    cursor: not-allowed;
}
/* Style du bouton désactivé */
.btn-submit:disabled {
    background: linear-gradient(135deg, #cccccc 0%, #999999 100%);
    cursor: not-allowed;
}

/* Animation hover seulement si actif */
.btn-submit:not(:disabled):hover::before {
    left: 100%;
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

                <form method="POST" action="{{ route('appartements.store') }}" id="apartmentForm" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="immeuble" class="form-label">Immeuble</label>
                        <select id="immeuble" name="immeuble_id" class="form-control @error('immeuble_id') error @enderror" required>
                            <option value="">-- Sélectionner un immeuble --</option>
                            @foreach($immeubles as $immeuble)
                                <option value="{{ $immeuble->id }}" {{ old('immeuble_id') == $immeuble->id ? 'selected' : '' }}>
                                    🏢 {{ $immeuble->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('immeuble_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero" class="form-label">N° de porte</label>
                        <input type="text" id="numero" name="numero" class="form-control @error('numero') error @enderror" placeholder="Ex : 12B" value="{{ old('numero') }}" required>
                        @error('numero')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="surface" class="form-label">Surface (m²)</label>
                        <input type="number" id="surface" name="surface" class="form-control @error('surface') error @enderror" min="1" step="0.1" placeholder="Ex : 45.5" value="{{ old('surface') }}" required>
                        @error('surface')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                  <div class="form-group">
    <label for="montant_cotisation_mensuelle" class="form-label">Montant de la cotisation mensuelle (DH)</label>
    <input type="number" id="montant_cotisation_mensuelle" name="montant_cotisation_mensuelle" class="form-control @error('montant_cotisation_mensuelle') error @enderror" min="0" step="0.01" placeholder="Ex : 1500.00" value="{{ old('montant_cotisation_mensuelle') }}">
    @error('montant_cotisation_mensuelle')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="dernier_mois_paye" class="form-label">Dernier mois payé</label>
<input type="text" id="dernier_mois_paye" name="dernier_mois_paye" class="form-control @error('dernier_mois_paye') error @enderror" value="{{ old('dernier_mois_paye') }}" placeholder="YYYY-MM" required>
    @error('dernier_mois_paye')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
                   
                    <hr style="margin: 2rem 0; border-top: 2px dashed #ccc;">

                    <h5 class="form-subtitle" style="text-align:left; margin-bottom: 1rem;">Informations du copropriétaire</h5>

                    <div class="form-group">
                        <label for="cin" class="form-label">CIN</label>
                        <input type="text" id="cin" name="CIN_A" class="form-control @error('CIN_A') error @enderror" placeholder="Ex : AB123456" value="{{ old('CIN_A') }}" required>
                        @error('CIN_A')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" id="nom" name="Nom" class="form-control @error('Nom') error @enderror" placeholder="Ex : Dupont" value="{{ old('Nom') }}" required>
                        @error('Nom')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" name="Prenom" class="form-control @error('Prenom') error @enderror" placeholder="Ex : Jean" value="{{ old('Prenom') }}" required>
                        @error('Prenom')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="telephone" class="form-label">Téléphone mobile</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') error @enderror" placeholder="+212 6 12 34 56 78" pattern="^\+212[ \d]{9,13}$" value="{{ old('telephone') }}" required>
                        @error('telephone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                      <div class="form-group">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
    @error('email')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

                    <button type="submit" class="btn-submit">Ajouter l'appartement</button>
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
  flatpickr("#dernier_mois_paye", {
    plugins: [
        new monthSelectPlugin({
            shorthand: true, // ou false selon affichage voulu
            dateFormat: "Y-m", // Format que Laravel attend
            altFormat: "F Y",  // Format visible par l'utilisateur
        })
    ],
    allowInput: true
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

    form.addEventListener('submit', function () {
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
    document.getElementById('immeuble').addEventListener('change', function() {
    const immeubleId = this.value;
    const submitButton = document.querySelector('button[type="submit"]');
    let fullMessage = document.getElementById('immeuble-full-message');

    // Créer le message si inexistant
    if (!fullMessage) {
        fullMessage = document.createElement('div');
        fullMessage.id = 'immeuble-full-message';
        fullMessage.className = 'text-danger mt-2';
        this.parentNode.appendChild(fullMessage);
    }

    // Réinitialisation à chaque changement
    fullMessage.style.display = 'none';
    submitButton.disabled = false;

    if (immeubleId) {
        // 1. Récupérer les infos de l'immeuble
        fetch(`/immeubles/${immeubleId}/info`)
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(immeubleData => {
                // 2. Récupérer le nombre actuel d'appartements
                return fetch(`/immeubles/${immeubleId}/appartements-count`)
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur réseau');
                        return response.json();
                    })
                    .then(countData => {
                        // Vérification capacité
                        const isFull = countData.current_count >= immeubleData.nombre_app;
                        
                        if (isFull) {
                            fullMessage.textContent = `⚠️ Immeuble complet (${countData.current_count}/${immeubleData.nombre_app} appartements)`;
                            fullMessage.style.display = 'block';
                        }
                        
                        // Bloquer le bouton si plein
                        submitButton.disabled = isFull;
                        
                        // Stocker l'état dans le formulaire
                        document.getElementById('apartmentForm').dataset.immeubleFull = isFull;
                    });
            })
            .catch(error => {
                console.error('Erreur:', error);
                fullMessage.textContent = 'Erreur de vérification';
                fullMessage.style.display = 'block';
            });
    }
});

// Empêcher la soumission si immeuble plein
document.getElementById('apartmentForm').addEventListener('submit', function(e) {
    if (this.dataset.immeubleFull === 'true') {
        e.preventDefault();
        alert("Impossible d'ajouter - immeuble complet!");
    }
});
</script>
@endpush
