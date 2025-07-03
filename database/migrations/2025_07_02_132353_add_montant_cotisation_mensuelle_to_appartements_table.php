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
        $table->decimal('montant_cotisation_mensuelle', 10, 2)->after('surface');
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn('montant_cotisation_mensuelle');
    });
}

};
