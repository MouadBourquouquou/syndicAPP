<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('assistant.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Syndic App</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('assistant.dashboard') }}" class="nav-link {{ request()->routeIs('assistant.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Appartements -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.appartements*') || request()->routeIs('assistant.appartement.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.appartements*') || request()->routeIs('assistant.appartement.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Appartements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.appartements.create') }}" class="nav-link {{ request()->routeIs('assistant.appartements.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.appartements.index') }}" class="nav-link {{ request()->routeIs('assistant.appartements.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Immeubles -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.immeubles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.immeubles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Immeubles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.immeubles.create') }}" class="nav-link {{ request()->routeIs('assistant.immeubles.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.immeubles.index') }}" class="nav-link {{ request()->routeIs('assistant.immeubles.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Résidences -->
                <li class="nav-item">
                    <a href="{{ route('assistant.residences.index') }}" class="nav-link {{ request()->routeIs('assistant.residences*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Résidences</p>
                    </a>
                </li>

                <!-- Charges -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.charges*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.charges*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Charges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.charges.create') }}" class="nav-link {{ request()->routeIs('assistant.charges.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.charges.index') }}" class="nav-link {{ request()->routeIs('assistant.charges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Paiements -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.paiements*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.paiements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Paiements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.paiements.create') }}" class="nav-link {{ request()->routeIs('assistant.paiements.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Enregistrer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.paiements.index') }}" class="nav-link {{ request()->routeIs('assistant.paiements.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Historique</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Rapports -->
                <li class="nav-item">
                    <a href="{{ route('assistant.historique') }}" class="nav-link {{ request()->routeIs('assistant.historique') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Rapports</p>
                    </a>
                </li>

                <!-- Déconnexion -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Déconnexion</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
