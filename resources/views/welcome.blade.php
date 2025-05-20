<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bienvenue sur Syndic</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        .btn-login {
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #2779bd;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur la plateforme Syndic</h1>
    <p>Cette plateforme vous permettra de gérer facilement votre syndic.</p>

    <!-- Bouton vers la page de login -->
<button onclick="window.location.href='{{ route('login') }}'">Connexion</button>


</body>
</html>
