<?php
session_start();
define('ACCES_AUTORISE', true);
require '../fonctions.php';
require '../config/connexion.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifier_token($_POST['csrf_token'] ?? '')) {
        die('Requête invalide.');
    }
    $email = nettoyer($_POST['email'] ?? '');
    $mdp   = $_POST['mot_de_passe'] ?? '';

    if (!empty($email) && !empty($mdp)) {
        $stmt = $pdo->prepare('SELECT * FROM administrateurs WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']     = $admin['id'];
            $_SESSION['admin_prenom'] = $admin['prenom'];
            header('Location: dashboard.php');
            exit;
        }
    }
    $erreur = 'Identifiants incorrects.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion — Administration</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-body">

  <div class="auth-card">
    <div class="auth-card__header">
      <h1 class="auth-card__logo">PAT<span class="accent">.</span></h1>
      <p class="auth-card__subtitle">Espace Administration</p>
    </div>

    <?php if ($erreur) : ?>
      <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form class="cform" method="POST" action="connexion.php">
      <input type="hidden" name="csrf_token"
             value="<?= htmlspecialchars(generer_token()) ?>" />

      <div class="cform__group">
        <label class="cform__label" for="email">Adresse e-mail</label>
        <input class="cform__input" type="email" id="email" name="email"
               placeholder="admin@exemple.com" required autofocus />
      </div>

      <div class="cform__group">
        <label class="cform__label" for="mot_de_passe">Mot de passe</label>
        <input class="cform__input" type="password" id="mot_de_passe"
               name="mot_de_passe" placeholder="••••••••" required />
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">
        Se connecter →
      </button>
    </form>
  </div>

</body>
</html>