@extends('layouts.app')

@section('content')

<h2 class="mb-4">Nueva Solicitud – Formulario Completo</h2>

<form action="{{ route('solicitudes.storeCompleto') }}" method="POST">
    @csrf


    
    <div class="card mb-4">
        <div class="card-header fw-bold">Información del Empleado</div>

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" 
                       value="{{ auth()->user()->nombre }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Departamento</label>
                <input type="text" name="departamento" class="form-control"
                       value="{{ auth()->user()->departamento }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Puesto / Función</label>
                <input type="text" name="puesto" class="form-control"
                       value="{{ auth()->user()->puesto }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Empresa</label>
                <input type="text" name="empresa" class="form-control" placeholder="Ej: Garden, MPY, Cuevas…" required>
            </div>

        </div>
    </div>



    
   
    <div class="card mb-4">
        <div class="card-header fw-bold">Descripción del Puesto y Tareas</div>

        <div class="card-body">

            <label class="form-label">Tarea 1</label>
            <input type="text" name="tarea1" class="form-control mb-2">

            <label class="form-label">Tarea 2</label>
            <input type="text" name="tarea2" class="form-control mb-2">

            <label class="form-label">Tarea 3</label>
            <input type="text" name="tarea3" class="form-control mb-2">

            <label class="form-label">Tarea 4</label>
            <input type="text" name="tarea4" class="form-control mb-2">

            <label class="form-label">Tarea 5</label>
            <input type="text" name="tarea5" class="form-control mb-2">

        </div>
    </div>



   
    <div class="card mb-4">
        <div class="card-header fw-bold">Programas y Sistemas</div>

        <div class="card-body">

            @php
                $programas = [
                    'sap_business_one' => 'SAP Business One',
                    'sdk' => 'SDK',
                    'gt_solutions' => 'GT Solutions',
                    'internet_rrhh' => 'Internet - RRHH Marcaciones',
                    'sistema_cobranzas' => 'Sistema de Cobranzas',
                ];
            @endphp

            @foreach($programas as $campo => $texto)
                <div class="form-check">
                    <input type="checkbox" name="{{ $campo }}" value="si" class="form-check-input" id="{{ $campo }}">
                    <label class="form-check-label" for="{{ $campo }}">{{ $texto }}</label>
                </div>
            @endforeach

            <div class="form-check mt-2">
                <input type="checkbox" name="otros_sistemas" value="si" class="form-check-input" id="otros_sistemas"
                       onchange="document.getElementById('otros_sistemas_texto').disabled = !this.checked">
                <label class="form-check-label" for="otros_sistemas">Otros sistemas</label>
            </div>

            <input type="text" name="otros_sistemas_texto" id="otros_sistemas_texto"
                   class="form-control mt-2" placeholder="Especificar..." disabled>

        </div>
    </div>



  
        <div class="card-header fw-bold">Herramientas Informáticas Requeridas</div>

        <div class="card-body">

            @php
                $herramientas = [
                    'pc_notebook' => 'PC / Notebook',
                    'tablet' => 'Tablet',
                    'impresora_scanner' => 'Impresora / Scanner',
                    'usuario_red' => 'Usuario de Red',
                    'correo_corporativo' => 'Correo Corporativo',
                    'sap_acceso' => 'Acceso SAP',
                    'sdk_acceso' => 'Acceso SDK',
                    'telefono_interno' => 'Teléfono interno',
                    'celular_corporativo' => 'Celular Corporativo',
                ];
            @endphp

            @foreach($herramientas as $campo => $texto)
                <div class="form-check">
                    <input type="checkbox" name="{{ $campo }}" value="si" class="form-check-input" id="{{ $campo }}">
                    <label class="form-check-label" for="{{ $campo }}">{{ $texto }}</label>
                </div>
            @endforeach

            <div class="form-check mt-2">
                <input type="checkbox" name="otro_equipo" value="si" class="form-check-input" id="otro_equipo"
                       onchange="document.getElementById('otro_equipo_texto').disabled = !this.checked">
                <label class="form-check-label" for="otro_equipo">Otro equipo</label>
            </div>

            <input type="text" name="otro_equipo_texto" id="otro_equipo_texto"
                   class="form-control mt-2" placeholder="Especificar..." disabled>

        </div>
    </div>




    <div class="card mb-4">
        <div class="card-header fw-bold">Comentarios Adicionales</div>
        <div class="card-body">
            <textarea name="comentarios" class="form-control" rows="4" placeholder="Escribe algo si querés… (opcional)"></textarea>
        </div>
    </div>



>
    <div class="text-end">
        <button type="submit" class="btn btn-primary px-4">
            Enviar solicitud completa
        </button>
    </div>

</form>

@endsection
