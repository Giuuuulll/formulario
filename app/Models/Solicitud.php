<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'user_id',
        'estado',

        // DATOS DEL EMPLEADO
        'nombre',
        'departamento',
        'puesto_funcion',
        'empresa',

        // TAREAS (texto)
        'tarea1',
        'tarea2',
        'tarea3',
        'tarea4',
        'tarea5',

        // PROGRAMAS (checkbox → tinyint)
        'sap_business_one',
        'sdk',
        'gt_solutions',
        'internet_rrhh',
        'sistema_cobranzas',
        'otros_sistemas',
        'otros_sistemas_texto',

        // HERRAMIENTAS (checkbox → tinyint)
        'pc_notebook',
        'tablet',
        'impresora_scanner',
        'usuario_red',
        'correo_corporativo',
        'sap_acceso',
        'sdk_acceso',
        'telefono_interno',
        'celular_corporativo',
        'otro_equipo',
        'otro_equipo_texto',

        // COMENTARIOS
        'comentarios',

        // APROBACIONES
        'aprobado_rrhh_por',
        'aprobado_auditoria_por',
        'aprobado_ti_por',
        'aprobado_ciber_por',
    ];

    // QUIÉN CREÓ LA SOLICITUD
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // QUIÉN APROBÓ CADA ETAPA
    public function rrhh()
    {
        return $this->belongsTo(User::class, 'aprobado_rrhh_por');
    }

    public function auditoria()
    {
        return $this->belongsTo(User::class, 'aprobado_auditoria_por');
    }

    public function ti()
    {
        return $this->belongsTo(User::class, 'aprobado_ti_por');
    }

    public function ciber()
    {
        return $this->belongsTo(User::class, 'aprobado_ciber_por');
    }
}
