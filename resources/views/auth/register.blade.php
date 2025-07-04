<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription - Syndic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4FD1C5;
      --primary-dark: #38B2AC;
      --primary-light: #81E6D9;
      --secondary-color: #1A202C;
      --accent-color: #4FD1C5;
      --background-gradient: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      --card-background: rgba(255, 255, 255, 0.95);
      --glass-background: rgba(255, 255, 255, 0.1);
      --text-primary: #2D3748;
      --text-secondary: #4A5568;
      --text-light: #718096;
      --border-color: #E2E8F0;
      --success-color: #48BB78;
      --warning-color: #ED8936;
      --error-color: #F56565;
      --shadow-soft: 0 20px 40px rgba(0, 0, 0, 0.1);
      --shadow-hover: 0 25px 50px rgba(0, 0, 0, 0.15);
      --border-radius: 20px;
      --border-radius-sm: 12px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--background-gradient);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header-bar {
      width: 100%;
      display: flex;
      padding: 20px ;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      margin-bottom: 40px;
    }

    .logo {
      font-size: 2rem;
      font-weight: 700;
      color: var(--accent-color);
    }

    .container {
      background: var(--card-background);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 50px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-soft);
      max-width: 600px;
      width: 100%;
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
      border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .header h2 {
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .form-grid {
      display: grid;
      gap: 1.5rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    .form-group {
      position: relative;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 0.9rem;
      text-transform: uppercase;
    }

    input,
    select {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid var(--border-color);
      border-radius: var(--border-radius-sm);
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.8);
    }

    input:focus,
    select:focus {
      border-color: var(--primary-color);
      outline: none;
      box-shadow: 0 0 0 3px rgba(79, 209, 197, 0.1);
      background: rgba(255, 255, 255, 0.95);
    }

    input:valid {
      border-color: var(--success-color);
    }

    .submit-btn {
      width: 100%;
      padding: 18px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      border: none;
      border-radius: var(--border-radius-sm);
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      margin-top: 1rem;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(79, 209, 197, 0.3);
    }

    .link {
      text-align: center;
      margin-top: 2rem;
      border-top: 1px solid var(--border-color);
      padding-top: 1rem;
    }

    .link a {
      color: var(--primary-color);
      font-weight: 600;
      text-decoration: none;
    }

    .link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .header-bar {
        padding: 20px 30px;
      }

      .container {
        padding: 40px 30px;
      }

      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <header class="header-bar">
    <div class="logo"> Syndic</div>
  </header>

  <div class="container">
    <div class="header">
      <h2>Créer un compte</h2>
    </div>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="form-grid">
        <div class="form-group full-width">
          <label for="statut">Statut</label>
          <select name="statut" id="statut" required onchange="toggleSocieteField()">
            <option value="">-- Choisissez votre statut --</option>
            <option value="professionnel">Syndic professionnel</option>
            <option value="benevolat">Syndic bénévole</option>
          </select>
        </div>

        <div class="form-group full-width company-field" id="nom_societe_group" style="display:none;">
          <label for="nom_societe">Nom de la société</label>
          <input type="text" id="nom_societe" name="nom_societe" placeholder="Nom de la société">
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="name" required>
          </div>
          <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
          </div>
        </div>

        <div class="form-group full-width">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
          </div>
        </div>

        <div class="form-group full-width">
          <label for="adresse">Adresse</label>
          <input type="text" id="adresse" name="adresse" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" required>
          </div>
          <div class="form-group">
            <label for="tel">Téléphone</label>
            <input type="tel" id="tel" name="tel" required>
          </div>
        </div>

        <div class="form-group full-width">
          <label for="fax">Fax (optionnel)</label>
          <input type="text" id="fax" name="fax">
        </div>

        <button type="submit" class="submit-btn">S'inscrire</button>
      </div>
    </form>

    <div class="link">
      <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
    </div>
  </div>

  <script>
    function toggleSocieteField() {
      const statut = document.getElementById('statut').value;
      const companyField = document.getElementById('nom_societe_group');
      const input = document.getElementById('nom_societe');
      if (statut === 'professionnel') {
        companyField.style.display = 'block';
        input.setAttribute('required', 'required');
      } else {
        companyField.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
      }
    }
    document.addEventListener('DOMContentLoaded', toggleSocieteField);
  </script>
</body>
</html>
