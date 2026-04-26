<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Patient') — Cabinet Médical</title>
    <meta name="description" content="Espace personnel du patient pour la gestion des rendez-vous">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0D9488;
            --primary-dark: #0F766E;
            --topbar-bg: #ffffff;
            --topbar-height: 70px;
            --text-muted: #64748b;
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background: #F8FAFC; min-height: 100vh; display: flex; flex-direction: column; }

        /* Top Navigation */
        .navbar-patient {
            height: var(--topbar-height);
            background: var(--topbar-bg);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .navbar-brand-custom {
            display: flex; align-items: center; gap: .75rem; text-decoration: none;
        }
        
        .brand-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: #0F172A;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0; color: white; font-weight: bold;
        }

        .brand-text h6 { color: #0f172a; font-weight: 700; font-size: 1rem; margin: 0; line-height: 1.2; }
        .brand-text small { color: #64748b; font-size: .75rem; }

        .nav-link-custom {
            color: #475569; font-weight: 500; padding: .5rem 1rem; border-radius: 8px; transition: all .2s; text-decoration: none; display: flex; align-items: center; gap: .5rem;
        }
        .nav-link-custom:hover, .nav-link-custom.active { background: #eff6ff; color: #2563eb; }

        /* Main content */
        .main-container { flex: 1; padding: 2rem 0; }

        /* Cards */
        .patient-card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden; }

        /* Badges */
        .badge-status { padding: .4rem .85rem; border-radius: 999px; font-size: .75rem; font-weight: 600; }
        .status-pending   { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-completed { background: #e0e7ff; color: #3730a3; }

        /* Buttons */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

        /* Footer */
        footer { padding: 1.5rem 0; background: #fff; border-top: 1px solid #e2e8f0; font-size: .85rem; color: var(--text-muted); text-align: center; }

        /* Animations */
        .fade-in { animation: fadeIn .4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar-patient sticky-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="navbar-brand-custom">
            <div class="brand-icon">C</div>
            <div class="brand-text">
                <h6>Cabinet Médical</h6>
                <small>Espace Patient</small>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="d-none d-md-flex align-items-center gap-2">
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i> Accueil
            </a>
            <a href="{{ route('appointments.index') }}" class="nav-link-custom {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Mes Rendez-vous
            </a>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm ms-2 px-3 rounded-pill">
                <i class="bi bi-plus-lg me-1"></i> Nouveau RDV
            </a>
        </div>

        <!-- User Dropdown & Mobile Toggle -->
        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-light rounded-pill border-0 d-flex align-items-center gap-2 px-3" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5 text-primary"></i>
                    <span class="d-none d-sm-inline fw-semibold text-dark">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3">
                    <li><h6 class="dropdown-header">Mon Compte</h6></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item py-2 text-danger" type="submit"><i class="bi bi-box-arrow-left me-2"></i>Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- Mobile Menu (Bottom Navigation idea or distinct menu) --}}
<div class="bg-white border-bottom d-md-none p-2 shadow-sm">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house fs-5"></i>
        </a>
        <a href="{{ route('appointments.index') }}" class="nav-link-custom {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
            <i class="bi bi-calendar fs-5"></i>
        </a>
        <a href="{{ route('appointments.create') }}" class="text-primary d-flex align-items-center p-2 rounded-circle" style="background:#eff6ff;">
            <i class="bi bi-plus-lg fs-4 line-height-1"></i>
        </a>
    </div>
</div>

{{-- Main --}}
<div class="main-container container fade-in">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Content inject --}}
    @yield('content')
</div>

<footer>
    <div class="container">
        © {{ date('Y') }} Espace Patient — Cabinet Médical. Vos données sont sécurisées.
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(a);
            bsAlert.close();
        });
    }, 5000);
</script>

@stack('scripts')
</body>
</html>
