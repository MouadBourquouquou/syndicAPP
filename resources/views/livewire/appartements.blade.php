@extends('layouts.app')

@section('title', 'Liste des appartements')
@push('styles')
<style>
    .card-appartement {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-appartement h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    /* Affichage vertical des données, une donnée par ligne */
    .card-appartement .card-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .card-field {
        margin-bottom: 8px;
    }
    .card-field strong {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
    }
    .card-field span {
        display: block;
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.75rem;
        padding: 5px 8px;
        border-radius: 12px;
        color: white;
        background-color: #10b981;
    }
    .actions {
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-view { background-color: #111827; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }
    .btn:hover { opacity: 0.85; }
</style>

@endpush

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Liste des appartements</h4>

    @forelse ($appartements as $appartement)
        <div class="card-appartement">
            <h5>{{ $appartement->immeuble->nom ?? 'Immeuble inconnu' }} - Appartement {{ $appartement->numero }}</h5>
            
            <div class="card-body">
                <div class="card-field">
                    <strong>Nom</strong>
                    <span>{{ $appartement->Nom }} {{ $appartement->Prenom }}</span>
                </div>

                <div class="card-field" style="display: flex; align-items: center; gap: 6px;">
                    <strong style="font-weight: 600; font-size: 0.85rem; color: #374151;">Dernier mois payé :</strong>
                    @if($appartement->dernier_mois_paye)
                        <span style="background-color: #4ade80; color: #065f46; padding: 3px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('M Y') }}
                        </span>
                    @else
                        <em style="color: #9ca3af; font-size: 0.75rem;">Non renseigné</em>
                    @endif
                </div>

                <div class="card-field">
                    <strong>Téléphone</strong>
                    <span>{{ $appartement->telephone ?? '-' }}</span>
                </div>
                
                <div class="card-field">
                    <strong>Email</strong>
                    <span>{{ $appartement->email ?? '-' }}</span>
                </div>
            </div>

            <div class="actions">
                <!-- Voir -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalAppartement{{ $appartement->id_A }}">
                    👁 Voir
                </button>

               <!-- Bouton Modifier déjà dans ton code -->
<button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $appartement->id_A }}">
    ✏️ Modifier
</button>

<!-- Modal Modifier Appartement -->
<div class="modal fade" id="modalEdit{{ $appartement->id_A }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $appartement->id_A }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('appartement.update', $appartement->id_A) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $appartement->id_A }}">Modifier l'appartement {{ $appartement->numero }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Numéro -->
                    <div class="mb-3">
                        <label for="numero{{ $appartement->id_A }}" class="form-label">Numéro</label>
                        <input type="text" class="form-control" id="numero{{ $appartement->id_A }}" name="numero" value="{{ old('numero', $appartement->numero) }}" required>
                    </div>

                    <!-- Immeuble -->
                    <div class="mb-3">
                        <label for="immeuble_id{{ $appartement->id_A }}" class="form-label">Immeuble</label>
                        <select class="form-select" id="immeuble_id{{ $appartement->id_A }}" name="immeuble_id" required>
                            <option value="">Sélectionnez un immeuble</option>
                            @foreach($immeubles as $immeuble)
                                <option value="{{ $immeuble->id }}" {{ (old('immeuble_id', $appartement->immeuble_id) == $immeuble->id) ? 'selected' : '' }}>
                                    {{ $immeuble->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="Nom{{ $appartement->id_A }}" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="Nom{{ $appartement->id_A }}" name="Nom" value="{{ old('Nom', $appartement->Nom) }}">
                    </div>

                    <!-- Prénom -->
                    <div class="mb-3">
                        <label for="Prenom{{ $appartement->id_A }}" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="Prenom{{ $appartement->id_A }}" name="Prenom" value="{{ old('Prenom', $appartement->Prenom) }}">
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3">
                        <label for="telephone{{ $appartement->id_A }}" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone{{ $appartement->id_A }}" name="telephone" value="{{ old('telephone', $appartement->telephone) }}">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email{{ $appartement->id_A }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email{{ $appartement->id_A }}" name="email" value="{{ old('email', $appartement->email) }}">
                    </div>

                    <!-- Surface -->
                    <div class="mb-3">
                        <label for="surface{{ $appartement->id_A }}" class="form-label">Surface (m²)</label>
                        <input type="number" step="0.01" class="form-control" id="surface{{ $appartement->id_A }}" name="surface" value="{{ old('surface', $appartement->surface) }}">
                    </div>

                    <!-- Montant cotisation mensuelle -->
                    <div class="mb-3">
                        <label for="montant_cotisation_mensuelle{{ $appartement->id_A }}" class="form-label">Montant cotisation mensuelle (MAD)</label>
                        <input type="number" step="0.01" class="form-control" id="montant_cotisation_mensuelle{{ $appartement->id_A }}" name="montant_cotisation_mensuelle" value="{{ old('montant_cotisation_mensuelle', $appartement->montant_cotisation_mensuelle) }}">
                    </div>

                    <!-- CIN -->
                    <div class="mb-3">
                        <label for="CIN_A{{ $appartement->id_A }}" class="form-label">CIN</label>
                        <input type="text" class="form-control" id="CIN_A{{ $appartement->id_A }}" name="CIN_A" value="{{ old('CIN_A', $appartement->CIN_A) }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

                <!-- Supprimer -->
                <form action="{{ route('appartement.destroy', $appartement) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet appartement ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        {{-- Modal Voir Détails --}}
        <div class="modal fade" id="modalAppartement{{ $appartement->id_A }}" tabindex="-1" aria-labelledby="modalLabel{{ $appartement->id_A }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $appartement->id_A }}">Détails de l'appartement</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row"><div class="col-md-6"><strong>Numéro :</strong></div><div class="col-md-6">{{ $appartement->numero }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Immeuble :</strong></div><div class="col-md-6">{{ $appartement->immeuble->nom ?? 'Inconnu' }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Nom :</strong></div><div class="col-md-6">{{ $appartement->Nom }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Prénom :</strong></div><div class="col-md-6">{{ $appartement->Prenom }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>CIN :</strong></div><div class="col-md-6">{{ $appartement->CIN_A }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Surface :</strong></div><div class="col-md-6">{{ $appartement->surface }} m²</div></div>
                            <div class="row"><div class="col-md-6"><strong>Montant cotisation :</strong></div><div class="col-md-6">{{ number_format($appartement->montant_cotisation_mensuelle, 2, ',', ' ') }} MAD</div></div>
                            <div class="row"><div class="col-md-6"><strong>Dernier mois payé :</strong></div>
                                <div class="col-md-6">
                                    @if($appartement->dernier_mois_paye)
                                        {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
                                    @else
                                        Non renseigné
                                    @endif
                                </div>
                            </div>
                            <div class="row"><div class="col-md-6"><strong>Téléphone :</strong></div><div class="col-md-6">{{ $appartement->telephone ?? '-' }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Créé le :</strong></div><div class="col-md-6">{{ $appartement->created_at ? $appartement->created_at->format('d/m/Y H:i') : '-' }}</div></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPaiement{{ $appartement->id_A }}">
                            💳 Ajouter un paiement
                        </button>
                    </div>
                </div>
            </div>
        </div>

  {{-- Modal Ajouter Paiement --}}
  {{-- Modal Voir Détails --}}
<div class="modal fade" id="modalAppartement{{ $appartement->id_A }}" tabindex="-1" aria-labelledby="modalLabel{{ $appartement->id_A }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $appartement->id_A }}">Détails de l'appartement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row"><div class="col-md-6"><strong>Numéro :</strong></div><div class="col-md-6">{{ $appartement->numero }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>Immeuble :</strong></div><div class="col-md-6">{{ $appartement->immeuble->nom ?? 'Inconnu' }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>Nom :</strong></div><div class="col-md-6">{{ $appartement->Nom }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>Prénom :</strong></div><div class="col-md-6">{{ $appartement->Prenom }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>CIN :</strong></div><div class="col-md-6">{{ $appartement->CIN_A }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>Surface :</strong></div><div class="col-md-6">{{ $appartement->surface }} m²</div></div>
                    <div class="row"><div class="col-md-6"><strong>Montant cotisation :</strong></div><div class="col-md-6">{{ number_format($appartement->montant_cotisation_mensuelle, 2, ',', ' ') }} MAD</div></div>
                    <div class="row"><div class="col-md-6"><strong>Dernier mois payé :</strong></div>
                        <div class="col-md-6">
                            @if($appartement->dernier_mois_paye)
                                {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
                            @else
                                Non renseigné
                            @endif
                        </div>
                    </div>
                    <div class="row"><div class="col-md-6"><strong>Téléphone :</strong></div><div class="col-md-6">{{ $appartement->telephone ?? '-' }}</div></div>
                    <div class="row"><div class="col-md-6"><strong>Créé le :</strong></div><div class="col-md-6">{{ $appartement->created_at ? $appartement->created_at->format('d/m/Y H:i') : '-' }}</div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPaiement{{ $appartement->id_A }}">
                    💳 Ajouter un paiement
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ajouter Paiement --}}
<div class="modal fade" id="modalPaiement{{ $appartement->id_A }}" tabindex="-1" aria-labelledby="modalPaiementLabel{{ $appartement->id_A }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('paiements.store') }}">
            @csrf
            <input type="hidden" name="id_A" value="{{ $appartement->id_A }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Montant mensuel -->
                    <div class="mb-3">
                        <label class="form-label">Montant cotisation mensuelle</label>
                        <div><strong>{{ number_format($appartement->montant_cotisation_mensuelle, 2, ',', ' ') }} MAD</strong></div>
                    </div>

                    <!-- Année -->
                    <div class="mb-3">
                        <label class="form-label">Année</label>
                        <select class="form-select annee-select" name="annee" id="annee{{ $appartement->id_A }}">
                            @php
                                $currentYear = now()->year;
                                $anneeParDefaut = $anneeParDefaut ?? $currentYear;
                            @endphp
                            @for ($y = $currentYear - 1; $y <= $currentYear + 2; $y++)
                                <option value="{{ $y }}" {{ $y == $anneeParDefaut ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Mois -->
                    <div class="mb-3">
                        <label class="form-label">Mois à payer</label>
                        <div class="d-flex flex-wrap gap-2" id="moisContainer{{ $appartement->id_A }}">
                            @foreach (['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'] as $index => $moisNom)
                                <div class="form-check">
                                    <input class="form-check-input mois-checkbox"
                                            type="checkbox"
                                            name="mois[]"
                                            value="{{ $index + 1 }}"
                                            data-mois="{{ $index + 1 }}"
                                            id="mois{{ $appartement->id_A }}_{{ $index + 1 }}">
                                    <label class="form-check-label" for="mois{{ $appartement->id_A }}_{{ $index + 1 }}">{{ $moisNom }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="mb-3">
                        <label class="form-label">Montant total à payer (MAD)</label>
                        <input type="text" class="form-control" readonly id="totalMontant{{ $appartement->id_A }}" value="0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider le paiement</button>
                </div>
            </div>
        </form>
    </div>
</div>

@php
    $moisPaye = $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->month : 0;
    $anneePaye = $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->year : 0;
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    const initPaiementModal = (id) => {
        const montantMensuel = {{ $appartement->montant_cotisation_mensuelle }};
        const checkboxes = document.querySelectorAll(`#modalPaiement${id} .mois-checkbox`);
        const anneeSelect = document.getElementById(`annee${id}`);
        const totalInput = document.getElementById(`totalMontant${id}`);
        const moisPaye = {{ $moisPaye }};
        const anneePaye = {{ $anneePaye }};

        const updateTotal = () => {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked && !cb.disabled) total += montantMensuel;
            });
            totalInput.value = total.toFixed(2);
        };

        const updateMoisDisponibles = () => {
            const selectedYear = parseInt(anneeSelect.value);
            
            checkboxes.forEach(cb => {
                const mois = parseInt(cb.dataset.mois);
                
                if (selectedYear < anneePaye) {
                    cb.disabled = true;
                    cb.checked = false;
                } else if (selectedYear === anneePaye) {
                    cb.disabled = mois <= moisPaye;
                    if (cb.disabled) cb.checked = false;
                } else {
                    cb.disabled = false;
                }
            });
            updateTotal();
        };

        anneeSelect.addEventListener('change', updateMoisDisponibles);
        checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
        updateMoisDisponibles(); // Initialisation
    };

    initPaiementModal({{ $appartement->id_A }});
});
</script>  @empty
        <p>Aucun appartement trouvé.</p>
    @endforelse
</div>
@endsection