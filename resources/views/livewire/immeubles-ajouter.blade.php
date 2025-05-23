<div class="card p-4 shadow rounded" style="max-width: 500px; margin: auto;">
    <h3 class="mb-4">Ajouter un appartement</h3>

    <form>
        <div class="mb-3">
            <label for="immeuble" class="form-label">Immeuble</label>
            <select id="immeuble" name="immeuble_id" class="form-control" required>
                <option value="">-- Sélectionner un immeuble --</option>
                <option value="1">Immeuble Alpha</option>
                <option value="2">Immeuble Beta</option>
                <option value="3">Immeuble Gamma</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="numero" class="form-label">N° de porte</label>
            <input type="text" id="numero" name="numero" class="form-control" placeholder="Ex : 12B" required>
        </div>

        <div class="mb-3">
            <label for="surface" class="form-label">Surface (m²)</label>
            <input type="number" id="surface" name="surface" class="form-control" min="1" step="0.1" placeholder="Ex : 45.5" required>
        </div>

        <div class="mb-3">
            <label for="dernier_mois_paye" class="form-label">Dernier mois payé</label>
            <input type="month" id="dernier_mois_paye" name="dernier_mois_paye" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone mobile</label>
            <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="+33 6 12 34 56 78" pattern="^\+?[0-9\s\-]{7,15}$" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l'appartement</button>
    </form>
</div>
