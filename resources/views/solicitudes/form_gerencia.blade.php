@extends('layouts.app')

@section('content')
<h2>Solicitud - Equipos y Accesos (Gerencia TI)</h2>

<form action="{{ route('solicitudes.store_gerencia') }}" method="POST">
    @csrf

    <label><input type="checkbox" name="pc_notebook"> PC / Notebook</label><br>
    <label><input type="checkbox" name="impresora_scanner"> Impresora / Scanner</label><br>
    <label><input type="checkbox" name="usuario_red"> Usuario de red</label><br>
    <label><input type="checkbox" name="correo_corporativo"> Correo corporativo</label><br>
    <label><input type="checkbox" name="sap_acceso"> SAP</label><br>
    <label><input type="checkbox" name="sdk_acceso"> SDK</label><br>
    <label><input type="checkbox" name="telefono_interno"> Teléfono interno</label><br>
    <label><input type="checkbox" name="celular_corporativo"> Celular corporativo</label><br>
    
    <label><input type="checkbox" name="otro_equipo"> Otro</label>
    <input type="text" name="otro_equipo_texto" placeholder="Especificar">

    <button type="submit">Enviar a Ciberseguridad</button>
</form>
@endsection
