@extends('layouts.admin')

@section('title', 'Gestion des Syndics')

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
        content: '📊';
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

    .id-badge {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
        min-width: 50px;
        text-align: center;
    }

    .status-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
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
        min-width: 100px;
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

    .btn-info {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
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

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 3rem;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: #ffffff;
        color: #334155;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f1f5f9;
        color: #94a3b8;
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: #f1f5f9;
        color: #94a3b8;
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
            min-width: 80px;
        }

        .pagination .page-link {
            width: 40px;
            height: 40px;
            font-size: 0.85rem;
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
    }
</style>

<div class="page-container">
    <div class="container py-4">
        <h2 class="page-title">Liste des Syndics</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($syndics->isEmpty())
            <div class="empty-state">
                <p>Aucun syndic trouvé.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Ville</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($syndics as $syndic)
                            <tr>
                                <td>
                                    <span class="id-badge">{{ $syndic->id }}</span>
                                </td>
                                <td>{{ $syndic->name }}</td>
                                <td>{{ $syndic->prenom }}</td>
                                <td>{{ $syndic->email }}</td>
                                <td>{{ $syndic->ville }}</td>
                                <td>
                                    <span class="status-badge">{{ $syndic->statut }}</span>
                                </td>
                                <td>
                                    <div class="action-container">
                                        <a href="{{ route('admin.syndics.show', $syndic->id) }}" 
                                           class="btn-modern btn-info">
                                            Voir
                                        </a>
                                        <form action="{{ route('admin.syndics.delete', $syndic->id) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-modern btn-danger delete-btn"
                                                    data-syndic-name="{{ $syndic->name }} {{ $syndic->prenom }}"
                                                    data-syndic-id="{{ $syndic->id }}">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $syndics->links() }}
            </div>
        @endif
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
            const syndicsName = this.getAttribute('data-syndic-name');
            const syndicsId = this.getAttribute('data-syndic-id');
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `Vous êtes sur le point de supprimer le syndic : <br><strong>${syndicsName}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title',
                    content: 'swal-content',
                    confirmButton: 'swal-confirm',
                    cancelButton: 'swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Suppression en cours...',
                        text: 'Veuillez patienter',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
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
});
</script>

<style>
/* Custom SweetAlert2 styles */
.swal-popup {
    border-radius: 20px !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

.swal-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
}

.swal-content {
    font-size: 1rem !important;
    color: #4b5563 !important;
    line-height: 1.6 !important;
}

.swal-confirm {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    transition: all 0.3s ease !important;
}

.swal-confirm:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
}

.swal-cancel {
    background: linear-gradient(135deg, #6b7280, #4b5563) !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3) !important;
    transition: all 0.3s ease !important;
}

.swal-cancel:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(107, 114, 128, 0.4) !important;
}
</style>

@endsection