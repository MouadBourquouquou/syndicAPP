<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appartement_id');
            $table->unsignedBigInteger('immeuble_id');
            $table->unsignedBigInteger('residence_id');
            $table->decimal('montant_paye', 10, 2);
            $table->date('date_operation');
            $table->date('date_prochain_paiement')->nullable();
            $table->timestamps();

            // Clés étrangères (à activer si les tables cibles existent)
            $table->foreign('appartement_id')->references('id')->on('appartements')->onDelete('cascade');
            $table->foreign('immeuble_id')->references('id')->on('immeubles')->onDelete('cascade');
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historiques');
    }
};
