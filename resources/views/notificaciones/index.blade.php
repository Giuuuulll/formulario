@extends('layouts.app')

@section('content')

<h2 class="mb-4">Notificaciones</h2>


<form method="GET" class="mb-4 d-flex gap-2">

    <select name="filtro" class="form-select form-select-sm" style="max-width:180px;">
        <option value="">Todas</option>
        <option value="nuevas" {{ request('filtro')=='nuevas'?'selected':'' }}>Nuevas</option>
        <option value="leidas" {{ request('filtro')=='leidas'?'selected':'' }}>Leídas</option>
    </select>

    <button class="btn btn-primary btn-sm px-3">Aplicar</button>
</form>



@if($notificaciones->count())

<form action="{{ route('notificaciones.eliminar') }}" method="POST">
    @csrf

    <div class="d-flex gap-2 mb-4">
        <button type="submit" class="btn btn-outline-danger btn-sm px-3">🗑️ Eliminar</button>
        <button type="button" onclick="marcarLeidas()" class="btn btn-outline-primary btn-sm px-3">✔️ Marcar leídas</button>
    </div>

    <div class="list-group">

        @foreach ($notificaciones as $n)

        @php
            $borderColor = $n->leido ? '#90A4AE' : '#1565C0';
            $bgColor = $n->leido ? '#F5F5F5' : '#E3F2FD';
            $icono = $n->leido ? '📨' : '🔔';
        @endphp

        <div class="list-group-item mb-2 rounded shadow-sm"
             style="border-left: 6px solid {{ $borderColor }}; background: {{ $bgColor }};">

            <div class="d-flex justify-content-between">

                <div class="d-flex">

                    <div class="pt-1 me-3">
                        <input type="checkbox" name="seleccion[]" value="{{ $n->id }}">
                    </div>

                    <div>
                        <div class="fw-bold" style="color:#0D47A1;">
                            {{ $icono }} {{ $n->mensaje }}
                        </div>

                        <div class="small text-muted mt-1">
                            {{ $n->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <div>
                    @if(!$n->leido)
                        <span class="badge bg-primary">Nuevo</span>
                    @else
                        <span class="badge bg-secondary">Leído</span>
                    @endif
                </div>

            </div>
        </div>

        @endforeach
    </div>

</form>

<div class="mt-3">
    {{ $notificaciones->links() }}
</div>

@else
<div class="alert alert-info">No tenés notificaciones.</div>
@endif



<script>
function marcarLeidas() {
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('notificaciones.leidoMultiple') }}";

    let token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = "{{ csrf_token() }}";
    form.appendChild(token);

    let checkboxes = document.querySelectorAll('input[name="seleccion[]"]:checked');

    if (checkboxes.length === 0) {
        alert("Seleccioná al menos una notificación");
        return;
    }

    checkboxes.forEach(ch => {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = ch.value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}
</script>

@endsection
