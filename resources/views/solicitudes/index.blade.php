@extends('layouts.app')

@section('content')

<h2 class="mb-4">Solicitudes</h2>


<div class="d-flex flex-wrap gap-2 mb-4">

    <a href="{{ route('solicitudes.index', ['filtro' => 'todos']) }}"
        class="filtro-pill filtro-{{ $intensidad['todos'] }} {{ $filtro === 'todos' ? 'active' : '' }}">
         Todos ({{ $contadores['todos'] }})
    </a>

    <a href="{{ route('solicitudes.index', ['filtro' => 'pendientes']) }}"
        class="filtro-pill filtro-{{ $intensidad['pendientes'] }} {{ $filtro === 'pendientes' ? 'active' : '' }}">
         Pendientes ({{ $contadores['pendientes'] }})
    </a>

    <a href="{{ route('solicitudes.index', ['filtro' => 'rechazadas']) }}"
        class="filtro-pill filtro-{{ $intensidad['rechazadas'] }} {{ $filtro === 'rechazadas' ? 'active' : '' }}">
         Rechazadas ({{ $contadores['rechazadas'] }})
    </a>

    <a href="{{ route('solicitudes.index', ['filtro' => 'completadas']) }}"
        class="filtro-pill filtro-{{ $intensidad['completadas'] }} {{ $filtro === 'completadas' ? 'active' : '' }}">
         Completadas ({{ $contadores['completadas'] }})
    </a>

</div>



@if($solicitudes->count())

<table class="table table-bordered table-striped bg-white shadow-sm">

    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

    @foreach ($solicitudes as $s)

        @php
            $badge = [
                'PENDIENTE_RRHH' => 'warning',
                'PENDIENTE_AUDITORIA' => 'warning',
                'PENDIENTE_TI' => 'warning',
                'PENDIENTE_TI2' => 'warning',
                'PENDIENTE_SISTEMAS' => 'warning',
                'RECHAZADO' => 'danger',
                'CULMINADO' => 'success',
            ][$s->estado] ?? 'secondary';
        @endphp

        <tr>
            <td>{{ $s->id }}</td>

            <td>{{ $s->nombre }}</td>

            <td>
                <span class="badge bg-{{ $badge }}">
                    {{ $s->estado }}
                </span>
            </td>

            <td>
                {{ $s->created_at->format('d/m/Y H:i') }} —
                @php
                    $diff = $s->created_at->diffInMinutes(now());

                    if ($diff < 1) {
                        $ago = "Hace unos segundos";
                    } elseif ($diff < 60) {
                        $ago = "Hace {$diff} min";
                    } elseif ($diff < 1440) {
                        $hours = floor($diff / 60);
                        $ago = "Hace {$hours} " . ($hours == 1 ? 'hora' : 'horas');
                    } else {
                        $days = floor($diff / 1440);
                        $ago = "Hace {$days} " . ($days == 1 ? 'día' : 'días');
                    }
                @endphp

                <span class="text-muted">{{ $ago }}</span>
            </td>

            <td>

                {{-- RRHH --}}
                @if(auth()->user()->rol === 'rrhh' && $s->estado === 'PENDIENTE_RRHH')
                    <a href="{{ route('solicitudes.vistaRRHH', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Revisar RRHH
                    </a>
                @endif

                {{-- AUDITORÍA --}}
                @if(auth()->user()->rol === 'auditoria' && $s->estado === 'PENDIENTE_AUDITORIA')
                    <a href="{{ route('solicitudes.vistaAuditoria', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Revisar Auditoría
                    </a>
                @endif

                {{-- TI --}}
                @if(auth()->user()->rol === 'ti' && $s->estado === 'PENDIENTE_TI')
                    <a href="{{ route('solicitudes.vistaTI', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Revisar TI
                    </a>
                @endif

                {{-- TI2 / CIBER --}}
                @if(auth()->user()->rol === 'ciber' && $s->estado === 'PENDIENTE_TI2')
                    <a href="{{ route('solicitudes.vistaTI2', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Revisar TI2
                    </a>
                @endif

                {{-- SISTEMAS --}}
                @if(auth()->user()->rol === 'sistemas' && $s->estado === 'PENDIENTE_SISTEMAS')
                    <a href="{{ route('solicitudes.vistaSistemas', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Revisar Sistemas
                    </a>
                @endif

                {{-- BOTÓN UNIVERSAL DE DETALLE PARA TODOS --}}
                <a href="{{ route('solicitudes.detalle', $s->id) }}"
                   class="btn btn-sm btn-dark mt-1">
                    Ver detalle
                </a>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

@else
    <div class="alert alert-info">
        No hay solicitudes para este filtro.
    </div>
@endif

@endsection
