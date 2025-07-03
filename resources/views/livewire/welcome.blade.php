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
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      flex: 1;
      padding: 80px 60px;
      gap: 60px;
    }

    .text-content {
      background: rgba(255, 255, 255, 0.05);
      padding: 40px;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
    }

    .text-content h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: var(--accent-color);
    }

    .text-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .btn-start {
      padding: 14px 32px;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      border-radius: 50px;
      background-color: var(--btn-color);
      color: #1A202C;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }

    .btn-start:hover {
      background-color: var(--btn-hover);
      transform: scale(1.05);
    }

    .image-content img {
      width: 100%;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .popup-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .popup {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      padding: 40px;
      border-radius: 20px;
      backdrop-filter: blur(20px);
      max-width: 500px;
      width: 90%;
      color: white;
    }

    .popup h2 {
      margin-bottom: 15px;
      font-size: 1.8rem;
      color: var(--btn-color);
    }

    .popup a {
      color: var(--btn-color);
    }

    .close-btn {
      position: absolute;
      top: 20px;
      right: 30px;
      background: var(--btn-color);
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .main {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .text-content h1 {
        font-size: 2.5rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">Syndic</div>
    <nav>
      <a onclick="openPopup('apropos')">À propos</a>
      <a onclick="openPopup('contact')">Contact</a>
      <a href="/login">Connexion</a>
    </nav>
  </header>

  <main class="main">
    <div class="text-content">
      <h1>Bienvenue sur l'application Syndic</h1>
      <p>Gérez votre copropriété de manière simple, moderne et efficace. Paiements, assemblées, documents, communication : tout est à portée de main.</p>
      <button class="btn-start">Commencer</button>
    </div>
    <div class="image-content">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Illustration immeuble">
    </div>
  </main>

  <!-- Popups -->
  <div id="popup-apropos" class="popup-overlay">
    <div class="popup">
      <button class="close-btn" onclick="closePopup('apropos')">Fermer</button>
      <h2>À propos</h2>
      <p>Syndic est une plateforme moderne conçue pour simplifier la gestion des copropriétés : paiements, assemblées, documents, et communication.</p>
    </div>
  </div>

  <div id="popup-contact" class="popup-overlay">
    <div class="popup">
      <button class="close-btn" onclick="closePopup('contact')">Fermer</button>
      <h2>Contact</h2>
      <p>Email : <a href="mailto:lahcen12@gmail.com">lahcen12@gmail.com</a></p>
      <p>Téléphone : <a href="tel:+212600000000">+212 6 34567898</a></p>
      <p>Fax : +212 5 00 00 00 00</p>
    </div>
  </div>

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