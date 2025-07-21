@extends('layouts.admin')

@section('title', 'Gestion des Syndics')

@section('content')

<style>
    .page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding: 1rem 0;
    }

    .page-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        text-align: center;
    }

    .alert {
        border-radius: 8px;
        padding: 0.8rem;
        margin-bottom: 1rem;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        margin: 1rem 0;
    }

    .empty-state p {
        font-size: 1rem;
        color: #64748b;
        font-weight: 600;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modern-table {
        background: white;
        border-radius: 12px;
        width: 100%;
        min-width: 650px; /* Minimum width for small screens */
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        font-size: 0.8rem;
    }

    .modern-table thead {
        background: #1e293b;
    }

    .modern-table thead th {
        color: white;
        font-weight: 600;
        font-size: 0.7rem;
        padding: 0.6rem 0.5rem;
        text-align: center;
    }

    .modern-table tbody td {
        padding: 0.6rem 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: center;
    }

    .status-badge {
        background: #10b981;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
        min-width: 70px;
    }

    .action-container {
        display: flex;
        gap: 0.4rem;
        justify-content: center;
    }

    .btn-modern {
        padding: 0.4rem 0.7rem;
        font-size: 0.7rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-info {
        background: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background: #1d4ed8;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }
        
        .modern-table {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 700px) {
        .page-container {
            padding: 0.5rem 0;
        }
        
        .modern-table {
            font-size: 0.7rem;
            min-width: unset;
        }
        
        .btn-modern {
            padding: 0.3rem 0.5rem;
            font-size: 0.65rem;
        }
        
        /* Hide email and ville columns on small screens */
        .modern-table th:nth-child(3),
        .modern-table th:nth-child(4),
        .modern-table td:nth-child(3),
        .modern-table td:nth-child(4) {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .modern-table {
            font-size: 0.65rem;
        }
    }
</style>

<div class="page-container">
    <div>
        <h2 class="page-title">Liste des Syndics</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($syndics->isEmpty())
            <div class="empty-state">
                <p>Aucun syndic trouvé</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th class="hide-on-mobile">Email</th>
                            <th class="hide-on-mobile">Ville</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($syndics as $syndic)
                            <tr>
                                <td>{{ $syndic->name }}</td>
                                <td>{{ $syndic->prenom }}</td>
                                <td class="hide-on-mobile">{{ $syndic->email }}</td>
                                <td class="hide-on-mobile">{{ $syndic->ville }}</td>
                                <td>
                                    <span class="status-badge">{{ $syndic->statut }}</span>
                                </td>
                                <td>
                                    <div class="action-container">
                                        <a href="{{ route('admin.syndics.show', $syndic->id) }}" class="btn-modern btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.syndics.delete', $syndic->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-danger delete-btn"
                                                    data-syndic-name="{{ $syndic->name }} {{ $syndic->prenom }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $syndics->links() }}
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const syndicName = this.getAttribute('data-syndic-name');
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Confirmer la suppression',
                html: `Supprimer <strong>${syndicName}</strong> ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Supprimer',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'swal-popup',
                    confirmButton: 'swal-confirm',
                    cancelButton: 'swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
.swal-popup {
    border-radius: 12px !important;
    padding: 1rem !important;
}
.swal-confirm {
    background: #ef4444 !important;
    padding: 0.5rem 1rem !important;
}
.swal-cancel {
    background: #64748b !important;
    padding: 0.5rem 1rem !important;
}
</style>

@endsection