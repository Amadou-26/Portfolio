<?php require 'fonctions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos — Papa Amadou Thomas</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/about.css" />
</head>
<body>

<?php require 'composants/navigation.php'; ?>

<main>

  
  <section class="bio section">
    <div class="container bio__grid">
      <div class="bio__photo">
        <img src="images/ma photo.jpeg" alt="Papa Amadou Thomas" />
        <div class="bio__photo-caption">
          <strong>Papa Amadou Thomas</strong>
          <span>Génie Logiciel & Réseaux — ESTM</span>
        </div>
      </div>
      <div class="bio__content">
        <p class="section-label">Qui suis-je</p>
        <h1 class="title-xl">À propos</h1>
        <p class="bio__text">
          Actuellement étudiant en deuxième année de <strong>Licence en Génie Logiciel et
          Administration Réseaux</strong> à l'École Supérieure de Technologie et de Management
          (ESTM), je forge des bases solides en informatique de haut et bas niveau.
        </p>
        <p class="bio__text">
          Passionné par l'innovation technologique, j'ai choisi ce cursus pour approfondir mes
          capacités de conception logicielle et de gestion d'infrastructures. Mon parcours a débuté
          à l'<strong>ISEP Amadou Traoré de Diamniadio</strong>, où j'ai obtenu mon diplôme en
          Électricité et Électronique Automobile.
        </p>
        <p class="bio__text">
          À travers ce portfolio, je partage mes réalisations qui illustrent ma transition vers un
          profil d'ingénieur logiciel. Je suis toujours à la recherche de nouvelles expériences
          pour enrichir mon parcours.
        </p>
        <a href="images/mon cv.pdf" download class="btn btn-primary" style="margin-top: var(--sp-md);">
          📄 Télécharger mon CV
        </a>
      </div>
    </div>
  </section>

  
  <section class="skills-detail section">
    <div class="container">
      <p class="section-label">Savoir-faire</p>
      <h2 class="title-lg" style="margin-bottom: var(--sp-lg);">Compétences détaillées</h2>
      <div class="skills-blocks">

        <div class="skills-block">
          <h3 class="skills-block__title">💻 Développement</h3>
          <ul class="skills-list">
            <li><span class="skill-name">Langage C</span><span class="skill-bar"><span style="width:80%"></span></span></li>
            <li><span class="skill-name">MySQL / SQLite</span><span class="skill-bar"><span style="width:75%"></span></span></li>
            <li><span class="skill-name">IoT — ESP32 / Arduino</span><span class="skill-bar"><span style="width:70%"></span></span></li>
            <li><span class="skill-name">Microsoft Office</span><span class="skill-bar"><span style="width:90%"></span></span></li>
          </ul>
        </div>

        <div class="skills-block">
          <h3 class="skills-block__title">🌐 Réseaux & Systèmes</h3>
          <ul class="skills-list">
            <li><span class="skill-name">Cisco / Packet Tracer</span><span class="skill-bar"><span style="width:72%"></span></span></li>
            <li><span class="skill-name">EIGRP / VLANs</span><span class="skill-bar"><span style="width:65%"></span></span></li>
            <li><span class="skill-name">Windows Server</span><span class="skill-bar"><span style="width:68%"></span></span></li>
            <li><span class="skill-name">Kali Linux (Pentest)</span><span class="skill-bar"><span style="width:60%"></span></span></li>
          </ul>
        </div>

        <div class="skills-block">
          <h3 class="skills-block__title">🚗 Automobile</h3>
          <ul class="skills-list">
            <li><span class="skill-name">Diagnostic électronique</span><span class="skill-bar"><span style="width:88%"></span></span></li>
            <li><span class="skill-name">Carmin / Autodata</span><span class="skill-bar"><span style="width:85%"></span></span></li>
            <li><span class="skill-name">Systèmes d'injection</span><span class="skill-bar"><span style="width:82%"></span></span></li>
          </ul>
        </div>

        <div class="skills-block">
          <h3 class="skills-block__title">🤝 Soft Skills</h3>
          <div class="soft-skills">
            <span class="tag">Analyse critique</span>
            <span class="tag">Travail d'équipe</span>
            <span class="tag">Résolution de pannes</span>
            <span class="tag">Rédaction technique</span>
            <span class="tag">Gestion de projet</span>
            <span class="tag">Adaptabilité</span>
          </div>
        </div>

      </div>
    </div>
  </section>

  
  <section class="timeline-section section">
    <div class="container">
      <p class="section-label">Parcours</p>
      <h2 class="title-lg" style="margin-bottom: var(--sp-lg);">Expériences & Formation</h2>
      <div class="timeline">

        <div class="timeline__item">
          <div class="timeline__dot"></div>
          <div class="timeline__date">2023 — Présent</div>
          <div class="timeline__card">
            <span class="timeline__type">🎓 Formation</span>
            <h3>Licence Génie Logiciel & Administration Réseaux</h3>
            <p class="timeline__org">École Supérieure de Technologie et de Management (ESTM)</p>
            <p>Conception logicielle, gestion d'infrastructures réseau, IoT, sécurité informatique.</p>
          </div>
        </div>

        <div class="timeline__item">
          <div class="timeline__dot"></div>
          <div class="timeline__date">Avril 2022 · 15 jours</div>
          <div class="timeline__card">
            <span class="timeline__type">💼 Stage</span>
            <h3>Technicien Supérieur — Dakar Dem Dikk</h3>
            <p class="timeline__org">Dakar, Sénégal</p>
            <ul class="timeline__list">
              <li>Intervention sur les systèmes électriques des bus de transport en commun.</li>
              <li>Collaboration avec des techniciens seniors pour le diagnostic de pannes complexes.</li>
              <li>Consolidation des compétences acquises en première année.</li>
            </ul>
          </div>
        </div>

        <div class="timeline__item">
          <div class="timeline__dot"></div>
          <div class="timeline__date">Janvier 2022 · 1 mois</div>
          <div class="timeline__card">
            <span class="timeline__type">💼 Stage</span>
            <h3>Technicien Supérieur — SALY SERVICES</h3>
            <p class="timeline__org">Mbour, Sénégal</p>
            <ul class="timeline__list">
              <li>Diagnostic et maintenance des systèmes d'injection et d'allumage.</li>
              <li>Découverte des nouvelles technologies appliquées à l'automobile.</li>
              <li>Utilisation d'outils de diagnostic informatisés (Carmin, Autodata).</li>
            </ul>
          </div>
        </div>

        <div class="timeline__item">
          <div class="timeline__dot"></div>
          <div class="timeline__date">2020 — 2022</div>
          <div class="timeline__card">
            <span class="timeline__type">🎓 Diplôme</span>
            <h3>Électricité et Électronique Automobile</h3>
            <p class="timeline__org">ISEP Amadou Traoré — Diamniadio, Sénégal</p>
            <p>Formation en électricité et électronique automobile.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<?php require 'composants/pied-de-page.php'; ?>

</body>
</html>
