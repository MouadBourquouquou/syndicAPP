// Notification System JavaScript
// Add this to your resources/js/notifications.js or include in your main JS file

/**
 * Mark a single notification as read
 */
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove unread class and badge
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                const badge = notificationItem.querySelector('.notification-badge');
                if (badge) {
                    badge.remove();
                }
            }
            
            // Update counters
            updateNotificationCounters();
            
            // Show success message
            showNotificationMessage(data.message || 'Notification marquée comme lue', 'success');
        } else {
            showNotificationMessage(data.message || 'Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotificationMessage('Erreur de connexion', 'error');
    });
}

/**
 * Delete a single notification
 */
function deleteNotification(notificationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove notification from DOM
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.remove();
                }
                
                // Update counters
                updateNotificationCounters();
                
                // Show success message
                showNotificationMessage(data.message || 'Notification supprimée', 'success');
                
                // Check if no notifications left
                checkEmptyNotifications();
            } else {
                showNotificationMessage(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotificationMessage('Erreur de connexion', 'error');
        });
    }
}

/**
 * Mark all notifications as read
 */
function markAllAsRead() {
    if (confirm('Êtes-vous sûr de vouloir marquer toutes les notifications comme lues ?')) {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove all unread classes and badges
                const unreadItems = document.querySelectorAll('.notification-item.unread');
                unreadItems.forEach(item => {
                    item.classList.remove('unread');
                    const badge = item.querySelector('.notification-badge');
                    if (badge) {
                        badge.remove();
                    }
                });
                
                // Update counters
                updateNotificationCounters();
                
                // Show success message
                showNotificationMessage(data.message || 'Toutes les notifications ont été marquées comme lues', 'success');
            } else {
                showNotificationMessage(data.message || 'Erreur lors de la mise à jour', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotificationMessage('Erreur de connexion', 'error');
        });
    }
}

/**
 * Delete all read notifications
 */
function deleteAllRead() {
    if (confirm('Êtes-vous sûr de vouloir supprimer toutes les notifications lues ?')) {
        fetch('/notifications/delete-read', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove all read notifications from DOM
                const readItems = document.querySelectorAll('.notification-item:not(.unread)');
                readItems.forEach(item => item.remove());
                
                // Update counters
                updateNotificationCounters();
                
                // Show success message
                showNotificationMessage(data.message || 'Toutes les notifications lues ont été supprimées', 'success');
                
                // Check if no notifications left
                checkEmptyNotifications();
            } else {
                showNotificationMessage(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotificationMessage('Erreur de connexion', 'error');
        });
    }
}

/**
 * Toggle notification dropdown
 */
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const isVisible = dropdown.classList.contains('show');
    
    // Close all other dropdowns
    document.querySelectorAll('.notification-dropdown.show').forEach(dd => {
        dd.classList.remove('show');
    });
    
    // Toggle current dropdown
    if (!isVisible) {
        dropdown.classList.add('show');
    }
}

/**
 * Update notification counters in the UI
 */
function updateNotificationCounters() {
    const totalItems = document.querySelectorAll('.notification-item').length;
    const unreadItems = document.querySelectorAll('.notification-item.unread').length;
    
    // Update counter badges
    const totalBadge = document.querySelector('[data-filter="all"] .badge');
    const unreadBadge = document.querySelector('[data-filter="unread"] .badge');
    
    if (totalBadge) totalBadge.textContent = totalItems;
    if (unreadBadge) unreadBadge.textContent = unreadItems;
}

/**
 * Check if notifications container is empty and show empty state
 */
function checkEmptyNotifications() {
    const notificationItems = document.querySelectorAll('.notification-item');
    const notificationCard = document.querySelector('.notification-card');
    
    if (notificationItems.length === 0 && notificationCard) {
        notificationCard.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Aucune notification pour le moment.</p>
            </div>
        `;
    }
}

/**
 * Show notification message (toast-like)
 */
function showNotificationMessage(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}

/**
 * Initialize notification system
 */
document.addEventListener('DOMContentLoaded', function() {
    // Add notification IDs to DOM elements for easier manipulation
    document.querySelectorAll('.notification-item').forEach((item, index) => {
        if (!item.hasAttribute('data-notification-id')) {
            // Try to extract ID from dropdown actions
            const markAsReadLink = item.querySelector('[onclick*="markAsRead"]');
            if (markAsReadLink) {
                const match = markAsReadLink.getAttribute('onclick').match(/markAsRead\('(.+?)'\)/);
                if (match) {
                    item.setAttribute('data-notification-id', match[1]);
                }
            }
        }
    });
    
    // Filter tabs functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Get filter value
            const filter = this.getAttribute('data-filter');
            
            // Redirect with filter parameter
            const url = new URL(window.location);
            if (filter === 'all') {
                url.searchParams.delete('filter');
            } else {
                url.searchParams.set('filter', filter);
            }
            window.location.href = url.toString();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.position-relative')) {
            document.querySelectorAll('.notification-dropdown.show').forEach(dd => {
                dd.classList.remove('show');
            });
        }
    });
    
    // Auto-refresh unread count every 30 seconds
    setInterval(function() {
        fetch('/notifications/unread-count', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const unreadBadge = document.querySelector('[data-filter="unread"] .badge');
            if (unreadBadge && data.count !== undefined) {
                unreadBadge.textContent = data.count;
            }
        })
        .catch(error => {
            console.log('Failed to update unread count:', error);
        });
    }, 30000);
});