<?php
session_start();
define('ACCES_AUTORISE', true);
require 'fonctions.php';
require 'config/connexion.php';

enregistrer_visite($pdo, 'projets');

$mot_cle = nettoyer($_GET['q'] ?? '');

if ($mot_cle !== '') {
    $stmt = $pdo->prepare(
        'SELECT * FROM projets
         WHERE titre LIKE ? OR description LIKE ?
         ORDER BY date_creation DESC'
    );
    $stmt->execute(['%' . $mot_cle . '%', '%' . $mot_cle . '%']);
} else {
    $stmt = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC');
}
$projets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projets — Papa Amadou Thomas</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/projets.css" />
</head>
<body>

<?php require 'composants/navigation.php'; ?>

<main>

  <section class="page-header section">
    <div class="container">
      <p class="section-label">Réalisations</p>
      <h1 class="title-xl">Mes Projets</h1>
      <p class="page-header__desc">
        Du système embarqué IoT à la gestion de base de données en C, voici les projets
        qui illustrent mon parcours et ma passion pour la technologie.
      </p>
    </div>
  </section>

  <section class="search-section">
    <div class="container">
      <form class="search-bar" method="GET" action="projets.php">
        <input
          type="search"
          name="q"
          class="search-input"
          placeholder="Rechercher par mot-clé, technologie…"
          value="<?= htmlspecialchars($mot_cle) ?>"
        />
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <?php if ($mot_cle !== '') : ?>
          <a href="projets.php" class="btn btn-outline">Réinitialiser</a>
        <?php endif; ?>
      </form>
      <?php if ($mot_cle !== '') : ?>
        <p class="search-result-info">
          <?= count($projets) ?> résultat(s) pour
          <strong>"<?= htmlspecialchars($mot_cle) ?>"</strong>
        </p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section" style="padding-top: var(--sp-lg);">
    <div class="container">

      <?php if (empty($projets)) : ?>
        <p class="no-result">Aucun projet ne correspond à ta recherche.</p>
      <?php else : ?>
      <div class="projects-grid">
        <?php foreach ($projets as $projet) : ?>
        <article class="pcard">

          <?php if (!empty($projet['image'])) : ?>
            <div class="pcard__img">
              <img src="<?= htmlspecialchars($projet['image']) ?>"
                   alt="<?= htmlspecialchars($projet['titre']) ?>" />
              <span class="pcard__badge"><?= htmlspecialchars($projet['technologies']) ?></span>
            </div>
          <?php else : ?>
            <div class="pcard__img img-placeholder">
              <span class="img-placeholder__text">📁 Projet</span>
              <span class="pcard__badge"><?= htmlspecialchars($projet['technologies']) ?></span>
            </div>
          <?php endif; ?>

          <div class="pcard__body">
            <h2 class="pcard__title"><?= htmlspecialchars($projet['titre']) ?></h2>
            <p class="pcard__desc"><?= htmlspecialchars($projet['description']) ?></p>
            <div class="pcard__tags">
              <?php foreach (explode(',', $projet['technologies']) as $tech) : ?>
                <span class="tag"><?= htmlspecialchars(trim($tech)) ?></span>
              <?php endforeach; ?>
            </div>
            <?php if (!empty($projet['lien'])) : ?>
              <a href="<?= htmlspecialchars($projet['lien']) ?>"
                 target="_blank" rel="noopener"
                 class="btn btn-primary btn-sm">Voir le projet →</a>
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

</main>

<?php require 'composants/pied-de-page.php'; ?>

</body>
</html>