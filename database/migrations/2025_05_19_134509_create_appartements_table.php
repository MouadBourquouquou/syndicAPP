<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appartements', function (Blueprint $table) {
            $table->id(); // id auto-incrémenté

            $table->string('CIN_A', 10); // CIN du propriétaire
            $table->string('Nom', 100);
            $table->string('Prenom', 100);

            $table->unsignedBigInteger('immeuble_id'); // clé étrangère vers immeubles

            $table->string('numero', 50); // numéro de porte (pas unique seul)

            $table->decimal('surface', 8, 2); // surface en m²

            $table->decimal('montant_cotisation_mensuelle', 10, 2); // montant en MAD

            $table->date('dernier_mois_paye'); // format YYYY-MM-DD

            $table->string('telephone', 20); // numéro téléphone format +212...

            $table->timestamps(); // created_at et updated_at

            // Clé étrangère
            $table->foreign('immeuble_id')
                ->references('id')
                ->on('immeubles')
                ->onDelete('cascade');

            // Unicité combinée immeuble + numéro
            $table->unique(['immeuble_id', 'numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
