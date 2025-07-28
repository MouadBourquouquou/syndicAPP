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
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 60px;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .logo {
      font-size: 2rem;
      font-weight: 700;
      color: var(--accent-color);
      cursor: pointer;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    nav a {
      color: var(--text-color);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s, transform 0.2s;
      cursor: pointer;
      position: relative;
      padding: 8px 16px;
      border-radius: 20px;
    }

    nav a:hover {
      color: var(--accent-color);
      transform: translateY(-2px);
      background: rgba(79, 209, 197, 0.1);
    }

   .main {
  margin-top: 80px;
  display: flex;
  align-items: stretch; /* 🔥 ensures equal height */
  justify-content: space-between;
  padding: 110px 60px;
  gap: 80px;
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}

    .text-content {
      background: rgba(255, 255, 255, 0.05);
      padding: 40px;
      border-radius: 25px;
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      position: relative;
      overflow: hidden;
      max-width: 600px;
    }

    .text-content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent-color), var(--btn-hover));
      border-radius: 25px 25px 0 0;
    }

    .text-content h1 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      color: var(--accent-color);
      line-height: 1.2;
      font-weight: 700;
    }

    .text-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      line-height: 1.6;
      color: rgba(226, 232, 240, 0.9);
    }

    .btn-start {
      padding: 18px 40px;
      font-size: 1.1rem;
      font-weight: bold;
      border: none;
      border-radius: 50px;
      background: linear-gradient(45deg, var(--btn-color), var(--btn-hover));
      color: #1A202C;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(79, 209, 197, 0.3);
      position: relative;
      overflow: hidden;
            text-decoration: none

    }

    .btn-start::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn-start:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(79, 209, 197, 0.4);
    }

    .btn-start:hover::before {
      left: 100%;
    }

    .image-content {
      position: relative;
    }

    .image-content img {
      width: 100%;
      border-radius: 25px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
      transition: transform 0.3s ease;
    }

    .image-content:hover img {
      transform: scale(1.02);
    }

    .popup-overlay {
      display: none;
      position: fixed;
      top: 0; 
      left: 0;
      width: 100%; 
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(5px);
    }

    .popup {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      padding: 50px;
      border-radius: 25px;
      backdrop-filter: blur(20px);
      max-width: 650px;
      width: 90%;
      color: white;
      position: relative;
      box-shadow: 0 20px 40px rgba(0,0,0,0.5);
      animation: popupSlideIn 0.3s ease;
      max-height: 80vh;
      overflow-y: auto;
    }

    @keyframes popupSlideIn {
      from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .popup h2 {
      margin-bottom: 25px;
      font-size: 2.2rem;
      color: var(--btn-color);
      font-weight: 700;
      text-align: center;
    }

    .popup h3 {
      margin-bottom: 15px;
      margin-top: 25px;
      font-size: 1.4rem;
      color: var(--accent-color);
      font-weight: 600;
    }

    .popup p {
      margin-bottom: 15px;
      line-height: 1.7;
      font-size: 1.1rem;
      color: rgba(226, 232, 240, 0.95);
    }

    .popup ul {
      margin-bottom: 20px;
      padding-left: 20px;
    }

    .popup li {
      margin-bottom: 10px;
      line-height: 1.6;
      font-size: 1.05rem;
      color: rgba(226, 232, 240, 0.9);
    }

    .popup a {
      color: var(--btn-color);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    .popup a:hover {
      color: var(--btn-hover);
      text-decoration: underline;
    }

    .close-btn {
      position: absolute;
      top: 20px;
      right: 25px;
      background: var(--btn-color);
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: 600;
      color: #1A202C;
      transition: all 0.3s ease;
    }

    .close-btn:hover {
      background: var(--btn-hover);
      transform: scale(1.05);
    }

    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-top: 20px;
    }

    .contact-item {
      background: rgba(255, 255, 255, 0.05);
      padding: 20px;
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .contact-item h4 {
      color: var(--accent-color);
      margin-bottom: 10px;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .contact-item p {
      margin-bottom: 5px;
      font-size: 1rem;
    }

    .business-hours {
      background: rgba(79, 209, 197, 0.1);
      padding: 20px;
      border-radius: 15px;
      border: 1px solid rgba(79, 209, 197, 0.2);
      margin-top: 20px;
    }

    @media (max-width: 1024px) {
      .main {
        gap: 60px;
        padding: 60px 40px;
      }
      
      .text-content {
        padding: 60px;
      }
      
      .text-content h1 {
        font-size: 2.8rem;
      }
      
      .contact-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
    }

    @media (max-width: 768px) {
      header {
        padding: 15px 30px;
      }
      
      .logo {
        font-size: 1.8rem;
      }
      
      nav {
        gap: 20px;
      }
      
      nav a {
        padding: 6px 12px;
        font-size: 0.9rem;
      }
      
      .main {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 40px 30px;
        gap: 40px;
      }

      .text-content {
        padding: 30px;
      }

      .text-content h1 {
        font-size: 2.5rem;
      }
      
      .text-content p {
        font-size: 1.1rem;
      }
      
      .btn-start {
        padding: 16px 32px;
        font-size: 1rem;
       
      }
      
      .popup {
        padding: 30px;
        margin: 20px;
        max-width: 95%;
      }
      
      .popup h2 {
        font-size: 1.8rem;
      }
      
      .contact-grid {
        grid-template-columns: 1fr;
        gap: 15px;
      }
    }

    @media (max-width: 480px) {
      .main {
        padding: 20px;
      }
      
      .text-content h1 {
        font-size: 2rem;
      }
      
      .text-content p {
        font-size: 1rem;
      }
      
      .popup {
        padding: 25px;
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
      <a href="/register" class="btn-start">Commencer</a>
    </div>
    <div class="image-content">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Illustration immeuble">
    </div>
  </main>

  <!-- Popups -->
  <div id="popup-apropos" class="popup-overlay">
    <div class="popup">
      <button class="close-btn" onclick="closePopup('apropos')">Fermer</button>
      <h2>À propos de Syndic</h2>
      
      <p>Syndic est une solution technologique innovante conçue pour révolutionner la gestion des copropriétés. Notre plateforme digitale offre une approche moderne et efficace pour simplifier les tâches administratives complexes des syndics et améliorer la communication entre tous les acteurs de la copropriété.</p>
      
     
      
      <h3>Pourquoi Choisir Syndic ?</h3>
      <p>Notre expertise en technologie immobilière, combinée à une interface utilisateur intuitive, garantit une expérience optimale pour tous les utilisateurs, qu'ils soient syndics professionnels ou copropriétaires.</p>
    </div>
  </div>

  <div id="popup-contact" class="popup-overlay">
    <div class="popup">
      <button class="close-btn" onclick="closePopup('contact')">Fermer</button>
      <h2>Contactez-nous</h2>
      
      <p>Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans la gestion de votre copropriété.</p>
      
      <div class="contact-grid">
        <div class="contact-item">
          <h4>Email</h4>
          <p><a href="mailto:mouadbourquouquou@gmail.com">mouadbourquouquou@gmail.com</a></p>
        </div>
        
        <div class="contact-item">
          <h4>Téléphone</h4>
          <p> <a href="tel:+212710461852">0710461852</a> </p>
        </div>
        
        
        
        
      </div>
      
   
    </div>
  </div>

  <script>
    function openPopup(id) {
      const popup = document.getElementById(`popup-${id}`);
      popup.style.display = 'flex';
    }

    function closePopup(id) {
      const popup = document.getElementById(`popup-${id}`);
      popup.style.display = 'none';
    }

    // Fermer les popups en cliquant sur l'overlay
    document.querySelectorAll('.popup-overlay').forEach(overlay => {
      overlay.addEventListener('click', function(e) {
        if (e.target === this) {
          this.style.display = 'none';
        }
      });
    });

    // Fermer les popups avec la touche Échap
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('.popup-overlay').forEach(popup => {
          popup.style.display = 'none';
        });
      }          
    });
  </script>
</body>
</html>