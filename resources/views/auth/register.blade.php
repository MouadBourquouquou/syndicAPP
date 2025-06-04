<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Syndic App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            max-width: 550px; /* Légèrement augmenté pour plus de champs */
            width: 100%;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow:
                0 35px 60px -12px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, select {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 1.3rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background-color: white;
            font-size: 1rem;
            color: #1f2937;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -12px rgba(102, 126, 234, 0.4);
        }

        button:hover::before {
            left: 100%;
        }

        .link {
            text-align: center;
            margin-top: 1rem;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Styles spécifiques pour le champ nom_societé visible conditionnellement */
        #nom_societe_group {
            display: none; /* Masqué par défaut */
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <label for="statut">Statut</label>
            <select name="statut" id="statut" required onchange="toggleSocieteField()">
                <option value="">-- Choisissez votre statut --</option>
                <option value="professionnel">Syndic professionnel</option>
                <option value="benevolat">Syndic bénévole</option>
            </select>
            <div id="nom_societe_group">
                <label for="nom_societe">Nom de la société</label>
                <input type="text" id="nom_societe" name="nom_societe">
            </div>

            <label for="nom">Nom</label>
            <input type="text" id="nom" name="name" required>

            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>

            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>

            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" required>

            <label for="tel">Téléphone</label>
            <input type="text" id="tel" name="tel" required>

            <label for="fax">Fax</label>
            <input type="text" id="fax" name="Fax"> <button type="submit">S'inscrire</button>
        </form>

        <div class="link">
            <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
        </div>
    </div>

    <script>
        function toggleSocieteField() {
            const statutSelect = document.getElementById('statut');
            const nomSocieteGroup = document.getElementById('nom_societe_group');
            const nomSocieteInput = document.getElementById('nom_societe');

            if (statutSelect.value === 'professionnel') {
                nomSocieteGroup.style.display = 'block';
                nomSocieteInput.setAttribute('required', 'required');
            } else {
                nomSocieteGroup.style.display = 'none';
                nomSocieteInput.removeAttribute('required');
                nomSocieteInput.value = ''; // Efface la valeur si le champ est masqué
            }
        }

        // Exécuter au chargement de la page pour le cas où l'utilisateur actualise avec une valeur sélectionnée
        document.addEventListener('DOMContentLoaded', toggleSocieteField);
    </script>
</body>
</html>