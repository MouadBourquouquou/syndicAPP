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
      --shadow-soft: 0 8px 16px rgba(0, 0, 0, 0.1);
      --shadow-hover: 0 12px 24px rgba(0, 0, 0, 0.15);
      --border-radius: 5px;
      --border-radius-sm: 5px;
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
      justify-content: center;
      padding: 10px;
    }

    .header-bar {
      width: 100%;
      padding: 10px 15px;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      position: fixed;
      top: 0;
      left: 0;
      z-index: 10;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent-color);
    }

    .container {
      background: var(--card-background);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 20px 15px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-soft);
      max-width: 700px;
      width: 95%;
      position: relative;
      margin-top: 60px;
    }

    .container::before {
      content: '';
      position: absolute;
      top: -2px;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
      border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .header {
      text-align: center;
      margin-bottom: 1rem;
    }

    .header h2 {
      font-size: 1.8rem;
      font-weight: 700;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .form-grid {
      display: grid;
      gap: 1rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .form-group {
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 0.2rem;
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 0.75rem;
      text-transform: uppercase;
    }

    input,
    select {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid var(--border-color);
      border-radius: var(--border-radius-sm);
      font-size: 0.85rem;
      background: rgba(255, 255, 255, 0.8);
    }

    input:focus,
    select:focus {
      border-color: var(--primary-color);
      outline: none;
      box-shadow: 0 0 0 2px rgba(79, 209, 197, 0.1);
      background: rgba(255, 255, 255, 0.95);
    }

    .submit-btn {
      width: 100%;
      padding: 10px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      border: none;
      border-radius: var(--border-radius-sm);
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      margin-top: 0.5rem;
    }

    .submit-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(79, 209, 197, 0.3);
    }

    .link {
      text-align: center;
      margin-top: 0.5rem;
      padding-top: 0.5rem;
      border-top: 1px solid var(--border-color);
      font-size: 0.85rem;
    }

    .link a {
      color: var(--primary-color);
      font-weight: 600;
      text-decoration: none;
    }

    .link a:hover {
      text-decoration: underline;
    }

    /* Desktop layout */
    @media (min-width: 768px) {
      .form-row {
        grid-template-columns: 1fr 1fr;
      }
      
      /* Specific groupings for desktop */
      .row-status-email {
        grid-template-columns: 1fr 1fr;
      }
      
      .row-name {
        grid-template-columns: 1fr 1fr;
      }
      
      .row-password {
        grid-template-columns: 1fr 1fr;
      }

        .row-address {
              grid-template-columns: 1fr 1fr; /* Equal width for both fields */
        }
      
      .row-contact {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px 10px;
        margin-top: 50px;
      }

      .header h2 {
        font-size: 1.6rem;
      }

      input,
      select {
        padding: 7px 10px;
        font-size: 0.8rem;
      }

      .submit-btn {
        padding: 8px;
        font-size: 0.85rem;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 10px 8px;
        margin-top: 45px;
      }

      .header h2 {
        font-size: 1.4rem;
      }

      label {
        font-size: 0.7rem;
      }

      input,
      select {
        padding: 6px 8px;
        font-size: 0.75rem;
      }

      .submit-btn {
        padding: 7px;
        font-size: 0.8rem;
      }

      .link {
        font-size: 0.75rem;
      }
    }
  </style>
</head>
<body>
  <header class="header-bar">
    <div class="logo">Syndic</div>
  </header>

  <div class="container">
    <div class="header">
      <h2>Créer un compte</h2>
    </div>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="form-grid">
        <!-- Status and Email row -->
        <div class="form-row row-status-email">
          <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" required onchange="toggleSocieteField()">
              <option value="">-- Statut --</option>
              <option value="professionnel">Syndic professionnel</option>
              <option value="benevolat">Syndic bénévole</option>
            </select>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
        </div>

        <!-- Company name (conditional) -->
        <div class="form-group company-field" id="nom_societe_group" style="display:none;">
          <label for="nom_societe">Société</label>
          <input type="text" id="nom_societe" name="nom_societe" placeholder="Nom de la société">
        </div>

        <!-- Name row -->
        <div class="form-row row-name">
          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="name" required>
          </div>
          <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
          </div>
        </div>

        <!-- Password row -->
        <div class="form-row row-password">
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
          </div>
        </div>

        <!-- Address row -->
        <div class="form-row row-address">
          <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" required>
          </div>
          <div class="form-group">
            <label for="ville">Ville</label>
            <select id="ville" name="ville" required>
              <option value="">-- Sélectionnez une ville --</option>
            </select>
          </div>
        </div>

        <!-- Contact row -->
        <div class="form-row row-contact">
          <div class="form-group">
            <label for="tel">Téléphone</label>
            <input type="tel" id="tel" name="tel" required>
          </div>
          <div class="form-group">
            <label for="fax">Fax (optionnel)</label>
            <input type="text" id="fax" name="fax">
          </div>
        </div>

        <button type="submit" class="submit-btn">S'inscrire</button>

        <div class="link">
          <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
        </div>
      </div>
    </form>
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

    document.addEventListener('DOMContentLoaded', function() {
      const villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];
      const villeSelect = document.getElementById('ville');
      
      villes.forEach(ville => {
        const option = document.createElement('option');
        option.value = ville;
        option.textContent = ville;
        villeSelect.appendChild(option);
      });
    });
  </script>
</body>
</html>