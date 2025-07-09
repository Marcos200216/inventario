<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ganados', function (Blueprint $table) {
            // Eliminar columnas peso1, peso2, peso3
            if (Schema::hasColumn('ganados', 'peso1')) {
                $table->dropColumn(['peso1', 'peso2', 'peso3']);
            }
            // Eliminar columnas rev1, rev2, rev3
            if (Schema::hasColumn('ganados', 'rev1')) {
                $table->dropColumn(['rev1', 'rev2', 'rev3']);
            }
        });
    }

    public function down()
    {
        Schema::table('ganados', function (Blueprint $table) {
            // Volver a crear las columnas eliminadas en el rollback
            $table->string('peso1')->nullable();
            $table->string('peso2')->nullable();
            $table->string('peso3')->nullable();

            $table->string('rev1')->nullable();
            $table->string('rev2')->nullable();
            $table->string('rev3')->nullable();
        });
    }
};
