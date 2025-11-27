<div class="card mb-4">
    <div class="card-header fw-bold">Tareas del puesto</div>
    <div class="card-body">
        <ul>
            @foreach (['tarea1','tarea2','tarea3','tarea4','tarea5'] as $t)
                @if($solicitud->$t)
                    <li>{{ $solicitud->$t }}</li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
