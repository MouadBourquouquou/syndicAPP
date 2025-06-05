<!-- Exemple de formulaire -->
<form action="{{ route('paiements.store') }}" method="POST">
    @csrf

    <!-- ID de l'appartement concerné -->
    <input type="hidden" name="id_A" value="{{ $appartement->id_A }}">

    <!-- Champ facultatif : numéro de reçu -->
    <label for="recu">Numéro de reçu (optionnel)</label>
    <input type="text" name="recu" id="recu">

    <!-- Bouton de validation -->
    <button type="submit" class="btn btn-success">Valider le paiement</button>
</form>
