<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {

            // Estado general del recorrido
            if (!Schema::hasColumn('solicitudes', 'estado')) {
                $table->string('estado')->default('PENDIENTE_RRHH');
            }

            // Estados por rol
            if (!Schema::hasColumn('solicitudes', 'estado_rrhh')) {
                $table->string('estado_rrhh')->default('Pendiente');
            }

            if (!Schema::hasColumn('solicitudes', 'estado_auditoria')) {
                $table->string('estado_auditoria')->default('Pendiente');
            }

            if (!Schema::hasColumn('solicitudes', 'estado_ti')) {
                $table->string('estado_ti')->default('Pendiente');
            }

            if (!Schema::hasColumn('solicitudes', 'estado_ti2')) {
                $table->string('estado_ti2')->default('Pendiente');
            }

            // Comentarios por rol
            if (!Schema::hasColumn('solicitudes', 'comentario_rrhh')) {
                $table->text('comentario_rrhh')->nullable();
            }

            if (!Schema::hasColumn('solicitudes', 'comentario_auditoria')) {
                $table->text('comentario_auditoria')->nullable();
            }

            if (!Schema::hasColumn('solicitudes', 'comentario_ti')) {
                $table->text('comentario_ti')->nullable();
            }

            if (!Schema::hasColumn('solicitudes', 'comentario_ti2')) {
                $table->text('comentario_ti2')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn([
                'estado',
                'estado_rrhh',
                'estado_auditoria',
                'estado_ti',
                'estado_ti2',
                'comentario_rrhh',
                'comentario_auditoria',
                'comentario_ti',
                'comentario_ti2',
            ]);
        });
    }
};
