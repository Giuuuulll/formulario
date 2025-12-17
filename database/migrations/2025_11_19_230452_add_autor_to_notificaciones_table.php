<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificaciones', function (Blueprint $table) {
            if (!Schema::hasColumn('notificaciones', 'autor_id')) {
                $table->unsignedBigInteger('autor_id')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notificaciones', function (Blueprint $table) {
            if (Schema::hasColumn('notificaciones', 'autor_id')) {
                $table->dropColumn('autor_id');
            }
        });
    }
};


