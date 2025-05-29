<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmeublesTable extends Migration
{
    public function up()
    {
        Schema::create('immeuble', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('ville')->nullable();          // nullable car immeuble peut appartenir à résidence
            $table->string('code_postal')->nullable();    // idem
            $table->string('adresse')->nullable();        // idem
            $table->integer('nombre_app')->default(0);    // champ ajouté pour nombre d'appartements
            $table->decimal('cotisation', 10, 2);
            $table->decimal('caisse', 10, 2)->nullable(); // nullable car pas toujours rempli si résidence
            $table->foreignId('residence_id')->nullable()->constrained('residences')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('immeuble');
    }
}
