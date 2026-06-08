<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
define('ACCES_AUTORISE', true);
require 'fonctions.php'; 
require  'config/connexion.php';
enregistrer_visite($pdo, 'index');

$stmt = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC LIMIT 3');
$projets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Papa Amadou Thomas — Portfolio</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/index.css" />
</head>
<body>

<?php require 'composants/navigation.php'; ?>


<section class="hero">
  <div class="container hero__inner">
    <div class="hero__text">
      <p class="section-label">Étudiant en Génie Logiciel & Administration Réseaux</p>
      <h1 class="title-xl">Papa Amadou<br /><span class="accent">Thomas</span></h1>
      <p class="hero__desc">
        Passionné par l'innovation technologique, je conçois des solutions logicielles
        et des systèmes embarqués. Étudiant à l'ESTM, je transforme chaque projet
        en une opportunité d'apprendre et de créer.
      </p>
      <div class="hero__cta">
        <a href="projets.php" class="btn btn-primary">Voir mes projets</a>
        <a href="contact.php" class="btn btn-outline">Me contacter</a>
      </div>
    </div>
    <div class="hero__visual">
      <div class="hero__avatar">
        <img src="images/ma photo.jpeg" alt="Photo de Papa Amadou Thomas" />
      </div>
      <div class="hero__badge">
        <span class="hero__badge-icon">🎓</span>
        <div>
          <strong>ESTM</strong>
          <span>Licence Génie Logiciel</span>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="stats">
  <div class="container stats__grid">
    <div class="stat"><span class="stat__num"><?= count($projets) ?></span><span class="stat__label">Projets réalisés</span></div>
    <div class="stat"><span class="stat__num">2</span><span class="stat__label">Stages effectués</span></div>
    <div class="stat"><span class="stat__num">2+</span><span class="stat__label">Ans d'expérience</span></div>
    <div class="stat"><span class="stat__num">5+</span><span class="stat__label">Technologies maîtrisées</span></div>
  </div>
</section>

<section class="skills section">
  <div class="container">
    <p class="section-label">Ce que je sais faire</p>
    <div class="skills__header">
      <h2 class="title-lg">Compétences</h2>
      <a href="about.php" class="btn btn-outline btn-sm">Voir tout →</a>
    </div>
    <div class="skills__grid">
      <div class="skill-card">
        <div class="skill-card__icon">💻</div>
        <h3>Développement</h3>
        <p>Langage C, MySQL, SQLite — structures de données, gestion mémoire, applications avec BDD.</p>
        <div class="skill-card__tags">
          <span class="tag">C</span><span class="tag">MySQL</span><span class="tag">SQLite</span>
        </div>
      </div>
      <div class="skill-card">
        <div class="skill-card__icon">🔌</div>
        <h3>IoT & Embarqué</h3>
        <p>Prototypage ESP32, Arduino. Capteurs ultrasons, DHT11, communication sans fil.</p>
        <div class="skill-card__tags">
          <span class="tag">ESP32</span><span class="tag">Arduino</span><span class="tag">C++</span>
        </div>
      </div>
      <div class="skill-card">
        <div class="skill-card__icon">🌐</div>
        <h3>Réseaux</h3>
        <p>Configuration Cisco, protocoles EIGRP, routage statique, VLANs sur Packet Tracer.</p>
        <div class="skill-card__tags">
          <span class="tag">Cisco</span><span class="tag">EIGRP</span><span class="tag">VLANs</span>
        </div>
      </div>
      <div class="skill-card">
        <div class="skill-card__icon">🛡️</div>
        <h3>Systèmes & Sécurité</h3>
        <p>Windows Server, VirtualBox, Kali Linux — administration et environnements Pentest.</p>
        <div class="skill-card__tags">
          <span class="tag">Windows Server</span><span class="tag">Kali Linux</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="projects section">
  <div class="container">
    <p class="section-label">Réalisations</p>
    <div class="projects__header">
      <h2 class="title-lg">Projets phares</h2>
      <a href="projets.php" class="btn btn-outline btn-sm">Tous les projets →</a>
    </div>
    <div class="projects__grid">
      <?php if (empty($projets)) : ?>
        <p class="muted">Aucun projet à afficher pour le moment.</p>
      <?php else : ?>
        <?php foreach ($projets as $index => $projet) : ?> 
        <article class="project-card <?= $index === 0 ? 'project-card--featured' : '' ?>">

         <?php if (!empty($projet['image'])) : ?>
            <div class="projet-card__image">
              <img src="<?= htmlspecialchars($projet['image']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>" />
            </div>
          <?php else : ?>
            <div class="projet-card__image image-placeholder">
              <span class="img-placeholder__text">📁 Projets</span>
            </div>
          <?php endif; ?>
              <div class="project-card__body">
      <h3 class="project-card__title"><?= htmlspecialchars($projet['titre']) ?></h3>
      <p class="project-card__desc"><?= htmlspecialchars($projet['description']) ?></p>
      <div class="project-card__tags">
        <?php foreach (explode(',', $projet['technologies']) as $tech) : ?>
          <span class="tag"><?= htmlspecialchars(trim($tech)) ?></span>
        <?php endforeach; ?>
      </div>
      <?php if (!empty($projet['lien'])) : ?>
        <a href="<?= htmlspecialchars($projet['lien']) ?>" target="_blank"
          rel="noopener" class="btn btn-primary btn-sm">Voir le projet →</a>
      <?php else : ?>
        <span class="btn btn-outline btn-sm btn-disabled">Bientôt disponible</span>
      <?php endif; ?>
      </div>

  </article>
  <?php endforeach; ?>
</div>
<?php endif; ?>

  </div>
</section>

<?php require 'composants/pied-de-page.php'; ?>

</body>
</html>
