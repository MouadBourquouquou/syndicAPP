<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Syndic')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Police Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --main-bg: #f8f9fa;
            --sidebar-bg: #2d3748;
            --accent-color: #64748b;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --hover-bg: rgba(100, 116, 139, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--main-bg);
        }

        .main-sidebar {
            background-color: var(--sidebar-bg) !important;
            border-right: 1px solid #e5e7eb !important;
        }

        .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: var(--sidebar-bg) !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.2s ease;
        }

        .nav-link.active {
            background: var(--hover-bg) !important;
            color: white !important;
            border-left: 4px solid var(--accent-color) !important;
        }

        .nav-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .nav-icon {
            color: var(--accent-color) !important;
            opacity: 0.8;
        }

        .nav-treeview .nav-link {
            padding-left: 2.5rem !important;
            font-size: 0.9em;
        }

        .content-wrapper {
            background: var(--main-bg);
        }

        .main-header {
            background: white !important;
            border-bottom: 1px solid #e5e7eb !important;
        }
        .sidebar-open .main-sidebar {
    transform: translateX(0) !important;
}

.main-sidebar {
    transition: transform 0.3s ease-in-out;
}

    </style>
    @stack('styles')
    @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="min-height: 100vh;">

<!-- Contenu principal -->
<div class="content-wrapper" style="background: #f8fafc">
    <section class="content pt-4">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
</div>

<!-- Navbar -->
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars text-gray-600"></i>
            </a>
        </li>
    </ul>
    

</nav>


<!-- Sidebar -->
<aside class="main-sidebar elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link py-3">
        <i class="fas fa-building-circle-check fa-lg ml-3" style="color: var(--accent-color)"></i>
        <span class="brand-text font-weight-bold ml-2" style="color: white">SyndicApp</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3">
            @php $currentRoute = Route::currentRouteName(); @endphp

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Appartements -->
                <li class="nav-item {{ Str::startsWith($currentRoute, 'appartements') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'appartements') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-door-closed"></i>
                        <p>Appartements <i class="right fas fa-angle-left text-muted"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('appartements.ajouter') }}" class="nav-link {{ $currentRoute === 'appartements.ajouter' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Nouvel appartement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('appartements.index') }}" class="nav-link {{ $currentRoute === 'appartements' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>Liste des appartements</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Immeubles -->
                <li class="nav-item {{ Str::startsWith($currentRoute, 'immeubles') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'immeubles') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Immeubles <i class="right fas fa-angle-left text-muted"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('livewire.immeubles-ajouter') }}" class="nav-link {{ $currentRoute === 'immeubles.ajouter' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Nouvel immeuble</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('immeubles.index') }}" class="nav-link {{ $currentRoute === 'immeubles' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>Liste des immeubles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Résidences -->
                <li class="nav-item {{ Str::startsWith($currentRoute, 'residences') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'residences') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Résidences <i class="right fas fa-angle-left text-muted"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('residences.ajouter') }}" class="nav-link {{ $currentRoute === 'residences.ajouter' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Nouvelle résidence</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('residences.index') }}" class="nav-link {{ $currentRoute === 'residences' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>Liste des résidences</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Employés -->
                <li class="nav-item {{ Str::startsWith($currentRoute, 'employes') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'employes') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-gear"></i>
                        <p>Employés <i class="right fas fa-angle-left text-muted"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('livewire.employes-ajouter') }}" class="nav-link {{ $currentRoute === 'employes.ajouter' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Nouvel employé</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('livewire.employes') }}" class="nav-link {{ $currentRoute === 'employes' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Liste des employés</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Charges -->
                <li class="nav-item {{ Str::startsWith($currentRoute, 'charges') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'charges') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Charges <i class="right fas fa-angle-left text-muted"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('charges.ajouter') }}" class="nav-link {{ $currentRoute === 'charges.ajouter' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                <p>Nouvelle charge</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('charges') }}" class="nav-link {{ $currentRoute === 'charges' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Liste des charges</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Historique -->
<li class="nav-item {{ Str::startsWith($currentRoute, 'historique') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'historique') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>Historique <i class="right fas fa-angle-left text-muted"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('historique') }}" class="nav-link {{ $currentRoute === 'historique' ? 'active' : '' }}">
                <i class="nav-icon fas fa-list"></i>
                <p>Liste des historiques</p>
            </a>
        </li>
    </ul>
</li>



            </ul>
        </nav>
    </div>
</aside>

<!-- Footer -->
{{-- 
<footer class="main-footer text-center py-3 border-top">
    <span class="text-muted">© 2025 SyndicApp · Tous droits réservés</span>
</footer>
--}}

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@livewireScripts
@stack('scripts')

</body>
</html>