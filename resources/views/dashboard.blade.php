@extends('layouts.app')

@php($title = 'Inicio')

@section('content')

<div class="row g-3 mb-4">
    @php($total = $stats->sum())
    <div class="col-md-3" v-cloak>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Tickets totales</p>
                <h3 class="mb-0">{{ $total }}</h3>
            </div>
        </div>
    </div>

    @foreach(['ALTA' => 'Alta',
              'PENDIENTE_RRHH' => 'Pendiente RRHH',
              'EN_PROCESO_SISTEMAS' => 'En Sistemas',
              'TERMINADO_SISTEMA' => 'Terminados'] as $key => $label)

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">{{ $label }}</p>
                    <h4 class="mb-0">{{ $stats[$key] ?? 0 }}</h4>
                </div>
            </div>
        </div>

    @endforeach
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Últimos tickets</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Referencia</th>
                        <th>Empresa</th>
                        <th>Estado</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->reference }}</td>
                            <td>{{ $ticket->company->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-status badge-{{ $ticket->status }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at?->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Sin tickets recientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
