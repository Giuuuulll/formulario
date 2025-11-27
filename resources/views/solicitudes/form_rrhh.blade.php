@extends('layouts.app')

@section('content')
<h2>Solicitud - Tareas del Puesto (RRHH)</h2>

<form action="{{ route('solicitudes.store_rrhh') }}" method="POST">
    @csrf

    <label>Tarea 1 (obligatoria)</label>
    <textarea name="tarea1" required></textarea>

    <label>Tarea 2 (opcional)</label>
    <textarea name="tarea2"></textarea>

    <label>Tarea 3 (opcional)</label>
    <textarea name="tarea3"></textarea>

    <label>Tarea 4 (opcional)</label>
    <textarea name="tarea4"></textarea>

    <label>Tarea 5 (opcional)</label>
    <textarea name="tarea5"></textarea>

    <button type="submit">Enviar a Auditoría</button>
</form>
@endsection
