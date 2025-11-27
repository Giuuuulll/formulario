<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');

            // ESTADO DEL FLUJO
            $table->string('estado')->default('PENDIENTE_RRHH');

            // --- FORMULARIO DEL USUARIO, ETAPA 1 ---
            $table->text('tarea1')->nullable();
            $table->text('tarea2')->nullable();
            $table->text('tarea3')->nullable();
            $table->text('tarea4')->nullable();
            $table->text('tarea5')->nullable();

            // --- FORMULARIO DEL USUARIO, ETAPA 2 ---
            $table->boolean('sap_business_one')->default(false);
            $table->boolean('sdk')->default(false);
            $table->boolean('gt_solutions')->default(false);
            $table->boolean('internet_rrhh')->default(false);
            $table->boolean('sistema_cobranzas')->default(false);
            $table->boolean('otros_sistemas')->default(false);
            $table->string('otros_sistemas_texto')->nullable();

            // --- FORMULARIO DEL USUARIO, ETAPA 3 ---
            $table->boolean('pc_notebook')->default(false);
            $table->boolean('impresora_scanner')->default(false);
            $table->boolean('usuario_red')->default(false);
            $table->boolean('correo_corporativo')->default(false);
            $table->boolean('sap_acceso')->default(false);
            $table->boolean('sdk_acceso')->default(false);
            $table->boolean('telefono_interno')->default(false);
            $table->boolean('celular_corporativo')->default(false);
            $table->boolean('otro_equipo')->default(false);
            $table->string('otro_equipo_texto')->nullable();

            // APROBADORES
            $table->unsignedBigInteger('aprobado_rrhh_por')->nullable();
            $table->unsignedBigInteger('aprobado_auditoria_por')->nullable();
            $table->unsignedBigInteger('aprobado_ti_por')->nullable();
            $table->unsignedBigInteger('aprobado_ciber_por')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
};
