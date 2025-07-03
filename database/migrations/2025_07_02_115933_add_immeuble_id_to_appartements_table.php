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
       $table->unsignedBigInteger('immeuble_id');
        $table->foreign('immeuble_id')->references('id')->on('immeuble')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropForeign(['immeuble_id']);
        $table->dropColumn('immeuble_id');
    });
}

};
