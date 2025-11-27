@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Aprobación Ciberseguridad (Final)</h2>

    <!-- Sección RRHH -->
    <div class="card mb-4">
        <div class="card-header">Tareas asignadas (RRHH)</div>
        <div class="card-body">
            <p><strong>Tarea 1:</strong> {{ $solicitud->tarea1 }}</p>
            @if($solicitud->tarea2)<p><strong>Tarea 2:</strong> {{ $solicitud->tarea2 }}</p>@endif
            @if($solicitud->tarea3)<p><strong>Tarea 3:</strong> {{ $solicitud->tarea3 }}</p>@endif
            @if($solicitud->tarea4)<p><strong>Tarea 4:</strong> {{ $solicitud->tarea4 }}</p>@endif
            @if($solicitud->tarea5)<p><strong>Tarea 5:</strong> {{ $solicitud->tarea5 }}</p>@endif
        </div>
    </div>

    <!-- Sección TI -->
    <div class="card mb-4">
        <div class="card-header">Herramientas informáticas (TI)</div>
        <div class="card-body">
            <ul>
                @if($solicitud->sap_business_one) <li>SAP Business One</li> @endif
                @if($solicitud->sdk) <li>SDK</li> @endif
                @if($solicitud->gt_solutions) <li>GT Solutions</li> @endif
                @if($solicitud->internet_rrhh) <li>Internet RRHH</li> @endif
                @if($solicitud->sistema_cobranzas) <li>Sistema de cobranzas</li> @endif
                @if($solicitud->otros_sistemas)
                    <li>Otros: {{ $solicitud->otros_sistemas_texto }}</li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Sección Gerencia TI -->
    <div class="card mb-4">
        <div class="card-header">Equipos y accesos (Gerencia TI)</div>
        <div class="card-body">
            <ul>
                @if($solicitud->pc_notebook) <li>PC / Notebook</li> @endif
                @if($solicitud->impresora_scanner) <li>Impresora / Scanner</li> @endif
                @if($solicitud->usuario_red) <li>Usuario de red</li> @endif
                @if($solicitud->correo_corporativo) <li>Correo corporativo</li> @endif
                @if($solicitud->sap_acceso) <li>SAP</li> @endif
                @if($solicitud->sdk_acceso) <li>SDK</li> @endif
                @if($solicitud->telefono_interno) <li>Teléfono interno</li> @endif
                @if($solicitud->celular_corporativo) <li>Celular corporativo</li> @endif
                @if($solicitud->otro_equipo)
                    <li>Otro: {{ $solicitud->otro_equipo_texto }}</li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Botones finales -->
    <form method="POST" action="{{ route('solicitudes.ciber.aprobar', $solicitud->id) }}">
        @csrf

        <button name="accion" value="aprobar" class="btn btn-success">Aprobar todo</button>
        <button name="accion" value="rechazar" class="btn btn-danger">Rechazar</button>
        <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
