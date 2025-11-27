<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Solicitudes</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background:#f6f8fb; }

        /* ===============================
           PILLS DE FILTROS
        =============================== */
        .filtro-pill {
            padding: 8px 18px;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all .25s ease;
            display: inline-block;
            border: 1px solid transparent;
        }
        .filtro-pill:hover { transform: translateY(-2px); }
        .filtro-pill.active {
            background: #1d4ed8;
            color: #fff !important;
            border-color: #1d4ed8;
            box-shadow: 0 0 10px rgba(29,78,216,0.35);
        }
        .filtro-vacio { background:#e5e7eb; color:#374151; }
        .filtro-medio { background:#bfdbfe; color:#1e3a8a; }
        .filtro-alto { background:#1e40af; color:white; }

        /* ===============================
           SIDEBAR
        =============================== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: #111827;
            padding: 16px 12px;
            color: #e5e7eb;
        }
        .sidebar .nav-link { color:#cbd5e1; }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background:#1f2937;
            color:#fff;
        }

        /* ===============================
           NOTIFICACIONES DROPDOWN
        =============================== */
        .noti-box {
            background:#1f2937;
            border:1px solid #374151;
            padding:10px;
            border-radius:6px;
            max-height:220px;
            overflow-y:auto;
        }
        .noti-item {
            padding:6px 0;
            border-bottom:1px solid #374151;
        }
        .noti-item:last-child { border-bottom:none; }

        /* ===============================
           CONTENIDO
        =============================== */
        .content {
            margin-left:240px;
            padding:24px;
        }
    </style>

    @stack('head')
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-lightning-fill text-warning"></i>
            <strong>Solicitudes</strong>
        </div>

        <nav class="nav flex-column gap-1">

            <a href="{{ route('solicitudes.index') }}"
               class="nav-link px-2 py-1 rounded {{ request()->routeIs('solicitudes.index') ? 'active' : '' }}">
                🏠 Inicio
            </a>

            <a href="{{ route('solicitudes.index') }}"
               class="nav-link px-2 py-1 rounded {{ request()->routeIs('solicitudes.index') ? 'active' : '' }}">
                📄 Mis Solicitudes
            </a>

            <a href="{{ route('solicitudes.crear') }}"
               class="nav-link px-2 py-1 rounded {{ request()->routeIs('solicitudes.crear') ? 'active' : '' }}">
                ➕ Nueva Solicitud
            </a>

            @php
                $noLeidas = \App\Models\Notificacion::where('user_id', auth()->id())
                            ->where('leido', 0)
                            ->count();
                $ultimas = \App\Models\Notificacion::where('user_id', auth()->id())
                            ->orderBy('created_at','desc')
                            ->take(5)
                            ->get();
            @endphp

            <!-- NOTIFICACIONES -->
            <div class="nav-link px-2 py-1 rounded position-relative">

                <div onclick="toggleNoti()" class="d-flex justify-content-between align-items-center" style="cursor:pointer;">
                    <span>🔔 Notificaciones</span>

                    @if($noLeidas > 0)
                        <span class="badge bg-danger">{{ $noLeidas }}</span>
                    @endif
                </div>

                <div id="notiDropdown" class="mt-2 d-none noti-box">
                    @forelse($ultimas as $n)
                        <div class="noti-item">
                            <small class="text-light">{{ Str::limit($n->mensaje, 60) }}</small>
                            <div class="text-muted small">{{ $n->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-muted small">Sin notificaciones</div>
                    @endforelse

                    <a href="{{ route('notificaciones.index') }}" class="btn btn-sm btn-primary mt-2 w-100">
                        Ver todas
                    </a>
                </div>
            </div>

            <a href="{{ route('notificaciones.index') }}"
               class="nav-link px-2 py-1 rounded {{ request()->routeIs('notificaciones.index') ? 'active' : '' }}">
                📬 Bandeja completa
            </a>

        </nav>

        <div class="mt-auto">
            @auth
                <div class="small text-secondary mt-4">Bienvenid@</div>
                <div class="fw-semibold">{{ auth()->user()->nombre }}</div>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="btn btn-sm btn-outline-light w-100">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </div>



    <!-- CONTENIDO -->
    <div class="content">
        @yield('content')
    </div>



<!-- =====================
     JS GENERAL
===================== -->

<script>
function toggleNoti() {
    let box = document.getElementById('notiDropdown');
    box.classList.toggle('d-none');
}
</script>

<audio id="notiSound" src="/sonidos/button-3.mp3" preload="auto"></audio>

<script>
let lastCount = {{ auth()->check() ? \App\Models\Notificacion::where('user_id', auth()->id())->where('leido',0)->count() : 0 }};

setInterval(() => {
    fetch("{{ route('notificaciones.poll') }}")
        .then(res => res.json())
        .then(data => {

            let count = data.noLeidas;

            const link = document.querySelector("a[href='{{ route('notificaciones.index') }}']");
            if (!link) return;

            let oldBadge = link.querySelector(".badge");
            if (oldBadge) oldBadge.remove();

            if (count > 0) {
                let b = document.createElement("span");
                b.className = "badge bg-danger ms-2";
                b.textContent = count;
                link.appendChild(b);
            }

            if (count > lastCount) {
                document.getElementById("notiSound").play();
            }

            lastCount = count;
        })
        .catch(err => console.error("Error poll:", err));
}, 4000);
</script>

<!-- BOOTSTRAP JS (para modales y dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
