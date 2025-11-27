@if($solicitud->comentarios)
<div class="card mb-4">
    <div class="card-header fw-bold">Comentario del solicitante</div>
    <div class="card-body">
        <p>{{ $solicitud->comentarios }}</p>
    </div>
</div>
@endif
