<?php
define('ACCES_AUTORISE', true);
require '../fonctions.php';
require '../config/connexion.php';
require 'authentique.php';


$nb_projets   = $pdo->query('SELECT COUNT(*) FROM projets')->fetchColumn();
$nb_messages  = $pdo->query('SELECT COUNT(*) FROM messages_contact WHERE lu = 0')->fetchColumn();
$nb_demandes  = $pdo->query('SELECT COUNT(*) FROM demandes_projet WHERE lu = 0')->fetchColumn();


$visites = $pdo->query('SELECT * FROM visites ORDER BY date_visite DESC LIMIT 5')->fetchAll();


$demandes = $pdo->query('SELECT * FROM demandes_projet ORDER BY date_demande DESC LIMIT 5')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Administration</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-body">
<div class="admin-layout">

  <?php require 'composants/sidebar.php'; ?>

  <main class="admin-content">

    <div class="admin-header">
      <h1>Dashboard</h1>
      <span class="muted">Bonjour, <strong><?= htmlspecialchars($_SESSION['admin_prenom']) ?></strong></span>
    </div>

    <!-- STATS -->
    <div class="dashboard-stats">
      <div class="dashboard-stat">
        <span class="dashboard-stat__num"><?= $nb_projets ?></span>
        <span class="dashboard-stat__label">Projets publiés</span>
      </div>
      <div class="dashboard-stat">
        <span class="dashboard-stat__num"><?= $nb_messages ?></span>
        <span class="dashboard-stat__label">Messages non lus</span>
      </div>
      <div class="dashboard-stat">
        <span class="dashboard-stat__num"><?= $nb_demandes ?></span>
        <span class="dashboard-stat__label">Demandes non lues</span>
      </div>
    </div>

    <!-- 5 DERNIÈRES VISITES -->
    <div class="admin-section">
      <h2 class="admin-section__title">5 dernières visites</h2>
      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Adresse IP</th>
              <th>Page</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($visites)) : ?>
              <tr><td colspan="3" class="muted">Aucune visite enregistrée.</td></tr>
            <?php else : ?>
              <?php foreach ($visites as $visite) : ?>
              <tr>
                <td><?= htmlspecialchars($visite['adresse_ip']) ?></td>
                <td><?= htmlspecialchars($visite['page']) ?></td>
                <td><?= htmlspecialchars($visite['date_visite']) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 5 DERNIÈRES DEMANDES -->
    <div class="admin-section">
      <h2 class="admin-section__title">5 dernières demandes de projet</h2>
      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Type</th>
              <th>Date</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($demandes)) : ?>
              <tr><td colspan="4" class="muted">Aucune demande reçue.</td></tr>
            <?php else : ?>
              <?php foreach ($demandes as $demande) : ?>
              <tr>
                <td><?= htmlspecialchars($demande['nom']) ?></td>
                <td><?= htmlspecialchars($demande['type_projet']) ?></td>
                <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                <td>
                  <?php if (!$demande['lu']) : ?>
                    <span class="badge-nonlu"></span>Non lu
                  <?php else : ?>
                    Lu
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</div>
</body>
</html>