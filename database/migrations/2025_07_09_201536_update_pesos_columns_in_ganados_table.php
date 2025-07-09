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
        Schema::table('ganados', function (Blueprint $table) {
            // Quitamos el drop de columnas que ya no existen para evitar error
            $table->string('peso1')->nullable();
            $table->string('peso2')->nullable();
            $table->string('peso3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
{
    Schema::table('ganados', function (Blueprint $table) {
        $table->dropColumn(['peso1', 'peso2', 'peso3']);
    });
}

};
