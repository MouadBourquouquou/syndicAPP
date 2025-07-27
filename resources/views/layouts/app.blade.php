<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Syndic')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            padding: 0 2rem;
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
        }

        .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: var(--sidebar-bg) !important;
            height: var(--header-height);
            display: flex;
            align-items: center;
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

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
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
            }

            .form-select {
                min-width: 150px;
            }

            .btn-primary {
                padding: 10px 20px;
                font-size: 14px;
            }

            .mb-4 {
                padding: 20px;
            }

            .user-dropdown-menu {
                right: 0;
                left: auto;
            }

            .header-right {
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .main-header {
                padding: 0 0.5rem;
            }

            .user-dropdown-menu {
                min-width: 180px;
            }

            .brand-mobile {
                font-size: 1rem;
            }
        }

        /* Mobile overlay */
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

        /* Add these styles to your existing <style> section in the layout */

        /* Notification Mini Window Styles */
        .notification-mini-window {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 380px;
            max-width: 95vw;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            max-height: 80vh;
            overflow: hidden;
            padding:10px;
        }

        .notification-mini-window.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f8fafc;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .notification-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notification-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .notification-item-mini {
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            position: relative;
        }

        .notification-item-mini:hover {
            background-color: #f9fafb;
        }

        .notification-item-mini:last-child {
            border-bottom: none;
        }

        .notification-item-mini.unread {
            background-color: #eff6ff;
            border-left: 3px solid #3b82f6;
        }

        .notification-icon-mini {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            color: white;
            flex-shrink: 0;
        }

        .notification-content-mini {
            flex: 1;
            min-width: 0;
        }

        .notification-title-mini {
            font-size: 10px;
            font-weight: 300;
            color: #1f2937;
            margin-bottom: 0.25rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-message-mini {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time-mini {
            font-size: 10px;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .notification-footer {
            padding: 0.875rem 1.25rem;
            border-top: 1px solid #e5e7eb;
            background: #fafbfc;
            border-radius: 0 0 0.75rem 0.75rem;
        }

        .voir-plus-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.5rem;
            color: #3b82f6;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .voir-plus-btn:hover {
            background-color: #eff6ff;
            color: #2563eb;
            text-decoration: none;
        }

        .empty-notifications {
            padding: 2rem 1.25rem;
            text-align: center;
            color: #6b7280;
        }

        .empty-notifications i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #d1d5db;
        }

        .unread-dot {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
        }

        /* Background colors for different notification types */
        .bg-blue-500 {
            background-color: #3b82f6;
        }

        .bg-red-500 {
            background-color: #ef4444;
        }

        .bg-orange-500 {
            background-color: #f59e0b;
        }
        .notif-route{
            color: #6b7280;;
            text-decoration: none;
            font-weight: 500;
        }
        .createdat{
            color: #3b82f6;;
            font-size: 0.75rem;
          
        }
        .bg-green-500 {
            background-color: #10b981;
        }
        

        /* Custom scrollbar for notification list */
        .notification-list::-webkit-scrollbar {
            width: 4px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .notification-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .notification-card{
            padding: 5px;
         
        }
      
        /* Mobile responsiveness for mini window */
        @media (max-width: 480px) {
            .notification-mini-window {
                width: calc(100vw - 1rem);
                right: 0.5rem;
            }

            .notification-item-mini {
                padding: 0.75rem 1rem;
                gap: 0.5rem;
            }

            .notification-header,
            .notification-footer {
                padding: 0.875rem 1rem;
            }

            .notification-icon-mini {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }

            .notification-title-mini {
                font-size: 0.8rem;
            }

            .notification-message-mini {
                font-size: 0.7rem;
            }
        }
    </style>
    @stack('styles')
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
 
    <!-- Header -->
        <nav class="main-header">
            <div class="header-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="brand-mobile">Syndic App</span>
            </div>

            <div class="header-right">

                <!-- Notifications Mini Window -->
            <div class="relative notification-dropdown">
               @php
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<button class="notification-btn" onclick="toggleNotificationWindow(event)">
    <i class="fas fa-bell"></i>
    @if($unreadCount > 0)
        <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
    @endif
</button>

                <!-- Mini Notification Window -->
                <div class="notification-mini-window" id="notificationWindow">
                    <div class="notification-header">
                        <h3>
                            <i class="fas fa-bell"></i>
                            Notifications
                        </h3>
                    </div>

                <!-- Replace your notification loop with this fixed version -->
                <div class="notification-list">
                    @php
                        // Get first 4 notifications for mini window
                        $notifications = auth()->user()->notifications()->latest()->take(4)->get();
                    @endphp
                    @foreach ($notifications as $notification)
                        @php
                            // Get the message from notification data
                            $message = strtolower($notification->data['message'] ?? '');
                            
                            // Map of keywords → route names
                            $modelRoutes = [
                                'appartement' => 'appartements.index',
                                'immeuble' => 'immeubles.index', // Fixed: was 'immeubles'
                                'résidence' => 'residences',
                                'residence' => 'residences',
                                'charge' => 'charges.index',
                               'payé'=>  'paiements.historique', // Add this line
                            ];

                           
                            $routeUrl = route('dashboard'); // default fallback
                            
                            // Check each keyword in the message
                            foreach ($modelRoutes as $keyword => $routeName) {
                                if (stripos($message, $keyword) !== false) {
                                    try {
                                        $routeUrl = route($routeName);
                                        break; // Stop at first match
                                    } catch (\Exception $e) {
                                        \Log::error('Notification route error: ' . $e->getMessage(), [
                                            'route_name' => $routeName,
                                            'message' => $message
                                        ]);
                                       $routeUrl = route('dashboard'); // default fallback
                                        break;
                                    }
                                }
                            }
                        @endphp
                        
                        <div class="notification-card">
                            <a href="{{ $routeUrl }}" class="notif-route">
                                {{ $notification->data['message'] }}
                            </a>
                            <p class="createdat">
                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                    @endforeach

                    @if ($notifications->isEmpty())
                        <p>Aucune notification pour le moment.</p>
                    @endif
                </div>

                    <div class="notification-footer">
                        <a href="{{ route('notifications') }}" class="voir-plus-btn">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Voir plus
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="user-dropdown" id="userDropdown">
                <button class="user-btn" onclick="toggleUserDropdown()">
                    <div class="user-avatar">
                        @if(auth()->user()->logo && file_exists(public_path(auth()->user()->logo)))
                            <img src="{{ asset(auth()->user()->logo) }}" alt="Avatar"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <span class="hidden md:block text-sm font-medium">
                        {{ auth()->user()->name ?? 'Utilisateur' }}
                    </span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>

                <div class="user-dropdown-menu">
                    <div class="dropdown-header">
                        <div class="font-medium text-gray-800">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                        <div class="text-sm text-gray-600">{{ auth()->user()->email ?? 'email@example.com' }}</div>
                    </div>

                    <a href="{{ route('Profile') }}" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        <span>Mon Profil</span>
                    </a>

                    <button class="dropdown-item logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </div>
            </div>
        </div>


    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-4">
        <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}"
            class="brand-link py-3">
            <i class="fas fa-building-circle-check fa-lg ml-3" style="color: var(--accent-color)"></i>
            <span class="brand-text font-weight-bold ml-2" style="color: white">Syndic App</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                @php $currentRoute = Route::currentRouteName(); @endphp

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item {{ Str::startsWith($currentRoute, 'appartements') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Str::startsWith($currentRoute, 'appartements') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-door-closed"></i>
                            <p>Appartements <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('appartements.ajouter') }}"
                                    class="nav-link {{ $currentRoute === 'appartements.ajouter' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Nouvel appartement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('appartements.index') }}"
                                    class="nav-link {{ $currentRoute === 'appartements.index' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-door-closed"></i>
                                    <p>Liste des appartements</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Str::startsWith($currentRoute, 'immeuble') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'immeuble') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Immeubles <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('immeubles-ajouter') }}"
                                    class="nav-link {{ $currentRoute === 'immeubles.ajouter' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Nouvel immeuble</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('immeubles.index') }}"
                                    class="nav-link {{ $currentRoute === 'immeubles' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list-ul"></i>
                                    <p>Liste des immeubles</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Str::startsWith($currentRoute, 'residences') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'residences') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Résidences <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('residences.ajouter') }}"
                                    class="nav-link {{ $currentRoute === 'residences.ajouter' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Nouvelle résidence</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('residences') }}"
                                    class="nav-link {{ $currentRoute === 'residences' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list-ul"></i>
                                    <p>Liste des résidences</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Str::startsWith($currentRoute, 'employes') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'employes') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-gear"></i>
                            <p>Employés <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('livewire.employes-ajouter') }}"
                                    class="nav-link {{ $currentRoute === 'employes.ajouter' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>Nouvel employé</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('livewire.employes') }}"
                                    class="nav-link {{ $currentRoute === 'employes' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Liste des employés</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Str::startsWith($currentRoute, 'charges') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'charges') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Charges <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('charges.ajouter') }}"
                                    class="nav-link {{ $currentRoute === 'charges.ajouter' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Nouvelle charge</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('charges.index') }}"
                                    class="nav-link {{ $currentRoute === 'charges' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Liste des charges</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Str::startsWith($currentRoute, 'historique') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'historique') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Historique <i class="right fas fa-angle-left text-muted"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('historique') }}"
                                    class="nav-link {{ $currentRoute === 'historique' ? 'active' : '' }}">
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

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="closeSidebar()"></div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    </div>


    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
    // Sidebar functionality
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

