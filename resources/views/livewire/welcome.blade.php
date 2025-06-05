<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Syndic - Bienvenue</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS pour faciliter la gestion du thème */
        :root {
            --primary-color: #003366; /* Bleu marine */
            --primary-color-dark: #002244; /* Bleu marine plus foncé pour le survol */
            --secondary-color-text: #555; /* Gris foncé pour le texte général */
            --accent-color: #FFC107; /* Un jaune subtil pour le bouton principal */
            --background-light: #f0f4f8; /* Arrière-plan gris clair */
            --card-background: #ffffff; /* Arrière-plan blanc pour la carte pivotante */
            --text-color-dark: #333;
            --text-color-light: #fff;
            --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.15);
            --border-radius-md: 20px;
            --transition-speed-slow: 0.8s; /* Pour l'animation de rotation */
            --transition-speed-fast: 0.3s; /* Pour les boutons, etc. */
            --perspective: 1200px; /* Pour l'effet 3D */
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color-dark);
            line-height: 1.6;
            overflow: hidden; /* Masque le débordement des transformations 3D */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Hauteur minimale de la fenêtre (full viewport height) */
            perspective: var(--perspective); /* Établit la perspective 3D */

            /* --- Styles de l'image d'arrière-plan (non colorée) --- */
            background-color: #dbe7f2; /* Couleur de secours bleu clair désaturé */
            background-image: url('https://images.unsplash.com/photo-1516100882582-cefacb897992?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); /* Façade de bâtiment subtile et désaturée */
            background-size: cover; /* Assure que l'image couvre tout le corps */
            background-position: center center; /* Centre l'image */
            background-repeat: no-repeat; /* Empêche l'image de se répéter */
            background-attachment: fixed; /* Garde l'arrière-plan fixe lors du défilement (si le contenu déborde) */
        }

        /* --- Conteneur principal de la carte pivotante --- */
        .flipper-container {
            width: 700px; /* Largeur fixe pour la carte de contenu principale */
            max-width: 90%; /* Largeur maximale réactive */
            height: 550px; /* Hauteur fixe pour la carte de contenu principale */
            position: relative;
            transform-style: preserve-3d; /* Clé pour la rotation 3D */
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius-md);
        }

        /* L'élément réel qui tourne pour révéler les faces */
        .flipper-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform var(--transition-speed-slow) ease-in-out;
            transform-style: preserve-3d;
        }

        /* Faces avant, à propos, contact du "cube" */
        .flipper-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden; /* Cache l'arrière lors de la rotation */
            border-radius: var(--border-radius-md);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
            box-sizing: border-box;
            background-color: var(--card-background); /* Arrière-plan blanc pour toutes les faces */
        }

        /* --- Face d'accueil (avant) --- */
        .flipper-face.welcome {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color-dark));
            color: var(--text-color-light);
            z-index: 2; /* Assure qu'il est au-dessus initialement */
            transform: rotateY(0deg); /* Définit explicitement son orientation par défaut */
        }

        .welcome-content .hero-logo {
            background-color: rgba(255, 255, 255, 0.2);
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.8em;
            font-weight: 700;
            margin: 0 auto 25px;
            transition: transform var(--transition-speed-fast) ease;
        }

        .welcome-content .hero-logo:hover {
            transform: scale(1.1);
        }

        .welcome-content h1 {
            font-size: 3em;
            margin-bottom: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .welcome-content p {
            font-size: 1.2em;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .btn {
            display: inline-block;
            padding: 15px 35px;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-speed-fast) ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--text-color-dark);
        }

        .btn-primary:hover {
            background-color: #FFD54F;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* --- Face "À Propos" --- */
        .flipper-face.about {
            transform: rotateY(90deg); /* Positionnée à 90deg à droite de la face 'welcome' */
            color: var(--text-color-dark);
        }

        .about-content h2 {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .about-content p {
            font-size: 1.1em;
            margin-bottom: 25px;
            color: var(--secondary-color-text);
            line-height: 1.8;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .about-item {
            background-color: var(--background-light);
            padding: 20px;
            border-radius: var(--border-radius-sm);
            text-align: left;
            font-size: 0.95em;
            line-height: 1.5;
            box-shadow: var(--shadow-sm);
        }
        .about-item h3 {
            color: var(--primary-color-dark);
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        /* --- Face "Contact" --- */
        .flipper-face.contact {
            transform: rotateY(180deg); /* Positionnée à 180deg (derrière) la face 'welcome' */
            color: var(--text-color-dark);
        }

        .contact-content h2 {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .contact-content p {
            font-size: 1.1em;
            margin-bottom: 25px;
            color: var(--secondary-color-text);
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
            align-items: center;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.1em;
            color: var(--secondary-color-text);
        }

        .contact-item .icon {
            font-size: 1.5em;
            color: var(--primary-color);
        }

        .contact-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color var(--transition-speed-fast) ease;
        }

        .contact-item a:hover {
            color: var(--primary-color-dark);
            text-decoration: underline;
        }

        /* --- Points de navigation (en dehors du flipper pour un contrôle persistant) --- */
        .navigation-dots {
            position: absolute;
            bottom: 30px; /* Ajustez si nécessaire */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10; /* Assure que les points sont au-dessus de tout */
        }

        .dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.2); /* Point inactif */
            cursor: pointer;
            transition: background-color var(--transition-speed-fast) ease, transform var(--transition-speed-fast) ease;
        }

        .dot.active {
            background-color: var(--primary-color); /* Point actif - Bleu marine */
            transform: scale(1.2);
        }

        /* --- Ajustements responsives --- */
        @media (max-width: 768px) {
            .flipper-container {
                height: 500px;
            }
            .flipper-face {
                padding: 30px;
            }
            .welcome-content h1 {
                font-size: 2.5em;
            }
            .welcome-content p {
                font-size: 1em;
            }
            .btn {
                padding: 12px 25px;
                font-size: 1em;
            }
            .about-content h2, .contact-content h2 {
                font-size: 2em;
            }
            .about-content p, .contact-content p, .contact-item {
                font-size: 1em;
            }
            .about-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .flipper-container {
                height: 450px;
            }
            .flipper-face {
                padding: 25px;
            }
            .welcome-content h1 {
                font-size: 2em;
            }
            .welcome-content .hero-logo {
                width: 70px;
                height: 70px;
                font-size: 2em;
            }
        }
    </style>
</head>
<body>

    <div class="flipper-container" id="flipperContainer">
        <div class="flipper-inner" id="flipperInner">
            <div class="flipper-face welcome" data-index="0">
                <div class="welcome-content">
                    <div class="hero-logo">S</div>
                    <h1>Bienvenue sur la plateforme Syndic</h1>
                    <p>La plateforme intelligente pour une gestion de copropriété transparente, efficace et simplifiée.</p>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('login') }}';">
                        Se connecter
                    </button>
                </div>
            </div>

            <div class="flipper-face about" data-index="1">
                <div class="about-content">
                    <h2>À Propos de Syndic</h2>
                    <p>Syndic est votre solution complète pour une gestion immobilière moderne. Nous transformons la complexité de l'administration de copropriété en une expérience fluide et intuitive, pour tous les intervenants.</p>

                    <div class="about-grid">
                        
                    </div>
                </div>
            </div>

            <div class="flipper-face contact" data-index="2">
                <div class="contact-content">
                    <h2>Nous Contacter</h2>
                    <p>Avez-vous des questions, des suggestions ou besoin d'assistance ? N'hésitez pas à nous contacter.</p>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="icon">✉️</span>
                            <a href="mailto:contact@syndic.com">contact@syndic.com</a>
                        </div>
                        <div class="contact-item">
                            <span class="icon">📞</span>
                            <a href="tel:+2125XXXYYYZZZ">+212 5XX YYY ZZZ</a>
                        </div>
                        <div class="contact-item">
                            <span class="icon">📍</span>
                            <span>123, Rue des Copropriétaires, Marrakech, Maroc</span>
                        </div>
                    </div>
                    <p style="margin-top: 25px; font-size: 0.9em; color: var(--secondary-color-text);">Nous nous engageons à répondre à toutes vos demandes.</p>
                </div>
            </div>
        </div> </div> <div class="navigation-dots" id="navigationDots">
        <div class="dot active" data-index="0"></div>
        <div class="dot" data-index="1"></div>
        <div class="dot" data-index="2"></div>
    </div>

    <script>
        const flipperInner = document.getElementById('flipperInner'); // Cible la nouvelle div interne
        const dotsContainer = document.getElementById('navigationDots');
        const totalFaces = 3; // Accueil, À Propos, Contact
        let currentFaceIndex = 0;
        let autoFlipInterval;
        const flipDuration = 8000; // 8 secondes pour la rotation automatique

        // Tableau pour stocker les angles de rotation de flipper-inner pour afficher chaque face
        const faceRotations = [
            0,   // Accueil (avant)
            -90, // À Propos (tourne pour afficher la face à 90deg)
            -180 // Contact (tourne pour afficher la face à 180deg)
        ];

        function updateFlipper() {
            // Applique la rotation à flipper-inner
            flipperInner.style.transform = `rotateY(${faceRotations[currentFaceIndex]}deg)`;
            updateDots();
        }

        function updateDots() {
            const dots = dotsContainer.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentFaceIndex);
            });
        }

        function goToFace(index) {
            currentFaceIndex = index;
            updateFlipper();
            resetAutoFlip(); // Réinitialise le minuteur lorsque l'utilisateur interagit
        }

        function nextFace() {
            currentFaceIndex = (currentFaceIndex + 1) % totalFaces; // Boucle pour revenir au début
            updateFlipper();
        }

        function startAutoFlip() {
            autoFlipInterval = setInterval(nextFace, flipDuration);
        }

        function resetAutoFlip() {
            clearInterval(autoFlipInterval);
            startAutoFlip();
        }

        // Écouteur d'événements pour les points de navigation
        dotsContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('dot')) {
                const index = parseInt(event.target.dataset.index);
                goToFace(index);
            }
        });

        // Initialisation au chargement
        updateFlipper(); // Définit l'état initial (face d'accueil visible)
        startAutoFlip(); // Démarre la rotation automatique

        // Pause la rotation automatique au survol de la carte pivotante
        flipperInner.addEventListener('mouseenter', () => clearInterval(autoFlipInterval)); // Cible flipperInner
        flipperInner.addEventListener('mouseleave', () => startAutoFlip()); // Cible flipperInner
    </script>

</body>
</html>