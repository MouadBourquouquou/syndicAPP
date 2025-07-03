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
        $table->date('dernier_mois_paye')->after('montant_cotisation_mensuelle');
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn('dernier_mois_paye');
    });
}

};
