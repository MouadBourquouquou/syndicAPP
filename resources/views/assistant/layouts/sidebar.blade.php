<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">SyndicApp</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Immeubles -->
                <li class="nav-item">
                    <a href="{{ route('assistant.immeubles.index') }}" class="nav-link {{ request()->routeIs('assistant.immeubles.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Immeubles</p>
                    </a>
                </li>

                <!-- Appartements -->
                <li class="nav-item">
                    <a href="{{ route('assistant.appartements.index') }}" class="nav-link {{ request()->routeIs('assistant.appartements.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Appartements</p>
                    </a>
                </li>

                <!-- Résidences (affichage seulement, pas de modification ni ajout) -->
                <li class="nav-item">
                    <a href="{{ route('assistant.residences') }}" class="nav-link {{ request()->routeIs('assistant.residences') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Résidences</p>
                    </a>
                </li>

                <!-- Charges (ajouter, modifier, supprimer, voir) -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.charges*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.charges*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-euro-sign"></i>
                        <p>
                            Charges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.charges.ajouter') }}" class="nav-link {{ request()->routeIs('assistant.charges.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.charges.index') }}" class="nav-link {{ request()->routeIs('assistant.charges.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Paiements (ajouter, supprimer, facture) -->
                <li class="nav-item has-treeview {{ request()->routeIs('assistant.paiements*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('assistant.paiements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Paiements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assistant.paiements.index') }}" class="nav-link {{ request()->routeIs('assistant.paiements.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assistant.paiements.historique') }}" class="nav-link {{ request()->routeIs('assistant.paiements.historique') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Historique</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Déconnexion -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Déconnexion</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
