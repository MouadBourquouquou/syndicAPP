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
    Schema::create('appartements', function (Blueprint $table) {
        $table->id();
        $table->string('numero')->unique();
        $table->unsignedBigInteger('immeuble_id'); // Clé étrangère vers immeuble
        $table->integer('surface');
        $table->integer('nombre_pieces');
        $table->timestamps();

        // Contrainte clé étrangère
        $table->foreign('immeuble_id')->references('id')->on('immeubles')->onDelete('cascade');
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
