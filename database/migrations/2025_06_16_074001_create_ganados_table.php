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
       Schema::create('ganados', function (Blueprint $table) {
    $table->id();
    $table->string('arete')->unique();
    $table->string('sexo');
    $table->string('subasta');
    $table->string('numero_subasta');
    $table->decimal('peso_total', 8, 2);
    $table->decimal('precio_kg', 8, 2);
    $table->decimal('monto', 10, 2);
    $table->string('lote');
    $table->string('destino');
    $table->string('rev1')->nullable();
    $table->string('rev2')->nullable();
    $table->string('rev3')->nullable();
    $table->string('estado');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganados');
    }
};
