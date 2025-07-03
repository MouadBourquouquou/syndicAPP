@extends('layouts.app')

@section('title', 'Ajouter un employé')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet" />
<style>
    .checkbox-container {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
    }
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 10px;
    }
    .residence-loading {
        display: none;
        color: #6b7280;
        font-size: 14px;
        margin-top: 5px;
    }
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .debug-info {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin-top: 10px;
        font-family: monospace;
        font-size: 12px;
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

                <!-- FIXED: Changed to POST method -->
                <form method="POST" action="{{ route('employes.store') }}" id="employeeForm">
                    @csrf

                    <!-- Nom -->
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom <span class="required-star">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control @error('nom') error @enderror" 
                               value="{{ old('nom') }}" required>
                        @error('nom')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom <span class="required-star">*</span></label>
                        <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') error @enderror" 
                               value="{{ old('prenom') }}" required>
                        @error('prenom')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span class="required-star">*</span></label>
                        <input type="email" id="email" name="email" class="form-control @error('email') error @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="form-group">
                        <label for="telephone" class="form-label">Téléphone mobile</label>
                        <input type="text" id="telephone" name="telephone" 
                               class="form-control @error('telephone') error @enderror" 
                               value="{{ old('telephone') }}">
                        @error('telephone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Ville -->
                    <div class="form-group">
                        <label for="ville" class="form-label">Ville</label>
                        <select id="ville" name="ville" class="form-control @error('ville') error @enderror">
                            <option value="">-- Choisir une ville --</option>
                            <option value="Casablanca" {{ old('ville') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                            <option value="Rabat" {{ old('ville') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                            <option value="Marrakech" {{ old('ville') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                        </select>
                        @error('ville')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="form-group">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea id="adresse" name="adresse" class="form-control @error('adresse') error @enderror">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Poste -->
                    <div class="form-group">
                        <label for="poste" class="form-label">Poste <span class="required-star">*</span></label>
                        <select id="poste" name="poste" class="form-control @error('poste') error @enderror" required>
                            <option value="">-- Choisir un poste --</option>
                            <option value="assistant_syndic" {{ old('poste') == 'assistant_syndic' ? 'selected' : '' }}>Assistant syndic</option>
                            <option value="concierge" {{ old('poste') == 'concierge' ? 'selected' : '' }}>Concierge</option>
                            <option value="femme_menage" {{ old('poste') == 'femme_menage' ? 'selected' : '' }}>Femme de ménage</option>
                        </select>
                        @error('poste')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Résidence -->
                    <div class="form-group">
                        <label for="residence_id" class="form-label">Résidence</label>
                        <select id="residence_id" name="residence_id" class="form-control @error('residence_id') error @enderror" disabled>
                            <option value="">-- Choisir d'abord une ville --</option>
                        </select>
                        <div class="residence-loading">
                            <small>Chargement des résidences...</small>
                        </div>
                        @error('residence_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Immeubles -->
                    <div class="form-group">
                        <label class="form-label">Immeubles</label>
                        <div id="immeubles_container" class="checkbox-container">
                            <p class="text-muted">Veuillez d'abord sélectionner une ville</p>
                        </div>
                        <div id="debug_info" class="debug-info" style="display: none;">
                            <strong>Debug Info:</strong><br>
                            <span id="debug_text"></span>
                        </div>
                        @error('immeubles')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_embauche" class="form-label">Date d'embauche <span class="required-star">*</span></label>
                        <input type="date" id="date_embauche" name="date_embauche" 
                            class="form-control @error('date_embauche') error @enderror" 
                            value="{{ old('date_embauche') }}" required>
                        @error('date_embauche')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <!-- Salaire -->
                    <div class="form-group input-salaire-wrapper">
                        <label for="salaire" class="form-label">Salaire</label>
                        <input type="number" id="salaire" name="salaire" 
                               class="form-control @error('salaire') error @enderror" 
                               value="{{ old('salaire') }}" step="0.01" min="0">
                        @error('salaire')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Bouton -->
                    <button type="submit" class="btn-submit">Ajouter l'employé</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Configuration variables
    const oldImmeubles = @json(old('immeubles', []));
    const oldResidenceId = @json(old('residence_id'));
    const csrfToken = '{{ csrf_token() }}';

    // Phone formatting
    document.getElementById('telephone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('212')) {
            value = '+212 ' + value.slice(3).replace(/(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4');
        } else if (value.startsWith('0')) {
            value = '+212 ' + value.slice(1).replace(/(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4');
        }
        e.target.value = value.trim();
    });

    // Main functionality
    $(document).ready(function() {
        const immeublesContainer = $('#immeubles_container');
        const loadingSpinner = $('.loading-spinner');
        const residenceLoadingSpinner = $('.residence-loading');
        const residenceSelect = $('#residence_id');

        // Function to load residences based on ville
        function loadResidences(ville = null) {
            
            if (!ville) {
                residenceSelect.html('<option value="">-- Choisir d\'abord une ville --</option>');
                residenceSelect.prop('disabled', true);
                return;
            }

            residenceLoadingSpinner.show();
            residenceSelect.prop('disabled', true);

            $.ajax({
                url: `/api/residences?ville=${encodeURIComponent(ville)}`,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    
                    let html = '<option value="">-- Aucune résidence --</option>';
                    data.forEach(residence => {
                        const selected = oldResidenceId == residence.id ? 'selected' : '';
                        html += `<option value="${residence.id}" ${selected}>${residence.nom}</option>`;
                    });
                    residenceSelect.html(html);
                    residenceSelect.prop('disabled', false);
                    
                    // If a residence was selected, load its immeubles
                    if (oldResidenceId) {
                        loadImmeubles(oldResidenceId, ville);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading residences:', xhr.responseText);
                    residenceSelect.html('<option value="">Erreur de chargement</option>');
                    residenceSelect.prop('disabled', false);
                },
                complete: function() {
                    residenceLoadingSpinner.hide();
                }
            });
        }

        // Function to load immeubles based on residence and ville
        function loadImmeubles(residenceId = null, ville = null) {
            
            if (!ville) {
                immeublesContainer.html('<p class="text-muted">Veuillez d\'abord sélectionner une ville</p>');
                return;
            }

            loadingSpinner.show();
            immeublesContainer.html('<div class="loading-spinner"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Chargement...</span></div></div>');

            // Build URL with appropriate parameters
            let url = '/api/immeubles?';
            let params = [`ville=${encodeURIComponent(ville)}`];
            
            if (residenceId) {
                params.push(`residence_id=${encodeURIComponent(residenceId)}`);
            }
            
            url += params.join('&');


            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    renderImmeubles(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading immeubles:', xhr.responseText);
                    immeublesContainer.html('<div class="alert alert-danger">Erreur lors du chargement des immeubles</div>');
                },
                complete: function() {
                    loadingSpinner.hide();
                }
            });
        }

        function renderImmeubles(immeubles) {            
            if (immeubles.length === 0) {
                immeublesContainer.html('<p class="text-muted">Aucun immeuble disponible pour cette sélection</p>');
                return;
            }

            let html = '';
            immeubles.forEach(immeuble => {
                // Only show immeubles that match the current ville
                const selectedVille = $('#ville').val();
                if (immeuble.ville === selectedVille || 
                    (immeuble.residence && immeuble.residence.ville === selectedVille)) {
                    const checked = oldImmeubles.includes(String(immeuble.id)) ? 'checked' : '';
                    const residenceName = immeuble.residence ? immeuble.residence.nom : 'Aucune résidence';
                    html += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="immeubles[]" value="${immeuble.id}" 
                                id="immeuble_${immeuble.id}" ${checked}>
                            <label class="form-check-label" for="immeuble_${immeuble.id}">
                                ${immeuble.nom} (${residenceName})
                            </label>
                        </div>
                    `;
                }
            });

            immeublesContainer.html(html || '<p class="text-muted">Aucun immeuble disponible pour cette sélection</p>');
        }

        // Initial load
        const initialVille = $('#ville').val();
        
        if (initialVille) {
            loadResidences(initialVille);
            loadImmeubles(null, initialVille);
        } else {
            loadResidences();
            loadImmeubles();
        }

        // Event listener for ville change
        $('#ville').change(function() {
            const selectedVille = $(this).val();
            
            // Reset residence selection
            residenceSelect.val('');
            
            // Load residences for selected ville
            loadResidences(selectedVille);
            
            // Load immeubles for selected ville (includes those without residence)
            loadImmeubles(null, selectedVille);
        });

        // Event listener for residence change
        $('#residence_id').change(function() {
            const selectedResidence = $(this).val();
            const selectedVille = $('#ville').val();            
            // Load immeubles based on residence and ville
            loadImmeubles(selectedResidence, selectedVille);
        });
    });
</script>
@endpush