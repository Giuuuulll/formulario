<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            // Campo de instalación de sistemas
            $table->string('instalacion_sistemas')
                  ->nullable()
                  ->after('instalacion_ti2');

            // Estado para sistemas
            $table->string('estado_sistemas')
                  ->default('Pendiente')
                  ->after('estado_ti2');
        });
    }

    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn(['instalacion_sistemas', 'estado_sistemas']);
        });
    }
};
