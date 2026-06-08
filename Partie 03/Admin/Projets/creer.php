<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

$erreurs = [];
$succes  = false;
$donnees = ['titre' => '', 'description' => '', 'technologies' => '', 'lien' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifier_token($_POST['csrf_token'] ?? '')) {
        die('Requête invalide.');
    }

    $donnees['titre']        = nettoyer($_POST['titre']        ?? '');
    $donnees['description']  = nettoyer($_POST['description']  ?? '');
    $donnees['technologies'] = nettoyer($_POST['technologies'] ?? '');
    $donnees['lien']         = nettoyer($_POST['lien']         ?? '');

    if (!champ_requis($donnees['titre']))
        $erreurs['titre']        = 'Le titre est obligatoire.';
    if (!champ_requis($donnees['description']))
        $erreurs['description']  = 'La description est obligatoire.';
    if (!champ_requis($donnees['technologies']))
        $erreurs['technologies'] = 'Les technologies sont obligatoires.';

    // Gestion de l'image
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensions_autorisees)) {
            $erreurs['image'] = 'Format non autorisé. Utilisez jpg, jpeg, png, webp ou gif.';
        } else {
            $nom_fichier = uniqid('projet_') . '.' . $extension;
            $dossier     = '../../images/projets/';

            if (!is_dir($dossier)) {
                mkdir($dossier, 0755, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nom_fichier)) {
                $image = 'images/projets/' . $nom_fichier;
            } else {
                $erreurs['image'] = 'Erreur lors de l\'upload de l\'image.';
            }
        }
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare(
            'INSERT INTO projets (titre, description, technologies, image, lien)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $donnees['titre'],
            $donnees['description'],
            $donnees['technologies'],
            $image,
            $donnees['lien'] ?: null
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
  <title>Nouveau projet — Administration</title>
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
      <h1>Nouveau projet</h1>
      <a href="index.php" class="btn btn-outline btn-sm">← Retour</a>
    </div>

    <?php if (!empty($erreurs)) : ?>
      <div class="alert alert-error">⚠️ Veuillez corriger les erreurs ci-dessous.</div>
    <?php endif; ?>

    <form class="cform admin-form" method="POST"
          action="creer.php" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token"
             value="<?= htmlspecialchars(generer_token()) ?>" />

      <div class="cform__group">
        <label class="cform__label" for="titre">Titre *</label>
        <input class="cform__input <?= isset($erreurs['titre']) ? 'invalid' : '' ?>"
               type="text" id="titre" name="titre"
               placeholder="Titre du projet"
               value="<?= htmlspecialchars($donnees['titre']) ?>" required />
        <?php if (isset($erreurs['titre'])) : ?>
          <span class="field-error"><?= $erreurs['titre'] ?></span>
        <?php endif; ?>
      </div>

      <div class="cform__group">
        <label class="cform__label" for="description">Description *</label>
        <textarea class="cform__textarea <?= isset($erreurs['description']) ? 'invalid' : '' ?>"
                  id="description" name="description"
                  placeholder="Description du projet"
                  required><?= htmlspecialchars($donnees['description']) ?></textarea>
        <?php if (isset($erreurs['description'])) : ?>
          <span class="field-error"><?= $erreurs['description'] ?></span>
        <?php endif; ?>
      </div>

      <div class="cform__group">
        <label class="cform__label" for="technologies">Technologies *</label>
        <input class="cform__input <?= isset($erreurs['technologies']) ? 'invalid' : '' ?>"
               type="text" id="technologies" name="technologies"
               placeholder="Ex : C++, ESP32, IoT (séparés par des virgules)"
               value="<?= htmlspecialchars($donnees['technologies']) ?>" required />
        <?php if (isset($erreurs['technologies'])) : ?>
          <span class="field-error"><?= $erreurs['technologies'] ?></span>
        <?php endif; ?>
      </div>

      <div class="cform__group">
        <label class="cform__label" for="lien">Lien externe</label>
        <input class="cform__input" type="url" id="lien" name="lien"
               placeholder="https://github.com/..."
               value="<?= htmlspecialchars($donnees['lien']) ?>" />
      </div>

      <div class="cform__group">
        <label class="cform__label" for="image">Image du projet</label>
        <input class="cform__input" type="file" id="image" name="image"
               accept=".jpg,.jpeg,.png,.webp,.gif" />
        <span style="font-size:var(--fs-xs);color:var(--muted);">
          Formats acceptés : jpg, jpeg, png, webp, gif
        </span>
        <?php if (isset($erreurs['image'])) : ?>
          <span class="field-error"><?= $erreurs['image'] ?></span>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-primary">Créer le projet →</button>
    </form>

  </main>
</div>
</body>
</html>