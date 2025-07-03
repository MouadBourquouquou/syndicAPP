<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->decimal('surface', 8, 2)->after('numero');
    });
}

public function down()
{
    Schema::table('appartements', function (Blueprint $table) {
        $table->dropColumn('surface');
    });
}

};
