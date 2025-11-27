@extends('layouts.app')

@section('content')

<h2 class="mb-4">Instalación - TI2</h2>

{{-- Estado general --}}
@include('solicitudes.partes.estado_general')

{{-- Datos del solicitante --}}
@include('solicitudes.partes.datos')

{{-- Tareas --}}
@include('solicitudes.partes.tareas')

<!-- =========================================
     TI2 — SOLO EQUIPOS
========================================= -->
<div class="card p-3 mb-3 shadow-sm">
    <h5 class="mb-3">Equipos solicitados</h5>

    <ul>
        @if($solicitud->pc_notebook) <li>PC / Notebook</li> @endif
        @if($solicitud->tablet) <li>Tablet</li> @endif
        @if($solicitud->impresora_scanner) <li>Impresora / Scanner</li> @endif
        @if($solicitud->usuario_red) <li>Usuario de red</li> @endif
        @if($solicitud->correo_corporativo) <li>Correo corporativo</li> @endif
        @if($solicitud->telefono_interno) <li>Teléfono interno</li> @endif
        @if($solicitud->celular_corporativo) <li>Celular corporativo</li> @endif

        @if($solicitud->otro_equipo)
            <li>Otro equipo: {{ $solicitud->otro_equipo_texto }}</li>
        @endif
    </ul>
</div>

<!-- =========================================
     BOTONES TI2
========================================= -->
<div class="card mt-4 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Estado de instalación (TI2)</h5>

        <form method="POST" action="{{ route('solicitudes.guardarInstalacionTI2', $solicitud->id) }}">
            @csrf

            <div class="d-flex flex-wrap gap-3 mt-3">

                <button type="submit" name="instalacion_ti2" value="En proceso"
                    class="btn btn-warning rounded-pill">
                    En proceso
                </button>

                <button type="submit" name="instalacion_ti2" value="Completada"
                    class="btn btn-success rounded-pill">
                    Completada
                </button>

            </div>
        </form>

    </div>
</div>

@endsection
