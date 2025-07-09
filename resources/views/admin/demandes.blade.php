@extends('layouts.admin')

@section('title', 'Demandes en attente')

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
        background: linear-gradient(135deg, #f59e0b, #d97706);
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
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }

    .accept-form {
        width: 100%;
    }

    .reject-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
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
        width: 100%;
        position: relative;
        overflow: hidden;
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

    .btn-accept {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-accept:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .reason-input {
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #ffffff;
        color: #334155;
        width: 100%;
    }

    .reason-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: #f8fafc;
    }

    .reason-input::placeholder {
        color: #94a3b8;
        font-style: italic;
    }

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
            gap: 0.5rem;
        }
        
        .btn-modern {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="page-container">
    <div class="container py-4">
        <h2 class="page-title">Liste des demandes en attente</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($demandes->isEmpty())
            <div class="empty-state">
                <p>Aucune demande en attente.</p>
            </div>
        @else
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Ville</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                        <tr>
                            <td>
                                <span class="id-badge">{{ $demande->id }}</span>
                            </td>
                            <td>{{ $demande->name }}</td>
                            <td>{{ $demande->prenom }}</td>
                            <td>{{ $demande->email }}</td>
                            <td>
                                <span class="status-badge">{{ $demande->statut }}</span>
                            </td>
                            <td>{{ $demande->ville }}</td>
                            <td>
                                <div class="action-container">
                                    <!-- Accepter (devient activer) -->
                                    <form action="{{ route('admin.demandes.activer', $demande->id) }}" method="POST" class="accept-form">
                                        @csrf
                                        <button type="submit" class="btn-modern btn-accept">Accepter</button>
                                    </form>

                                    <!-- Refuser -->
                                    <form method="POST" action="{{ route('admin.demandes.refuser', $demande->id) }}" class="reject-form">
                                        @csrf
                                        <input type="text" name="reason" placeholder="Raison du rejet" required class="reason-input" />
                                        <button type="submit" class="btn-modern btn-reject">Refuser</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection