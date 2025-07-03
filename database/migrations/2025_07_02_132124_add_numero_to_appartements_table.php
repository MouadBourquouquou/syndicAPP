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
        $table->string('numero', 50)->after('immeuble_id');
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn('numero');
    });
}

};
