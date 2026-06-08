<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$projets = $pdo->query('SELECT * FROM projets ORDER BY date_creation DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projets — Administration</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/global.css" />
  <link rel="stylesheet" href="../../css/admin.css" />
</head>
<body class="admin-body">
<div class="admin-layout">

  <?php require '../composants/sidebar.php'; ?>

  <main class="admin-content">

    <div class="admin-header">
      <h1>Projets</h1>
      <a href="creer.php" class="btn btn-primary">+ Nouveau projet</a>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Technologies</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($projets)) : ?>
            <tr><td colspan="4" class="muted">Aucun projet. Crée le premier !</td></tr>
          <?php else : ?>
            <?php foreach ($projets as $projet) : ?>
            <tr>
              <td><?= htmlspecialchars($projet['titre']) ?></td>
              <td><?= htmlspecialchars($projet['technologies']) ?></td>
              <td><?= htmlspecialchars($projet['date_creation']) ?></td>
              <td>
                <div class="actions">
                  <a href="modifier.php?id=<?= $projet['id'] ?>"
                     class="btn btn-outline btn-sm">Modifier</a>
                  <form method="POST" action="supprimer.php"
                        onsubmit="return confirm('Supprimer ce projet ?')">
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars(generer_token()) ?>" />
                    <input type="hidden" name="id" value="<?= $projet['id'] ?>" />
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</div>
</body>
</html>