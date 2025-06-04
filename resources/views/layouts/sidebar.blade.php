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

                <!-- Appartements -->
                <li class="nav-item has-treeview {{ request()->routeIs('appartements*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('appartements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Appartements
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('appartements.ajouter') }}" class="nav-link {{ request()->routeIs('appartements.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('appartements') }}" class="nav-link {{ request()->routeIs('appartements') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Immeubles -->
                <li class="nav-item has-treeview {{ request()->routeIs('immeubles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('immeubles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Immeubles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('immeubles.ajouter') }}" class="nav-link {{ request()->routeIs('immeubles.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('immeubles') }}" class="nav-link {{ request()->routeIs('immeubles') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Résidences -->
                <li class="nav-item has-treeview {{ request()->routeIs('residences*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('residences*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>
                            Résidences
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('residences.ajouter') }}" class="nav-link {{ request()->routeIs('residences.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('residences') }}" class="nav-link {{ request()->routeIs('residences') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Employés -->
                <li class="nav-item has-treeview {{ request()->routeIs('employes*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('employes*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Employés
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('employes.ajouter') }}" class="nav-link {{ request()->routeIs('employes.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employes') }}" class="nav-link {{ request()->routeIs('employes') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Charges -->
                <li class="nav-item has-treeview {{ request()->routeIs('charges*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('charges*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-euro-sign"></i>
                        <p>
                            Charges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('charges.ajouter') }}" class="nav-link {{ request()->routeIs('charges.ajouter') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('charges') }}" class="nav-link {{ request()->routeIs('charges') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Afficher</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Historique -->
<li class="nav-item has-treeview {{ request()->routeIs('historique*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('historique*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>
            Historique
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('historique') }}" class="nav-link {{ request()->routeIs('historique') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Afficher</p>
            </a>
        </li>
    </ul>
</li>

</aside>                        