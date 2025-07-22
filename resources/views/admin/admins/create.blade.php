@extends('layouts.admin')

@section('title', 'Ajouter un administrateur')

@section('content')

<style>
    .page-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 1rem 0;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        text-align: center;
        padding: 0 1rem;
    }

    .form-container {
        max-width: 500px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        display: block;
        height: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    }

    .form-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        padding: 1rem;
        padding-bottom: 0.1rem;
        text-align: center;
    }

    .form-header h2 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }

    .form-header .subtitle {
        font-size: 0.8rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }

    .form-content {
        padding: 1rem 1.5rem 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }

    .form-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #1e293b;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input.error {
        border-color: #ef4444;
    }

    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 0.9rem;
    }

    .password-strength {
        margin-top: 0.4rem;
        font-size: 0.7rem;
    }

    .strength-bar {
        height: 3px;
        background: #e2e8f0;
        border-radius: 2px;
        margin-top: 0.2rem;
    }

    .strength-fill {
        height: 100%;
        transition: width 0.3s ease;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.2rem;
    }

    .button-container {
        display: flex;
        gap: 0.6rem;
        justify-content: center;
        margin-top: 0.5rem;
    }

    .btn-modern {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
    }

    .loading-spinner {
        display: none;
        width: 14px;
        height: 14px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.4rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .form-modern.loading .loading-spinner {
        display: inline-block;
    }

    /* Alert Styles */
    .alert {
        border-radius: 8px;
        padding: 0.8rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border-left: 3px solid #ef4444;
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .page-container {
            padding: 0.8rem 0;
        }
        
        .page-title {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
        }
        
        .form-container {
            margin: 0 0.8rem;
            border-radius: 10px;
        }
        
        .form-content {
            padding: 0.8rem 1rem 1.2rem;
        }
        
        .btn-modern {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            min-width: 100px;
        }
    }

    @media (max-width: 400px) {
        .button-container {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-modern {
            width: 100%;
        }
    }
</style>

<div class="page-container">
    <div class="container">
        <h1 class="page-title">Ajouter un Administrateur</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erreurs :</strong>
                <ul style="margin: 0.3rem 0 0 0; padding-left: 1rem; font-size: 0.8rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <div class="form-header">
                <h2>👤 Nouvel Administrateur</h2>
                <p class="subtitle">Créez un nouveau compte administrateur</p>
            </div>

            <div class="form-content">
                <form action="{{ route('admin.admins.store') }}" method="POST" class="form-modern" id="adminForm">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               class="form-input @error('name') error @enderror" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Entrez le nom">
                        @error('name')
                            <div class="error-message">
                              {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" 
                               name="prenom" 
                               id="prenom"
                               class="form-input @error('prenom') error @enderror" 
                               value="{{ old('prenom') }}" 
                               required 
                               placeholder="Entrez le prénom">
                        @error('prenom')
                            <div class="error-message">
                               {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               class="form-input @error('email') error @enderror" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="admin@example.com">
                        @error('email')
                            <div class="error-message">
                               {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <div class="password-container">
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="form-input @error('password') error @enderror" 
                                   required 
                                   placeholder="Mot de passe sécurisé"
                                   minlength="8">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                👁️
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar">
                                <div class="strength-fill"></div>
                            </div>
                            <span class="strength-text">Saisissez un mot de passe</span>
                        </div>
                        @error('password')
                            <div class="error-message">
                             {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmation</label>
                        <div class="password-container">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="form-input @error('password_confirmation') error @enderror" 
                                   required 
                                   placeholder="Confirmez le mot de passe">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                👁️
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="button-container">
                        <button type="submit" class="btn-modern btn-success">
                            <div class="loading-spinner"></div>
                            <span>Créer</span>
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn-modern btn-secondary">
                            ← Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('adminForm');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const strengthIndicator = document.getElementById('passwordStrength');

    // Password strength checker
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updatePasswordStrength(strength);
    });

    // Password confirmation checker
    passwordConfirmInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirmation = this.value;
        
        if (confirmation && password !== confirmation) {
            this.classList.add('error');
        } else {
            this.classList.remove('error');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (passwordInput.value !== passwordConfirmInput.value) {
            Swal.fire({
                title: 'Erreur',
                text: 'Les mots de passe ne correspondent pas.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        form.classList.add('loading');
        setTimeout(() => {
            form.submit();
        }, 500);
    });

    function calculatePasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        return score;
    }

    function updatePasswordStrength(score) {
        const strengthBar = strengthIndicator.querySelector('.strength-fill');
        const strengthText = strengthIndicator.querySelector('.strength-text');
        
        strengthIndicator.className = 'password-strength';
        
        if (score === 0) {
            strengthText.textContent = 'Saisissez un mot de passe';
            return;
        }
        
        if (score <= 2) {
            strengthIndicator.classList.add('strength-weak');
            strengthText.textContent = 'Faible';
            strengthBar.style.width = '25%';
            strengthBar.style.backgroundColor = '#ef4444';
        } else if (score <= 4) {
            strengthIndicator.classList.add('strength-medium');
            strengthText.textContent = 'Moyen';
            strengthBar.style.width = '50%';
            strengthBar.style.backgroundColor = '#f59e0b';
        } else if (score <= 5) {
            strengthIndicator.classList.add('strength-strong');
            strengthText.textContent = 'Fort';
            strengthBar.style.width = '75%';
            strengthBar.style.backgroundColor = '#10b981';
        } else {
            strengthIndicator.classList.add('strength-very-strong');
            strengthText.textContent = 'Très fort';
            strengthBar.style.width = '100%';
            strengthBar.style.backgroundColor = '#059669';
        }
    }
});

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>

@endsection