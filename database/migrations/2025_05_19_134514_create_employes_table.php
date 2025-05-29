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
        Schema::create('employes', function (Blueprint $table) {
            $table->id('id_E'); // Clé primaire personnalisée

            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique()->nullable();
            $table->string('telephone')->nullable();
            $table->string('ville')->nullable();
            $table->string('adresse')->nullable();
            $table->string('poste');

            $table->unsignedBigInteger('immeuble_id')->nullable();
            $table->unsignedBigInteger('residence_id')->nullable();

            $table->date('date_embauche')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();

            $table->timestamps();

            // Clés étrangères
            $table->foreign('immeuble_id')
                ->references('id')
                ->on('immeuble')
                ->onDelete('set null');

            $table->foreign('residence_id')
                ->references('id')
                ->on('residences')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
