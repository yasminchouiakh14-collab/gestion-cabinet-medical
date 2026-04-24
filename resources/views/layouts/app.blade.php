<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cabinet Médical') — Cabinet Médical</title>
    <meta name="description" content="Application de gestion des rendez-vous du cabinet médical">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --sidebar-bg: #0f172a;
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --text-muted: #64748b;
        }

        * { font-family: 'Inter', sans-serif; }

        body { background: #f1f5f9; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            position: fixed; left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; gap: .75rem;
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }

        .sidebar-brand h6 {
            color: #fff; font-weight: 700; font-size: .9rem;
            margin: 0; line-height: 1.2;
        }
        .sidebar-brand small { color: #94a3b8; font-size: .72rem; }

        .sidebar-label {
            padding: .5rem 1.5rem .25rem;
            font-size: .65rem; font-weight: 600; letter-spacing: .1em;
            color: #475569; text-transform: uppercase;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem 1.5rem;
            color: #94a3b8; text-decoration: none;
            font-size: .875rem; font-weight: 500;
            border-radius: 0; transition: all .2s;
            margin: .1rem .75rem;
            border-radius: 8px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(37,99,235,.15);
            color: #60a5fa;
        }

        .sidebar-link.active { color: #93c5fd; font-weight: 600; }
        .sidebar-link i { font-size: 1rem; width: 20px; flex-shrink: 0; }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar .page-title {
            font-size: 1.1rem; font-weight: 600; color: #0f172a; margin: 0;
        }

        .topbar-actions { display: flex; align-items: center; gap: .75rem; }

        /* Content area */
        .content-area { padding: 1.75rem; flex: 1; }

        /* Cards */
        .stat-card {
            background: #fff; border-radius: 16px;
            padding: 1.5rem; border: 1px solid #e2e8f0;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.08); }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; color: #0f172a; }
        .stat-card .stat-label { color: var(--text-muted); font-size: .875rem; }

        /* Table */
        .table-card {
            background: #fff; border-radius: 16px;
            border: 1px solid #e2e8f0; overflow: hidden;
        }
        .table-card .card-header {
            padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;
            background: #fff;
        }
        .table { margin: 0; }
        .table th { font-size: .8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; }
        .table td { vertical-align: middle; font-size: .875rem; }

        /* Badges */
        .badge-status {
            padding: .3rem .75rem; border-radius: 999px;
            font-size: .75rem; font-weight: 600;
        }
        .status-pending   { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-completed { background: #e0e7ff; color: #3730a3; }

        /* Buttons */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

        /* Avatar */
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 600; font-size: .85rem; flex-shrink: 0;
        }

        /* Alert */
        .alert { border-radius: 10px; border: none; }

        /* Footer */
        footer {
            padding: 1rem 1.75rem;
            border-top: 1px solid #e2e8f0;
            background: #fff;
            font-size: .8rem; color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* Animations */
        .fade-in { animation: fadeIn .4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🏥</div>
        <div>
            <h6>Cabinet Médical</h6>
            <small>Gestion des RDV</small>
        </div>
    </div>

    <nav class="mt-2 pb-4">
        <div class="sidebar-label">Principal</div>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> {{ __('navigation.dashboard') }}
        </a>
        <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> {{ __('navigation.appointments') }}
        </a>

        <div class="sidebar-label mt-2">Gestion</div>
        <a href="{{ route('doctors.index') }}" class="sidebar-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> {{ __('navigation.doctors') }}
        </a>
        <a href="{{ route('services.index') }}" class="sidebar-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
            <i class="bi bi-heart-pulse-fill"></i> {{ __('navigation.services') }}
        </a>

        <div class="sidebar-label mt-2">Compte</div>
        <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> {{ __('navigation.profile') }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link border-0 w-100 text-start">
                <i class="bi bi-box-arrow-left"></i> {{ __('navigation.logout') }}
            </button>
        </form>
    </nav>
</aside>

{{-- Main --}}
<div class="main-content">
    {{-- Topbar --}}
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h1 class="page-title mb-0">@yield('page-title', 'Dashboard')</h1>
        </div>

        <div class="topbar-actions">
            {{-- Language Switcher --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    {{ app()->getLocale() === 'fr' ? '🇫🇷 FR' : '🇬🇧 EN' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('language.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="locale" value="fr">
                            <button class="dropdown-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}" type="submit">
                                🇫🇷 Français
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('language.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <button class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" type="submit">
                                🇬🇧 English
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            {{-- New appointment shortcut --}}
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> {{ __('navigation.new_appointment') }}
            </a>

            {{-- User dropdown --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <div class="avatar" style="width:28px;height:28px;font-size:.75rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>{{ __('navigation.profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-left me-2"></i>{{ __('navigation.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    {{-- Alerts --}}
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="fade-in">
            @yield('content')
        </div>
    </div>

    <footer>
        <div class="d-flex justify-content-between">
            <span>© {{ date('Y') }} Cabinet Médical — Tous droits réservés</span>
            <span>v1.0.0</span>
        </div>
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Sidebar mobile toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });

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
