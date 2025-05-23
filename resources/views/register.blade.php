<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            width: 400px;
        }

        .register-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Créer un compte</h2>

        <form action="#" method="POST">
            @csrf

            <label for="statut">Votre statut :</label>
            <select name="statut" id="statut" required>
                <option value="">-- Choisissez --</option>
                <option value="professionnel">Syndic professionnel</option>
                <option value="benevolat">Syndic bénévolat</option>
            </select>

            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Adresse email" required>
            <input type="password" name="password" placeholder="Mot de passe (min. 8 caractères)" minlength="8" required>
            <input type="password" name="password_confirmation" placeholder="Retapez le mot de passe" minlength="8" required>

            <button type="submit">S'inscrire</button>
            <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
        </form>
    </div>
</body>
</html>
