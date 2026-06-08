<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$messages = $pdo->query('SELECT * FROM messages_contact ORDER BY date_envoi DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Messages — Administration</title>
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
      <h1>Messages de contact</h1>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Statut</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($messages)) : ?>
            <tr><td colspan="5" class="muted">Aucun message reçu.</td></tr>
          <?php else : ?>
            <?php foreach ($messages as $msg) : ?>
            <?php
              // Marquer comme lu automatiquement
              if (!$msg['lu']) {
                $pdo->prepare('UPDATE messages_contact SET lu = 1 WHERE id = ?')
                    ->execute([$msg['id']]);
              }
            ?>
            <tr>
              <td>
                <?php if (!$msg['lu']) : ?>
                  <span class="badge-nonlu"></span><strong>Non lu</strong>
                <?php else : ?>
                  <span style="color:var(--muted)">Lu</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($msg['nom']) ?></td>
              <td><?= htmlspecialchars($msg['email']) ?></td>
              <td><?= htmlspecialchars($msg['message']) ?></td>
              <td><?= htmlspecialchars($msg['date_envoi']) ?></td>
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