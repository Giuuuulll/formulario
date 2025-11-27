@extends('layouts.app')

@section('content')
<h2>Solicitud - Herramientas Informáticas (TI)</h2>

<form action="{{ route('solicitudes.store_ti') }}" method="POST">
    @csrf

    <label><input type="checkbox" name="sap_business_one"> SAP Business One</label><br>
    <label><input type="checkbox" name="sdk"> SDK</label><br>
    <label><input type="checkbox" name="gt_solutions"> GT Solutions</label><br>
    <label><input type="checkbox" name="internet_rrhh"> Internet - RRHH marcaciones</label><br>
    <label><input type="checkbox" name="sistema_cobranzas"> Sistema de cobranzas</label><br>

    <label><input type="checkbox" name="otros_sistemas"> Otros sistemas</label>
    <input type="text" name="otros_sistemas_texto" placeholder="Especificar (si corresponde)">

    <button type="submit">Enviar a Auditoría TI</button>
</form>
@endsection
