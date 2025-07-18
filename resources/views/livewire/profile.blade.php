{{-- resources/views/profile/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mon Profil - Syndic App')
@section('page-title', 'Mon Profil')

@push('styles')
    <style>
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            padding: 2rem;
            width: 100%;
        }

        .profile-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0 auto 1rem;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .profile-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .btn-primary {
            background: #667eea;
            border: 1px solid #667eea;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #5a67d8;
            border-color: #5a67d8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6b7280;
            border: 1px solid #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #4b5563;
            border-color: #4b5563;
            color: white;
        }

        .password-section {
            border-top: 1px solid #e5e7eb;
            padding-top: 2rem;
            margin-top: 2rem;
        }

        .logo-section {
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding-top: 1rem;
            padding-bottom: 2rem;

        }


        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .group-header {
            display: flex;
            flex-direction: row;
            justify-content:flex-start;
            margin-bottom: 1.5rem;
            align-items: center;
            
        }
        .group-header h5 {
            margin-left: 5rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
        }
       

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .d-flex {
            display: flex;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .image {
            height: 55px;

        }

        input[type="file"]::-webkit-file-upload-button {
            color: #667eea;
            padding: 7px 5px;
            border: none;
            cursor: pointer;
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .profile-container {
                padding: 1rem;
            }

            .profile-body {
                padding: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .profile-container {
                justify-content: center;
                align-items: center;
                margin-left: 160px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-body">
                <div class="group-header">@if(auth()->user()->logo && file_exists(public_path(auth()->user()->logo)))
                    <img src="{{ asset(auth()->user()->logo) }}" alt="Avatar"
                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                @else
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: #ccc; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 10px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="mb-4">Informations personnelles</h5>
                </div>


                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Nom complet -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Téléphone -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="phone" class="form-control"
                                    value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="+33 1 23 45 67 89">
                            </div>
                        </div>

                        <!-- Nom Société -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nom Société</label>
                                <input type="text" name="nom_societe" class="form-control"
                                    value="{{ old('nom_societe', auth()->user()->nom_societé ?? '') }}"
                                    placeholder="Nom Société">
                            </div>
                        </div>

                        <!-- Poste -->

                    </div>

                    <!-- Adresse -->
                    <div class="form-group">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="3"
                            placeholder="Votre adresse complète">{{ old('address', auth()->user()->adresse ?? '') }}</textarea>
                    </div>

                    <!-- Section mot de passe -->
                    <div class="password-section">
                        <h5 class="mb-4">Changer le mot de passe</h5>

                        <div class="form-group">
                            <label class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Confirmer le mot de passe</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section logo -->
                    <div class="logo-section">
                        <h5 class="mb-2">LOGO</h5>
                        <div class="form-group">
                            <input type="file" name="file" class="form-control image" accept="image/*">
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Sauvegarder
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            Annuler
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form validation
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Veuillez remplir tous les champs obligatoires.');
                    }
                });
            });
        });
    </script>
@endpush