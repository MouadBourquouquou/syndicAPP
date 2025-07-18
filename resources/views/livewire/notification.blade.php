{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Notifications - Syndic App')
@section('page-title', 'Notifications')

@push('styles')
<style>
    .notification-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    
    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .notification-item {
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        border-bottom: 1px solid #f3f4f6;
        position: relative;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .notification-item:last-child {
        border-bottom: none;
    }
    
    .notification-item:hover {
        background-color: #f9fafb;
    }
    
    .notification-item.unread {
        background-color: #eff6ff;
        border-left: 4px solid #3b82f6;
    }
    
    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }
    
    .notification-content {
        flex: 1;
        min-width: 0;
    }
    
    .notification-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .notification-message {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }
    
    .notification-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    .notification-time {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .notification-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    
    .notification-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 12px;
        height: 12px;
        background: #3b82f6;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .filters-container {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .filter-tab {
        padding: 0.75rem 1rem;
        background: none;
        border: none;
        color: #6b7280;
        font-weight: 500;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
    }
    
    .filter-tab.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
    }
    
    .filter-tab:hover {
        color: #1f2937;
    }
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background: white;
        color: #374151;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    .btn-primary {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        border-color: #2563eb;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    .priority-high {
        border-left-color: #ef4444 !important;
    }
    
    .priority-medium {
        border-left-color: #f59e0b !important;
    }
    
    .priority-low {
        border-left-color: #10b981 !important;
    }
    
    .notification-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1000;
        min-width: 150px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
    }
    
    .notification-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        color: #374151;
        text-decoration: none;
        display: block;
        font-size: 0.875rem;
        transition: background-color 0.2s ease;
    }
    
    .dropdown-item:hover {
        background: #f9fafb;
        color: #1f2937;
    }
    
    @media (max-width: 768px) {
        .notification-item {
            padding: 1rem;
        }
        
        .notification-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .filter-tabs {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .btn-group {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="filters-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filtres</h5>
                <div class="btn-group">
                    <button class="btn btn-sm" onclick="markAllAsRead()">
                        <i class="fas fa-check me-1"></i>
                        Tout marquer comme lu
                    </button>
                    <button class="btn btn-sm" onclick="deleteAllRead()">
                        <i class="fas fa-trash me-1"></i>
                        Supprimer les lues
                    </button>
                </div>
            </div>
            
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">
                    Toutes <span class="badge bg-secondary ms-1">{{ $totalNotifications ?? '15' }}</span>
                </button>
                <button class="filter-tab" data-filter="unread">
                    Non lues <span class="badge bg-primary ms-1">{{ $unreadNotifications ?? '3' }}</span>
                </button>
                <button class="filter-tab" data-filter="important">
                    Importantes <span class="badge bg-danger ms-1">{{ $importantNotifications ?? '2' }}</span>
                </button>
                <button class="filter-tab" data-filter="system">
                    Système <span class="badge bg-info ms-1">{{ $systemNotifications ?? '5' }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="notification-card">
            <!-- Notification importante non lue -->
            <div class="notification-item unread priority-high" data-category="important">
                <div class="notification-icon bg-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Paiement en retard - Appartement 3B</div>
                    <div class="notification-message">
                        Le locataire de l'appartement 3B dans la résidence Les Jardins n'a pas effectué son paiement de charges pour le mois de janvier 2025. Montant dû : 250€.
                    </div>
                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="fas fa-clock"></i>
                            <span>Il y a 2 heures</span>
                        </div>
                        <span class="badge bg-danger">Urgent</span>
                    </div>
                </div>
                <div class="notification-actions">
                    <button class="btn btn-sm btn-primary" onclick="viewDetails(1)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="position-relative">
                        <button class="btn btn-sm" onclick="toggleDropdown(this)">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="notification-dropdown">
                            <a href="#" class="dropdown-item" onclick="markAsRead(1)">
                                <i class="fas fa-check me-2"></i>Marquer comme lu
                            </a>
                            <a href="#" class="dropdown-item" onclick="deleteNotification(1)">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="notification-badge"></div>
            </div>
            
            <!-- Notification système non lue -->
            <div class="notification-item unread" data-category="system">
                <div class="notification-icon bg-info">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Maintenance système programmée</div>
                    <div class="notification-message">
                        Une maintenance système est prévue ce dimanche de 2h à 4h du matin. L'application sera temporairement indisponible.
                    </div>
                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="fas fa-clock"></i>
                            <span>Il y a 4 heures</span>
                        </div>
                        <span class="badge bg-info">Système</span>
                    </div>
                </div>
                <div class="notification-actions">
                    <button class="btn btn-sm btn-primary" onclick="viewDetails(2)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="position-relative">
                        <button class="btn btn-sm" onclick="toggleDropdown(this)">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="notification-dropdown">
                            <a href="#" class="dropdown-item" onclick="markAsRead(2)">
                                <i class="fas fa-check me-2"></i>Marquer comme lu
                            </a>
                            <a href="#" class="dropdown-item" onclick="deleteNotification(2)">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="notification-badge"></div>
            </div>
            
            <!-- Notification normale lue -->
            <div class="notification-item" data-category="normal">
                <div class="notification-icon bg-success">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Nouvel employé ajouté</div>
                    <div class="notification-message">
                        Marie Dubois a été ajoutée comme employée de maintenance pour la résidence Les Pins.
                    </div>
                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="fas fa-clock"></i>
                            <span>Hier à 14:30</span>
                        </div>
                        <span class="badge bg-success">Employé</span>
                    </div>
                </div>
                <div class="notification-actions">
                    <button class="btn btn-sm btn-primary" onclick="viewDetails(3)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="position-relative">
                        <button class="btn btn-sm" onclick="toggleDropdown(this)">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="notification-dropdown">
                            <a href="#" class="dropdown-item" onclick="deleteNotification(3)">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notification charge -->
            <div class="notification-item" data-category="charges">
                <div class="notification-icon bg-warning">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Nouvelles charges ajoutées</div>
                    <div class="notification-message">
                        Les charges d'électricité pour le mois de janvier ont été ajoutées pour tous les appartements de la résidence Les Jardins.
                    </div>
                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="fas fa-clock"></i>
                            <span>Il y a 2 jours</span>
                        </div>
                        <span class="badge bg-warning">Charges</span>
                    </div>
                </div>
                <div class="notification-actions">
                    <button class="btn btn-sm btn-primary" onclick="viewDetails(4)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="position-relative">
                        <button class="btn btn-sm" onclick="toggleDropdown(this)">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="notification-dropdown">
                            <a href="#" class="dropdown-item" onclick="deleteNotification(4)">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notification appartement -->
            <div class="notification-item" data-category="apartments">
                <div class="notification-icon bg