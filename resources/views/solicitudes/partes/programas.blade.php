<div class="card mb-4">
    <div class="card-header fw-bold">Programas solicitados</div>
    <div class="card-body">
        <ul>
            @if($solicitud->sap_business_one) <li>SAP Business One</li> @endif
            @if($solicitud->sdk) <li>SDK</li> @endif
            @if($solicitud->gt_solutions) <li>GT Solutions</li> @endif
            @if($solicitud->internet_rrhh) <li>Internet RRHH</li> @endif
            @if($solicitud->sistema_cobranzas) <li>Sistema de cobranzas</li> @endif
            @if($solicitud->otros_sistemas)
                <li>Otros: {{ $solicitud->otros_sistemas_texto }}</li>
            @endif
        </ul>
    </div>
</div>
