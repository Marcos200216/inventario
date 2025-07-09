<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ganados', function (Blueprint $table) {
            $table->string('peso1')->nullable()->after('destino');
            $table->string('peso2')->nullable()->after('peso1');
            $table->string('peso3')->nullable()->after('peso2');
        });
    }

    public function down()
    {
        Schema::table('ganados', function (Blueprint $table) {
            $table->dropColumn(['peso1', 'peso2', 'peso3']);
        });
    }
};
