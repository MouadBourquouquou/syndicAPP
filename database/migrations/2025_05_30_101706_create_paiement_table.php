<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiement', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_A')->constrained('appartements')->onDelete('cascade');

            $table->json('mois_payes')->nullable();

            // Si id_E et id_S existent déjà dans la table paiement (ceci ne marche pas dans create())
            // il faut faire ces changements dans une migration séparée, car ici on crée la table.
            // Sinon, on peut les ajouter ici en nullable si ce sont des colonnes nouvelles :

            $table->integer('id_E')->nullable();
            $table->integer('id_S')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiement');
    }
};
