<div>
   <div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white">
            <h4>Ajouter un immeuble</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label>Nom de l'immeuble</label>
                    <input type="text" class="form-control" wire:model.defer="nom">
                    @error('nom') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Ville</label>
                    <input type="text" class="form-control" wire:model.defer="ville">
                    @error('ville') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Code postal</label>
                    <input type="text" class="form-control" wire:model.defer="code_postal">
                    @error('code_postal') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Adresse</label>
                    <textarea class="form-control" wire:model.defer="adresse"></textarea>
                    @error('adresse') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Montant de la cotisation mensuelle</label>
                    <input type="number" class="form-control" wire:model.defer="cotisation_mensuelle" step="0.01">
                    @error('cotisation_mensuelle') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Enregistrer et passer aux appartements
                </button>
            </form>
        </div>
    </div>
</div>

</div>
