@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Formulario — Paso 1 (Tareas)</h2>

    <form action="{{ route('solicitudes.store') }}" method="POST">
        @csrf

        <label class="form-label">Tarea 1 (obligatoria)</label>
        <textarea name="tarea1" class="form-control" required></textarea>

        <label class="form-label mt-3">Tarea 2</label>
        <textarea name="tarea2" class="form-control"></textarea>

        <label class="form-label mt-3">Tarea 3</label>
        <textarea name="tarea3" class="form-control"></textarea>

        <label class="form-label mt-3">Tarea 4</label>
        <textarea name="tarea4" class="form-control"></textarea>

        <label class="form-label mt-3">Tarea 5</label>
        <textarea name="tarea5" class="form-control"></textarea>

        <button class="btn btn-primary mt-4">Enviar</button>
    </form>

</div>
@endsection
