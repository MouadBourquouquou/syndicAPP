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
Schema::table('paiement', function (Blueprint $table) {
    $table->integer('id_E')->nullable()->change();
});
Schema::table('paiement', function (Blueprint $table) {
    $table->integer('id_S')->nullable()->change();
});


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiement');
    }
};
