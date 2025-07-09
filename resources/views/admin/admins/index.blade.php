@extends('layouts.admin')

@section('title', 'Gestion des administrateurs')

@section('content')

<style>
    .page-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 2rem;
        text-align: center;
        background: linear-gradient(135deg, #0f172a 0%, #334155 50%, #64748b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        position: relative;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    .alert {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: none;
        backdrop-filter: blur(10px);
        font-weight: 600;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #065f46;
        border-left: 5px solid #10b981;
    }

    .add-admin-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        text-decoration: none;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .add-admin-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .add-admin-btn:hover::before {
        left: 100%;
    }

    .add-admin-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin: 2rem 0;
        position: relative;
    }

    .empty-state::before {
        content: '👥';
        font-size: 4rem;
        display: block;
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: 1.5rem;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    .modern-table {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
        border: none;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .modern-table thead th {
        color: #ffffff;
        font-weight: 700;
        font-size: 0.90rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.5rem 1rem;
        border: none;
        text-align: center;
        position: relative;
    }

    .modern-table thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .modern-table tbody td {
        padding: 1.5rem 1rem;
        border: none;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 500;
        color: #334155;
        text-align: center;
        vertical-align: middle;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .action-container {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        gap: 0.5rem;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .empty-row {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 5px solid #f59e0b;
    }

    .empty-row td {
        font-weight: 600;
        color: #92400e;
        font-size: 1.1rem;
        padding: 2rem;
    }

    /* Custom SweetAlert2 styles */
    .swal2-popup {
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }

    .swal2-title {
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    .swal2-html-container {
        font-weight: 500 !important;
        color: #64748b !important;
    }

    .swal2-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        padding: 12px 24px !important;
        font-size: 14px !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    }

    .swal2-cancel {
        background: linear-gradient(135deg, #64748b, #475569) !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        padding: 12px 24px !important;
        font-size: 14px !important;
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3) !important;
    }

    .swal2-icon.swal2-warning {
        color: #f59e0b !important;
        border-color: #f59e0b !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .modern-table {
            font-size: 0.9rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 1rem 0.5rem;
        }
        
        .action-container {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-modern {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            min-width: 100px;
        }

        .add-admin-btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .page-container {
            padding: 1rem 0;
        }

        .container {
            padding: 0 1rem;
        }

        .btn-modern {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        .add-admin-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="page-container">
    <div class="container py-4">
        <h1 class="page-title">Liste des Administrateurs</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.admins.create') }}" class="add-admin-btn">
            ➕ Ajouter un administrateur
        </a>

        <div class="table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->prenom }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <div class="action-container">
                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-modern btn-danger delete-btn"
                                                data-admin-name="{{ $admin->name }} {{ $admin->prenom }}"
                                                data-admin-email="{{ $admin->email }}">
                                            🗑 Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="4" class="text-center">
                                Aucun administrateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button clicks
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const adminName = this.getAttribute('data-admin-name');
            const adminEmail = this.getAttribute('data-admin-email');
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `
                    <div style="text-align: left; margin-top: 20px;">
                        <p><strong>Administrateur :</strong> ${adminName}</p>
                        <p><strong>Email :</strong> ${adminEmail}</p>
                        <p style="color: #dc2626; font-weight: 600; margin-top: 15px;">
                            Cette action est irréversible !
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'swal2-confirm-custom',
                    cancelButton: 'swal2-cancel-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Suppression en cours...',
                        html: 'Veuillez patienter',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form
                    form.submit();
                }
            });
        });
    });

    // Success message with SweetAlert2 if session has success
    @if(session('success'))
        Swal.fire({
            title: 'Succès !',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    @endif
});
</script>

@endsection