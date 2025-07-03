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
    if (!Schema::hasTable('appartements')) {
        Schema::create('appartements', function (Blueprint $table) {
            $table->bigIncrements('id_A'); 
             $table->unsignedBigInteger('immeuble_id');
            $table->timestamps();

            $table->foreign('immeuble_id')->references('id')->on('immeuble')->onDelete('cascade');

        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