// Notification functionality
function toggleNotificationWindow(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    const notificationWindow = document.getElementById('notificationWindow');
    const isOpening = !notificationWindow.classList.contains('show');
    
    if (isOpening) {
        markAllNotificationsAsRead();
        // Force update the badge immediately
        updateNotificationBadge();
    }
    
    notificationWindow.classList.toggle('show');
}

function markAllNotificationsAsRead() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch('/notifications/mark-all-read-mini', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            console.error('Failed to mark notifications as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateNotificationBadge() {
    fetch('/notifications/unread-count', {
        headers: {
            'Accept': 'application/json',
            'Cache-Control': 'no-cache'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error updating badge:', error);
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        // Close notification window
        const notificationWindow = document.getElementById('notificationWindow');
        const notificationBtn = document.querySelector('.notification-btn');
        
        if (!notificationWindow.contains(event.target) && 
            !notificationBtn.contains(event.target)) {
            notificationWindow.classList.remove('show');
        }

        // Close user dropdown
        const userDropdown = document.getElementById('userDropdown');
        if (!userDropdown.contains(event.target)) {
            userDropdown.classList.remove('active');
        }

        // Close sidebar on mobile
        if (window.innerWidth <= 768) {
            const sidebar = document.querySelector('.main-sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (!sidebar.contains(event.target) && 
                !menuToggle.contains(event.target)) {
                closeSidebar();
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.body.classList.remove('sidebar-open');
        }
    });

    // Update notification badge periodically (every 3 seconds)
    setInterval(updateNotificationBadge, 30000);

    // Initialize notification badge on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateNotificationBadge();
    });
}
</script>

    @livewireScripts
    @stack('scripts')
</body>

</html>