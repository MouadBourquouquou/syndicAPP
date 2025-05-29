<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e9f5ff, #ffffff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.9rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
        }

        .form-options input {
            margin-right: 0.4rem;
        }

        button {
            width: 100%;
            padding: 0.9rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .register-link,
        .forgot-password-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
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

        <form method="POST" action="{{ route('login.submit') }}">

            @csrf
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                {{-- <a href="{{ route('password.request') }}" class="forgot-password-link">Mot de passe oublié ?</a> --}}
            </div>

            <button type="submit">Se connecter</button>
        </form>

        <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
    </div>
</body>
</html>
