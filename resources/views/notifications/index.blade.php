{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Notifications - Syndic App')
@section('page-title', 'Notifications')

@push('styles')
    <style>
        .notification-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
            margin-top: 10px;
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
            align-items: flex-start;
            gap: 0.5rem;
            flex-shrink: 0;
            flex-direction: column;
        }



        .apartment-details {
            margin-top: 0.75rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 0.375rem;
            border-left: 3px solid #3b82f6;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .apartment-details.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .apartment-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .apartment-field {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .apartment-field i {
            color: #3b82f6;
            width: 16px;
        }

        .apartment-field strong {
            color: #374151;
            font-weight: 600;
        }

        .apartment-field span {
            color: #6b7280;
        }

        .btn-group {
            display: flex;
            gap: 0.25rem;
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

        .btn-success {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            border-color: #059669;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
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

        .read-status {
            font-size: 0.7rem;
            color: #10b981;
            font-weight: 500;
        }

        .filters-container {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

        .container {}

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                margin-left: 250px;
            }
        }

        @media (max-width: 992px) {
            .container {
                margin-left: 0;
                padding: 0 1rem;
            }

            .notification-item {
                padding: 1.25rem;
            }

            .notification-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .apartment-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 0.75rem;
            }

            .notification-item {
                padding: 1rem;
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .notification-icon {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
                align-self: flex-start;
            }

            .notification-content {
                order: 2;
            }

            .notification-actions {
                order: 3;
                justify-content: flex-end;
                margin-top: 0.5rem;
                flex-direction: row;
            }

            .notification-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .notification-title {
                font-size: 0.95rem;
            }

            .notification-message {
                font-size: 0.8rem;
            }

            .filter-tabs {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .filter-tab {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }

            .btn-group {
                flex-wrap: wrap;
            }

            .filters-container {
                padding: 1rem;
            }

            .notification-badge {
                top: 0.5rem;
                right: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 0 0.5rem;
            }

            .notification-item {
                padding: 0.75rem;
            }

            .notification-icon {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .notification-title {
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
            }

            .notification-message {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }

            .notification-meta {
                font-size: 0.7rem;
            }

            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .filter-tab {
                padding: 0.4rem 0.6rem;
                font-size: 0.75rem;
            }

            .filters-container {
                padding: 0.75rem;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state i {
                font-size: 2rem;
            }

            .notification-item {
                flex-direction: row;
                align-items: flex-start;
            }

            .notification-content {
                order: unset;
            }

            .notification-actions {
                order: unset;
                margin-top: 0;
                flex-direction: column;
                gap: 0.25rem;
            }
        }

        @media (max-width: 400px) {
            .notification-item {
                padding: 0.5rem;
                gap: 0.5rem;
            }

            .notification-icon {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }

            .notification-title {
                font-size: 0.85rem;
            }

            .notification-message {
                font-size: 0.7rem;
            }

            .notification-actions {
                gap: 0.2rem;
            }

            .btn-sm {
                padding: 0.15rem 0.3rem;
                font-size: 0.65rem;
            }

        }
    </style>
@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="d-flex justify-content-center" style="min-height: 80vh;">
        <div class="col-12">
            <div class="notification-card">
                @forelse ($notifications as $notification)
                    @php
                        $isUnread = $notification->read_at === null;
                        $priority = $notification->data['priority'] ?? 'low';
                        $category = $notification->data['category'] ?? 'default';
                        $message = strtolower($notification->data['message'] ?? '');

                        // Map of keywords → route names
                        $modelRoutes = [
                            'appartement' => 'appartements.index',
                            'immeuble' => 'immeubles.index', // Fixed: was 'immeubles'
                            'résidence' => 'residences',
                            'residence' => 'residences', // Handle both spellings
                            'employé' => 'livewire.employes',
                            'employe' => 'livewire.employes',
                            'charge' => 'charges.index',
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
                                    $routeUrl = route('dashboard');
                                    break;
                                }
                            }
                        }
                    @endphp

                    <div class="notification-item {{ $isUnread ? 'unread' : '' }} priority-{{ $priority }}"
                        data-category="{{ $category }}" id="notification-{{ $notification->id }}">
                        <div
                            class="notification-icon bg-{{ $category === 'system' ? 'info' : ($priority === 'high' ? 'danger' : ($priority === 'medium' ? 'warning' : 'success')) }}">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title"><a href="{{ $routeUrl }}">{{ $notification->data['title'] ?? 'Notification' }}</a>
                            </div>
                            <div class="notification-message">{{ $notification->data['message'] ?? '' }}</div>
                            <div class="notification-meta">
                                <div class="notification-time">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="badge bg-secondary">{{ ucfirst($category) }}</span>
                                @if(!$isUnread)
                                    <span class="read-status">
                                        <i class="fas fa-check-circle"></i> Lu
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="notification-actions">
                            <div class="btn-group">

                                <button class="btn btn-success btn-sm" onclick="markAsRead('{{ $notification->id }}')">
                                    <i class="fas fa-check"></i> Marquer comme lu
                                </button>

                            </div>
                        </div>
                        @if ($isUnread)
                            <div class="notification-badge"></div>
                        @endif
                    </div>

                @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Aucune notification disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleApartmentDetails(notificationId) {
            const detailsDiv = document.getElementById('details-' + notificationId);
            const toggleBtn = document.getElementById('toggle-btn-' + notificationId);

            if (detailsDiv.classList.contains('show')) {
                detailsDiv.classList.remove('show');
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i> Détails';
            } else {
                detailsDiv.classList.add('show');
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Masquer';
            }
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationItem = document.getElementById('notification-' + notificationId);
                        const badge = notificationItem.querySelector('.notification-badge');
                        const markAsReadBtn = notificationItem.querySelector('.btn-success');
                        const meta = notificationItem.querySelector('.notification-meta');

                        // Remove unread styling
                        notificationItem.classList.remove('unread');

                        // Remove the unread badge
                        if (badge) {
                            badge.remove();
                        }

                        // Remove the "Mark as read" button
                        if (markAsReadBtn) {
                            markAsReadBtn.remove();
                        }

                        // Add read status
                        const readStatus = document.createElement('span');
                        readStatus.className = 'read-status';
                        readStatus.innerHTML = '<i class="fas fa-check-circle"></i> Lu';
                        meta.appendChild(readStatus);

                        // Show success message
                        showNotificationMessage('Notification marquée comme lue', 'success');
                    } else {
                        showNotificationMessage('Erreur lors de la mise à jour', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotificationMessage('Erreur lors de la mise à jour', 'error');
                });
        }

        function showNotificationMessage(message, type) {
            // Create a simple toast notification
            const toast = document.createElement('div');
            toast.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 12px 20px;
                        background: ${type === 'success' ? '#10b981' : '#ef4444'};
                        color: white;
                        border-radius: 0.375rem;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        z-index: 1000;
                        font-size: 0.875rem;
                        opacity: 0;
                        transform: translateY(-20px);
                        transition: all 0.3s ease;
                    `;
            toast.textContent = message;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>

@endsection