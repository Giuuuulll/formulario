<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->text('comentario_rrhh')->nullable();
            $table->text('comentario_auditoria')->nullable();
            $table->text('comentario_ti')->nullable();
            $table->text('comentario_ti2')->nullable();
        });
    }

    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn([
                'comentario_rrhh',
                'comentario_auditoria',
                'comentario_ti',
                'comentario_ti2',
            ]);
        });
    }
};
