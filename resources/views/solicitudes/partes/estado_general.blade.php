<div class="card mb-4">
    <div class="card-header fw-bold">Estado general</div>
    <div class="card-body">
        <p><strong>RRHH:</strong> {{ $solicitud->estado_rrhh ?? 'Pendiente' }}</p>
        @if($solicitud->comentario_rrhh)
            <p class="text-muted">Motivo RRHH: {{ $solicitud->comentario_rrhh }}</p>
        @endif

        <p><strong>Auditoría:</strong> {{ $solicitud->estado_auditoria ?? 'Pendiente' }}</p>
        @if($solicitud->comentario_auditoria)
            <p class="text-muted">Motivo Auditoría: {{ $solicitud->comentario_auditoria }}</p>
        @endif

        <p><strong>TI:</strong> {{ $solicitud->estado_ti ?? 'Pendiente' }}</p>
        @if($solicitud->comentario_ti)
            <p class="text-muted">Motivo TI: {{ $solicitud->comentario_ti }}</p>
        @endif

        <p><strong>TI2:</strong> {{ $solicitud->estado_ti2 ?? 'Pendiente' }}</p>
        @if($solicitud->comentario_ti2)
            <p class="text-muted">Motivo TI2: {{ $solicitud->comentario_ti2 }}</p>
        @endif
    </div>
</div>
