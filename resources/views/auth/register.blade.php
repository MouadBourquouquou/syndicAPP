<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscription - Syndic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #003366;
      --primary-color-dark: #002244;
      --secondary-color-text: #555;
      --accent-color: #4FD1C5;
      --background-light: #f0f4f8;
      --card-background: #ffffff;
      --text-color-dark: #333;
      --text-color-light: #fff;
      --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.15);
      --border-radius-md: 20px;
      --border-radius-sm: 10px;
      --transition-speed-fast: 0.3s;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: var(--text-color-dark);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      background-color: var(--card-background);
      padding: 40px;
      border-radius: var(--border-radius-md);
      box-shadow: var(--shadow-md);
      max-width: 550px;
      width: 100%;
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2rem;
      color: var(--primary-color);
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: var(--secondary-color-text);
      font-size: 0.875rem;
    }

    input, select {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 1.2rem;
      border: 1px solid #ccc;
      border-radius: var(--border-radius-sm);
      font-size: 1rem;
      transition: border-color var(--transition-speed-fast), box-shadow var(--transition-speed-fast);
    }

    input:focus, select:focus {
      border-color: var(--primary-color);
      outline: none;
      box-shadow: 0 0 5px rgba(0, 51, 102, 0.3);
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: var(--primary-color);
      color: var(--text-color-light);
      border: none;
      border-radius: var(--border-radius-sm);
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color var(--transition-speed-fast);
    }

    button:hover {
      background-color: var(--primary-color-dark);
    }

    .link {
      text-align: center;
      margin-top: 1rem;
    }

    .link a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
    }

    .link a:hover {
      text-decoration: underline;
    }

    #nom_societe_group {
      display: none;
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
      <input type="text" id="fax" name="Fax">

      <button type="submit">S'inscrire</button>
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
        nomSocieteInput.value = '';
      }
    }

    document.addEventListener('DOMContentLoaded', toggleSocieteField);
  </script>
</body>
</html>
