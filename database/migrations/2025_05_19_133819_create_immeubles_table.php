<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmeublesTable extends Migration
{
    public function up()
{
    if (!Schema::hasTable('immeuble')) {
        Schema::create('immeuble', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('adresse')->nullable();
            $table->integer('nombre_app')->default(0);
            $table->decimal('cotisation', 10, 2);
            $table->decimal('caisse', 10, 2)->nullable();
            $table->foreignId('residence_id')->nullable()->constrained('residences')->onDelete('set null');
            $table->timestamps();
        });
    }
}


    public function down()
    {
        Schema::dropIfExists('immeuble');
    }
}
