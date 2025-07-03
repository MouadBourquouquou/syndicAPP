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
        $table->string('telephone',20)->after('Prenom');
        $table->string('email')->nullable()->after('telephone'); // si tu as cette colonne
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn([
            'telephone',
            'email',
        ]);
    });
}

};
