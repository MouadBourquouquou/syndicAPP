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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('immeuble_id');
            $table->unsignedBigInteger('id_residence')->nullable();

            $table->string('type', 255);
            $table->text('description')->nullable();

            $table->decimal('montant', 10, 2);
            $table->date('date');

            $table->timestamps();

            // Clés étrangères
            $table->foreign('immeuble_id')->references('id')->on('immeuble')->onDelete('cascade');
            $table->foreign('id_residence')->references('id')->on('residences')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
