<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiement', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_A')->constrained('appartements')->onDelete('cascade');
            $table->foreignId('id_E')->constrained('employes')->onDelete('cascade');
            $table->foreignId('id_S')->constrained('syndics')->onDelete('cascade');

            $table->decimal('montant', 10, 2);
            $table->date('mois_paye');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiement');
    }
};
