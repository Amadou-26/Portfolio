<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$utilisateurs = $pdo->query('SELECT * FROM administrateurs ORDER BY date_creation DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Utilisateurs — Administration</title>
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
      <h1>Utilisateurs</h1>
      <a href="creer.php" class="btn btn-primary">+ Nouvel utilisateur</a>
    </div>

    <?php if (isset($_GET['succes'])) : ?>
      <div class="alert alert-success">✅ Opération effectuée avec succès.</div>
    <?php endif; ?>

    <?php if (isset($_GET['erreur'])) : ?>
      <div class="alert alert-error">⚠️ Vous ne pouvez pas supprimer votre propre compte.</div>
    <?php endif; ?>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Date création</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($utilisateurs)) : ?>
            <tr><td colspan="5" class="muted">Aucun utilisateur.</td></tr>
          <?php else : ?>
            <?php foreach ($utilisateurs as $user) : ?>
            <tr>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['date_creation']) ?></td>
              <td>
                <div class="actions">
                  <a href="modifier.php?id=<?= $user['id'] ?>"
                     class="btn btn-outline btn-sm">Modifier</a>
                  <?php if ($user['id'] !== (int)$_SESSION['admin_id']) : ?>
                  <form method="POST" action="supprimer.php"
                        onsubmit="return confirm('Supprimer cet utilisateur ?')">
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars(generer_token()) ?>" />
                    <input type="hidden" name="id" value="<?= $user['id'] ?>" />
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                  </form>
                  <?php else : ?>
                    <span class="btn btn-outline btn-sm btn-disabled">Vous</span>
                  <?php endif; ?>
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