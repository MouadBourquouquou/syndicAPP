<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Assistant')</title>

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
        }

        html, body {
            font-family: 'Inter', sans-serif;
            background: var(--main-bg);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            display: none;
            width: 0 !important;
            height: 0 !important;
        }

        * {
            scrollbar-width: none;
        }

        .main-sidebar {
            background-color: var(--sidebar-bg) !important;
            border-right: 1px solid #e5e7eb !important;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-open .main-sidebar {
            transform: translateX(0) !important;
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

        .main-header {
            background: white !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .content-wrapper {
            background: var(--main-bg);
        }

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

    <div class="content-wrapper" style="background: #f8fafc">
        <section class="content pt-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <nav class="main-header navbar navbar-expand navbar-white">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars text-gray-600"></i>
                </a>
            </li>
        </ul>
    </nav>

    @include('assistant.layouts.sidebar')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    @livewireScripts
    @stack('scripts')

</body>

</html>
