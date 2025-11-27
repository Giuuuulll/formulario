@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Aprobación Auditoría</h2>

    <div class="card mb-4">
        <div class="card-header">Tareas completadas por RRHH</div>
        <div class="card-body">
            <p><strong>Tarea 1:</strong> {{ $solicitud->tarea1 }}</p>
            @if($solicitud->tarea2)<p><strong>Tarea 2:</strong> {{ $solicitud->tarea2 }}</p>@endif
            @if($solicitud->tarea3)<p><strong>Tarea 3:</strong> {{ $solicitud->tarea3 }}</p>@endif
            @if($solicitud->tarea4)<p><strong>Tarea 4:</strong> {{ $solicitud->tarea4 }}</p>@endif
            @if($solicitud->tarea5)<p><strong>Tarea 5:</strong> {{ $solicitud->tarea5 }}</p>@endif
        </div>
    </div>

    <form method="POST" action="{{ route('solicitudes.auditoria.aprobar', $solicitud->id) }}">
        @csrf
        
        <button name="accion" value="aprobar" class="btn btn-success">Aprobar</button>
        <button name="accion" value="rechazar" class="btn btn-danger">Rechazar</button>
        <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
