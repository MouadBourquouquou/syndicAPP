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
    Schema::table('paiement', function (Blueprint $table) {
        $table->decimal('montant', 10, 2)->after('id_S'); // ou après la colonne souhaitée
    });
}

public function down()
{
    Schema::table('paiement', function (Blueprint $table) {
        $table->dropColumn('montant');
    });
}

};
