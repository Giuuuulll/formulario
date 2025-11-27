<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets_nuevo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // Datos base
            $table->string('reference');
            $table->string('applicant_name');
            $table->string('responsible_email');
            $table->string('position');
            $table->string('department');
            $table->string('company');

            // Estado general
            $table->string('status')->default('PENDIENTE_RRHH');

            // FORMULARIO RRHH
            $table->text('rrhh_descripcion_puesto')->nullable();
            $table->text('rrhh_tareas')->nullable();
            $table->string('rrhh_observacion')->nullable();
            $table->boolean('rrhh_aprobado')->nullable();

            // FORMULARIO AUDITORÍA
            $table->boolean('auditoria_aprobado')->nullable();
            $table->string('auditoria_observacion')->nullable();

            // FORMULARIO TI – herramientas requeridas
            $table->boolean('ti_pc')->default(false);
            $table->boolean('ti_impresora')->default(false);
            $table->boolean('ti_usuario_red')->default(false);
            $table->boolean('ti_correo')->default(false);
            $table->boolean('ti_telefono')->default(false);
            $table->boolean('ti_sap')->default(false);
            $table->boolean('ti_sdk')->default(false);
            $table->boolean('ti_celular')->default(false);
            $table->string('ti_otro')->nullable();
            $table->boolean('ti_aprobado')->nullable();
            $table->string('ti_observacion')->nullable();

            // FORMULARIO CIBERSEGURIDAD
            $table->boolean('ciber_aprobado')->nullable();
            $table->text('ciber_observacion')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets_nuevo');
    }
};
