@extends('layouts.template')

@section('title', 'Profil - Gestion de Stock')

@section('content')
<style>
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
        }
        .profile-header {
            background: linear-gradient(135deg,rgb(39, 190, 228), #3399ff);
            color: #fff;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .profile-header:hover {
            transform: translateY(-5px);
        }
        .avatar-wrapper {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-form {
            border-radius: 12px;
            background: #fff;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background-color:rgb(52, 158, 219);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-primary:hover {
            background-color: #3399ff;
            transform: scale(1.05);
        }
        .btn-primary:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
        .alert {
            border-radius: 8px;
            animation: fadeIn 0.5s ease-in-out;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s;
        }
        .toggle-password:hover {
            color: #007bff;
        }
        .spinner {
            margin-right: 8px;
        }
        .password-strength .progress-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        .password-strength .bg-weak {
            background-color: #dc3545;
        }
        .password-strength .bg-medium {
            background-color: #ffc107;
        }
        .password-strength .bg-strong {
            background-color: #28a745;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 576px) {
            .profile-container {
                padding: 15px;
            }
            .avatar-wrapper {
                width: 100px;
                height: 100px;
            }
            .d-flex.gap-3 {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    <div class="profile-container">
        <!-- En-tête avec avatar et nom -->
        <div class="profile-header card shadow-sm">
            <div class="card-body text-center">
                <div class="avatar-wrapper">
                    <img src="{{ Auth::user()->photo ?? asset('assets/img/default-avatar.png') }}" alt="Avatar de {{ Auth::user()->name }}" class="avatar-img">
                </div>
                <h3 class="mt-3 mb-1">{{ Auth::user()->name }}</h3>
                <p class="text" style="color: white;">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="profile-form card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="mb-4">Modifier mon profil</h5>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Votre nom complet.</small>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Votre adresse e-mail.</small>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe (facultatif)</label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp">
                            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                        <small id="passwordHelp" class="form-text text-muted">Laissez vide pour ne pas modifier.</small>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <!-- Barre de progression -->
                        <div class="password-strength mt-2" style="display: none;">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="strength-text text-muted mt-1"></small>
                        </div>
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <span class="spinner" style="display: none;"><i class="fas fa-spinner fa-pulse"></i></span>
                            Mettre à jour
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

    

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Profile form script loaded'); // Débogage

            // Basculer l'affichage du mot de passe
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                    console.log('Toggle password:', type); // Débogage
                });
            } else {
                console.error('Toggle password elements not found');
            }

            // Évaluer la force du mot de passe
            const passwordStrength = document.querySelector('.password-strength');
            const progressBar = passwordStrength?.querySelector('.progress-bar');
            const strengthText = passwordStrength?.querySelector('.strength-text');

            if (passwordInput && passwordStrength && progressBar && strengthText) {
                passwordInput.addEventListener('input', function () {
                    const password = this.value;
                    let strength = 0;

                    if (password.length >= 8) strength += 20;
                    if (/[A-Z]/.test(password)) strength += 20;
                    if (/[a-z]/.test(password)) strength += 20;
                    if (/[0-9]/.test(password)) strength += 20;
                    if (/[^A-Za-z0-9]/.test(password)) strength += 20;

                    progressBar.style.width = ${strength}%;
                    progressBar.setAttribute('aria-valuenow', strength);

                    if (strength < 50) {
                        progressBar.classList.remove('bg-medium', 'bg-strong');
                        progressBar.classList.add('bg-weak');
                        strengthText.textContent = 'Faible';
                        strengthText.style.color = '#dc3545';
                    } else if (strength < 80) {
                        progressBar.classList.remove('bg-weak', 'bg-strong');
                        progressBar.classList.add('bg-medium');
                        strengthText.textContent = 'Moyen';
                        strengthText.style.color = '#ffc107';
                    } else {
                        progressBar.classList.remove('bg-weak', 'bg-medium');
                        progressBar.classList.add('bg-strong');
                        strengthText.textContent = 'Fort';
                        strengthText.style.color = '#28a745';
                    }

                    passwordStrength.style.display = password ? 'block' : 'none';
                    console.log('Password strength:', strength); // Débogage
                });
            } else {
                console.error('Password strength elements not found');
            }

            // Activer/désactiver le bouton de soumission
            const form = document.querySelector('#profileForm');
            const submitBtn = document.querySelector('.btn-submit');
            const inputs = form?.querySelectorAll('input');

            if (form && submitBtn && inputs) {
                // Vérifier la validité initiale
                submitBtn.disabled = !form.checkValidity();
                console.log('Initial form validity:', form.checkValidity()); // Débogage

                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        const isValid = form.checkValidity();
                        submitBtn.disabled = !isValid;
                        console.log('Form validity:', isValid, 'Input:', input.id); // Débogage
                    });
                });

                // Débogage de la soumission
                form.addEventListener('submit', (event) => {
                    console.log('Form submitted');
                    submitBtn.disabled = true;
                    submitBtn.querySelector('.spinner').style.display = 'inline-block';
                });
            } else {
                console.error('Form or submit button not found');
            }
        });
    </script>
@endsection