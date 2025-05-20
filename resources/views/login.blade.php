<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            width: 350px;
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .form-options label {
            display: flex;
            align-items: center;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .register-link,
        .forgot-password-link {
            display: block;
            text-align: center;
            margin-top: 0.8rem;
            color: #007bff;
            text-decoration: none;
        }

        .register-link:hover,
        .forgot-password-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                {{-- <a href="{{ route('password.request') }}" class="forgot-password-link">Mot de passe oublié ?</a>--}}
            </div>

            <button type="submit">Se connecter</button>
        </form>

        <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
    </div>
</body>
</html>
