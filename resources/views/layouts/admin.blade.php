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

    html, body {
        font-family: 'Inter', sans-serif;
        background: var(--main-bg);
        overflow-x: hidden; /* Prevent horizontal scrollbar */
    }

    .wrapper {
        overflow: hidden; /* Prevent main wrapper overflow */
    }

    .main-sidebar {
        background-color: var(--sidebar-bg) !important;
        border-right: 1px solid #e5e7eb !important;
        height: 100vh;
        overflow-y: auto; /* Keep this for vertical scrolling if sidebar content is long */
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

    /* --- New/Modified Styles Below --- */

    /* For single-line menu item */
    .nav-sidebar .nav-link p {
        white-space: nowrap; /* Prevent text from wrapping */
        overflow: hidden; /* Hide overflow text */
        text-overflow: ellipsis; /* Add ellipsis for hidden text */
        font-size: 0.95em; /* Slightly reduce font size to fit */
    }

    /* Hide scrollbars (works across most browsers) */
    ::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Webkit browsers (Chrome, Safari, Edge) */
        width: 0 !important; /* Ensure no width for vertical scrollbar */
        height: 0 !important; /* Ensure no height for horizontal scrollbar */
    }
    * {
        scrollbar-width: none; /* Hide scrollbar for Firefox */
    }

    /* --- End New/Modified Styles --- */


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

    /* Logout specific styles */
    .logout-section {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-link {
        color: #ef4444 !important;
    }

    .logout-link:hover {
        background: rgba(239, 68, 68, 0.1) !important;
        color: #dc2626 !important;
    }

    .logout-link .nav-icon {
        color: #ef4444 !important;
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


<!-- Sidebar Admin -->
<aside class="main-sidebar elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link py-3">
        <i class="fas fa-building-circle-check fa-lg ml-3" style="color: var(--accent-color)"></i>
        <span class="brand-text font-weight-bold ml-2" style="color: white">Syndic App</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Demandes d'inscription -->
                <li class="nav-item">
                    <a href="{{ route('admin.demandes') }}" class="nav-link {{ Route::is('admin.demandes') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>Demandes d’inscription</p>
                    </a>
                </li>

                <!-- Gérer les syndics -->
                <li class="nav-item">
                    <a href="{{ route('admin.syndics') }}" class="nav-link {{ Route::is('admin.syndics') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Gérer les syndics</p>
                    </a>
                </li>

                <!-- Gérer les administrateurs -->
                <li class="nav-item">
                    <a href="{{ route('admin.admins.index') }}" class="nav-link {{ Route::is('admin.admins.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Gérer les admins</p>
                    </a>
                </li>

                <!-- Déconnexion -->
                <div class="logout-section">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link logout-link" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Déconnexion</p>
                        </a>
                    </li>
                </div>
            </ul>
        </nav>
    </div>
</aside>

<!-- Logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


<!-- Logout Form (hidden) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

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