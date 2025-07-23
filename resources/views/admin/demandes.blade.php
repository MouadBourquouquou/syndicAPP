@extends('layouts.admin')

@section('title', 'Demandes en attente')

@section('content')

<style>
    .page-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .page-title {
        font-size: 1.5rem;
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
        border: none;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        font-size: 0.9rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1.5rem;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        margin: 1.5rem 0;
    }

    .empty-state p {
        font-size: 1.2rem;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    .modern-table {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        border: none;
        font-size: 0.85rem;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .modern-table thead th {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none;
        text-align: center;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
    }

    .modern-table tbody td {
        padding: 1rem 0.75rem;
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
        padding: 0.3rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-block;
    }

    .status-badge {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 0.3rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-block;
        min-width: 80px;
    }

    .action-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
    }

    .reject-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .accept-form, .reject-form {
        width: 100%;
    }

    .btn-modern {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        width: 100%;
    }

    .btn-accept {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-accept:hover {
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-reject:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .reason-input {
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        background: #ffffff;
        color: #334155;
        width: 100%;
    }

    .reason-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #475569, #334155);
    }

    .accept-form.hide, .initial-reject-btn.hide {
        display: none;
    }

    .reject-section {
        display: none;
        flex-direction: column;
        gap: 0.5rem;
    }

    .reject-section.show {
        display: flex;
        animation: slideIn 0.2s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 1rem 0;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .modern-table {
            font-size: 0.8rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .action-container {
            gap: 0.5rem;
        }
        
        .btn-modern {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
        
        .status-badge {
            min-width: 70px;
        }
    }

    @media (max-width: 576px) {
        .modern-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        
        .btn-modern {
            min-width: 80px;
        }
    }
</style>

<div class="page-container">
    <div class="container py-3">
        <h2 class="page-title">Demandes en attente</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($demandes->isEmpty())
            <div class="empty-state">
                <p>Aucune demande en attente</p>
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
                                        <form action="{{ route('admin.demandes.activer', $demande->id) }}" method="POST" class="accept-form" id="accept-form-{{ $demande->id }}">
                                            @csrf
                                            <button type="submit" class="btn-modern btn-accept">Accepter</button>
                                        </form>

                                        <!-- Refuser Form -->
                                        <div class="reject-form">
                                            <button type="button" class="btn-modern btn-reject initial-reject-btn" id="initial-reject-{{ $demande->id }}" onclick="showRejectSection({{ $demande->id }})">Refuser</button>
                                            
                                            <div class="reject-section" id="reject-section-{{ $demande->id }}">
                                                <input type="text" name="reason" placeholder="Raison du rejet" required class="reason-input" />
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn-modern btn-reject" onclick="submitRejectForm({{ $demande->id }})">Confirmer</button>
                                                    <button type="button" class="btn-modern btn-cancel" onclick="hideRejectSection({{ $demande->id }})">Annuler</button>
                                                </div>
                                            </div>
                                            
                                            <form method="POST" action="{{ route('admin.demandes.refuser', $demande->id) }}" id="reject-form-{{ $demande->id }}" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="reason" id="hidden-reason-{{ $demande->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
function showRejectSection(demandeId) {
    // Hide the accept button and initial reject button
    document.getElementById(`accept-form-${demandeId}`).classList.add('hide');
    document.getElementById(`initial-reject-${demandeId}`).classList.add('hide');
    
    // Show the reject section for this specific demande
    const rejectSection = document.getElementById(`reject-section-${demandeId}`);
    rejectSection.classList.add('show');
    
    // Focus on the reason input
    setTimeout(() => {
        rejectSection.querySelector('.reason-input').focus();
    }, 100);
}

function hideRejectSection(demandeId) {
    // Hide the reject section
    const rejectSection = document.getElementById(`reject-section-${demandeId}`);
    rejectSection.classList.remove('show');
    
    // Show the accept button and initial reject button again
    document.getElementById(`accept-form-${demandeId}`).classList.remove('hide');
    document.getElementById(`initial-reject-${demandeId}`).classList.remove('hide');
    
    // Clear the input
    rejectSection.querySelector('.reason-input').value = '';
}

function submitRejectForm(demandeId) {
    const rejectSection = document.getElementById(`reject-section-${demandeId}`);
    const reasonInput = rejectSection.querySelector('.reason-input');
    const hiddenReasonInput = document.getElementById(`hidden-reason-${demandeId}`);
    const form = document.getElementById(`reject-form-${demandeId}`);
    
    if (reasonInput.value.trim() === '') {
        alert('Veuillez saisir une raison pour le rejet');
        reasonInput.focus();
        return;
    }
    
    // Set the hidden input value and submit the form
    hiddenReasonInput.value = reasonInput.value;
    form.submit();
}
</script>

@endsection