<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudController extends Controller
{
    // =============================
    // LISTADO
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

        $nivelColor = function($c) {
            if ($c == 0) return 'vacio';
            if ($c <= 5) return 'medio';
            return 'alto';
        };

        $intensidad = [
            'todos' => $nivelColor($contadores['todos']),
            'pendientes' => $nivelColor($contadores['pendientes']),
            'rechazadas' => $nivelColor($contadores['rechazadas']),
            'completadas' => $nivelColor($contadores['completadas']),
        ];

        return view('solicitudes.index', compact(
            'solicitudes', 'user', 'filtro', 'contadores', 'intensidad'
        ));
    }

    // =============================
    // CREAR SOLICITUD
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
            'estado_sistemas'  => 'Pendiente',

            'nombre'          => $request->nombre,
            'departamento'    => $request->departamento,
            'puesto_funcion'  => $request->puesto,
            'empresa'         => $request->empresa,

            'tarea1' => $request->tarea1,
            'tarea2' => $request->tarea2,
            'tarea3' => $request->tarea3,
            'tarea4' => $request->tarea4,
            'tarea5' => $request->tarea5,

            'internet_rrhh'     => $cb($request->internet_rrhh),
            'sistema_cobranzas' => $cb($request->sistema_cobranzas),
            'gt_solutions'      => $cb($request->gt_solutions),
            'sdk'               => $cb($request->sdk),
            'sap_business_one'  => $cb($request->sap_business_one),
            'sdk_acceso'        => $cb($request->sdk_acceso),
            'sap_acceso'        => $cb($request->sap_acceso),
            'otros_sistemas'    => $cb($request->otros_sistemas),
            'otros_sistemas_texto' => $request->otros_sistemas_texto,

            'pc_notebook'         => $cb($request->pc_notebook),
            'tablet'              => $cb($request->tablet),
            'impresora_scanner'   => $cb($request->impresora_scanner),
            'usuario_red'         => $cb($request->usuario_red),
            'correo_corporativo'  => $cb($request->correo_corporativo),
            'telefono_interno'    => $cb($request->telefono_interno),
            'celular_corporativo' => $cb($request->celular_corporativo),
            'otro_equipo'         => $cb($request->otro_equipo),
            'otro_equipo_texto'   => $request->otro_equipo_texto,

            'comentarios' => $request->comentarios,
        ]);

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // ROLE CHECK
    // =============================
    private function checkRole($rol)
    {
        if (Auth::user()->rol !== $rol) abort(403);
    }

    // =============================
    // NOTIFICAR A TODOS (USUARIO + ROLES)
    // =============================
    private function notificarATodos(Solicitud $solicitud, string $mensaje, ?string $comentario = null): void
    {
        // dueñx de la solicitud
        $destinatarios = [$solicitud->user_id];

        // roles que querés notificar
        $roles = ['rrhh', 'auditoria', 'ti', 'ciber', 'sistemas'];

        $idsRoles = User::whereIn('rol', $roles)->pluck('id')->toArray();

        // unir y quitar repetidos
        $destinatarios = array_values(array_unique(array_merge($destinatarios, $idsRoles)));

        foreach ($destinatarios as $userId) {
            Notificacion::create([
                'user_id'    => $userId,
                'autor_id'   => Auth::id(),
                'mensaje'    => $mensaje,
                'comentario' => $comentario ?: null, // opcional
                'leido'      => 0,
            ]);
        }
    }

    // =============================
    // DETALLE
    // =============================
    public function verDetalle($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.detalle', compact('solicitud'));
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

        $request->validate([
            'comentario' => 'nullable|string',
        ]);

        if ($request->accion === 'rechazar') {
            $solicitud->estado_rrhh = 'Rechazado';
            $solicitud->estado = 'RECHAZADO';
            $solicitud->save();

            $this->notificarATodos(
                $solicitud,
                'RRHH rechazó la solicitud #' . $solicitud->id,
                $request->comentario
            );

            return redirect()->route('solicitudes.index');
        }

        $solicitud->estado_rrhh = 'Aprobado';
        $solicitud->estado = 'PENDIENTE_AUDITORIA';
        $solicitud->save();

        $this->notificarATodos(
            $solicitud,
            'RRHH aprobó la solicitud #' . $solicitud->id,
            $request->comentario
        );

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

        $request->validate([
            'comentario' => 'nullable|string',
        ]);

        if ($request->accion === 'rechazar') {
            $solicitud->estado_auditoria = 'Rechazado';
            $solicitud->estado = 'RECHAZADO';
            $solicitud->save();

            $this->notificarATodos(
                $solicitud,
                'Auditoría rechazó la solicitud #' . $solicitud->id,
                $request->comentario
            );

            return redirect()->route('solicitudes.index');
        }

        $solicitud->estado_auditoria = 'Aprobado';
        $solicitud->estado = 'PENDIENTE_TI';
        $solicitud->save();

        $this->notificarATodos(
            $solicitud,
            'Auditoría aprobó la solicitud #' . $solicitud->id,
            $request->comentario
        );

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

        $request->validate([
            'comentario' => 'nullable|string',
        ]);

        if ($request->accion === 'rechazar') {
            $solicitud->estado_ti = 'Rechazado';
            $solicitud->estado = 'RECHAZADO';
            $solicitud->save();

            $this->notificarATodos(
                $solicitud,
                'TI rechazó la solicitud #' . $solicitud->id,
                $request->comentario
            );

            return redirect()->route('solicitudes.index');
        }

        $solicitud->estado_ti = 'Aprobado';
        $solicitud->estado = 'PENDIENTE_TI2';
        $solicitud->save();

        $this->notificarATodos(
            $solicitud,
            'TI aprobó la solicitud #' . $solicitud->id,
            $request->comentario
        );

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

        $solicitud->estado =
            $request->instalacion_ti2 === 'Completada'
            ? 'PENDIENTE_SISTEMAS'
            : 'PENDIENTE_TI2';

        $solicitud->save();

        // Notificar a todos (opcional, si querés también en TI2)
        $this->notificarATodos(
            $solicitud,
            'TI2 actualizó instalación: ' . $solicitud->instalacion_ti2 . ' (Solicitud #' . $solicitud->id . ')',
            null
        );

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // SISTEMAS
    // =============================
    public function vistaSistemas($id)
    {
        $this->checkRole('sistemas');
        $solicitud = Solicitud::findOrFail($id);
        return view('solicitudes.aprobar_sistemas', compact('solicitud'));
    }

    public function guardarInstalacionSistemas(Request $request, $id)
    {
        $this->checkRole('sistemas');
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->instalacion_sistemas = $request->instalacion_sistemas;

        $solicitud->estado =
            $request->instalacion_sistemas === 'Completada'
            ? 'CULMINADO'
            : 'PENDIENTE_SISTEMAS';

        $solicitud->save();

        // Notificar a todos (opcional, si querés también en Sistemas)
        $this->notificarATodos(
            $solicitud,
            'Sistemas actualizó instalación: ' . $solicitud->instalacion_sistemas . ' (Solicitud #' . $solicitud->id . ')',
            null
        );

        return redirect()->route('solicitudes.index');
    }

    // =============================
    // PDF
    // =============================
    public function exportarPDF($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $pdf = Pdf::loadView('solicitudes.pdf', compact('solicitud'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Solicitud_'.$solicitud->id.'.pdf');
    }
}
