<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB; // por si lo necesitás

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ganados', function (Blueprint $table) {
            if (!Schema::hasColumn('ganados', 'peso1')) {
                $table->string('peso1')->nullable();
            }
            if (!Schema::hasColumn('ganados', 'peso2')) {
                $table->string('peso2')->nullable();
            }
            if (!Schema::hasColumn('ganados', 'peso3')) {
                $table->string('peso3')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ganados', function (Blueprint $table) {
            if (Schema::hasColumn('ganados', 'peso1')) {
                $table->dropColumn('peso1');
            }
            if (Schema::hasColumn('ganados', 'peso2')) {
                $table->dropColumn('peso2');
            }
            if (Schema::hasColumn('ganados', 'peso3')) {
                $table->dropColumn('peso3');
            }
        });
    }
};
