<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            --header-height: 60px;
        }

        /* --- Global and Body Styles --- */
        html,
        body {
            font-family: 'Inter', sans-serif;
            background: var(--main-bg);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Hide scrollbars */
        ::-webkit-scrollbar {
            display: none;
            width: 0 !important;
            height: 0 !important;
        }

        * {
            scrollbar-width: none;
        }

        /* --- Layout Structure --- */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- Header Styles --- */
        .main-header {
            background: white !important;
            border-bottom: 1px solid #e5e7eb !important;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
        }

        .brand-mobile {
            display: none;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.1rem;
        }

        /* Notification Button */
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .notification-btn:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .user-btn:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }

        .dropdown-item.logout {
            color: #ef4444;
            border-top: 1px solid #e5e7eb;
        }

        .dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* --- Sidebar Styles --- */
        .main-sidebar {
            background-color: var(--sidebar-bg) !important;
            border-right: 1px solid #e5e7eb !important;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            padding-top: var(--header-height);
        }

        .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: var(--sidebar-bg) !important;
            height: var(--header-height);
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
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

        .nav-sidebar .nav-link p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.95em;
        }

        .nav-treeview .nav-link {
            padding-left: 2.5rem !important;
            font-size: 0.9em;
        }

        /* --- Content Wrapper Styles --- */
        .content-wrapper {
            background: var(--main-bg);
            margin-left: 250px;
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease-in-out;
            padding: 1.5rem;
        }

        .sidebar-collapsed .content-wrapper {
            margin-left: 0;
        }

        .sidebar-collapsed .main-sidebar {
            transform: translateX(-250px);
        }

        /* --- Logout Specific Styles --- */
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

        /* --- Mobile Overlay --- */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-open .mobile-overlay {
            opacity: 1;
            visibility: visible;
        }

        /* --- Responsive Design --- */
        @media (max-width: 1000px) {
            .menu-toggle {
                display: block;
            }

            .brand-mobile {
                display: block;
            }

            .main-sidebar {
                transform: translateX(-250px);
            }

            .sidebar-open .main-sidebar {
                transform: translateX(0);
            }

            .content-wrapper {
                margin-left: 0;
                padding: 1rem;
            }

            .main-header {
                padding: 0 1rem;
            }

            .user-dropdown-menu {
                right: 0;
                left: auto;
            }

            .header-right {
                gap: 0.5rem;
            }
        }

        @media (max-width: 680px) {
            .main-header {
                padding: 0 0.75rem;
            }

            .user-dropdown-menu {
                min-width: 180px;
            }

            .brand-mobile {
                font-size: 1rem;
            }
            
            .content-wrapper {
                padding: 0.75rem;
            }
        }
    </style>
    @stack('styles')
    @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="min-height: 100vh;">

<!-- Mobile Overlay -->
<div class="mobile-overlay" onclick="closeSidebar()"></div>

<!-- Navbar -->
<nav class="main-header">
    <div class="header-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}">
            <span class="brand-mobile">Syndic App</span>
        </a>
    </div>

    <div class="header-right">

        <!-- User Dropdown -->
        <div class="user-dropdown" id="userDropdown">
            <button class="user-btn" onclick="toggleUserDropdown()">
                <div class="user-avatar">
                    @if(auth()->user()->logo && file_exists(public_path(auth()->user()->logo)))
                        <img src="{{ asset(auth()->user()->logo) }}" alt="Avatar"
                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <span class="hidden md:block text-sm font-medium">
                    {{ auth()->user()->name ?? 'Utilisateur' }} {{ auth()->user()->prenom ?? '' }}
                </span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>

            <div class="user-dropdown-menu">
                <div class="dropdown-header">
                    <div class="font-medium text-gray-800">{{ auth()->user()->name ?? 'Utilisateur' }} {{auth()->user()->prenom ?? ''}}</div>
                    <div class="text-sm text-gray-600">{{ auth()->user()->email ?? 'email@example.com' }}</div>
                </div>

                <button class="dropdown-item logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </div>
        </div>
    </div>
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
                        <p>Gérer les demandes </p>
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
            </ul>
        </nav>
    </div>
</aside>

<!-- Contenu principal -->
<div class="content-wrapper">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<!-- Logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@livewireScripts
@stack('scripts')

<script>
    // Sidebar toggle functionality
    function toggleSidebar() {
        document.body.classList.toggle('sidebar-open');
    }

    function closeSidebar() {
        document.body.classList.remove('sidebar-open');
    }

    // User dropdown functionality
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }


    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        const userDropdown = document.getElementById('userDropdown');
        
        if (!userDropdown.contains(event.target)) {
            userDropdown.classList.remove('active');
        }
        
        // Close sidebar when clicking outside on mobile
        const sidebar = document.querySelector('.main-sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (window.innerWidth <= 768 &&
            !sidebar.contains(event.target) &&
            !menuToggle.contains(event.target) &&
            !event.target.classList.contains('mobile-overlay')) {
            closeSidebar();
        }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
</script>

</body>
</html>