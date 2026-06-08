<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$demandes = $pdo->query('SELECT * FROM demandes_projet ORDER BY date_demande DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Demandes — Administration</title>
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
      <h1>Demandes de projet</h1>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Statut</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Type</th>
            <th>Description</th>
            <th>Budget</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($demandes)) : ?>
            <tr><td colspan="7" class="muted">Aucune demande reçue.</td></tr>
          <?php else : ?>
            <?php foreach ($demandes as $demande) : ?>
            <?php
              if (!$demande['lu']) {
                $pdo->prepare('UPDATE demandes_projet SET lu = 1 WHERE id = ?')
                    ->execute([$demande['id']]);
              }
            ?>
            <tr>
              <td>
                <?php if (!$demande['lu']) : ?>
                  <span class="badge-nonlu"></span><strong>Non lu</strong>
                <?php else : ?>
                  <span style="color:var(--muted)">Lu</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($demande['nom']) ?></td>
              <td><?= htmlspecialchars($demande['email']) ?></td>
              <td><?= htmlspecialchars($demande['type_projet']) ?></td>
              <td><?= htmlspecialchars($demande['description']) ?></td>
              <td><?= htmlspecialchars($demande['budget'] ?? '—') ?></td>
              <td><?= htmlspecialchars($demande['date_demande']) ?></td>
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