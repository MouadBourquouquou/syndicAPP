@extends('layouts.admin')

@section('title', 'Gestion des administrateurs')

@section('content')

<style>
    .page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding: 1rem 0;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .page-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
        margin: 0.5rem auto 0;
    }

    .alert {
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        font-size: 0.9rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #065f46;
        border-color: #10b981;
    }

    .add-admin-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #10b981;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        margin-bottom: 1.5rem;
    }

    .add-admin-btn:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .empty-state p {
        font-size: 1rem;
        color: #64748b;
        font-weight: 600;
    }

    .modern-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        font-size: 0.85rem;
    }

    .modern-table thead {
        background: #1e293b;
    }

    .modern-table thead th {
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 1rem 0.75rem;
        text-align: center;
    }

    .modern-table tbody tr {
        transition: background 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
    }

    .modern-table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: center;
    }

    .action-container {
        display: flex;
        justify-content: center;
    }

    .btn-modern {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 0.5rem 0;
        }
        
        .page-title {
            font-size: 1.3rem;
        }
        
        .modern-table {
            font-size: 0.8rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-modern {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="page-container">
    <div class="container py-3">
        <h1 class="page-title">Administrateurs</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.admins.create') }}" class="add-admin-btn">
            ➕ Ajouter admin
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
                                    <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-modern btn-danger delete-btn"
                                                data-admin-name="{{ $admin->name }} {{ $admin->prenom }}">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <p>Aucun administrateur</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const adminName = this.getAttribute('data-admin-name');
            const form = this.closest('form');
            
            if (confirm(`Supprimer l'admin ${adminName} ?`)) {
                form.submit();
            }
        });
    });
});
</script>

@endsection