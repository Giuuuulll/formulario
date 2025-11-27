@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">📄 Detalle de Solicitud #{{ $solicitud->id }}</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Información General</h5>
            <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
            <p><strong>Departamento:</strong> {{ $solicitud->departamento }}</p>
            <p><strong>Puesto / Función:</strong> {{ $solicitud->puesto_funcion }}</p>
            <p><strong>Empresa:</strong> {{ $solicitud->empresa }}</p>
            <p><strong>Estado actual:</strong> {{ $solicitud->estado }}</p>
            <p><strong>Fecha de creación:</strong> {{ $solicitud->created_at }}</p>

            <hr>

            <h5 class="fw-bold mb-3">Tareas seleccionadas</h5>
            <ul>
                @if($solicitud->tarea1) <li>{{ $solicitud->tarea1 }}</li> @endif
                @if($solicitud->tarea2) <li>{{ $solicitud->tarea2 }}</li> @endif
                @if($solicitud->tarea3) <li>{{ $solicitud->tarea3 }}</li> @endif
                @if($solicitud->tarea4) <li>{{ $solicitud->tarea4 }}</li> @endif
                @if($solicitud->tarea5) <li>{{ $solicitud->tarea5 }}</li> @endif
            </ul>

            <hr>

            <h5 class="fw-bold mb-3">Sistemas (RRHH)</h5>
            <ul>
                <li>Internet RRHH: {{ $solicitud->internet_rrhh ? 'Sí' : 'No' }}</li>
                <li>Sistema cobranzas: {{ $solicitud->sistema_cobranzas ? 'Sí' : 'No' }}</li>
                <li>GT Solutions: {{ $solicitud->gt_solutions ? 'Sí' : 'No' }}</li>
                <li>SDK: {{ $solicitud->sdk ? 'Sí' : 'No' }}</li>
                <li>SAP Business One: {{ $solicitud->sap_business_one ? 'Sí' : 'No' }}</li>
                <li>SDK Acceso: {{ $solicitud->sdk_acceso ? 'Sí' : 'No' }}</li>
                <li>SAP Acceso: {{ $solicitud->sap_acceso ? 'Sí' : 'No' }}</li>
                <li>Otros sistemas: {{ $solicitud->otros_sistemas ? $solicitud->otros_sistemas_texto : 'No' }}</li>
            </ul>

            <hr>

            <h5 class="fw-bold mb-3">TI2 (Equipos)</h5>
            <ul>
                <li>PC/Notebook: {{ $solicitud->pc_notebook ? 'Sí' : 'No' }}</li>
                <li>Tablet: {{ $solicitud->tablet ? 'Sí' : 'No' }}</li>
                <li>Impresora/Scanner: {{ $solicitud->impresora_scanner ? 'Sí' : 'No' }}</li>
                <li>Usuario de red: {{ $solicitud->usuario_red ? 'Sí' : 'No' }}</li>
                <li>Correo corporativo: {{ $solicitud->correo_corporativo ? 'Sí' : 'No' }}</li>
                <li>Teléfono interno: {{ $solicitud->telefono_interno ? 'Sí' : 'No' }}</li>
                <li>Celular corporativo: {{ $solicitud->celular_corporativo ? 'Sí' : 'No' }}</li>
                <li>Otro equipo: {{ $solicitud->otro_equipo ? $solicitud->otro_equipo_texto : 'No' }}</li>
            </ul>

            <hr>

            <h5 class="fw-bold mb-3">Comentarios del usuario</h5>
            <p>{{ $solicitud->comentarios ?? 'Sin comentarios.' }}</p>

            <hr>

            <h5 class="fw-bold mb-3">Estados por área</h5>
            <ul>
                <li>RRHH: {{ $solicitud->estado_rrhh }}</li>
                <li>Auditoría: {{ $solicitud->estado_auditoria }}</li>
                <li>TI: {{ $solicitud->estado_ti }}</li>
                <li>TI2: {{ $solicitud->estado_ti2 }}</li>
                <li>Sistemas: {{ $solicitud->estado_sistemas }}</li>
            </ul>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Volver</a>

                <a href="{{ route('solicitudes.pdf', $solicitud->id) }}" 
                   class="btn btn-danger">
                    Exportar PDF
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
