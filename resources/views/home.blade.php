@extends('layouts.app')

@section('content')
<div class="container">

   
    <div class="mb-4">
        <h2 class="fw-bold">Bienvenido/a, {{ auth()->user()->nombre }} 💗</h2>
        <p class="text-muted">Sistema de gestión de solicitudes</p>
    </div>

    <div class="row g-3">

        {{-- =======================================
             ROL: USUARIO
        ======================================== --}}
        @if(auth()->user()->rol === 'usuario')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Nueva Solicitud</h5>
                    <p class="text-muted small">Completá el formulario inicial</p>
                    <a href="{{ route('solicitudes.crear') }}" class="btn btn-primary w-100">
                        Crear solicitud
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Mis solicitudes</h5>
                    <p class="text-muted small">Revisá el estado de tus trámites</p>
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-outline-primary w-100">
                        Ver mis solicitudes
                    </a>
                </div>
            </div>
        </div>
        @endif


        {{-- =======================================
             ROL: RRHH
        ======================================== --}}
        @if(auth()->user()->rol === 'rrhh')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Solicitudes pendientes</h5>
                    <p class="text-muted small">Tareas asignadas para aprobar</p>
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-primary w-100">
                        Revisar solicitudes
                    </a>
                </div>
            </div>
        </div>
        @endif



        {{-- =======================================
             ROL: AUDITORÍA
        ======================================== --}}
        @if(auth()->user()->rol === 'auditoria')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Solicitudes RRHH</h5>
                    <p class="text-muted small">Aprobar tareas enviadas por RRHH</p>
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-warning w-100">
                        Revisar pendientes
                    </a>
                </div>
            </div>
        </div>
        @endif


        {{-- =======================================
             ROL: TI
        ======================================== --}}
        @if(auth()->user()->rol === 'ti')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Herramientas TI</h5>
                    <p class="text-muted small">Aprobar accesos requeridos</p>
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-info w-100 text-white">
                        Revisar solicitudes
                    </a>
                </div>
            </div>
        </div>
        @endif



        {{-- =======================================
             ROL: CIBERSEGURIDAD
        ======================================== --}}
        @if(auth()->user()->rol === 'ciber')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Aprobación Final</h5>
                    <p class="text-muted small">Revisión completa de toda la cadena</p>
                    <a href="{{ route('solicitudes.index') }}" class="btn btn-danger w-100">
                        Ver solicitudes pendientes
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection
