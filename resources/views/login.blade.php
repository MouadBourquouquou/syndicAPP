<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Syndic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS pour les couleurs et espacements, cohérentes avec la page d'accueil */
        :root {
            --primary-color: #003366; /* Bleu marine */
            --primary-color-dark: #002244; /* Bleu marine plus foncé pour le survol */
            --secondary-color-text: #555; /* Gris foncé pour le texte général */
            --accent-color: #FFC107; /* Un jaune subtil pour les boutons */
            --background-light: #f0f4f8; /* Arrière-plan gris clair */
            --card-background: #ffffff; /* Arrière-plan blanc pour la carte de connexion */
            --text-color-dark: #333;
            --text-color-light: #fff; /* Pour les textes sur fond primaire */
            --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.15); /* Ombre cohérente */
            --border-radius-md: 20px; /* Rayon de bordure pour les conteneurs */
            --border-radius-sm: 10px; /* Rayon de bordure pour les champs de saisie */
            --transition-speed-fast: 0.3s; /* Pour les transitions fluides */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif; /* Utilisation de Poppins */
            color: var(--text-color-dark);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            /* --- STYLES D'ARRIÈRE-PLAN AVEC L'IMAGE DE L'IMMEUBLE --- */
            background-color: #dbe7f2; /* Couleur de secours bleu clair désaturé */
            background-image: url('https://images.unsplash.com/photo-1516100882582-cefacb897992?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); /* Image d'un immeuble/appartement */
            background-size: cover; /* Assure que l'image couvre tout l'arrière-plan */
            background-position: center center; /* Centre l'image */
            background-repeat: no-repeat; /* Empêche l'image de se répéter */
            background-attachment: fixed; /* Garde l'image fixe lors du défilement */
        }

        .login-container {
            background-color: var(--card-background); /* Blanc, comme la carte d'accueil */
            padding: 40px; /* Plus d'espace, comme la carte d'accueil */
            border-radius: var(--border-radius-md); /* Rayon de bordure cohérent */
            box-shadow: var(--shadow-md); /* Ombre cohérente */
            width: 100%;
            max-width: 420px; /* Légèrement plus large pour l'esthétique */
            text-align: center; /* Centrer le contenu */
        }

        .login-container .hero-logo {
            background-color: var(--primary-color); /* Couleur primaire pour le logo */
            color: var(--text-color-light);
            width: 70px; /* Taille légèrement plus petite pour un formulaire */
            height: 70px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.2em;
            font-weight: 700;
            margin: 0 auto 25px; /* Centré et espacé */
            transition: transform var(--transition-speed-fast) ease;
        }

        .login-container .hero-logo:hover {
            transform: scale(1.05); /* Effet de survol subtil */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color); /* Couleur primaire pour le titre */
            font-weight: 600; /* Poids de police cohérent */
            font-size: 2.2em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 1.1rem; /* Padding accru pour une meilleure ergonomie */
            margin-bottom: 1.5rem; /* Espacement cohérent */
            border: 1px solid var(--background-light); /* Bordure subtile */
            border-radius: var(--border-radius-sm); /* Rayon de bordure pour les champs */
            transition: border-color var(--transition-speed-fast), box-shadow var(--transition-speed-fast);
            font-size: 1em; /* Taille de police lisible */
            color: var(--text-color-dark);
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary-color); /* Couleur de bordure au focus */
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1); /* Ombre au focus */
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem; /* Espacement cohérent */
            font-size: 0.95rem; /* Taille de police légèrement ajustée */
            color: var(--secondary-color-text); /* Couleur de texte secondaire */
        }

        .form-options input[type="checkbox"] {
            margin-right: 0.6rem;
            accent-color: var(--primary-color); /* Couleur de la case à cocher */
        }

        .forgot-password-link {
            color: var(--primary-color); /* Couleur primaire pour les liens */
            text-decoration: none;
            transition: color var(--transition-speed-fast) ease;
        }

        .forgot-password-link:hover {
            color: var(--primary-color-dark); /* Couleur de survol pour les liens */
            text-decoration: underline;
        }

        button {
            width: 100%;
            padding: 1.1rem; /* Padding accru */
            background-color: var(--accent-color); /* Couleur du bouton principal */
            color: var(--text-color-dark); /* Texte foncé sur bouton clair */
            border: none;
            border-radius: var(--border-radius-md); /* Rayon de bordure cohérent */
            font-weight: 600;
            font-size: 1.1rem; /* Taille de police cohérente */
            cursor: pointer;
            transition: background-color var(--transition-speed-fast) ease, transform var(--transition-speed-fast) ease, box-shadow var(--transition-speed-fast) ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre cohérente */
        }

        button:hover {
            background-color: #FFD54F; /* Jaune légèrement plus clair au survol */
            transform: translateY(-2px); /* Léger effet de soulèvement */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée au survol */
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem; /* Espacement cohérent */
            font-size: 0.95rem;
            color: var(--primary-color); /* Couleur primaire pour les liens */
            text-decoration: none;
            transition: color var(--transition-speed-fast) ease;
        }

        .register-link:hover {
            color: var(--primary-color-dark);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="hero-logo">S</div>
        <h2>Connexion</h2>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                {{-- La ligne ci-dessous est commentée si la route n'est pas encore définie --}}
               
            </div>

            <button type="submit">Se connecter</button>
        </form>

        {{-- La ligne ci-dessous est commentée si la route n'est pas encore définie --}}
        <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
    </div>
</body>
</html>