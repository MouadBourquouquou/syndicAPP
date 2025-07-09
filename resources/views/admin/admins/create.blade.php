@extends('layouts.admin')

@section('title', 'Ajouter un administrateur')

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
        margin-bottom: 3rem;
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

    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 8px 16px rgba(0,0,0,0.05);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899);
    }

    .form-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .form-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .form-header .subtitle {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .form-content {
        padding: 2.5rem;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .form-label::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 1px;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
        position: relative;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: #fafbff;
        transform: translateY(-2px);
    }

    .form-input:hover {
        border-color: #cbd5e1;
    }

    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: #64748b;
        transition: color 0.3s ease;
        z-index: 10;
    }

    .password-toggle:hover {
        color: #3b82f6;
    }

    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .strength-bar {
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.25rem;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak .strength-fill {
        width: 25%;
        background: #ef4444;
    }

    .strength-medium .strength-fill {
        width: 50%;
        background: #f59e0b;
    }

    .strength-strong .strength-fill {
        width: 75%;
        background: #10b981;
    }

    .strength-very-strong .strength-fill {
        width: 100%;
        background: #059669;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .button-container {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 3rem;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 1rem 2.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1rem;
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
        gap: 0.5rem;
        min-width: 160px;
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

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(100, 116, 139, 0.4);
        background: linear-gradient(135deg, #475569, #334155);
        text-decoration: none;
        color: white;
    }

    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .form-modern.loading .loading-spinner {
        display: block;
    }

    .form-modern.loading .btn-text {
        display: none;
    }

    /* Alert Styles */
    .alert {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: none;
        backdrop-filter: blur(10px);
        font-weight: 600;   
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #991b1b;
        border-left: 5px solid #ef4444;
    }

    .alert-success {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #065f46;
        border-left: 5px solid #10b981;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .form-container {
            margin: 0 1rem;
        }
        
        .form-content {
            padding: 1.5rem;
        }
        
        .button-container {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-modern {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .page-container {
            padding: 1rem 0;
        }
        
        .form-header {
            padding: 1.5rem;
        }
        
        .form-content {
            padding: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
    }
</style>

<div class="page-container">
    <div class="container py-4">
        <h1 class="page-title">Ajouter un Administrateur</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong> Erreurs détectées :</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <div class="form-header">
                <h2>👤 Nouvel Administrateur</h2>
                <p class="subtitle">Créez un nouveau compte administrateur avec des privilèges complets</p>
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
                        <label for="email" class="form-label">Adresse Email</label>
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
                        <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                        <div class="password-container">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="form-input @error('password_confirmation') error @enderror" 
                                   required 
                                   placeholder="Confirmez le mot de passe">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                
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
                            <span class="btn-text"> Créer l'Administrateur</span>
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn-modern btn-secondary">
                            ← Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
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

    // Form submission with loading state
   form.addEventListener('submit', function(e) {
    e.preventDefault();

    console.log('Tentative de soumission du formulaire');

    if (passwordInput.value !== passwordConfirmInput.value) {
        console.log('Mots de passe non identiques');
        Swal.fire({
            title: 'Erreur !',
            text: 'Les mots de passe ne correspondent pas.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    form.classList.add('loading');
    console.log('Mot de passe OK, envoi en cours');

    setTimeout(() => {
        console.log('Soumission du formulaire maintenant');
        form.submit(); // ← ici le vrai envoi
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
        
        // Reset classes
        strengthIndicator.className = 'password-strength';
        
        if (score === 0) {
            strengthText.textContent = 'Saisissez un mot de passe';
            return;
        }
        
        if (score <= 2) {
            strengthIndicator.classList.add('strength-weak');
            strengthText.textContent = 'Faible';
        } else if (score <= 4) {
            strengthIndicator.classList.add('strength-medium');
            strengthText.textContent = 'Moyen';
        } else if (score <= 5) {
            strengthIndicator.classList.add('strength-strong');
            strengthText.textContent = 'Fort';
        } else {
            strengthIndicator.classList.add('strength-very-strong');
            strengthText.textContent = 'Très fort';
        }
    }
});

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
     
    } else {
        input.type = 'password';
       
    }
}
</script>

@endsection