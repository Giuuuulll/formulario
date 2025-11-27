<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h5 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .section {
            margin-bottom: 18px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 18px;
            border-radius: 6px;
        }

        hr {
            border: none;
            border-top: 1px solid #aaa;
            margin: 14px 0;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>

<body>

<h2>📄 Detalle de Solicitud #{{ $solicitud->id }}</h2>

<div class="card">

    {{-- Información General --}}
    <div class="section">
        <h5><strong>Información General</strong></h5>
        <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
        <p><strong>Departamento:</strong> {{ $solicitud->departamento }}</p>
        <p><strong>Puesto / Función:</strong> {{ $solicitud->puesto_funcion }}</p>
        <p><strong>Empresa:</strong> {{ $solicitud->empresa }}</p>
        <p><strong>Estado actual:</strong> {{ $solicitud->estado }}</p>
        <p><strong>Fecha de creación:</strong> {{ $solicitud->created_at }}</p>
    </div>

    <hr>

    {{-- Tareas --}}
    <div class="section">
        <h5><strong>Tareas seleccionadas</strong></h5>
        <ul>
            @if($solicitud->tarea1) <li>{{ $solicitud->tarea1 }}</li> @endif
            @if($solicitud->tarea2) <li>{{ $solicitud->tarea2 }}</li> @endif
            @if($solicitud->tarea3) <li>{{ $solicitud->tarea3 }}</li> @endif
            @if($solicitud->tarea4) <li>{{ $solicitud->tarea4 }}</li> @endif
            @if($solicitud->tarea5) <li>{{ $solicitud->tarea5 }}</li> @endif
        </ul>
    </div>

    <hr>

    {{-- Sistemas --}}
    <div class="section">
        <h5><strong>Sistemas (RRHH)</strong></h5>
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
    </div>

    <hr>

    {{-- Equipos TI2 --}}
    <div class="section">
        <h5><strong>TI2 (Equipos)</strong></h5>
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
    </div>

    <hr>

    {{-- Comentarios --}}
    <div class="section">
        <h5><strong>Comentarios del usuario</strong></h5>
        <p>{{ $solicitud->comentarios ?? 'Sin comentarios.' }}</p>
    </div>

    <hr>

    {{-- Estados por área --}}
    <div class="section">
        <h5><strong>Estados por área</strong></h5>
        <ul>
            <li>RRHH: {{ $solicitud->estado_rrhh }}</li>
            <li>Auditoría: {{ $solicitud->estado_auditoria }}</li>
            <li>TI: {{ $solicitud->estado_ti }}</li>
            <li>TI2: {{ $solicitud->estado_ti2 }}</li>
            <li>Sistemas: {{ $solicitud->estado_sistemas }}</li>
        </ul>
    </div>

</div>

</body>
</html>
