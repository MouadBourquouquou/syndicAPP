<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeImmeubleTable extends Migration
{
    public function up()
    {
        Schema::create('employe_immeuble', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers employes(id_E)
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')
                  ->references('id_E')
                  ->on('employes')
                  ->onDelete('cascade');

            // Clé étrangère vers immeuble(id)
            $table->unsignedBigInteger('immeuble_id');
            $table->foreign('immeuble_id')
                  ->references('id')
                  ->on('immeuble')
                  ->onDelete('cascade');

            $table->timestamps();

            // Pour éviter doublons : un employé lié une seule fois à un immeuble
            $table->unique(['employe_id', 'immeuble_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employe_immeuble');
    }
}
