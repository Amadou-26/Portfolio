<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$erreurs = [];
$donnees = ['prenom' => '', 'nom' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifier_token($_POST['csrf_token'] ?? '')) {
        die('Requête invalide.');
    }

    $donnees['prenom'] = nettoyer($_POST['prenom'] ?? '');
    $donnees['nom']    = nettoyer($_POST['nom']    ?? '');
    $donnees['email']  = nettoyer($_POST['email']  ?? '');
    $mdp               = $_POST['mot_de_passe']    ?? '';
    $mdp_confirm       = $_POST['mot_de_passe_confirm'] ?? '';

    if (!champ_requis($donnees['prenom']))
        $erreurs['prenom'] = 'Le prénom est obligatoire.';
    if (!champ_requis($donnees['nom']))
        $erreurs['nom']    = 'Le nom est obligatoire.';
    if (!champ_requis($donnees['email']))
        $erreurs['email']  = 'L\'e-mail est obligatoire.';
    elseif (!email_valide($donnees['email']))
        $erreurs['email']  = 'L\'e-mail est invalide.';
    if (!champ_requis($mdp))
        $erreurs['mdp']    = 'Le mot de passe est obligatoire.';
    elseif (strlen($mdp) < 8)
        $erreurs['mdp']    = 'Le mot de passe doit contenir au moins 8 caractères.';
    elseif ($mdp !== $mdp_confirm)
        $erreurs['mdp']    = 'Les mots de passe ne correspondent pas.';

    // Vérifier que l'email n'existe pas déjà
    if (empty($erreurs)) {
        $stmt = $pdo->prepare('SELECT id FROM administrateurs WHERE email = ?');
        $stmt->execute([$donnees['email']]);
        if ($stmt->fetch()) {
            $erreurs['email'] = 'Cet e-mail est déjà utilisé.';
        }
    }

    if (empty($erreurs)) {
        $hash = password_hash($mdp, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare(
            'INSERT INTO administrateurs (prenom, nom, email, mot_de_passe)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $donnees['prenom'],
            $donnees['nom'],
            $donnees['email'],
            $hash
        ]);
        header('Location: index.php?succes=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nouvel utilisateur — Administration</title>
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
      <h1>Nouvel utilisateur</h1>
      <a href="index.php" class="btn btn-outline btn-sm">← Retour</a>
    </div>

    <?php if (!empty($erreurs)) : ?>
      <div class="alert alert-error">⚠️ Veuillez corriger les erreurs ci-dessous.</div>
    <?php endif; ?>

    <form class="cform admin-form" method="POST" action="creer.php">
      <input type="hidden" name="csrf_token"
             value="<?= htmlspecialchars(generer_token()) ?>" />

      <div class="cform__row">
        <div class="cform__group">
          <label class="cform__label" for="prenom">Prénom *</label>
          <input class="cform__input <?= isset($erreurs['prenom']) ? 'invalid' : '' ?>"
                 type="text" id="prenom" name="prenom"
                 placeholder="Prénom"
                 value="<?= htmlspecialchars($donnees['prenom']) ?>" required />
          <?php if (isset($erreurs['prenom'])) : ?>
            <span class="field-error"><?= $erreurs['prenom'] ?></span>
          <?php endif; ?>
        </div>
        <div class="cform__group">
          <label class="cform__label" for="nom">Nom *</label>
          <input class="cform__input <?= isset($erreurs['nom']) ? 'invalid' : '' ?>"
                 type="text" id="nom" name="nom"
                 placeholder="Nom"
                 value="<?= htmlspecialchars($donnees['nom']) ?>" required />
          <?php if (isset($erreurs['nom'])) : ?>
            <span class="field-error"><?= $erreurs['nom'] ?></span>
          <?php endif; ?>
        </div>
      </div>

      <div class="cform__group">
        <label class="cform__label" for="email">Adresse e-mail *</label>
        <input class="cform__input <?= isset($erreurs['email']) ? 'invalid' : '' ?>"
               type="email" id="email" name="email"
               placeholder="admin@exemple.com"
               value="<?= htmlspecialchars($donnees['email']) ?>" required />
        <?php if (isset($erreurs['email'])) : ?>
          <span class="field-error"><?= $erreurs['email'] ?></span>
        <?php endif; ?>
      </div>

      <div class="cform__row">
        <div class="cform__group">
          <label class="cform__label" for="mot_de_passe">Mot de passe *</label>
          <input class="cform__input <?= isset($erreurs['mdp']) ? 'invalid' : '' ?>"
                 type="password" id="mot_de_passe" name="mot_de_passe"
                 placeholder="Minimum 8 caractères" required />
          <?php if (isset($erreurs['mdp'])) : ?>
            <span class="field-error"><?= $erreurs['mdp'] ?></span>
          <?php endif; ?>
        </div>
        <div class="cform__group">
          <label class="cform__label" for="mot_de_passe_confirm">Confirmer *</label>
          <input class="cform__input"
                 type="password" id="mot_de_passe_confirm"
                 name="mot_de_passe_confirm"
                 placeholder="Répéter le mot de passe" required />
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Créer l'utilisateur →</button>
    </form>

  </main>
</div>
</body>
</html>