<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    // =============================
    // LISTADO GENERAL
    // =============================
    public function index(Request $request)
    {
        $user   = Auth::user();
        $filtro = $request->get('filtro', 'todos');

        $query = Solicitud::query();

        if ($user->rol === 'usuario') {
            $query->where('user_id', $user->id);
        }

        if ($filtro === 'pendientes') {
            $query->whereIn('estado', [
                'PENDIENTE_RRHH',
                'PENDIENTE_AUDITORIA',
                'PENDIENTE_TI',
                'PENDIENTE_TI2',
                'PENDIENTE_SISTEMAS',
            ]);
        }

        if ($filtro === 'rechazadas') {
            $query->where('estado', 'RECHAZADO');
        }

        if ($filtro === 'completadas') {
            $query->where('estado', 'CULMINADO');
        }

        $solicitudes = $query->orderByDesc('created_at')->get();

        $contadores = [
            'todos' => Solicitud::count(),
            'pendientes' => Solicitud::whereIn('estado', [
                'PENDIENTE_RRHH',
                'PENDIENTE_AUDITORIA',
                'PENDIENTE_TI',
                'PENDIENTE_TI2',
                'PENDIENTE_SISTEMAS',
            ])->count(),
            'rechazadas' => Solicitud::where('estado', 'RECHAZADO')->count(),
            'completadas' => Solicitud::where('estado', 'CULMINADO')->count(),
        ];

        $nivelColor = function ($cantidad) {
            if ($cantidad == 0)  return 'vacio';
            if ($cantidad <= 5) return 'medio';
            return 'alto';
        };

        $intensidad = [
            'todos'       => $nivelColor($contadores['todos']),
            'pendientes'  => $nivelColor($contadores['pendientes']),
            'rechazadas'  => $nivelColor($contadores['rechazadas']),
            'completadas' => $nivelColor($contadores['completadas']),
        ];

        return view('solicitudes.index', compact(
            'solicitudes', 'user', 'filtro', 'contadores', 'intensidad'
        ));
    }

    // =============================
    // GUARDAR FORMULARIO COMPLETO
    // =============================
    public function storeCompleto(Request $request)
    {
        $cb = fn($x) => $x ? 1 : 0;

        $solicitud = Solicitud::create([
            'user_id' => auth()->id(),

            'estado'           => 'PENDIENTE_RRHH',
            'estado_rrhh'      => 'Pendiente',
            'estado_auditoria' => 'Pendiente',
            'estado_ti'        => 'Pendiente',
            'estado_ti2'       => 'Pendiente',

            'nombre'          => $request->nombre,
            'departamento'    => $request->departamento,
            'puesto_funcion'  => $request->puesto,
            'empresa'         => $request->empresa,

            'tarea1' => $request->tarea1,
            'tarea2' => $request->tarea2,
            'tarea3' => $request->tarea3,
            'tarea4' => $request->tarea4,
            'tarea5' => $request->tarea5,

            // SISTEMAS
            'internet_rrhh'     => $cb($request->internet_rrhh),
            'sistema_cobranzas' => $cb($request->sistema_cobranzas),
            'gt_solutions'      => $cb($request->gt_solutions),
            'sdk'               => $cb($request->sdk),
            'sap_business_one'  => $cb($request->sap_business_one),
            'sdk_acceso'        => $cb($request->sdk_acceso),
            'sap_acceso'        => $cb($request->sap_acceso),
            'otros_sistemas'    => $cb($request->otros_sistemas),
            'otros_sistemas_texto' => $request->otros_sistemas_texto,

            // TI2
            'pc_notebook'        => $cb($request->pc_notebook),
            'tablet'             => $cb($request->tablet),
            'impresora_scanner'  => $cb($request->impresora_scanner),
            'usuario_red'        => $cb($request->usuario_red),
            'correo_corporativo' => $cb($request->correo_corporativo),
            'telefono_interno'   => $cb($request->telefono_interno),
            'celular_corporativo'=> $cb($request->celular_corporativo),
            'otro_equipo'        => $cb($request->otro_equipo),
            'otro_equipo_texto'  => $request->otro_equipo_texto,

            'comentarios' => $request->comentarios,
        ]);

        $this->notificarATodos($solicitud, 'Sistema', 'Enviada');

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // NOTIFICACIONES
    // =============================
    private function notificarATodos($solicitud, $rol, $estado, $comentario = null)
    {
        $mensaje = "La solicitud de {$solicitud->nombre} fue {$estado} por {$rol}.";
        if ($comentario) $mensaje .= " Motivo: {$comentario}";

        $roles = ['usuario', 'rrhh', 'auditoria', 'ti', 'ciber', 'sistemas'];

        foreach ($roles as $r) {
            foreach (User::where('rol', $r)->get() as $u) {
                Notificacion::create([
                    'user_id' => $u->id,
                    'mensaje' => $mensaje,
                ]);
            }
        }
    }

    private function checkRole($rol)
    {
        if (Auth::user()->rol !== $rol) abort(403);
    }

    // =============================
    // RRHH
    // =============================
    public function vistaRRHH($id)
    {
        $this->checkRole('rrhh');
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.aprobar_rrhh', compact('solicitud'));
    }

    public function aprobarRRHH(Request $request, $id)
    {
        $this->checkRole('rrhh');

        $solicitud = Solicitud::findOrFail($id);

        $solicitud->estado_rrhh    = $request->accion === 'aprobar' ? 'Aprobado' : 'Rechazado';
        $solicitud->comentario_rrhh = $request->comentario;

        $solicitud->estado =
            $solicitud->estado_rrhh === 'Aprobado'
            ? 'PENDIENTE_AUDITORIA'
            : 'RECHAZADO';

        $solicitud->save();

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // AUDITORÍA
    // =============================
    public function vistaAuditoria($id)
    {
        $this->checkRole('auditoria');
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.aprobar_auditoria', compact('solicitud'));
    }

    public function aprobarAuditoria(Request $request, $id)
    {
        $this->checkRole('auditoria');

        $solicitud = Solicitud::findOrFail($id);

        $solicitud->estado_auditoria = $request->accion === 'aprobar' ? 'Aprobado' : 'Rechazado';
        $solicitud->comentario_auditoria = $request->comentario;

        $solicitud->estado =
            $solicitud->estado_auditoria === 'Aprobado'
            ? 'PENDIENTE_TI'
            : 'RECHAZADO';

        $solicitud->save();

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // TI
    // =============================
    public function vistaTI($id)
    {
        $this->checkRole('ti');
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.aprobar_ti', compact('solicitud'));
    }

    public function aprobarTI(Request $request, $id)
    {
        $this->checkRole('ti');

        $solicitud = Solicitud::findOrFail($id);

        $solicitud->estado_ti = $request->accion === 'aprobar' ? 'Aprobado' : 'Rechazado';
        $solicitud->comentario_ti = $request->comentario;

        $solicitud->estado =
            $solicitud->estado_ti === 'Aprobado'
            ? 'PENDIENTE_TI2'
            : 'RECHAZADO';

        $solicitud->save();

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // TI2
    // =============================
    public function vistaTI2($id)
    {
        $this->checkRole('ciber');
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.aprobar_ti2', compact('solicitud'));
    }

    public function guardarInstalacionTI2(Request $request, $id)
    {
        $this->checkRole('ciber');

        $solicitud = Solicitud::findOrFail($id);

        $solicitud->instalacion_ti2 = $request->instalacion_ti2;

        // si TI2 completa → pasa a sistemas
        if ($request->instalacion_ti2 === 'Completada') {
            $solicitud->estado = 'PENDIENTE_SISTEMAS';
        } else {
            $solicitud->estado = 'PENDING_TI2';
        }

        $solicitud->save();

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // SISTEMAS (solo lo que corresponde)
    // =============================
    public function vistaSistemas($id)
    {
        $this->checkRole('sistemas');

        $solicitud = Solicitud::findOrFail($id);

        // 🔥 VALIDAMOS QUE REALMENTE TENGA COSAS DE SISTEMAS
        $esSistemas = (
            $solicitud->internet_rrhh ||
            $solicitud->sistema_cobranzas ||
            $solicitud->gt_solutions ||
            $solicitud->sdk ||
            $solicitud->sap_business_one ||
            $solicitud->sdk_acceso ||
            $solicitud->sap_acceso ||
            $solicitud->otros_sistemas
        );

        if (!$esSistemas) abort(403); // no debe poder ver

        return view('solicitudes.aprobar_sistemas', compact('solicitud'));
    }

    public function guardarInstalacionSistemas(Request $request, $id)
    {
        $this->checkRole('sistemas');

        $solicitud = Solicitud::findOrFail($id);

        $solicitud->instalacion_sistemas = $request->instalacion_sistemas;

        if ($request->instalacion_sistemas === 'Completada') {
            $solicitud->estado = 'CULMINADO';
        } else {
            $solicitud->estado = 'PENDIENTE_SISTEMAS';
        }

        $solicitud->save();

        return redirect()->route('solicitudes.index');
    }
}
