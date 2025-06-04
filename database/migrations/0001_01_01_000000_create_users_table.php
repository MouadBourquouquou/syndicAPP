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
        Schema::create('users', function (Blueprint $table) {
            // Dans votre modèle, vous avez spécifié 'id_S' comme primaryKey.
            // Si vous voulez que cette colonne soit nommée 'id_S' au lieu de 'id',
            // vous devez changer $table->id(); en $table->id('id_S');
            // Ou si 'id' est bien la PK et 'id_S' est un autre champ (moins probable),
            // il faudrait l'ajouter spécifiquement.
            // Pour l'instant, je conserve $table->id() qui crée une colonne 'id' par défaut.
            // Si vous voulez 'id_S' comme clé primaire, changez la ligne ci-dessous :
            // $table->increments('id_S'); // Pour une clé primaire auto-incrémentée nommée 'id_S'
            $table->id(); // Ceci crée une colonne 'id' auto-incrémentée et clé primaire

            $table->string('name');
            $table->string('prenom')->nullable();
            $table->string('statut')->default('professionnel');

            // Add the nom_societé column here
            $table->string('nom_societé')->nullable(); // <-- DÉJÀ PRÉSENT ET C'EST BON !

            $table->string('adresse')->nullable();
            $table->string('tel')->nullable();
            $table->string('Fax')->nullable(); // <-- AJOUTÉ : La colonne pour le Fax
            $table->string('ville')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};