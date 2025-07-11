<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->string('CIN_A', 10)->after('dernier_mois_paye');
        // Ajouter les autres colonnes manquantes ici aussi...
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn('CIN_A');
        // Supprimer aussi les autres colonnes ajoutées
    });
}

};
