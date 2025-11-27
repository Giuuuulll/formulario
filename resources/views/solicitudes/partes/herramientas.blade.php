<div class="card mb-4">
    <div class="card-header fw-bold">Herramientas solicitadas</div>
    <div class="card-body">
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
</div>
