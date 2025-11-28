@extends('layouts.app')

@section('content')

<h2 class="mb-4">Revisión de TI</h2>

@include('solicitudes.partes.estado_general')
@include('solicitudes.partes.datos')
@include('solicitudes.partes.tareas')
@include('solicitudes.partes.programas')
@include('solicitudes.partes.herramientas')
@include('solicitudes.partes.comentarios_usuario')



<form id="formAprobacion" method="POST" action="{{ route('solicitudes.aprobarTI', $solicitud->id) }}">
    @csrf

    
    <textarea id="comentarioInput" name="comentario" class="d-none"></textarea>

    <div class="mt-4 d-flex gap-3">

        
        <button type="button" class="btn btn-success" onclick="aprobar()">
            Aprobar
        </button>

        
        <button type="button" class="btn btn-danger" onclick="mostrarModal()">
            Rechazar
        </button>

    </div>
</form>




<div class="modal fade" id="modalComentario" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">¿Querés agregar un comentario?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label>Comentario (opcional):</label>
        <textarea id="comentarioModal" class="form-control" placeholder="Motivo del rechazo (si querés)..."></textarea>
      </div>

      <div class="modal-footer">

        <button class="btn btn-secondary" data-bs-dismiss="modal">
            Cancelar
        </button>

        <button class="btn btn-danger" onclick="rechazar()">
            Rechazar sin comentario
        </button>

        <button class="btn btn-warning" onclick="rechazarConComentario()">
            Rechazar con comentario
        </button>

      </div>

    </div>
  </div>
</div>




<script>

function aprobar() {
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "accion";
    input.value = "aprobar";

    document.getElementById('formAprobacion').appendChild(input);
    document.getElementById('formAprobacion').submit();
}


function mostrarModal() {
    let modal = new bootstrap.Modal(document.getElementById('modalComentario'));
    modal.show();
}


function rechazar() {
    enviarRechazo("");
}

function rechazarConComentario() {
    let com = document.getElementById('comentarioModal').value;
    enviarRechazo(com);
}

function enviarRechazo(comentario) {
    document.getElementById('comentarioInput').value = comentario;

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "accion";
    input.value = "rechazar";

    document.getElementById('formAprobacion').appendChild(input);

    document.getElementById('formAprobacion').submit();
}

</script>

@endsection
