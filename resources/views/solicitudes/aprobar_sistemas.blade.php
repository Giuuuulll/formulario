@extends('layouts.app')

@section('content')

<h2 class="mb-4">Instalación - Sistemas</h2>

{{-- Estado general --}}
@include('solicitudes.partes.estado_general')

{{-- Datos del solicitante --}}
@include('solicitudes.partes.datos')

{{-- Tareas del puesto --}}
@include('solicitudes.partes.tareas')

<!-- =========================================
     SISTEMAS — SOLO ESTOS 8 CAMPOS
========================================= -->
<div class="card p-3 mb-3 shadow-sm">
    <h5 class="mb-3">Sistemas solicitados</h5>

    <ul>
        @if($solicitud->internet_rrhh)
            <li>Internet - RRHH marcaciones</li>
        @endif

        @if($solicitud->sistema_cobranzas)
            <li>Sistema de cobranzas</li>
        @endif

        @if($solicitud->gt_solutions)
            <li>GT Solutions</li>
        @endif

        @if($solicitud->sdk)
            <li>SDK</li>
        @endif

        @if($solicitud->sap_business_one)
            <li>SAP Business One</li>
        @endif

        @if($solicitud->sdk_acceso)
            <li>Acceso SDK</li>
        @endif

        @if($solicitud->sap_acceso)
            <li>Acceso SAP</li>
        @endif

        @if($solicitud->otros_sistemas)
            <li>Otros sistemas: {{ $solicitud->otros_sistemas_texto }}</li>
        @endif
    </ul>
</div>

<!-- =========================================
     BOTONES DE SISTEMAS
========================================= -->
<div class="card mt-4 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Estado de instalación (Sistemas)</h5>

        <form method="POST" action="{{ route('solicitudes.guardarInstalacionSistemas', $solicitud->id) }}">
            @csrf

            <div class="d-flex flex-wrap gap-3 mt-3">

                <button type="submit" name="instalacion_sistemas" value="En proceso"
                    class="btn btn-warning rounded-pill">
                    En proceso
                </button>

                <button type="submit" name="instalacion_sistemas" value="Completada"
                    class="btn btn-success rounded-pill">
                    Completada
                </button>

            </div>
        </form>

    </div>
</div>

@endsection
