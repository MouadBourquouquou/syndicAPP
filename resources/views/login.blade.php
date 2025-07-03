<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bienvenue - Syndic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --main-color: #1E1F29;
      --accent-color: #4FD1C5;
      --text-color: #E2E8F0;
      --btn-color: #4FD1C5;
      --btn-hover: #38B2AC;
      --popup-bg: rgba(30, 31, 41, 0.9);
      --glass-bg: rgba(255, 255, 255, 0.1);
      --glass-border: rgba(255, 255, 255, 0.2);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: var(--text-color);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 60px;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .logo {
      font-size: 2rem;
      font-weight: 700;
      color: var(--accent-color);
    }

    nav a {
      margin-left: 30px;
      color: var(--text-color);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: var(--accent-color);
    }

    .main {
      display: flex;
      justify-content: center;
      align-items: center;
      flex: 1;
      padding: 60px 20px;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.05);
      padding: 40px;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-container .hero-logo {
      background-color: var(--accent-color);
      color: #1A202C;
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2.2em;
      font-weight: 700;
      margin: 0 auto 25px;
    }

    .login-container h2 {
      color: var(--accent-color);
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    input[type="email"], input[type="password"] {
      width: 100%;
      padding: 1rem;
      margin-bottom: 1rem;
      border: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.1);
      color: var(--text-color);
    }

    input:focus {
      outline: none;
      background: rgba(255,255,255,0.2);
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      font-size: 0.9rem;
      color: var(--text-color);
      margin-bottom: 1rem;
    }

    .form-options input[type="checkbox"] {
      margin-right: 0.5rem;
    }

    .forgot-password-link {
      color: var(--accent-color);
      text-decoration: none;
    }

    .forgot-password-link:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      padding: 1rem;
      background-color: var(--btn-color);
      color: #1A202C;
      border: none;
      border-radius: 50px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: var(--btn-hover);
    }

    .register-link {
      display: block;
      margin-top: 1.2rem;
      color: var(--accent-color);
      text-decoration: none;
    }

    .register-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">Syndic</div>
    
  </header>

  <main class="main">
    <div class="login-container">
      <div class="hero-logo">S</div>
      <h2>Connexion</h2>
      <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <input type="email" name="email" placeholder="Adresse e-mail" required />
        <input type="password" name="password" placeholder="Mot de passe" required />
        <div class="form-options">
          <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
        </div>
        <button type="submit">Se connecter</button>
      </form>
      <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
    </div>
  </main>

  

  <

  <script>
    function openPopup(id) {
      document.getElementById(`popup-${id}`).style.display = 'flex';
    }

    function closePopup(id) {
      document.getElementById(`popup-${id}`).style.display = 'none';
    }
  </script>
</body>
</html>
