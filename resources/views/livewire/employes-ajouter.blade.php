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
 /* Conteneur de la liste de cases à cocher */
/* Conteneur de la liste de cases à cocher */
.checkbox-list {
    display: grid;
    gap: 0.75rem; /* Espacement entre les éléments */
    padding: 1rem;
    background-color: #f0f4f8; /* Un fond très léger et apaisant */
    border-radius: 12px;
    border: 1px solid #e2e8f0; /* Bordure très subtile */
    max-height: 250px; /* Hauteur maximale pour le défilement */
    overflow-y: auto; /* Permet le défilement vertical si nécessaire */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.03); /* Ombre interne subtile pour la profondeur du conteneur */
}

/* Chaque élément de case à cocher (la "carte" individuelle) */
.checkbox-list.form-check {
    display: flex;
    align-items: center;
    background: white;
    padding: 12px 16px; /* Espace généreux pour la clarté */
    border-radius: 8px; /* Rayon de bordure légèrement plus petit pour un look plus net */
    border: 1px solid #cbd5e1; /* Bordure par défaut, discrète */
    transition: all 0.2s ease-in-out; /* Transition douce pour tous les changements */
    cursor: pointer; /* Indique que l'élément est cliquable */
}

/* Effet au survol de chaque élément */
.checkbox-list.form-check:hover {
    background-color: #ecfdf5; /* Fond très léger vert au survol */
    border-color: #34d399; /* Bordure verte plus prononcée au survol */
    transform: translateY(-2px); /* Léger soulèvement pour un feedback d'interaction */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Ombre plus visible au survol */
}

/* Style de la case à cocher elle-même */
.checkbox-list.form-check-input {
    margin-right: 16px; /* Espace entre la case et le texte */
    width: 20px; /* Taille pour une meilleure visibilité */
    height: 20px;
    accent-color: #10b981; /* Couleur d'accentuation verte vive */
    transition: transform 0.2s ease-in-out, border-color 0.2s ease-in-out;
    flex-shrink: 0; /* Empêche la case à cocher de rétrécir */
    border: 2px solid #94a3b8; /* Bordure par défaut pour la case à cocher */
    border-radius: 4px; /* Légèrement arrondi */
}

/* Effet lorsque la case à cocher est cochée */
.checkbox-list.form-check-input:checked {
    transform: scale(1.05); /* Léger zoom */
    border-color: #10b981; /* Bordure de la même couleur que l'accent */
}

/* Style de l'élément parent (.form-check) lorsque la case à cocher est cochée */
/* Utilise :has() pour styliser l'ensemble de la "carte" lorsque sa case à cocher est sélectionnée */
.checkbox-list.form-check:has(.form-check-input:checked) {
    background-color: #dcfce7; /* Fond vert clair pour l'élément sélectionné */
    border-color: #10b981; /* Bordure de couleur primaire pour l'élément sélectionné */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Ombre subtile pour l'état sélectionné */
}

/* Style du label de la case à cocher */
.checkbox-list.form-check-label {
    font-size: 1rem; /* Taille de police de 16px pour une excellente lisibilité [1, 2] */
    color: #334155; /* Couleur de texte sombre pour un bon contraste */
    flex-grow: 1; /* Permet au label de prendre tout l'espace disponible */
}

/* Style du label lorsque la case à cocher est cochée */
.checkbox-list.form-check-input:checked +.form-check-label {
    color: #10b981; /* Changer la couleur du texte du label pour correspondre à l'accentuation */
    font-weight: 600; /* Rendre le texte plus gras pour souligner la sélection */
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

                <form method="POST" action="{{ route('employes.store') }}">
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
    <label for="residence_id">Résidence</label>
    <select id="residence_id" name="residence_id" class="form-control">
        <option value="">-- Aucune résidence --</option>
        @foreach($residences as $residence)
            <option value="{{ $residence->id }}">{{ $residence->nom }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="immeubles">Immeubles </label>
   <div id="immeubles_container" class="checkbox-list"  name="immeubles[]" ></div>

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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var allImmeubles = [];

    function afficherImmeubles(immeubles) {
        var container = $('#immeubles_container');
        container.empty();

        if (immeubles.length === 0) {
            container.append('<p>Aucun immeuble disponible.</p>');
            return;
        }

        immeubles.forEach(function(immeuble) {
            var checkbox = `
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="immeuble_${immeuble.id}" name="immeubles[]" value="${immeuble.id}">
                    <label class="form-check-label" for="immeuble_${immeuble.id}">${immeuble.nom} (Résidence: ${immeuble.residence_nom || 'N/A'})</label>
                </div>
            `;
            container.append(checkbox);
        });
    }

    // Chargement initial : récupérer tous les immeubles (avec résidence)
    $.ajax({
        url: '/immeubles/tous',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            allImmeubles = data;
            afficherImmeubles(allImmeubles);
        },
        error: function() {
            $('#immeubles_container').html('<p>Erreur lors du chargement des immeubles.</p>');
        }
    });

    // Filtrer quand résidence change
    $('#residence_id').on('change', function() {
        var residenceId = $(this).val();

        if (!residenceId) {
            // Aucune résidence = afficher tous les immeubles
            afficherImmeubles(allImmeubles);
            return;
        }

        // Filtrer les immeubles côté client
        var filtered = allImmeubles.filter(function(i) {
            return i.residence_id == residenceId;
        });

        afficherImmeubles(filtered);
    });
});
</script>
@endpush