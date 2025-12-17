<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    // =========================
    // LISTADO DE NOTIFICACIONES
    // =========================
    public function index(Request $request)
    {
        $query = Notificacion::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($request->filtro === 'nuevas') {
            $query->where('leido', 0);
        }

        if ($request->filtro === 'leidas') {
            $query->where('leido', 1);
        }

        $notificaciones = $query->paginate(10);

        return view('notificaciones.index', compact('notificaciones'));
    }

    // =========================
    // CREAR NOTIFICACIÓN
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer|exists:users,id',
            'mensaje'    => 'required|string|max:255',
            'comentario' => 'nullable|string',
        ]);

        Notificacion::create([
            'user_id'    => (int) $request->user_id,
            'autor_id'   => Auth::id(),
            'mensaje'    => $request->mensaje,
            'comentario' => $request->comentario ?: null, // opcional, si viene vacío => NULL
            'leido'      => 0,
        ]);

        return back()->with('ok', 'Notificación creada 💌');
    }

    // =========================
    // MARCAR UNA COMO LEÍDA
    // =========================
    public function marcarLeido($id)
    {
        $n = Notificacion::findOrFail($id);

        if ($n->user_id != Auth::id()) {
            abort(403);
        }

        $n->leido = 1;
        $n->save();

        return back();
    }

    // =========================
    // MARCAR VARIAS COMO LEÍDAS
    // =========================
    public function marcarLeidoMultiple(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return back();
        }

        Notificacion::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->update(['leido' => 1]);

        return back();
    }

    // =========================
    // ELIMINAR VARIAS
    // =========================
    public function eliminarMultiples(Request $request)
    {
        $ids = $request->seleccion ?? [];

        if (empty($ids)) {
            return back();
        }

        Notificacion::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }

    // =========================
    // POLL (AJAX)
    // =========================
    public function poll()
    {
        $userId = Auth::id();

        $noLeidas = Notificacion::where('user_id', $userId)
            ->where('leido', 0)
            ->count();

        $ultimas = Notificacion::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(['mensaje', 'created_at']);

        return response()->json([
            'noLeidas' => $noLeidas,
            'ultimas'  => $ultimas
        ]);
    }
}
